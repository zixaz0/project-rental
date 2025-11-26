// Auto submit filter
document.getElementById('search')?.addEventListener('input', function() {
    clearTimeout(window.searchTimeout);
    window.searchTimeout = setTimeout(() => {
        document.getElementById('filterForm').submit();
    }, 500);
});

['role', 'verification_status', 'gender'].forEach(id => {
    document.getElementById(id)?.addEventListener('change', () => {
        document.getElementById('filterForm').submit();
    });
});

// Helper Functions
const statusColors = {
    'belum_lengkap': 'red',
    'menunggu_verifikasi': 'yellow',
    'terverifikasi': 'green',
    'ditolak': 'orange'
};

const generateDocumentsHTML = (data) => {
    if (!data.foto_ktp && !data.foto_selfie_ktp && !data.foto_sim) return '';
    
    const cols = data.foto_sim ? 'grid-cols-3' : 'grid-cols-2';
    const docs = [
        { key: 'foto_ktp', label: 'Foto KTP' },
        { key: 'foto_selfie_ktp', label: 'Selfie dengan KTP' },
        { key: 'foto_sim', label: 'Foto SIM' }
    ];
    
    return `
        <div class="bg-gray-50 p-4 rounded-lg mb-4">
            <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                <i class="fas fa-id-card text-indigo-600 mr-2"></i>Dokumen
            </h4>
            <div class="grid ${cols} gap-3">
                ${docs.map(doc => data[doc.key] ? `
                    <div>
                        <p class="text-xs text-gray-600 mb-2">${doc.label}</p>
                        <img src="${data[doc.key]}" alt="${doc.label}" 
                            class="w-full h-32 object-cover rounded-lg cursor-pointer hover:opacity-80 transition border-2 border-gray-200"
                            onclick="window.open('${data[doc.key]}', '_blank')"
                            title="Klik untuk memperbesar">
                    </div>
                ` : '').join('')}
            </div>
        </div>
    `;
};

const createForm = (action, data) => {
    const form = document.createElement('form');
    form.method = 'POST';
    form.action = action;
    
    const csrfToken = document.createElement('input');
    csrfToken.type = 'hidden';
    csrfToken.name = '_token';
    csrfToken.value = document.querySelector('meta[name="csrf-token"]')?.content || '';
    form.appendChild(csrfToken);
    
    Object.entries(data).forEach(([key, value]) => {
        const input = document.createElement('input');
        input.type = 'hidden';
        input.name = key;
        input.value = value;
        form.appendChild(input);
    });
    
    document.body.appendChild(form);
    return form;
};

// Show User Detail
window.showUserDetail = (data) => {
    Swal.fire({
        title: '<div class="text-2xl font-bold text-gray-800"><i class="fas fa-user-circle mr-2 text-indigo-600"></i>Detail User</div>',
        html: `
            <div class="text-left">
                <div class="bg-gradient-to-r from-indigo-50 to-blue-50 p-4 rounded-lg mb-4">
                    <h3 class="text-xl font-bold text-gray-800 mb-2">${data.name}</h3>
                    <p class="text-sm text-gray-600">${data.email}</p>
                </div>
                <div class="grid grid-cols-2 gap-3 mb-4">
                    ${[
                        { label: 'Role', value: data.role },
                        { label: 'NIK', value: data.nik, mono: true },
                        { label: 'Tanggal Lahir', value: data.tanggal_lahir },
                        { label: 'Jenis Kelamin', value: data.jenis_kelamin }
                    ].map(item => `
                        <div class="bg-gray-50 p-3 rounded-lg">
                            <p class="text-xs text-gray-500 mb-1">${item.label}</p>
                            <p class="${item.mono ? 'font-mono ' : ''}font-semibold text-gray-800">${item.value}</p>
                        </div>
                    `).join('')}
                </div>
                <div class="space-y-3 mb-4">
                    <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center">
                            <i class="fas fa-phone text-green-600 mr-3"></i>
                            <span class="text-sm text-gray-600">Telepon</span>
                        </div>
                        <span class="font-semibold text-gray-800">${data.phone}</span>
                    </div>
                    <div class="p-3 bg-gray-50 rounded-lg">
                        <div class="flex items-center mb-2">
                            <i class="fas fa-map-marker-alt text-red-600 mr-3"></i>
                            <span class="text-sm text-gray-600">Alamat</span>
                        </div>
                        <p class="text-sm text-gray-800 ml-8">${data.address}</p>
                    </div>
                </div>
                ${generateDocumentsHTML(data)}
                <div class="bg-${statusColors[data.status]}-50 p-4 rounded-lg mb-4">
                    <h4 class="font-semibold text-gray-800 mb-3 flex items-center">
                        <i class="fas fa-clipboard-check text-${statusColors[data.status]}-600 mr-2"></i>
                        Status: ${data.status_text}
                    </h4>
                    ${data.status === 'terverifikasi' ? `
                        <div class="border-t pt-2 mt-2">
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">Diverifikasi Oleh</span>
                                <span class="text-sm text-gray-800">${data.verified_by_name}</span>
                            </div>
                        </div>
                    ` : ''}
                </div>
                ${data.verification_note && data.verification_note !== 'Tidak ada catatan' ? `
                    <div class="bg-gray-50 p-4 rounded-lg">
                        <h4 class="font-semibold text-gray-800 mb-2 flex items-center">
                            <i class="fas fa-comment-alt text-gray-600 mr-2"></i>Catatan
                        </h4>
                        <p class="text-sm text-gray-700">${data.verification_note}</p>
                    </div>
                ` : ''}
            </div>
        `,
        showCloseButton: true,
        showConfirmButton: false,
        width: '800px',
        customClass: { popup: 'swal-detail-modal', htmlContainer: 'swal-html-container' }
    });
};

// Show Verify Modal
window.showVerifyModal = (data) => {
    Swal.fire({
        title: '<div class="text-xl font-bold text-gray-800">Verifikasi User</div>',
        html: `
            <div class="text-left mb-4">
                <div class="bg-gray-100 p-4 rounded-lg mb-4">
                    <p class="font-semibold text-gray-800 text-lg">${data.name}</p>
                    <p class="text-sm text-gray-600">${data.email}</p>
                    <p class="text-sm text-gray-600 mt-1">NIK: <span class="font-mono font-bold">${data.nik}</span></p>
                </div>
                ${generateDocumentsHTML(data).replace('mb-4', 'mb-4').replace('h-32', 'h-20')}
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Catatan Verifikasi <span class="text-red-500">*</span>
                    </label>
                    <textarea id="verification_note" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-green-500 focus:border-green-500"
                        placeholder="Contoh: Data sudah sesuai dan valid. Dokumen lengkap dan jelas."></textarea>
                </div>
                <div class="bg-blue-50 p-3 rounded-lg">
                    <p class="text-sm text-blue-800">
                        <i class="fas fa-info-circle mr-1"></i>
                        Pastikan semua dokumen dan data sudah benar sebelum memverifikasi
                    </p>
                </div>
            </div>
        `,
        icon: 'question',
        showCancelButton: true,
        confirmButtonColor: '#10b981',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-check mr-2"></i>Verifikasi',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        focusCancel: true,
        width: '600px',
        preConfirm: () => {
            const note = document.getElementById('verification_note').value;
            if (!note.trim()) {
                Swal.showValidationMessage('Catatan verifikasi harus diisi!');
                return false;
            }
            return { note };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Memverifikasi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            createForm(`/admin/users/${data.id}/verify`, { verification_note: result.value.note }).submit();
        }
    });
};

// Show Reject Modal
window.showRejectModal = (data) => {
    Swal.fire({
        title: '<div class="text-xl font-bold text-red-800">Tolak Verifikasi</div>',
        html: `
            <div class="text-left mb-4">
                <div class="bg-red-50 border border-red-200 p-4 rounded-lg mb-4">
                    <p class="font-semibold text-gray-800 text-lg">${data.name}</p>
                    <p class="text-sm text-gray-600">${data.email}</p>
                    <p class="text-sm text-gray-600 mt-1">NIK: <span class="font-mono font-bold">${data.nik}</span></p>
                </div>
                ${generateDocumentsHTML(data).replace('border-gray-200', 'border-red-200').replace('h-32', 'h-20')}
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Penolakan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="reject_note" rows="4"
                        class="w-full px-3 py-2 border border-red-300 rounded-lg focus:ring-2 focus:ring-red-500 focus:border-red-500"
                        placeholder="Contoh: Foto KTP tidak jelas/buram..."></textarea>
                </div>
                <div class="bg-red-50 border border-red-200 p-3 rounded-lg">
                    <p class="text-sm text-red-800 font-semibold mb-2">
                        <i class="fas fa-exclamation-triangle mr-1"></i>Peringatan!
                    </p>
                    <ul class="text-xs text-red-700 space-y-1 ml-5 list-disc">
                        <li>User harus melengkapi data dari awal</li>
                        <li>Semua dokumen yang sudah diupload akan dihapus</li>
                        <li>Status akan berubah menjadi "Ditolak"</li>
                    </ul>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-times mr-2"></i>Tolak Verifikasi',
        cancelButtonText: '<i class="fas fa-arrow-left mr-2"></i>Batal',
        reverseButtons: true,
        focusCancel: true,
        width: '600px',
        preConfirm: () => {
            const note = document.getElementById('reject_note').value;
            if (!note.trim()) {
                Swal.showValidationMessage('Alasan penolakan harus diisi!');
                return false;
            }
            return { note };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menolak Verifikasi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            createForm(`/admin/users/${data.id}/reject`, { reject_note: result.value.note }).submit();
        }
    });
};

// Confirm Unverify
window.confirmUnverify = (userId, userName) => {
    Swal.fire({
        title: 'Batalkan Verifikasi?',
        html: `
            <div class="text-left">
                <p class="mb-2">Anda yakin ingin membatalkan verifikasi untuk:</p>
                <div class="bg-gray-100 p-3 rounded-lg mb-3">
                    <p class="font-semibold text-gray-800">${userName}</p>
                </div>
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Alasan Pembatalan <span class="text-red-500">*</span>
                    </label>
                    <textarea id="unverify_note" rows="3"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-yellow-500 focus:border-yellow-500"
                        placeholder="Contoh: Ditemukan ketidaksesuaian data..."></textarea>
                </div>
                <div class="bg-yellow-50 p-3 rounded-lg">
                    <p class="text-sm text-yellow-800">
                        <i class="fas fa-exclamation-triangle mr-1"></i>
                        User ini akan kembali ke status "Menunggu Verifikasi"
                    </p>
                </div>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#eab308',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-undo mr-2"></i>Ya, Batalkan',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        focusCancel: true,
        preConfirm: () => {
            const note = document.getElementById('unverify_note').value;
            if (!note.trim()) {
                Swal.showValidationMessage('Alasan pembatalan harus diisi!');
                return false;
            }
            return { note };
        }
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Membatalkan Verifikasi...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            createForm(`/admin/users/${userId}/unverify`, { verification_note: result.value.note }).submit();
        }
    });
};

// Confirm Delete
window.confirmDelete = (userId, userName) => {
    Swal.fire({
        title: 'Hapus User?',
        html: `
            <div class="text-left">
                <p class="mb-2">Anda yakin ingin menghapus user:</p>
                <div class="bg-gray-100 p-3 rounded-lg">
                    <p class="font-semibold text-gray-800">${userName}</p>
                </div>
                <p class="mt-3 text-red-600 text-sm">
                    <i class="fas fa-exclamation-triangle mr-1"></i>
                    Data yang dihapus tidak dapat dikembalikan!
                </p>
            </div>
        `,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc2626',
        cancelButtonColor: '#6b7280',
        confirmButtonText: '<i class="fas fa-trash mr-2"></i>Ya, Hapus!',
        cancelButtonText: '<i class="fas fa-times mr-2"></i>Batal',
        reverseButtons: true,
        focusCancel: true
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: 'Menghapus...',
                text: 'Mohon tunggu sebentar',
                allowOutsideClick: false,
                allowEscapeKey: false,
                didOpen: () => Swal.showLoading()
            });
            document.getElementById('delete-form-' + userId).submit();
        }
    });
};