<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Kerja - KerjaKita</title>
    
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
            background-color: #E8FBFF; /* Foam White Background */
        }
        
        /* Hide scrollbar for Chrome, Safari and Opera */
        .no-scrollbar::-webkit-scrollbar {
            display: none;
        }
        
        /* Hide scrollbar for IE, Edge and Firefox */
        .no-scrollbar {
            -ms-overflow-style: none;  /* IE and Edge */
            scrollbar-width: none;  /* Firefox */
        }
    </style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">

    <!-- Sidebar (Floating Style) -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <!-- Settings Icon -->
        <div class="mb-auto">
             <a href="{{ route('pekerja.pengaturan') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </a>
        </div>
        
        <!-- Center Icons -->
        <div class="flex flex-col space-y-8">
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-home text-xl"></i>
            </button>
            
            <!-- Filter Toggle Button -->
            <button id="filterToggle" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Filter Sidebar (Slide Panel) -->
    <div id="filterSidebar" class="fixed left-20 lg:left-24 top-0 h-screen w-80 bg-white shadow-2xl transform -translate-x-full transition-transform duration-300 ease-in-out z-40 overflow-y-auto">
        <div class="p-6">
            <!-- Header -->
            <div class="flex items-center justify-between mb-6">
                <h2 class="text-xl font-bold text-keel-black">Filter Pekerjaan</h2>
                <button id="closeFilter" class="w-8 h-8 rounded-full hover:bg-gray-100 flex items-center justify-center">
                    <i class="fas fa-times text-keel-black"></i>
                </button>
            </div>

            <!-- Tipe Pekerjaan -->
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Tipe Pekerjaan</h3>
                <div class="space-y-2">
                    <label class="flex items-center p-3 rounded-xl hover:bg-seafoam-bloom hover:bg-opacity-20 cursor-pointer transition-colors">
                        <input type="checkbox" name="tipe[]" value="remote" class="w-4 h-4 text-pelagic-blue rounded focus:ring-pelagic-blue">
                        <span class="ml-3 text-gray-700">Remote</span>
                    </label>
                    <label class="flex items-center p-3 rounded-xl hover:bg-seafoam-bloom hover:bg-opacity-20 cursor-pointer transition-colors">
                        <input type="checkbox" name="tipe[]" value="onsite" class="w-4 h-4 text-pelagic-blue rounded focus:ring-pelagic-blue">
                        <span class="ml-3 text-gray-700">On-Site</span>
                    </label>
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Kategori -->
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Kategori</h3>
                <div class="space-y-2">
                    @php
                        $kategori = DB::table('kategori')->get();
                    @endphp
                    @foreach($kategori as $kat)
                    <label class="flex items-center p-3 rounded-xl hover:bg-seafoam-bloom hover:bg-opacity-20 cursor-pointer transition-colors">
                        <input type="checkbox" name="kategori[]" value="{{ $kat->id_kategori }}" class="w-4 h-4 text-pelagic-blue rounded focus:ring-pelagic-blue">
                        <span class="ml-3 text-gray-700">{{ $kat->nama_kategori }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <hr class="my-6 border-gray-200">

            <!-- Lokasi -->
            <div class="mb-6">
                <h3 class="text-sm font-bold text-gray-700 uppercase tracking-wider mb-3">Lokasi</h3>
                <div class="space-y-2">
                    @php
                        $lokasi = DB::table('lowongan')
                            ->select('lokasi')
                            ->distinct()
                            ->orderBy('lokasi')
                            ->get();
                    @endphp
                    @foreach($lokasi as $lok)
                    <label class="flex items-center p-3 rounded-xl hover:bg-seafoam-bloom hover:bg-opacity-20 cursor-pointer transition-colors">
                        <input type="checkbox" name="lokasi[]" value="{{ $lok->lokasi }}" class="w-4 h-4 text-pelagic-blue rounded focus:ring-pelagic-blue">
                        <span class="ml-3 text-gray-700">{{ $lok->lokasi }}</span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Action Buttons -->
            <div class="sticky bottom-0 bg-white pt-4 pb-2 space-y-3">
                <button class="w-full bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                    <i class="fas fa-filter mr-2"></i>
                    Terapkan Filter
                </button>
                <button class="w-full bg-gray-200 hover:bg-gray-300 text-keel-black font-semibold py-3 px-6 rounded-full transition-colors">
                    <i class="fas fa-redo mr-2"></i>
                    Reset Filter
                </button>
            </div>
        </div>
    </div>

    <!-- Overlay -->
    <div id="filterOverlay" class="fixed inset-0 bg-black bg-opacity-50 z-30 hidden transition-opacity duration-300"></div>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4">
            <!-- Logo Icon (Top Left) -->
            <div class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0 p-1.5">
                <img src="{{ asset('images/LOGO.png') }}" alt="KerjaKita Logo" class="w-full h-full object-contain">
            </div>

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
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="far fa-user text-2xl text-keel-black"></i>
            </button>
        </header>

        <!-- Page Title -->
        <div class="px-8 pb-4">
            <h1 class="text-xl md:text-2xl font-bold text-gray-700">Halaman Cari Kerja (Untuk pekerja)</h1>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 sm:px-8 pb-20">
            
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
                
                @forelse($lowongan as $job)
                <!-- Job Card Component -->
                <a href="{{ route('pekerja.lowongan.detail', $job->idLowongan) }}" class="block">
                    <div class="bg-keel-black rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 group transform hover:-translate-y-1 cursor-pointer">
                        <!-- Card Body -->
                        <div class="p-6 h-48 flex flex-col relative">
                            <!-- Decorative gradient overlay -->
                            <div class="absolute top-0 right-0 w-32 h-32 bg-gradient-to-bl from-pelagic-blue to-transparent opacity-20 rounded-bl-full"></div>
                            
                            <h3 class="text-white text-xl font-bold mb-2 z-10 line-clamp-1">{{ $job->judul }}</h3>
                            <p class="text-gray-300 text-sm line-clamp-3 z-10 flex-grow">
                                {{ $job->deskripsi }}
                            </p>
                        </div>

                        <!-- Card Footer (Details) -->
                        <div class="bg-[#1a2526] px-6 py-4 border-t border-gray-700">
                            <div class="flex items-center justify-between text-white text-sm mb-2">
                                <span class="font-medium text-seafoam-bloom">Bayaran :</span>
                                <span class="font-bold">Rp {{ number_format($job->upah, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-white text-sm">
                                <span class="text-gray-400">Durasi kerja: <span class="text-white">-</span></span>
                                
                                <!-- Location Icon/Text -->
                                <div class="flex items-center gap-2">
                                    <span class="text-xs text-gray-400">{{ Str::limit($job->lokasi, 15) }}</span>
                                    <i class="fas fa-map-marker-alt text-pelagic-blue"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </a>
                @empty
                <!-- Empty State -->
                <div class="col-span-full text-center py-20">
                    <div class="inline-block p-6 rounded-full bg-seafoam-bloom bg-opacity-20 mb-4">
                        <i class="fas fa-search text-4xl text-abyss-teal"></i>
                    </div>
                    <h3 class="text-xl font-bold text-abyss-teal">Belum ada lowongan tersedia</h3>
                    <p class="text-gray-500">Silakan cek kembali nanti.</p>
                </div>
                @endforelse

            </div>
        </div>
    </main>

    <script>
        // Toggle Filter Sidebar
        const filterToggle = document.getElementById('filterToggle');
        const filterSidebar = document.getElementById('filterSidebar');
        const filterOverlay = document.getElementById('filterOverlay');
        const closeFilter = document.getElementById('closeFilter');

        // Open filter
        filterToggle.addEventListener('click', () => {
            filterSidebar.classList.remove('-translate-x-full');
            filterOverlay.classList.remove('hidden');
        });

        // Close filter
        closeFilter.addEventListener('click', () => {
            filterSidebar.classList.add('-translate-x-full');
            filterOverlay.classList.add('hidden');
        });

        // Close when clicking overlay
        filterOverlay.addEventListener('click', () => {
            filterSidebar.classList.add('-translate-x-full');
            filterOverlay.classList.add('hidden');
        });
    </script>

</body>
</html>
