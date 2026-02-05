<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Pemberi Kerja - KerjaKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'seafoam-bloom': '#9FE7E7',
                        'shallow-reef': '#6ECBD3',
                        'pelagic-blue': '#289FB7',
                        'abyss-teal': '#146B8C',
                        'foam-white': '#E8FBFF',
                        'keel-black': '#0F1A1B',
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background-color: #E8FBFF;
        }
    </style>
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
</head>
<body class="text-keel-black h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <!-- Settings Icon -->
        <div class="mb-auto">
             <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </a>
        </div>
        
        <!-- Center Icons -->
        <div class="flex flex-col space-y-8">
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-home text-xl"></i>
            </a>
            
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button> <!-- Placeholder for future menu -->

            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-briefcase text-2xl"></i>
            </a>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 overflow-y-auto">
        <div class="max-w-6xl mx-auto p-6 lg:p-8">
            
            <!-- Header with Back Button -->
            <div class="mb-8 flex items-center gap-4">
                <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100">
                    <i class="fas fa-arrow-left text-keel-black"></i>
                </a>
                <h1 class="text-3xl font-bold text-keel-black">Profil Pemberi Kerja</h1>
            </div>

            <!-- Success/Error Messages -->
            @if(session('success'))
            <div class="mb-6 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-lg flex items-center gap-3">
                <i class="fas fa-check-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Berhasil!</p>
                    <p>{{ session('success') }}</p>
                </div>
            </div>
            @endif

            @if(session('error'))
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg flex items-center gap-3">
                <i class="fas fa-exclamation-circle text-2xl"></i>
                <div>
                    <p class="font-bold">Gagal!</p>
                    <p>{{ session('error') }}</p>
                </div>
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                <p class="font-bold mb-2"><i class="fas fa-exclamation-circle mr-2"></i>Terdapat kesalahan:</p>
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Main Profile Card -->
            <form id="profilForm" action="{{ route('pemberi-kerja.profil.update') }}" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <div class="bg-white rounded-3xl shadow-xl p-8 mb-6">
                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                        
                        <!-- Left Column - Photo & Rating -->
                        <div class="flex flex-col items-center">
                            <!-- Profile Photo -->
                            <div class="w-40 h-40 rounded-full bg-gray-200 border-4 border-pelagic-blue flex items-center justify-center mb-4 overflow-hidden relative">
                                <img id="previewFoto" 
                                     src="{{ auth()->user()->foto_profil ? asset('storage/' . auth()->user()->foto_profil) : '' }}" 
                                     alt="Foto Profil" 
                                     class="w-full h-full object-cover {{ auth()->user()->foto_profil ? '' : 'hidden' }}">
                                <i id="placeholderIcon" class="fas fa-user-tie text-6xl text-gray-400 {{ auth()->user()->foto_profil ? 'hidden' : '' }}"></i>
                            </div>
                            
                            <!-- Upload Photo Button -->
                            <button type="button" 
                                    id="btnUbahFoto" 
                                    onclick="document.getElementById('fotoInput').click()" 
                                    disabled
                                    class="px-4 py-2 bg-pelagic-blue hover:bg-abyss-teal disabled:opacity-50 disabled:cursor-not-allowed text-white rounded-lg transition-colors text-sm mb-4">
                                <i class="fas fa-camera mr-2"></i>
                                Ubah Foto
                            </button>
                            <input type="file" id="fotoInput" name="foto_profil" class="hidden" accept="image/*">
                            <p id="fotoFileName" class="text-xs text-gray-500 mb-4"></p>
                        </div>
                        
                        <!-- Right Column - Profile Info -->
                        <div class="lg:col-span-2 space-y-4">
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nama Lengkap</label>
                                <input type="text" 
                                       id="inputNamaHidden"
                                       value="{{ auth()->user()->nama }}" 
                                       readonly 
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black font-medium focus:outline-none focus:border-pelagic-blue transition-colors">
                                <!-- Note: User name update usually handled separately or locked -->
                            </div>
                            
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nama Perusahaan / Usaha</label>
                                <input type="text" 
                                       name="nama_perusahaan"
                                       id="inputPerusahaan"
                                       value="{{ $pemberiKerja->nama_perusahaan ?? '' }}" 
                                       readonly 
                                       placeholder="Nama Usaha (Opsional)"
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black focus:outline-none focus:border-pelagic-blue transition-colors">
                            </div>
                            
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Alamat Lengkap</label>
                                <input type="text" 
                                       name="alamat"
                                       id="inputAlamat"
                                       value="{{ $pemberiKerja->alamat ?? '' }}" 
                                       readonly 
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black focus:outline-none focus:border-pelagic-blue transition-colors">
                            </div>
                            
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nomor Kontak (Telp/WA)</label>
                                <input type="text" 
                                       name="no_telp"
                                       id="inputNoTelp"
                                       value="{{ $pemberiKerja->no_telp ?? '' }}" 
                                       readonly 
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black focus:outline-none focus:border-pelagic-blue transition-colors">
                            </div>
                            
                            <!-- Action Buttons -->
                            <div class="pt-4 flex gap-3">
                                <!-- Edit Button (Default) -->
                                <button type="button" 
                                        id="btnEdit" 
                                        onclick="toggleEditMode(true)"
                                        class="px-6 py-3 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold rounded-full transition-colors">
                                    <i class="fas fa-edit mr-2"></i>
                                    Edit Profil
                                </button>
                                
                                <!-- Save & Cancel Buttons (Hidden by default) -->
                                <button type="submit" 
                                        id="btnSimpan" 
                                        class="hidden px-6 py-3 bg-green-600 hover:bg-green-700 text-white font-bold rounded-full transition-colors">
                                    <i class="fas fa-save mr-2"></i>
                                    Simpan
                                </button>
                                
                                <button type="button" 
                                        id="btnBatal" 
                                        onclick="toggleEditMode(false)"
                                        class="hidden px-6 py-3 bg-gray-400 hover:bg-gray-500 text-white font-bold rounded-full transition-colors">
                                    <i class="fas fa-times mr-2"></i>
                                    Batal
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <!-- Riwayat Lowongan Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-6">
                <h2 class="text-2xl font-bold text-keel-black mb-6">Riwayat Lowongan</h2>
                
                <div class="space-y-4">
                    @forelse($riwayatLowongan as $lowongan)
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-keel-black mb-1">{{ $lowongan->judul }}</h3>
                                <div class="flex items-center gap-2 text-sm text-gray-600">
                                    <i class="fas fa-map-marker-alt text-pelagic-blue"></i>
                                    <span>{{ $lowongan->lokasi }}</span>
                                </div>
                            </div>
                            @if($lowongan->status == 'aktif')
                                <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-xs font-bold">Aktif</span>
                            @else
                                <span class="px-3 py-1 bg-gray-200 text-gray-700 rounded-full text-xs font-bold">{{ ucfirst($lowongan->status) }}</span>
                            @endif
                        </div>
                        
                        <p class="text-gray-700 mb-3 line-clamp-2">{{ $lowongan->deskripsi }}</p>
                        
                        <div class="flex items-center gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-money-bill-wave text-green-600"></i>
                                <span class="font-semibold">Rp {{ number_format($lowongan->upah, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center gap-2">
                                <i class="far fa-calendar-alt text-pelagic-blue"></i>
                                <span>{{ \Carbon\Carbon::parse($lowongan->created_at)->format('d M Y') }}</span>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-300">
                        <i class="fas fa-clipboard-list text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Belum ada riwayat lowongan</p>
                        <a href="{{ route('pemberi-kerja.buat-lowongan') }}" class="text-pelagic-blue hover:underline text-sm mt-1">Buat lowongan pertama Anda</a>
                    </div>
                    @endforelse
                </div>
            </div>


        </div>
    </main>

    <script>
        // Store original values for cancel
        let originalValues = {};
        
        // Toggle Edit Mode
        function toggleEditMode(isEdit) {
            const inputs = ['inputPerusahaan', 'inputAlamat', 'inputNoTelp'];
            const btnEdit = document.getElementById('btnEdit');
            const btnSimpan = document.getElementById('btnSimpan');
            const btnBatal = document.getElementById('btnBatal');
            const btnUbahFoto = document.getElementById('btnUbahFoto');
            
            if (isEdit) {
                // Save original values
                inputs.forEach(id => {
                    const input = document.getElementById(id);
                    originalValues[id] = input.value;
                    input.readOnly = false;
                    input.classList.remove('bg-gray-100');
                    input.classList.add('bg-white', 'border-2');
                });
                
                // Toggle buttons - enable ubah foto
                btnEdit.classList.add('hidden');
                btnSimpan.classList.remove('hidden');
                btnBatal.classList.remove('hidden');
                btnUbahFoto.disabled = false;
                btnUbahFoto.style.opacity = '1';
                btnUbahFoto.style.pointerEvents = 'auto';
            } else {
                // Restore original values
                inputs.forEach(id => {
                    const input = document.getElementById(id);
                    input.value = originalValues[id] || input.value;
                    input.readOnly = true;
                    input.classList.add('bg-gray-100');
                    input.classList.remove('bg-white', 'border-2');
                });
                
                // Reset foto input
                document.getElementById('fotoInput').value = '';
                document.getElementById('fotoFileName').textContent = '';
                
                // Toggle buttons - disable ubah foto
                btnEdit.classList.remove('hidden');
                btnSimpan.classList.add('hidden');
                btnBatal.classList.add('hidden');
                btnUbahFoto.disabled = true;
                btnUbahFoto.style.opacity = '0.5';
                btnUbahFoto.style.pointerEvents = 'none';
            }
        }
        
        // Preview foto sebelum upload
        document.getElementById('fotoInput')?.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validasi ukuran file (max 2MB)
                if (file.size > 2 * 1024 * 1024) {
                    alert('❌ Ukuran file terlalu besar! Maksimal 2MB.');
                    e.target.value = '';
                    return;
                }
                
                // Validasi tipe file
                if (!file.type.startsWith('image/')) {
                    alert('❌ File harus berupa gambar!');
                    e.target.value = '';
                    return;
                }
                
                // Preview foto
                const reader = new FileReader();
                reader.onload = function(event) {
                    const previewFoto = document.getElementById('previewFoto');
                    const placeholderIcon = document.getElementById('placeholderIcon');
                    
                    previewFoto.src = event.target.result;
                    previewFoto.classList.remove('hidden');
                    placeholderIcon.classList.add('hidden');
                };
                reader.readAsDataURL(file);
                
                // Tampilkan nama file
                document.getElementById('fotoFileName').textContent = '📷 ' + file.name;
                
                // Auto enable edit mode jika belum
                const btnEdit = document.getElementById('btnEdit');
                if (!btnEdit.classList.contains('hidden')) {
                    toggleEditMode(true);
                }
            }
        });
    </script>

</body>
</html>
