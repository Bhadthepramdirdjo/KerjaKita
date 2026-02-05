<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pelamar - {{ $lowongan->judul }} - KerjaKita</title>
    
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
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Dashboard">
                <i class="fas fa-home text-lg"></i>
            </a>
            
            <!-- Lowongan Saya -->
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Lowongan Saya">
                <i class="fas fa-briefcase text-lg"></i>
            </a>

            <!-- Profil -->
            <a href="{{ route('pemberi-kerja.profil') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Profil">
                <i class="fas fa-user text-lg"></i>
            </a>

            <!-- Pengaturan -->
            <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Pengaturan">
                <i class="fas fa-cog text-lg"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen relative w-full">
        
        <!-- Header Section -->
        <div class="w-full px-6 pt-8 pb-4 flex items-center gap-4 ml-20">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-keel-black">{{ $lowongan->judul }}</h1>
                <p class="text-base text-gray-600 mt-1">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    {{ $lowongan->lokasi }}
                </p>
            </div>
        </div>

        <!-- Alert Messages -->
        @if(session('success'))
        <div class="mx-6 mt-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-check-circle mr-2"></i>
                <p>{{ session('success') }}</p>
            </div>
        </div>
        @endif

        @if(session('error'))
        <div class="mx-6 mt-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded" role="alert">
            <div class="flex items-center">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <p>{{ session('error') }}</p>
            </div>
        </div>
        @endif

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-6 py-6">
            
            @if($pelamar->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-block p-6 rounded-full bg-seafoam-bloom bg-opacity-20 mb-4">
                    <i class="fas fa-users text-5xl text-abyss-teal"></i>
                </div>
                <h3 class="text-2xl font-bold text-abyss-teal mb-2">Belum Ada Pelamar</h3>
                <p class="text-gray-500 mb-6">Belum ada pelamar untuk lowongan ini.</p>
            </div>
            @else
            <!-- Pelamar List -->
            <div class="max-w-5xl mx-auto space-y-4">
                
                @foreach($pelamar as $p)
                <!-- Pelamar Card -->
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden border-2 border-gray-200 hover:shadow-xl transition-all duration-300">
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <!-- Profile Picture -->
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-pelagic-blue to-abyss-teal flex items-center justify-center shadow-lg">
                                    <span class="text-3xl font-bold text-white">
                                        {{ substr($p->nama, 0, 1) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-xl font-bold text-keel-black">{{ $p->nama }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($p->rating_avg))
                                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                                    @else
                                                        <i class="far fa-star text-gray-300 text-sm"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-600">
                                                {{ number_format($p->rating_avg, 1) }} ({{ $p->total_rating }} ulasan)
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    @if($p->status_lamaran == 'pending')
                                        <span class="px-4 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700">Menunggu</span>
                                    @elseif($p->status_lamaran == 'diterima')
                                        <span class="px-4 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Diterima</span>
                                    @else
                                        <span class="px-4 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Ditolak</span>
                                    @endif
                                </div>

                                <!-- Details Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-tools text-pelagic-blue w-4"></i>
                                        <span><strong>Keahlian:</strong> {{ $p->keahlian ?? 'Tidak disebutkan' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-briefcase text-pelagic-blue w-4"></i>
                                        <span><strong>Pengalaman:</strong> {{ $p->pengalaman ?? 'Tidak disebutkan' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-phone text-pelagic-blue w-4"></i>
                                        <span>{{ $p->no_telp ?? 'Tidak tersedia' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-envelope text-pelagic-blue w-4"></i>
                                        <span>{{ $p->email }}</span>
                                    </div>
                                </div>

                                <div class="text-xs text-gray-500 mb-4">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Melamar pada {{ \Carbon\Carbon::parse($p->tanggal_lamaran)->format('d M Y, H:i') }}
                                </div>

                                <!-- Lihat Profil Button -->
                                <div class="mb-4">
                                    <a href="{{ route('pemberi-kerja.profil-pelamar', $p->idPekerja) }}" class="inline-flex items-center justify-center w-full px-6 py-2 border-2 border-pelagic-blue text-pelagic-blue font-bold rounded-full hover:bg-pelagic-blue hover:text-white transition-colors">
                                        <i class="fas fa-user-circle mr-2"></i>
                                        Lihat Profil Lengkap
                                    </a>
                                </div>

                                <!-- Action Buttons -->
                                @if($p->status_lamaran == 'pending')
                                <div class="flex gap-3">
                                    <button type="button" onclick="openModalTerima('{{ route('pemberi-kerja.lamaran.terima', $p->idLamaran) }}')" class="flex-1 w-full px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full transition-colors shadow-lg">
                                        <i class="fas fa-check mr-2"></i>
                                        Terima Pelamar
                                    </button>

                                    <form action="{{ route('pemberi-kerja.lamaran.tolak', $p->idLamaran) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Yakin ingin menolak pelamar ini?')" class="w-full px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-full transition-colors shadow-lg">
                                            <i class="fas fa-times mr-2"></i>
                                            Tolak
                                        </button>
                                    </form>
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif

        </div>
    </main>

    <!-- Modal Konfirmasi Terima -->
    <div id="modalTerima" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Backdrop Blur -->
        <div class="fixed inset-0 bg-black/50 backdrop-blur-sm transition-opacity opacity-0 duration-300 ease-out" id="modalBackdrop"></div>

        <div class="flex min-h-full items-center justify-center p-4 text-center sm:p-0">
            <!-- Modal Panel -->
            <div class="relative transform overflow-hidden rounded-2xl bg-white text-left shadow-2xl transition-all sm:my-8 sm:w-full sm:max-w-lg opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95 duration-300 ease-out" id="modalPanel">
                <div class="bg-white px-4 pb-4 pt-5 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex h-14 w-14 flex-shrink-0 items-center justify-center rounded-full bg-green-100 sm:mx-0 sm:h-12 sm:w-12">
                            <i class="fas fa-check text-green-600 text-xl"></i>
                        </div>
                        <div class="mt-3 text-center sm:ml-4 sm:mt-0 sm:text-left">
                            <h3 class="text-xl font-bold leading-6 text-keel-black" id="modal-title">Konfirmasi Penerimaan</h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500 leading-relaxed">
                                    Yakin ingin menerima pelamar ini? <br>
                                    <span class="text-red-500 font-medium">Warning:</span> Lamaran lain untuk lowongan ini akan otomatis <strong>Ditolak</strong>.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:flex sm:flex-row-reverse sm:px-6 gap-2">
                    <!-- Form untuk Submit -->
                    <form id="formTerima" method="POST" action="" class="w-full sm:w-auto">
                        @csrf
                        <button type="submit" class="inline-flex w-full justify-center rounded-xl bg-green-600 px-5 py-2.5 text-sm font-bold text-white shadow-sm hover:bg-green-500 transition-all duration-200">
                            Ya, Terima Pelamar
                        </button>
                    </form>
                    <button type="button" onclick="closeModalTerima()" class="mt-3 inline-flex w-full justify-center rounded-xl bg-white px-5 py-2.5 text-sm font-bold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50 transition-all duration-200 sm:mt-0 sm:w-auto">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openModalTerima(url) {
            const modal = document.getElementById('modalTerima');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            const form = document.getElementById('formTerima');
            
            // Set action URL
            form.action = url;
            
            // Show modal container
            modal.classList.remove('hidden');
            
            // Trigger animation in
            // Gunakan requestAnimationFrame agar browser me-paint state hidden->block dulu
            requestAnimationFrame(() => {
                backdrop.classList.remove('opacity-0');
                panel.classList.remove('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
                panel.classList.add('opacity-100', 'translate-y-0', 'sm:scale-100');
            });
        }

        function closeModalTerima() {
            const modal = document.getElementById('modalTerima');
            const backdrop = document.getElementById('modalBackdrop');
            const panel = document.getElementById('modalPanel');
            
            // Trigger animation out
            backdrop.classList.add('opacity-0');
            panel.classList.remove('opacity-100', 'translate-y-0', 'sm:scale-100');
            panel.classList.add('opacity-0', 'translate-y-4', 'sm:translate-y-0', 'sm:scale-95');
            
            // Hide modal container after transition finishes (300ms)
            setTimeout(() => {
                modal.classList.add('hidden');
            }, 300);
        }

        // Close modal on click outside
        document.getElementById('modalTerima').addEventListener('click', function(e) {
            if (e.target === this || e.target.id === 'modalBackdrop') {
                closeModalTerima();
            }
        });
    </script>
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
</body>
</html>