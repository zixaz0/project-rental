<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of users
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('nik', 'like', "%{$search}%")
                    ->orWhere('phone', 'like', "%{$search}%");
            });
        }

        // Filter by Role
        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        // Filter by Gender
        if ($request->filled('gender')) {
            $query->where('jenis_kelamin', $request->gender);
        }

        // Filter by Status (UPDATED)
        if ($request->filled('verification_status')) {
            $query->where('status', $request->verification_status);
        }

        // Get paginated users
        $users = $query->with('verifiedBy')
            ->orderBy('created_at', 'desc')
            ->paginate(10)
            ->withQueryString();

        // Calculate statistics (UPDATED)
        $totalUsers = User::count();
        $verifiedUsers = User::where('status', 'terverifikasi')->count();
        $pendingUsers = User::where('status', 'menunggu_verifikasi')->count();
        $incompleteUsers = User::where('status', 'belum_lengkap')->count();
        $rejectedUsers = User::where('status', 'ditolak')->count();

        return view('admin.users.index', compact(
            'users',
            'totalUsers',
            'verifiedUsers',
            'pendingUsers',
            'incompleteUsers',
            'rejectedUsers'
        ));
    }

    /**
     * Verify a user
     */
    public function verify(Request $request, User $user)
    {
        // Validate
        $request->validate([
            'verification_note' => 'required|string|max:500'
        ], [
            'verification_note.required' => 'Catatan verifikasi harus diisi',
            'verification_note.max' => 'Catatan maksimal 500 karakter'
        ]);

        // Check if user is customer and waiting for verification
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Hanya customer yang dapat diverifikasi!');
        }

        if ($user->status !== 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 'User tidak dalam status menunggu verifikasi!');
        }

        // Update verification status
        $user->update([
            'status' => 'terverifikasi',
            'is_verified' => true,
            'is_complete' => true,
            'verified_at' => now(),
            'verified_by' => Auth::id(),
            'verification_note' => $request->verification_note
        ]);

        return redirect()->back()->with('success', "User {$user->name} berhasil diverifikasi!");
    }

    /**
     * Reject verification and reset user data
     */
    public function reject(Request $request, User $user)
    {
        // Validate
        $request->validate([
            'reject_note' => 'required|string|max:500'
        ], [
            'reject_note.required' => 'Alasan penolakan harus diisi',
            'reject_note.max' => 'Alasan maksimal 500 karakter'
        ]);

        // Check if user is customer
        if ($user->role !== 'customer') {
            return redirect()->back()->with('error', 'Hanya customer yang dapat ditolak verifikasinya!');
        }

        if ($user->status !== 'menunggu_verifikasi') {
            return redirect()->back()->with('error', 'User tidak dalam status menunggu verifikasi!');
        }

        // PERBAIKAN: TIDAK HAPUS DOKUMEN, biarkan user edit sendiri
        // Update status ke ditolak, dokumen tetap ada
        $user->update([
            'status' => 'ditolak',
            'is_verified' => false,
            'verified_at' => null,
            'verified_by' => null,
            'verification_note' => 'DITOLAK: ' . $request->reject_note
        ]);

        return redirect()->back()->with('success', "Verifikasi {$user->name} ditolak! User dapat memperbaiki dokumen.");
    }

    /**
     * Unverify a user (cancel verification)
     */
    public function unverify(Request $request, User $user)
    {
        // Validate
        $request->validate([
            'verification_note' => 'required|string|max:500'
        ], [
            'verification_note.required' => 'Alasan pembatalan harus diisi',
            'verification_note.max' => 'Alasan maksimal 500 karakter'
        ]);

        // Check if user is verified
        if ($user->status !== 'terverifikasi') {
            return redirect()->back()->with('error', 'User belum diverifikasi!');
        }

        // Update verification status to menunggu verifikasi
        $user->update([
            'status' => 'menunggu_verifikasi',
            'is_verified' => false,
            'verified_at' => null,
            'verified_by' => null,
            'verification_note' => 'DIBATALKAN: ' . $request->verification_note
        ]);

        return redirect()->back()->with('success', "Verifikasi {$user->name} berhasil dibatalkan!");
    }

    /**
     * Remove the specified user
     */
    public function destroy(User $user)
    {
        // Prevent deleting self
        if ($user->id === Auth::id()) {
            return redirect()->back()->with('error', 'Tidak dapat menghapus akun sendiri!');
        }

        // Delete user documents if exists
        if ($user->foto_ktp && Storage::exists($user->foto_ktp)) {
            Storage::delete($user->foto_ktp);
        }
        if ($user->foto_selfie_ktp && Storage::exists($user->foto_selfie_ktp)) {
            Storage::delete($user->foto_selfie_ktp);
        }
        if ($user->foto_sim && Storage::exists($user->foto_sim)) {
            Storage::delete($user->foto_sim);
        }

        $userName = $user->name;
        $user->delete();

        return redirect()->back()->with('success', "User {$userName} berhasil dihapus!");
    }
}