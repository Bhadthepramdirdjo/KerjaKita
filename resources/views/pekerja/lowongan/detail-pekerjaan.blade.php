<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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

    <!-- Sidebar (Floating Style) -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <!-- Settings Icon -->
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
        <header class="w-full px-6 py-6 flex items-center gap-4">
            <!-- Back Button -->
            <a href="{{ route('pekerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
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
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="far fa-user text-2xl text-keel-black"></i>
            </button>
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
                                // Untuk sementara, karena belum ada kolom gambar di database
                                // Nanti bisa diganti dengan data dari database
                                $gambar = []; // Array kosong, nanti isi dari database
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
                            <button class="w-full bg-seafoam-bloom hover:bg-shallow-reef text-keel-black font-bold py-4 px-6 rounded-full transition-all duration-300 shadow-lg hover:shadow-xl transform hover:-translate-y-1 flex items-center justify-center gap-2">
                                <i class="fas fa-paper-plane"></i>
                                <span>Lamar Sekarang</span>
                            </button>

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

</body>
</html>
