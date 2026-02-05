<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Profil Pekerja - KerjaKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'seafoam-bloom': '#A8E6CF',
                        'shallow-reef': '#7FCFB8',
                        'pelagic-blue': '#289FB7',
                        'abyss-teal': '#146B8C',
                        'foam-white': '#F8FFFE',
                        'keel-black': '#1A1A1A'
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background: linear-gradient(135deg, #F8FFFE 0%, #E8F5F1 100%);
        }
    </style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <!-- Settings Icon -->
        <div class="mb-auto">
             <a href="{{ route('pekerja.pengaturan') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </a>
        </div>
        
        <!-- Center Icons -->
        <div class="flex flex-col space-y-8">
            <a href="{{ route('pekerja.dashboard') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-home text-xl"></i>
            </a>
            
            <a href="{{ route('pekerja.lamaran') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
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
                <a href="{{ route('pekerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100">
                    <i class="fas fa-arrow-left text-keel-black"></i>
                </a>
                <h1 class="text-3xl font-bold text-keel-black">Profil Pekerja</h1>
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
            <form id="profilForm" action="{{ route('pekerja.profil.update') }}" method="POST" enctype="multipart/form-data">
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
                                <i id="placeholderIcon" class="fas fa-user text-6xl text-gray-400 {{ auth()->user()->foto_profil ? 'hidden' : '' }}"></i>
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
                            
                            <!-- Rating -->
                            <div class="bg-seafoam-bloom bg-opacity-30 rounded-2xl p-4 w-full text-center">
                                <p class="text-sm text-gray-600 mb-1">Rating Pekerja</p>
                                <div class="flex items-center justify-center gap-2">
                                    <div class="flex text-yellow-400">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($rating ?? 0))
                                                <i class="fas fa-star"></i>
                                            @elseif($i - ($rating ?? 0) < 1)
                                                <i class="fas fa-star-half-alt"></i>
                                            @else
                                                <i class="far fa-star"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span class="text-2xl font-bold text-keel-black">{{ number_format($rating ?? 0, 1) }}</span>
                                </div>
                                <p class="text-xs text-gray-500 mt-1">{{ $totalRating ?? 0 }} ulasan</p>
                            </div>
                        </div>
                        
                        <!-- Right Column - Profile Info -->
                        <div class="lg:col-span-2 space-y-4">
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nama Pekerja</label>
                                <input type="text" 
                                       name="nama" 
                                       id="inputNama"
                                       value="{{ auth()->user()->nama }}" 
                                       readonly 
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black font-medium focus:outline-none focus:border-pelagic-blue transition-colors">
                            </div>
                            
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Usia Pekerja</label>
                                <input type="number" 
                                       name="usia"
                                       id="inputUsia"
                                       value="{{ $pekerja->usia ?? '' }}" 
                                       readonly 
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black focus:outline-none focus:border-pelagic-blue transition-colors">
                            </div>
                            
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Alamat Rumah</label>
                                <input type="text" 
                                       name="alamat"
                                       id="inputAlamat"
                                       value="{{ $pekerja->alamat ?? '' }}" 
                                       readonly 
                                       class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black focus:outline-none focus:border-pelagic-blue transition-colors">
                            </div>
                            
                            <div>
                                <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nomor Kontak</label>
                                <input type="text" 
                                       name="no_telp"
                                       id="inputNoTelp"
                                       value="{{ $pekerja->no_telp ?? '' }}" 
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

            <!-- Skills Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="text-2xl font-bold text-keel-black">Keahlian</h2>
                    <button onclick="openAddSkillModal()" class="w-10 h-10 rounded-full bg-pelagic-blue hover:bg-abyss-teal text-white flex items-center justify-center transition-colors">
                        <i class="fas fa-plus"></i>
                    </button>
                </div>
                
                <div class="flex flex-wrap gap-3">
                    @php
                        $keahlian = explode(',', $pekerja->keahlian ?? '');
                    @endphp
                    
                    @if(!empty($pekerja->keahlian))
                        @foreach($keahlian as $skill)
                            <span class="px-4 py-2 bg-pelagic-blue text-white rounded-full font-medium text-sm">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    @else
                        <p class="text-gray-500 italic">Belum ada keahlian ditambahkan</p>
                    @endif
                </div>
            </div>

            <!-- Work Experience Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-keel-black mb-6">Pengalaman Pekerjaan</h2>
                
                <div class="space-y-4">
                    @forelse($pengalamanKerja as $pengalaman)
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-keel-black mb-1">{{ $pengalaman->judul }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $pengalaman->nama_perusahaan }}</p>
                            </div>
                            <button class="px-3 py-1 bg-red-100 hover:bg-red-200 text-red-600 rounded-lg text-xs font-medium transition-colors">
                                <i class="fas fa-trash"></i>
                            </button>
                        </div>
                        
                        <p class="text-gray-700 mb-3">{{ $pengalaman->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        
                        <div class="flex items-center gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-pelagic-blue"></i>
                                <span>Durasi: {{ $pengalaman->durasi ?? '-' }}</span>
                            </div>
                            @if($pengalaman->tanggal_selesai)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-check text-green-600"></i>
                                <span>Selesai: {{ \Carbon\Carbon::parse($pengalaman->tanggal_selesai)->format('M Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-300">
                        <i class="fas fa-briefcase text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Belum ada pengalaman pekerjaan</p>
                        <p class="text-gray-400 text-sm mt-1">Selesaikan pekerjaan untuk menambah pengalaman</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mt-6 mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-bold text-keel-black">Ulasan & Rating</h2>
                    <span class="bg-seafoam-bloom text-abyss-teal text-xs font-bold px-3 py-1 rounded-full">
                        {{ $totalRating ?? 0 }} Total
                    </span>
                </div>
                
                <div class="space-y-6">
                    @forelse($ulasanList as $review)
                    <div class="border-b border-gray-100 last:border-0 pb-6 last:pb-0">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-pelagic-blue flex items-center justify-center text-white text-lg font-bold">
                                    {{ substr($review->nama_pemberi_kerja, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-keel-black">{{ $review->nama_pemberi_kerja }}</h4>
                                    <p class="text-xs text-gray-500">{{ $review->judul_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center justify-end gap-1 text-yellow-400 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->nilai_rating)
                                            <i class="fas fa-star text-sm"></i>
                                        @else
                                            <i class="far fa-star text-sm text-gray-300"></i>
                                        @endif
                                    @endfor
                                    <span class="text-sm font-bold text-gray-700 ml-1">{{ $review->nilai_rating }}.0</span>
                                </div>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            {{ $review->ulasan }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                            <i class="far fa-comment-dots text-2xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada ulasan yang diterima.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <!-- Modal Add Skill -->
    <div id="addSkillModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4">
            <h3 class="text-2xl font-bold text-keel-black mb-4">Tambah Keahlian</h3>
            
            <form action="{{ route('pekerja.keahlian.tambah') }}" method="POST">
                @csrf
                <input type="text" name="keahlian" id="newSkillInput" placeholder="Contoh: Web Design" class="w-full px-4 py-3 border-2 border-gray-300 rounded-lg focus:border-pelagic-blue focus:outline-none mb-4" required>
                
                <div class="flex gap-3">
                    <button type="button" onclick="closeAddSkillModal()" class="flex-1 bg-gray-200 hover:bg-gray-300 text-keel-black font-bold py-3 px-6 rounded-full transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors">
                        Tambah
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Store original values for cancel
        let originalValues = {};
        
        // Toggle Edit Mode
        function toggleEditMode(isEdit) {
            const inputs = ['inputNama', 'inputUsia', 'inputAlamat', 'inputNoTelp'];
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
        
        // Modal Add Skill
        function openAddSkillModal() {
            document.getElementById('addSkillModal').classList.remove('hidden');
            document.getElementById('addSkillModal').classList.add('flex');
            // Auto focus
            const input = document.getElementById('newSkillInput');
            if(input) setTimeout(() => input.focus(), 100);
        }

        function closeAddSkillModal() {
            document.getElementById('addSkillModal').classList.add('hidden');
            document.getElementById('addSkillModal').classList.remove('flex');
            const input = document.getElementById('newSkillInput');
            if(input) input.value = '';
        }
    </script>

</body>
</html>
