<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekomendasi Pekerja - KerjaKita</title>
    
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

    <!-- Sidebar (Floating Style) -->
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
            </button>

            <!-- Recommendation Icon (Active) -->
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-user-friends text-xl"></i>
            </button>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4 bg-white shadow-sm">
            <!-- Back Button -->
            <a href="{{ route('pemberi-kerja.buat-lowongan') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <!-- Title -->
            <div class="flex-1 text-center">
                <h1 class="text-2xl font-bold text-keel-black">Rekomendasi Pekerja</h1>
            </div>

            <!-- Profile Icon -->
            <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <i class="far fa-user text-2xl text-keel-black"></i>
                @endif
            </a>
        </header>

        <!-- Filter Section (Optional) -->
        <div class="px-6 py-4 bg-white border-b border-gray-200">
            <div class="max-w-6xl mx-auto flex gap-4 items-center">
                <!-- Search -->
                <div class="flex-1 relative">
                    <input 
                        type="text" 
                        placeholder="Cari pekerja berdasarkan nama atau keahlian..."
                        class="w-full px-4 py-2 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent">
                    <i class="fas fa-search absolute right-4 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                </div>
                
                <!-- Filter by Category -->
                <select class="px-4 py-2 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue bg-white">
                    <option value="">Semua Kategori</option>
                    @php
                        $kategori = DB::table('kategori')->get();
                    @endphp
                    @foreach($kategori as $kat)
                    <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 sm:px-8 py-6">
            
            <!-- Worker Cards Grid -->
            <div class="max-w-6xl mx-auto grid grid-cols-1 md:grid-cols-2 lg:grid-cols-2 gap-6">
                
                @php
                    // Dummy data pekerja untuk UI
                    $pekerja = [
                        (object)[
                            'nama' => 'Budi Santoso',
                            'alamat' => 'Jl. Merdeka No. 45, Jakarta Selatan',
                            'no_telp' => '081234567890',
                            'foto_profil' => null,
                            'rating' => 4.5
                        ],
                        (object)[
                            'nama' => 'Siti Rahayu',
                            'alamat' => 'Jl. Sudirman No. 12, Bandung',
                            'no_telp' => '081298765432',
                            'foto_profil' => null,
                            'rating' => 4.8
                        ],
                        (object)[
                            'nama' => 'Ahmad Fauzi',
                            'alamat' => 'Jl. Gatot Subroto No. 78, Surabaya',
                            'no_telp' => '081356789012',
                            'foto_profil' => null,
                            'rating' => 4.2
                        ],
                        (object)[
                            'nama' => 'Dewi Lestari',
                            'alamat' => 'Jl. Diponegoro No. 23, Yogyakarta',
                            'no_telp' => '081445678901',
                            'foto_profil' => null,
                            'rating' => 4.9
                        ],
                    ];
                @endphp

                @foreach($pekerja as $worker)
                <!-- Worker Card -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-gray-200 hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-1">
                    
                    <!-- Card Header with Photo -->
                    <div class="p-6 flex gap-4">
                        <!-- Photo -->
                        <div class="w-24 h-24 rounded-2xl bg-gray-200 flex items-center justify-center overflow-hidden flex-shrink-0 border-2 border-gray-300">
                            <i class="fas fa-user text-4xl text-gray-400"></i>
                        </div>

                        <!-- Info -->
                        <div class="flex-1">
                            <h3 class="text-lg font-bold text-keel-black mb-1">{{ $worker->nama }}</h3>
                            
                            <div class="space-y-1 text-sm text-gray-600">
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-map-marker-alt text-pelagic-blue w-4"></i>
                                    <span>{{ $worker->alamat }}</span>
                                </div>
                                
                                <div class="flex items-center gap-2">
                                    <i class="fas fa-phone text-pelagic-blue w-4"></i>
                                    <span>{{ $worker->no_telp }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="bg-keel-black px-6 py-4 flex items-center justify-between">
                        <!-- Rating -->
                        <div class="text-white">
                            <div class="text-xs font-semibold mb-1">Rate Pekerja</div>
                            <div class="flex items-center gap-2">
                                <div class="flex gap-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($worker->rating))
                                            <i class="fas fa-star text-yellow-400 text-sm"></i>
                                        @elseif($i == ceil($worker->rating) && $worker->rating - floor($worker->rating) >= 0.5)
                                            <i class="fas fa-star-half-alt text-yellow-400 text-sm"></i>
                                        @else
                                            <i class="far fa-star text-yellow-400 text-sm"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="font-bold text-seafoam-bloom">{{ number_format($worker->rating, 1) }}/5</span>
                            </div>
                        </div>

                        <!-- Detail Button -->
                        <a href="#" class="bg-seafoam-bloom hover:bg-shallow-reef text-keel-black font-bold py-2 px-6 rounded-full transition-colors shadow-lg">
                            Detail
                        </a>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Info Card -->
            <div class="max-w-6xl mx-auto mt-8 bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-200">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-full bg-pelagic-blue bg-opacity-20 flex items-center justify-center flex-shrink-0">
                        <i class="fas fa-info-circle text-pelagic-blue text-xl"></i>
                    </div>
                    <div>
                        <h3 class="font-bold text-keel-black mb-1">Tentang Rekomendasi</h3>
                        <p class="text-sm text-gray-600">
                            Pekerja yang ditampilkan adalah rekomendasi berdasarkan pengalaman, keahlian, dan rating mereka. 
                            Klik tombol <span class="font-semibold text-pelagic-blue">Detail</span> untuk melihat informasi lengkap dan menghubungi pekerja.
                        </p>
                    </div>
                </div>
            </div>

        </div>
    </main>

</body>
</html>
