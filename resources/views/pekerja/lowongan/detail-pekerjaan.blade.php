<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Detail Pekerjaan - KerjaKita</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;600;700&display=swap" rel="stylesheet">
    
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
                    },
                    fontFamily: {
                        'poppins': ['Poppins', 'sans-serif'],
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
        
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        .no-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
    </style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">

    <!-- Speed Dial Navigation -->
    <div id="speed-dial-container" class="fixed top-6 left-6 z-50 flex flex-col items-center gap-4">
        <!-- Trigger Button (Logo) -->
        <button id="speed-dial-trigger" class="w-16 h-16 rounded-full bg-white shadow-xl border border-gray-100 flex items-center justify-center relative z-20 transition-all duration-300 hover:scale-110 hover:shadow-2xl focus:outline-none">
             <img src="{{ asset('images/LOGO.png') }}" alt="Menu" class="w-10 h-10 object-contain">
        </button>

        <!-- Menu Items -->
        <div id="speed-dial-menu" class="flex flex-col gap-3 items-center opacity-0 -translate-y-4 scale-90 pointer-events-none transition-all duration-300 ease-out origin-top">
            <!-- Dashboard -->
            <a href="{{ route('pekerja.dashboard') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Dashboard">
                <i class="fas fa-home text-lg"></i>
            </a>
            
            <!-- Lamaran Saya -->
            <a href="{{ route('pekerja.lamaran') }}" class="w-12 h-12 rounded-full bg-keel-black text-white shadow-lg flex items-center justify-center hover:bg-keel-black hover:text-white transition-all duration-200 transform hover:scale-110" title="Lamaran Saya">
                <i class="fas fa-briefcase text-lg"></i>
            </a>

            <!-- Profil -->
            <a href="{{ route('pekerja.profil') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Profil">
                <i class="fas fa-user text-lg"></i>
            </a>

            <!-- Pengaturan -->
            <a href="{{ route('pekerja.pengaturan') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Pengaturan">
                <i class="fas fa-cog text-lg"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen relative w-full">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4 pl-28">
            <!-- Back Button -->
            <a href="javascript:history.back()" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 relative">
                <input type="text" 
                       placeholder="Cari pekerjaan..." 
                       class="w-full bg-white border-2 border-keel-black rounded-full py-2 px-6 focus:outline-none focus:ring-2 focus:ring-pelagic-blue shadow-sm">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-search text-keel-black"></i>
                </button>
            </div>

            <!-- Profile Icon -->
            <a href="{{ route('pekerja.profil') }}" class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <i class="far fa-user text-2xl text-keel-black"></i>
                @endif
            </a>
        </header>

        <!-- Page Title -->
        <div class="px-8 pb-4">
            <h1 class="text-xl md:text-2xl font-bold text-gray-700">Detail Pekerjaan</h1>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 sm:px-8 pb-20">
            
            <!-- Main Content Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                
                <!-- Left Column - Job Details -->
                <div class="lg:col-span-2 space-y-6">
                    
                    <!-- Job Info Card -->
                    <div class="bg-white rounded-3xl shadow-lg p-6 border-2 border-gray-200">
                        <!-- Job Title -->
                        <div class="mb-6">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider">Nama Pekerjaan</span>
                            <h2 class="text-2xl md:text-3xl font-bold text-keel-black mt-1">{{ $lowongan->judul }}</h2>
                        </div>

                        <!-- Category Badge -->
                        <div class="mb-6">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Kategori Pekerjaan</span>
                            @if($lowongan->nama_kategori)
                            <span class="inline-block bg-pelagic-blue text-white px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-briefcase mr-2"></i>{{ $lowongan->nama_kategori }}
                            </span>
                            @else
                            <span class="inline-block bg-gray-400 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                <i class="fas fa-briefcase mr-2"></i>Umum
                            </span>
                            @endif
                        </div>

                        <!-- Location & Description -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">
                            <!-- Location -->
                            <div class="bg-foam-white rounded-2xl p-4 border border-gray-200">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Lokasi Pekerjaan</span>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-pelagic-blue text-lg"></i>
                                    <span class="font-semibold text-keel-black">{{ $lowongan->lokasi }}</span>
                                </div>
                            </div>

                            <!-- Company -->
                            <div class="bg-foam-white rounded-2xl p-4 border border-gray-200">
                                <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Pemberi Kerja</span>
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-building text-pelagic-blue text-lg"></i>
                                    <span class="font-semibold text-keel-black">{{ $lowongan->nama_perusahaan ?? $lowongan->nama_pemberi_kerja }}</span>
                                </div>
                            </div>
                        </div>

                        <!-- Full Description -->
                        <div class="mb-6">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-2">Deskripsi Lengkap</span>
                            <div class="bg-gray-50 rounded-2xl p-4 border border-gray-200">
                                <p class="text-gray-700 leading-relaxed">
                                    {{ $lowongan->deskripsi }}
                                </p>
                            </div>
                        </div>

                        <!-- Gambar Pekerjaan -->
                        <div class="mb-6">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Gambar Pekerjaan</span>
                            
                            @php
                                $gambar = [];
                                if (isset($lowongan->gambar) && $lowongan->gambar) {
                                    $gambar[] = asset('storage/' . $lowongan->gambar);
                                }
                            @endphp
                            
                            @if(count($gambar) > 0)
                                <!-- Grid Gambar (Maksimal 5) -->
                                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                                    @foreach(array_slice($gambar, 0, 5) as $img)
                                    <div class="relative group overflow-hidden rounded-2xl border-2 border-gray-200 aspect-video bg-gray-100 hover:border-pelagic-blue transition-all duration-300">
                                        <img src="{{ $img }}" 
                                             alt="Gambar Pekerjaan" 
                                             class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-300">
                                        <!-- Overlay on hover -->
                                        <div class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center">
                                            <i class="fas fa-search-plus text-white text-2xl opacity-0 group-hover:opacity-100 transition-opacity duration-300"></i>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            @else
                                <!-- Empty State - Tidak Ada Gambar -->
                                <div class="bg-gray-50 rounded-2xl p-8 border-2 border-dashed border-gray-300 text-center">
                                    <div class="inline-block p-4 rounded-full bg-gray-200 mb-3">
                                        <i class="fas fa-image text-3xl text-gray-400"></i>
                                    </div>
                                    <p class="text-gray-500 font-medium">Pemberi kerja belum menambahkan gambar</p>
                                    <p class="text-gray-400 text-sm mt-1">Hubungi pemberi kerja untuk informasi lebih detail</p>
                                </div>
                            @endif
                        </div>

                        <!-- Additional Info -->
                        <div class="mb-6">
                            <span class="text-xs font-bold text-gray-500 uppercase tracking-wider block mb-3">Informasi Tambahan</span>
                            <div class="space-y-2">
                                <div class="flex items-center gap-3 text-gray-700">
                                    <i class="fas fa-calendar-plus text-pelagic-blue w-5"></i>
                                    <span>Diposting: {{ \Carbon\Carbon::parse($lowongan->created_at)->format('d M Y') }}</span>
                                </div>
                                <div class="flex items-center gap-3 text-gray-700">
                                    <i class="fas fa-info-circle text-pelagic-blue w-5"></i>
                                    <span>Status: <span class="font-semibold text-green-600">{{ ucfirst($lowongan->status) }}</span></span>
                                </div>
                                @if($lowongan->telp_perusahaan)
                                <div class="flex items-center gap-3 text-gray-700">
                                    <i class="fas fa-phone text-pelagic-blue w-5"></i>
                                    <span>Kontak: {{ $lowongan->telp_perusahaan }}</span>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>

                </div>

                <!-- Right Column - Action Card -->
                <div class="lg:col-span-1">
                    <div class="bg-keel-black rounded-3xl shadow-xl overflow-hidden sticky top-4">
                        <!-- Header -->
                        <div class="bg-gradient-to-br from-pelagic-blue to-abyss-teal p-6">
                            <h3 class="text-white text-lg font-bold mb-1">Jenis Pekerjaan</h3>
                            <p class="text-seafoam-bloom text-sm">Pekerjaan Serabutan</p>
                        </div>

                        <!-- Payment Info -->
                        <div class="p-6 space-y-4">
                            <!-- Bayaran -->
                            <div class="bg-[#1a2526] rounded-2xl p-4">
                                <span class="text-seafoam-bloom text-xs font-bold uppercase tracking-wider block mb-2">Bayaran</span>
                                <div class="text-white text-2xl font-bold">Rp {{ number_format($lowongan->upah, 0, ',', '.') }}</div>
                            </div>

                            <!-- Durasi -->
                            <div class="bg-[#1a2526] rounded-2xl p-4">
                                <span class="text-seafoam-bloom text-xs font-bold uppercase tracking-wider block mb-2">Durasi Kerja</span>
                                <div class="text-white text-lg font-semibold">Hubungi Pemberi Kerja</div>
                            </div>

                            <!-- Apply Button -->
                            <!-- Apply Button -->
                            @if(isset($sudahMelamar) && $sudahMelamar)
                                <div class="relative group w-full">
                                    <button disabled class="w-full bg-gray-600 text-white font-bold py-4 px-6 rounded-full cursor-not-allowed flex items-center justify-center gap-2 opacity-80">
                                        <i class="fas fa-check-circle"></i>
                                        <span>Anda sudah melamar ke Lowongan ini</span>
                                    </button>
                                    
                                    <!-- Custom Popover -->
                                    <div class="absolute bottom-full left-1/2 transform -translate-x-1/2 mb-3 w-64 p-4 bg-keel-black text-white text-sm rounded-xl shadow-2xl opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all duration-300 text-center z-20 border border-gray-700">
                                        <p class="leading-relaxed">Silahkan tunggu kabar dari <span class="font-bold text-seafoam-bloom">{{ $lowongan->nama_perusahaan ?? $lowongan->nama_pemberi_kerja }}</span></p>
                                        <!-- Arrow -->
                                        <div class="absolute top-full left-1/2 transform -translate-x-1/2 border-8 border-transparent border-t-keel-black"></div>
                                    </div>
                                </div>
                            @else
                                <button id="lamarBtn" class="w-full bg-seafoam-bloom hover:bg-shallow-reef text-keel-black font-bold py-4 px-6 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                    <i class="fas fa-paper-plane"></i>
                                    <span>Lamar Sekarang</span>
                                </button>
                            @endif

                            <!-- WhatsApp Contact Button -->
                            @if($lowongan->telp_perusahaan)
                            <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $lowongan->telp_perusahaan) }}?text=Halo%20{{ urlencode($lowongan->nama_perusahaan ?? $lowongan->nama_pemberi_kerja) }},%20saya%20tertarik%20dengan%20lowongan%20{{ urlencode($lowongan->judul) }}" 
                               target="_blank"
                               class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 px-6 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <i class="fab fa-whatsapp text-2xl"></i>
                                <span>Hubungi {{ Str::limit($lowongan->nama_perusahaan ?? $lowongan->nama_pemberi_kerja, 15) }}</span>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

    <!-- Modal Konfirmasi Lamaran -->
    <div id="lamaranModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
            <!-- Icon -->
            <div class="w-16 h-16 rounded-full bg-pelagic-blue bg-opacity-20 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-briefcase text-3xl text-pelagic-blue"></i>
            </div>
            
            <!-- Title -->
            <h3 class="text-2xl font-bold text-center text-keel-black mb-2">Konfirmasi Lamaran</h3>
            <p class="text-center text-gray-600 mb-6">
                Apakah Anda yakin ingin melamar pekerjaan ini? 
                <br><br>
                <span class="text-sm font-semibold text-pelagic-blue">
                    Dengan melamar, Anda berkomitmen untuk bertanggung jawab dan menyelesaikan pekerjaan dengan baik sesuai kesepakatan.
                </span>
            </p>
            
            <!-- Job Info Summary -->
            <div class="bg-foam-white rounded-2xl p-4 mb-6">
                <div class="flex items-center gap-3 mb-2">
                    <i class="fas fa-briefcase text-pelagic-blue"></i>
                    <span class="font-bold text-keel-black">{{ $lowongan->judul }}</span>
                </div>
                <div class="flex items-center gap-3 text-sm text-gray-600">
                    <i class="fas fa-money-bill-wave text-green-600"></i>
                    <span>Rp {{ number_format($lowongan->upah, 0, ',', '.') }}</span>
                </div>
            </div>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button id="cancelLamar" class="flex-1 bg-gray-200 hover:bg-gray-300 text-keel-black font-bold py-3 px-6 rounded-full transition-colors">
                    Batal
                </button>
                <button id="confirmLamar" class="flex-1 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- Success Modal -->
    <div id="successModal" class="hidden fixed inset-0 z-[60] flex items-center justify-center bg-black bg-opacity-50 transition-opacity duration-300 opacity-0 pointer-events-none">
        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-4 text-center transform scale-90 transition-transform duration-300">
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-check text-4xl text-green-500"></i>
            </div>
            <h3 class="text-2xl font-bold text-keel-black mb-2">Berhasil!</h3>
            <p class="text-gray-600">Lamaran Anda telah berhasil dikirim.</p>
        </div>
    </div>

    <script>
        // Speed Dial Navigation Logic
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('speed-dial-container');
            const menu = document.getElementById('speed-dial-menu');
            const trigger = document.getElementById('speed-dial-trigger');
            let isLocked = false;

            if (container && menu && trigger) {
                function toggleMenu() {
                    isLocked = !isLocked;
                    if (isLocked) {
                        menu.classList.remove('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                        menu.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                        trigger.classList.add('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    } else {
                        menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                        menu.classList.add('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                        trigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    }
                }

                function closeMenu() {
                    isLocked = false;
                    menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                    menu.classList.add('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                    trigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                }

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleMenu();
                });

                // Close if clicked outside
                document.addEventListener('click', (e) => {
                    if (isLocked && !container.contains(e.target)) {
                        closeMenu();
                    }
                });
            }
        });
    </script>

    <script>
        // Modal Lamaran
        const lamarBtn = document.getElementById('lamarBtn');
        const lamaranModal = document.getElementById('lamaranModal');
        const cancelLamar = document.getElementById('cancelLamar');
        const confirmLamar = document.getElementById('confirmLamar');

        // Open modal
        if (lamarBtn) {
            lamarBtn.addEventListener('click', () => {
                lamaranModal.classList.remove('hidden');
                lamaranModal.classList.add('flex');
            });
        }

        // Close modal
        cancelLamar.addEventListener('click', () => {
            lamaranModal.classList.add('hidden');
            lamaranModal.classList.remove('flex');
        });

        // Confirm lamaran - Submit ke backend
        confirmLamar.addEventListener('click', async () => {
            // Disable button dan tampilkan loading
            confirmLamar.disabled = true;
            confirmLamar.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i> Mengirim...';
            
            try {
                // Get CSRF token
                const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');
                
                // Submit lamaran via AJAX
                const response = await fetch("{{ route('pekerja.lowongan.lamar', $lowongan->idLowongan) }}", {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken || '',
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        idLowongan: {{ $lowongan->idLowongan }}
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    // 1. Close Confirmation Modal
                    lamaranModal.classList.add('hidden');
                    lamaranModal.classList.remove('flex');

                    // 2. Show Success Modal
                    const successModal = document.getElementById('successModal');
                    successModal.classList.remove('hidden', 'opacity-0', 'pointer-events-none');
                    successModal.classList.add('flex', 'opacity-100');
                    
                    // Animation for content
                    setTimeout(() => {
                        const modalContent = successModal.querySelector('div');
                        modalContent.classList.remove('scale-90');
                        modalContent.classList.add('scale-100');
                    }, 10);

                    // 3. Redirect Logic
                    const redirect = () => {
                        window.location.href = "{{ route('pekerja.lamaran') }}";
                    };

                    // Auto redirect after 3s
                    const timer = setTimeout(redirect, 3000);

                    // Click anywhere to dismiss and redirect immediately
                    successModal.addEventListener('click', () => {
                        clearTimeout(timer);
                        redirect();
                    }, { once: true });
                } else {
                    // Error dari server
                    alert('❌ ' + (data.message || 'Gagal mengirim lamaran. Silakan coba lagi.'));
                    
                    // Reset button
                    confirmLamar.disabled = false;
                    confirmLamar.innerHTML = 'Lanjutkan';
                }
            } catch (error) {
                console.error('Error:', error);
                alert('❌ Terjadi kesalahan. Silakan coba lagi.');
                
                // Reset button
                confirmLamar.disabled = false;
                confirmLamar.innerHTML = 'Lanjutkan';
            }
            
            // Close modal
            lamaranModal.classList.add('hidden');
            lamaranModal.classList.remove('flex');
        });

        // Close modal when clicking backdrop
        lamaranModal.addEventListener('click', (e) => {
            if (e.target === lamaranModal) {
                lamaranModal.classList.add('hidden');
                lamaranModal.classList.remove('flex');
            }
        });
    </script>


</body>
</html>
