<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'status', // TAMBAHAN INI
        
        // Data Kontak
        'phone',
        'address',
        
        // Data Identitas
        'nik',
        'tanggal_lahir',
        'jenis_kelamin',
        
        // Upload Dokumen
        'foto_ktp',
        'foto_selfie_ktp',
        'foto_sim',
        
        // Status
        'is_complete',
        'is_verified',
        'verified_at',
        'verified_by',
        'verification_note',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'tanggal_lahir' => 'date',
        'is_complete' => 'boolean',
        'is_verified' => 'boolean',
        'verified_at' => 'datetime',
    ];

    // ==================== HELPER METHOD ROLE ====================
    
    public function isAdmin()
    {
        return $this->role === 'admin';
    }
    public function isOwner()
    {
        return $this->role === 'owner';
    }

    public function isCustomer()
    {
        return $this->role === 'customer';
    }
    
    // ==================== HELPER METHOD STATUS PROFIL ====================
    
    public function hasCompleteProfile()
    {
        return $this->is_complete;
    }
    
    public function isVerified()
    {
        return $this->is_verified;
    }
    
    // ==================== HELPER METHOD STATUS ====================
    
    /**
     * Cek apakah user belum lengkap data
     */
    public function isBelumLengkap()
    {
        return $this->status === 'belum_lengkap';
    }
    
    /**
     * Cek apakah user menunggu verifikasi
     */
    public function isMenungguVerifikasi()
    {
        return $this->status === 'menunggu_verifikasi';
    }
    
    /**
     * Cek apakah user terverifikasi
     */
    public function isTerverifikasi()
    {
        return $this->status === 'terverifikasi';
    }
    
    /**
     * Cek apakah user ditolak
     */
    public function isDitolak()
    {
        return $this->status === 'ditolak';
    }
    
    /**
     * Dapatkan badge HTML untuk status
     */
    public function getStatusBadge()
    {
        $badges = [
            'belum_lengkap' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                    <i class="fas fa-exclamation-circle mr-1"></i>
                                    Belum Lengkap
                                </span>',
            'menunggu_verifikasi' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800">
                                          <i class="fas fa-clock mr-1"></i>
                                          Menunggu Verifikasi
                                      </span>',
            'terverifikasi' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                    <i class="fas fa-check-circle mr-1"></i>
                                    Terverifikasi
                                </span>',
            'ditolak' => '<span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800">
                              <i class="fas fa-times-circle mr-1"></i>
                              Ditolak
                          </span>',
        ];
        
        return $badges[$this->status] ?? $badges['belum_lengkap'];
    }
    
    /**
     * Dapatkan text status (bahasa Indonesia)
     */
    public function getStatusText()
    {
        $statusText = [
            'belum_lengkap' => 'Belum Lengkap',
            'menunggu_verifikasi' => 'Menunggu Verifikasi',
            'terverifikasi' => 'Terverifikasi',
            'ditolak' => 'Ditolak',
        ];
        
        return $statusText[$this->status] ?? 'Tidak Diketahui';
    }
    
    /**
     * Cek apakah user bisa booking kendaraan
     */
    public function canBookVehicle()
    {
        return $this->isTerverifikasi();
    }
    
    // ==================== RELATIONSHIP ====================
    
    /**
     * Relationship ke admin yang verifikasi
     */
    public function verifiedBy()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    /**
     * Relationship ke bookings (future)
     */
    // public function bookings()
    // {
    //     return $this->hasMany(Booking::class);
    // }
}