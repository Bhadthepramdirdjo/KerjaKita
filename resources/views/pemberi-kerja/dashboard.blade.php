<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Pemberi Kerja - KerjaKita</title>
    
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
        body { font-family: 'Poppins', sans-serif; background-color: #E8FBFF; }
        
        /* Hide scrollbar */
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }
        
        /* Horizontal Scroll Snap */
        .scrolling-wrapper {
            -webkit-overflow-scrolling: touch;
            scroll-snap-type: x mandatory;
        }
        .card-snap {
            scroll-snap-align: center;
        }
    </style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">

    <!-- Sidebar (Floating Style) -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <div class="mb-auto">
             <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </a>
        </div>
        <div class="flex flex-col space-y-8">
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-home text-xl"></i>
            </button>
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-briefcase text-2xl"></i>
            </button>
        </div>
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4">
            <!-- Logo Icon -->
            <div class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0 p-1.5">
                <img src="{{ asset('images/LOGO.png') }}" alt="KerjaKita Logo" class="w-full h-full object-contain">
            </div>

            <!-- Search Bar -->
            <div class="flex-1 relative">
                <input type="text" placeholder="Cari..." class="w-full bg-white border-2 border-keel-black rounded-full py-2 px-6 focus:outline-none focus:ring-2 focus:ring-pelagic-blue shadow-sm">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-search text-keel-black"></i>
                </button>
            </div>

            <!-- "Pasang Lowongan" Button            <!-- Desktop Add Button -->
            <a href="{{ route('pemberi-kerja.buat-lowongan') }}" class="hidden md:flex items-center gap-2 bg-keel-black text-white px-6 py-2 rounded-full hover:bg-gray-800 transition-colors font-semibold">
                <i class="fas fa-plus"></i> Pasang Lowongan
            </a>

            <!-- Mobile Add Button -->
            <a href="{{ route('pemberi-kerja.buat-lowongan') }}" class="md:hidden w-10 h-10 rounded-full bg-keel-black text-white flex items-center justify-center hover:bg-gray-800">
                <i class="fas fa-plus"></i>
            </a>

            <!-- Profile Icon -->
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="far fa-user text-2xl text-keel-black"></i>
            </button>
        </header>

        <!-- Page Title & Stats Grid -->
        <div class="px-8 pb-4 flex flex-col gap-6">
            <h1 class="text-xl md:text-2xl font-bold text-gray-700 hidden">Halaman Dashboard Pemberi Kerja</h1>
            
            <!-- Statistics Cards (White Cards with Shadow based on wireframe) -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                <!-- Stat 1 -->
                <div class="bg-white border text-center p-4 rounded-xl shadow-md transform hover:-translate-y-1 transition-transform">
                    <div class="text-3xl font-bold text-keel-black mb-1">{{ $stats['lowongan_aktif'] }}</div>
                    <div class="text-sm font-semibold text-gray-600 leading-tight">Lowongan Aktif</div>
                </div>
                <!-- Stat 2 -->
                <div class="bg-white border text-center p-4 rounded-xl shadow-md transform hover:-translate-y-1 transition-transform">
                    <div class="text-3xl font-bold text-keel-black mb-1">{{ $stats['pelamar_baru'] }}</div>
                    <div class="text-sm font-semibold text-gray-600 leading-tight">Pelamar Baru<br>Hari Ini</div>
                </div>
                <!-- Stat 3 -->
                <div class="bg-white border text-center p-4 rounded-xl shadow-md transform hover:-translate-y-1 transition-transform">
                    <div class="text-3xl font-bold text-keel-black mb-1">{{ $stats['dalam_proses'] }}</div>
                    <div class="text-sm font-semibold text-gray-600 leading-tight">Dalam Proses</div>
                </div>
                <!-- Stat 4 -->
                <div class="bg-white border text-center p-4 rounded-xl shadow-md transform hover:-translate-y-1 transition-transform">
                    <div class="text-3xl font-bold text-keel-black mb-1">{{ $stats['pekerjaan_selesai'] }}</div>
                    <div class="text-sm font-semibold text-gray-600 leading-tight">Pekerjaan Selesai</div>
                </div>
            </div>
        </div>

        <!-- Slider Section (The Jobs) -->
        <div class="flex-1 flex items-center relative px-2 md:px-8 pb-8 overflow-hidden">
            
            <!-- Left Arrow -->
            <button id="scrollLeft" class="absolute left-2 md:left-4 z-20 w-10 h-10 md:w-12 md:h-12 bg-transparent hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                <i class="fas fa-chevron-left text-3xl md:text-4xl text-keel-black"></i>
            </button>

            <!-- Scrollable Container -->
            <div id="cardContainer" class="scrolling-wrapper flex gap-6 px-12 overflow-x-auto no-scrollbar w-full py-4 items-center h-full">
                
                @forelse($pekerjaan as $job)
                <!-- Job Card -->
                <div class="card-snap min-w-[300px] md:min-w-[340px] bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex-shrink-0 flex flex-col h-[420px] transition-transform hover:-translate-y-1">
                    <!-- Top White Section -->
                    <div class="flex-1 px-8 py-6 flex flex-col justify-start">
                        <!-- Header -->
                        <div class="mb-4">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">NAMA PEKERJAAN :</span>
                            <h3 class="text-2xl font-bold text-keel-black leading-tight">{{ $job->judul }}</h3>
                        </div>

                        <!-- Details Grid -->
                        <div class="space-y-3">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Bayaran :</span>
                                <div class="text-lg font-bold text-pelagic-blue">Rp {{ number_format($job->upah, 0, ',', '.') }}</div>
                            </div>
                            
                            <!-- Durasi & Pelamar in one row if possible, or stacked -->
                             <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Durasi :</span>
                                <div class="font-bold text-gray-800">-</div>
                            </div>
                            
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Pekerja :</span>
                                <div class="font-bold text-gray-800 flex items-center gap-2">
                                     {{ $job->nama_pekerja }}
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Bottom Black Section -->
                    <div class="bg-keel-black px-8 py-6 relative flex items-center">
                        <!-- Buttons Container (Left Aligned & Limited Width) -->
                        <div class="w-3/4 space-y-3 z-10 flex flex-col items-start">
                            <button class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-seafoam-bloom transition-colors shadow-lg text-sm tracking-wide">
                                Beri Rating
                            </button>
                            <button class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-foam-white transition-colors shadow-lg text-sm tracking-wide">
                                Lihat Detail
                            </button>
                        </div>
                        <!-- Right Icon (Absolutely Positioned Bottom-Right) -->
                        <div class="absolute bottom-6 right-6 flex flex-col items-center">
                            <span class="text-[10px] text-white opacity-60 mb-1">Lokasi</span>
                            <i class="fas fa-map-marker-alt text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
                @empty
                 <!-- Dummy Card 1 (Renovasi) -->
                 <div class="card-snap min-w-[300px] md:min-w-[340px] bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex-shrink-0 flex flex-col h-[420px] transition-transform hover:-translate-y-1">
                    <div class="flex-1 px-8 py-6 flex flex-col justify-start">
                        <div class="mb-5">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">NAMA PEKERJAAN :</span>
                            <h3 class="text-2xl font-bold text-keel-black leading-tight">Renovasi Dapur</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Bayaran :</span>
                                <div class="text-xl font-bold text-pelagic-blue">Rp 1.500.000</div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Durasi :</span>
                                <div class="font-bold text-gray-800">3 Hari</div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Pelamar :</span>
                                <span class="inline-block bg-red-500 text-white text-xs font-bold px-2.5 py-1 rounded-full">3 Baru</span>
                            </div>
                        </div>
                    </div>

                    <div class="bg-keel-black px-8 py-6 relative flex items-center">
                        <div class="w-3/4 space-y-3 z-10 flex flex-col items-start">
                            <button class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-seafoam-bloom transition-colors shadow-lg text-sm tracking-wide">
                                Lihat Pelamar
                            </button>
                            <button class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-foam-white transition-colors shadow-lg text-sm tracking-wide">
                                Lihat Detail
                            </button>
                        </div>
                        <div class="absolute bottom-6 right-8 flex flex-col items-center">
                            <span class="text-[10px] text-white opacity-60 mb-1">Lokasi</span>
                            <i class="fas fa-map-marker-alt text-2xl text-white"></i>
                        </div>
                    </div>
                </div>

                <!-- Dummy Card 2 (Bersih rumah) -->
                <div class="card-snap min-w-[300px] md:min-w-[340px] bg-white rounded-3xl overflow-hidden shadow-xl border border-gray-100 flex-shrink-0 flex flex-col h-[420px] transition-transform hover:-translate-y-1">
                    <div class="flex-1 px-8 py-6 flex flex-col justify-start">
                        <div class="mb-5">
                            <span class="block text-xs font-bold text-gray-500 uppercase tracking-widest mb-1">NAMA PEKERJAAN :</span>
                            <h3 class="text-2xl font-bold text-keel-black leading-tight">Cleaning Service</h3>
                        </div>

                        <div class="space-y-4">
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Bayaran :</span>
                                <div class="text-xl font-bold text-pelagic-blue">Rp 150.000</div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Durasi :</span>
                                <div class="font-bold text-gray-800">4 Jam</div>
                            </div>
                            <div>
                                <span class="block text-xs font-bold text-gray-500 mb-0.5">Status :</span>
                                <div class="font-bold text-green-600 flex items-center gap-1.5">
                                    <i class="fas fa-check-circle"></i> Selesai
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="bg-keel-black px-8 py-6 relative flex items-center">
                        <div class="w-3/4 space-y-3 z-10 flex flex-col items-start">
                            <button class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-seafoam-bloom transition-colors shadow-lg text-sm tracking-wide">
                                Beri Rating
                            </button>
                            <button class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-foam-white transition-colors shadow-lg text-sm tracking-wide">
                                Lihat Detail
                            </button>
                        </div>
                        <div class="absolute bottom-6 right-8 flex flex-col items-center">
                            <span class="text-[10px] text-white opacity-60 mb-1">Remote</span>
                            <i class="fas fa-wifi text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
                @endforelse

            </div>

            <!-- Right Arrow -->
            <button id="scrollRight" class="absolute right-2 md:right-4 z-20 w-10 h-10 md:w-12 md:h-12 bg-transparent hover:bg-gray-200 rounded-full flex items-center justify-center transition-colors">
                <i class="fas fa-chevron-right text-3xl md:text-4xl text-keel-black"></i>
            </button>
        </div>
    </main>

    <script>
        const container = document.getElementById('cardContainer');
        const nextBtn = document.getElementById('scrollRight');
        const prevBtn = document.getElementById('scrollLeft');

        nextBtn.addEventListener('click', () => {
            container.scrollBy({ left: 320, behavior: 'smooth' });
        });

        prevBtn.addEventListener('click', () => {
            container.scrollBy({ left: -320, behavior: 'smooth' });
        });
    </script>

</body>
</html>
