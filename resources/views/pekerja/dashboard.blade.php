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

    <!-- Sidebar (Floating Style as per wireframe) -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <!-- Logo / Top Icon -->
        <div class="mb-auto">
             <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </button>
        </div>
        
        <!-- Center Icons -->
        <div class="flex flex-col space-y-8">
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-home text-xl"></i>
            </button>
            
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center justify-between">
            <!-- Back / Top Left Icon -->
            <button class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100">
                <i class="fas fa-chevron-up text-keel-black"></i>
            </button>

            <!-- Search Bar -->
            <div class="flex-1 max-w-2xl mx-6 relative">
                <input type="text" 
                       placeholder="Cari pekerjaan..." 
                       class="w-full bg-white border-2 border-keel-black rounded-full py-2 px-6 focus:outline-none focus:ring-2 focus:ring-pelagic-blue shadow-sm">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-search text-keel-black"></i>
                </button>
            </div>

            <!-- Profile Icon -->
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50">
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
                <div class="bg-keel-black rounded-3xl overflow-hidden shadow-xl hover:shadow-2xl transition-all duration-300 group transform hover:-translate-y-1">
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
                            <span class="text-gray-400">Durasi kerja: <span class="text-white">-</span></span> <!-- Durasi tidak ada di DB, strip dulu -->
                            
                            <!-- Location Icon/Text -->
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">{{ Str::limit($job->lokasi, 15) }}</span>
                                <i class="fas fa-map-marker-alt text-pelagic-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>
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

                <!-- Dummy Data for Visual Check (If DB is empty) -->
                <!-- You can remove this block later -->
                <div class="bg-keel-black rounded-3xl overflow-hidden shadow-xl transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 h-48 flex flex-col relative">
                        <h3 class="text-white text-xl font-bold mb-2 z-10">Desain UI/UX App</h3>
                        <p class="text-gray-300 text-sm line-clamp-3 z-10">
                            Mencari desainer untuk membuat tampilan aplikasi mobile marketplace sederhana.
                        </p>
                    </div>
                    <div class="bg-[#1a2526] px-6 py-4 border-t border-gray-700">
                        <div class="flex items-center justify-between text-white text-sm mb-2">
                            <span class="font-medium text-seafoam-bloom">Bayaran :</span>
                            <span class="font-bold">Rp 500.000</span>
                        </div>
                        <div class="flex items-center justify-between text-white text-sm">
                            <span class="text-gray-400">Durasi kerja: <span class="text-white">5 Jam</span></span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">Remote</span>
                                <i class="fas fa-wifi text-pelagic-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="bg-keel-black rounded-3xl overflow-hidden shadow-xl transition-all duration-300 hover:shadow-2xl">
                    <div class="p-6 h-48 flex flex-col relative">
                        <h3 class="text-white text-xl font-bold mb-2 z-10">Bersih Rumah Total</h3>
                        <p class="text-gray-300 text-sm line-clamp-3 z-10">
                            Membersihkan rumah 2 lantai pasca renovasi. Alat disediakan.
                        </p>
                    </div>
                    <div class="bg-[#1a2526] px-6 py-4 border-t border-gray-700">
                        <div class="flex items-center justify-between text-white text-sm mb-2">
                            <span class="font-medium text-seafoam-bloom">Bayaran :</span>
                            <span class="font-bold">Rp 300.000</span>
                        </div>
                        <div class="flex items-center justify-between text-white text-sm">
                            <span class="text-gray-400">Durasi kerja: <span class="text-white">6 Jam</span></span>
                            <div class="flex items-center gap-2">
                                <span class="text-xs text-gray-400">Bandung</span>
                                <i class="fas fa-map-marker-alt text-pelagic-blue"></i>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </main>

</body>
</html>
