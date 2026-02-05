<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
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

        /* Notifikasi Dropdown Animation */
        @keyframes slideDown {
            from {
                transform: translateY(-20px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .notification-dropdown {
            animation: slideDown 0.3s ease-out;
        }

        /* Notifikasi Item */
        .notification-item {
            border-left: 4px solid #289FB7;
            transition: all 0.2s ease;
        }

        .notification-item:hover {
            background-color: #E8FBFF;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
        }

        .notification-item.unread {
            background-color: #e0f7fa;
            border-left-color: #146B8C;
        }

        /* Range Slider Styling */
        .range-slider {
            position: absolute;
            width: 100%;
            height: 2px;
            background: transparent;
            pointer-events: none;
            -webkit-appearance: none;
            appearance: none;
            z-index: 1;
        }

        .range-slider::-webkit-slider-track {
            background: transparent;
            height: 2px;
        }

        .range-slider::-moz-range-track {
            background: transparent;
            height: 2px;
        }

        .range-slider::-webkit-slider-thumb {
            -webkit-appearance: none;
            appearance: none;
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #289FB7;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            pointer-events: auto;
            position: relative;
            margin-top: -6px;
            z-index: 2;
        }

        .range-slider::-moz-range-thumb {
            width: 14px;
            height: 14px;
            border-radius: 50%;
            background: #289FB7;
            cursor: pointer;
            border: 2px solid white;
            box-shadow: 0 2px 4px rgba(0, 0, 0, 0.2);
            pointer-events: auto;
            margin-top: -6px;
            z-index: 2;
        }

        .range-slider::-webkit-slider-thumb:hover {
            background: #146B8C;
            transform: scale(1.1);
        }

        .range-slider::-moz-range-thumb:hover {
            background: #146B8C;
            transform: scale(1.1);
        }

        .range-slider::-webkit-slider-thumb:active {
            background: #0f5a73;
        }

        .range-slider::-moz-range-thumb:active {
            background: #0f5a73;
        }

        /* Z-index management */
        .range-min {
            z-index: 1;
        }

        .range-max {
            z-index: 2;
        }

        .range-slider:focus {
            outline: none;
            z-index: 3;
        }
        /* Custom Scrollbar for Modal Sections */
        .custom-scrollbar::-webkit-scrollbar {
            width: 6px;
        }

        .custom-scrollbar::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb {
            background: #cbd5e1;
            border-radius: 4px;
        }

        .custom-scrollbar::-webkit-scrollbar-thumb:hover {
            background: #94a3b8;
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
            <a href="{{ route('pekerja.dashboard') }}" class="w-12 h-12 rounded-full bg-keel-black text-white shadow-lg flex items-center justify-center hover:bg-keel-black hover:text-white transition-all duration-200 transform hover:scale-110" title="Dashboard">
                <i class="fas fa-home text-lg"></i>
            </a>
            
            <!-- Filter Toggle (Khusus Dashboard) -->
            <button id="filterToggle" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Filter">
                <i class="fas fa-filter text-lg"></i>
            </button> <!-- Diganti icon filter agar lebih relevan -->

            <!-- Lamaran Saya -->
            <a href="{{ route('pekerja.lamaran') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Lamaran Saya">
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

    <!-- Filter Modal (Pengganti Sidebar) -->
    <div id="filterModal" class="fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <!-- Modal Content -->
        <div class="bg-white rounded-3xl shadow-2xl w-full max-w-lg max-h-[85vh] overflow-y-auto transform scale-95 transition-transform duration-300 no-scrollbar" id="filterContent">
            
            <!-- Header (Sticky) -->
            <div class="sticky top-0 z-10 bg-white px-8 py-6 border-b border-gray-100 flex items-center justify-between">
                <h2 class="text-2xl font-bold text-keel-black">Filter Pekerjaan</h2>
                <button id="closeFilter" class="w-10 h-10 rounded-full bg-gray-100 hover:bg-gray-200 flex items-center justify-center transition-colors">
                    <i class="fas fa-times text-gray-600"></i>
                </button>
            </div>

            <!-- Scrollable Content -->
            <div class="p-8 space-y-8">
                
                <!-- Tipe Pekerjaan -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Tipe Pekerjaan</h3>
                    <div class="grid grid-cols-2 gap-3">
                        <label class="relative flex items-center p-4 rounded-2xl border-2 border-gray-100 cursor-pointer hover:border-pelagic-blue transition-all group">
                            <input type="checkbox" name="tipe[]" value="remote" class="peer hidden">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:bg-pelagic-blue peer-checked:border-pelagic-blue flex items-center justify-center mr-3 transition-colors">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                            <span class="font-semibold text-gray-600 group-hover:text-keel-black">Remote</span>
                        </label>
                        <label class="relative flex items-center p-4 rounded-2xl border-2 border-gray-100 cursor-pointer hover:border-pelagic-blue transition-all group">
                            <input type="checkbox" name="tipe[]" value="onsite" class="peer hidden">
                            <div class="w-5 h-5 rounded-full border-2 border-gray-300 peer-checked:bg-pelagic-blue peer-checked:border-pelagic-blue flex items-center justify-center mr-3 transition-colors">
                                <i class="fas fa-check text-white text-xs opacity-0 peer-checked:opacity-100"></i>
                            </div>
                            <span class="font-semibold text-gray-600 group-hover:text-keel-black">On-Site</span>
                        </label>
                    </div>
                </div>

                <div class="h-px bg-gray-100"></div>

                <!-- Kategori -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Kategori</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                        @php
                            $kategori = DB::table('kategori')->get();
                        @endphp
                        @foreach($kategori as $kat)
                        <label class="flex items-center justify-between p-3 rounded-xl hover:bg-foam-white cursor-pointer transition-colors group">
                            <span class="font-medium text-gray-600 group-hover:text-pelagic-blue">{{ $kat->nama_kategori }}</span>
                            <div class="relative">
                                <input type="checkbox" name="kategori[]" value="{{ $kat->id_kategori }}" class="peer hidden">
                                <div class="w-6 h-6 rounded-lg bg-gray-100 text-transparent peer-checked:bg-pelagic-blue peer-checked:text-white flex items-center justify-center transition-all">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="h-px bg-gray-100"></div>

                <!-- Lokasi -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-4">Lokasi</h3>
                    <div class="space-y-2 max-h-48 overflow-y-auto custom-scrollbar pr-2">
                        @php
                            $lokasi = DB::table('lowongan')
                                ->select('lokasi')
                                ->whereNotNull('lokasi')
                                ->distinct()
                                ->orderBy('lokasi')
                                ->get();
                        @endphp
                        @foreach($lokasi as $lok)
                        <label class="flex items-center justify-between p-3 rounded-xl hover:bg-foam-white cursor-pointer transition-colors group">
                            <span class="font-medium text-gray-600 group-hover:text-pelagic-blue">{{ $lok->lokasi }}</span>
                            <div class="relative">
                                <input type="checkbox" name="lokasi[]" value="{{ $lok->lokasi }}" class="peer hidden">
                                <div class="w-6 h-6 rounded-lg bg-gray-100 text-transparent peer-checked:bg-pelagic-blue peer-checked:text-white flex items-center justify-center transition-all">
                                    <i class="fas fa-check text-xs"></i>
                                </div>
                            </div>
                        </label>
                        @endforeach
                    </div>
                </div>

                <div class="h-px bg-gray-100"></div>

                <!-- Range Harga/Upah -->
                <div>
                    <h3 class="text-sm font-bold text-gray-400 uppercase tracking-wider mb-6">Range Upah</h3>
                    <div class="px-2">
                        <div class="flex items-center justify-between mb-6">
                        <div class="bg-seafoam-bloom bg-opacity-20 px-3 py-2 rounded-lg">
                            <span class="text-xs text-gray-600 block">Min</span>
                            <span class="text-sm font-bold text-pelagic-blue" id="minPriceDisplay">Rp 0</span>
                        </div>
                        <div class="text-gray-400">-</div>
                        <div class="bg-seafoam-bloom bg-opacity-20 px-3 py-2 rounded-lg">
                            <span class="text-xs text-gray-600 block">Max</span>
                            <span class="text-sm font-bold text-pelagic-blue" id="maxPriceDisplay">Rp 10.000.000</span>
                        </div>
                    </div>

                    <!-- Quick Preset Buttons (moved to top) -->
                    <div class="grid grid-cols-2 gap-2 mb-4">
                        <button type="button" class="preset-btn text-xs py-2 px-3 bg-gray-100 hover:bg-pelagic-blue hover:text-white rounded-lg transition-colors" data-min="0" data-max="1000000">
                            < 1 Juta
                        </button>
                        <button type="button" class="preset-btn text-xs py-2 px-3 bg-gray-100 hover:bg-pelagic-blue hover:text-white rounded-lg transition-colors" data-min="1000000" data-max="3000000">
                            1-3 Juta
                        </button>
                        <button type="button" class="preset-btn text-xs py-2 px-3 bg-gray-100 hover:bg-pelagic-blue hover:text-white rounded-lg transition-colors" data-min="3000000" data-max="5000000">
                            3-5 Juta
                        </button>
                        <button type="button" class="preset-btn text-xs py-2 px-3 bg-gray-100 hover:bg-pelagic-blue hover:text-white rounded-lg transition-colors" data-min="5000000" data-max="10000000">
                            > 5 Juta
                        </button>
                    </div>

                    <!-- Range Slider Container with fixed height -->
                    <div class="relative" style="height: 40px;">
                        <div class="relative" style="height: 30px; overflow: hidden;">
                            <!-- Background Track -->
                            <div class="relative h-2 bg-gray-200 rounded-full" style="top: 14px;">
                                <!-- Active Range Track -->
                                <div id="rangeTrack" class="absolute h-full bg-pelagic-blue rounded-full" style="left: 0%; right: 0%;"></div>
                            </div>
                            
                            <!-- Slider Wrapper -->
                            <div class="relative" style="top: 9px;">
                                <!-- Min Range Input -->
                                <input type="range" 
                                       id="minPrice" 
                                       name="min_upah"
                                       min="0" 
                                       max="10000000" 
                                       step="100000"
                                       value="0"
                                       class="range-slider range-min">
                                
                                <!-- Max Range Input -->
                                <input type="range" 
                                       id="maxPrice" 
                                       name="max_upah"
                                       min="0" 
                                       max="10000000" 
                                       step="100000"
                                       value="10000000"
                                       class="range-slider range-max">
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="sticky bottom-0 bg-white pt-4 space-y-3 z-10">
                    <button class="w-full bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                        <i class="fas fa-filter mr-2"></i>
                        Terapkan Filter
                    </button>
                    <button class="w-full bg-gray-100 hover:bg-gray-200 text-keel-black font-semibold py-3 px-6 rounded-full transition-colors">
                        <i class="fas fa-redo mr-2"></i>
                        Reset Filter
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen relative w-full">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4">
            <!-- Search Bar -->
            <div class="flex-1 relative ml-20">
                <input type="text" 
                       placeholder="Cari pekerjaan..." 
                       class="w-full bg-white border-2 border-keel-black rounded-full py-2 px-6 focus:outline-none focus:ring-2 focus:ring-pelagic-blue shadow-sm">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-search text-keel-black"></i>
                </button>
            </div>

            <!-- Notifikasi Bell -->
            <button id="notificationBtn" class="relative w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="fas fa-bell text-2xl text-keel-black"></i>
                @if(count($notifikasi) > 0)
                    <span class="absolute top-2 right-2 w-4 h-4 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">
                        {{ count($notifikasi) }}
                    </span>
                @endif
            </button>

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
            <h1 class="text-xl md:text-2xl font-bold text-gray-700">Halaman Cari Kerja (Untuk pekerja)</h1>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 sm:px-8 pb-20">
            
            <!-- Cards Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
                
                @forelse($lowongan as $job)
                <!-- Job Card Component -->
                <a href="{{ route('pekerja.lowongan.detail', $job->idLowongan) }}" class="block">
                    <div class="bg-keel-black rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transition-all duration-300 group transform hover:-translate-y-1 cursor-pointer">
                        <!-- Card Body -->
                        <div class="p-4 h-32 flex flex-col relative">
                            <!-- Decorative gradient overlay -->
                            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-bl from-pelagic-blue to-transparent opacity-20 rounded-bl-full"></div>
                            
                            <h3 class="text-white text-base font-bold mb-1.5 z-10 line-clamp-1">{{ $job->judul }}</h3>
                            <p class="text-gray-300 text-xs line-clamp-2 z-10 flex-grow">
                                {{ $job->deskripsi }}
                            </p>
                        </div>

                        <!-- Card Footer (Details) -->
                        <div class="bg-[#1a2526] px-4 py-3 border-t border-gray-700">
                            <div class="flex items-center justify-between text-white text-xs mb-1.5">
                                <span class="font-medium text-seafoam-bloom">Bayaran :</span>
                                <span class="font-bold">Rp {{ number_format($job->upah, 0, ',', '.') }}</span>
                            </div>
                            <div class="flex items-center justify-between text-white text-xs">
                                <span class="text-gray-400 text-[10px]">Durasi: <span class="text-white">{{ isset($job->durasi) ? ucwords(str_replace('-', ' ', $job->durasi)) : '-' }}</span></span>
                                
                                <!-- Location Icon/Text -->
                                <div class="flex items-center gap-1.5">
                                    <span class="text-[10px] text-gray-400">{{ Str::limit($job->lokasi, 12) }}</span>
                                    <i class="fas fa-map-marker-alt text-pelagic-blue text-xs"></i>
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



    <!-- Notification Dropdown -->
    <div id="notificationDropdown" class="hidden fixed top-20 right-8 w-80 bg-white rounded-2xl shadow-2xl z-50 notification-dropdown max-h-96 overflow-y-auto">
        <!-- Header -->
        <div class="sticky top-0 bg-gradient-to-r from-pelagic-blue to-shallow-reef px-6 py-4 rounded-t-2xl flex justify-between items-center z-10">
            <div>
                <h3 class="text-lg font-bold text-white">Notifikasi</h3>
                <p class="text-white text-opacity-90 text-xs mt-1">Pembaruan terbaru dari sistem</p>
            </div>
            <button id="clearAllBtn" class="text-xs text-white bg-white bg-opacity-20 hover:bg-opacity-30 px-3 py-1.5 rounded-full transition-all flex items-center gap-1 font-medium">
                <i class="fas fa-trash-alt text-[10px]"></i>
                Hapus Semua
            </button>
        </div>

        <!-- Notifikasi List -->
        <div id="notificationList" class="divide-y divide-gray-200 bg-white">
            @forelse($notifikasi as $notif)
                <div class="notification-item p-4 {{ !$notif->is_read ? 'unread' : '' }}" data-notification-id="{{ $notif->id_notifikasi }}">
                    <!-- Header Notifikasi -->
                    <div class="flex items-start gap-3 mb-2">
                        @if($notif->tipe_notifikasi == 'rating')
                            <div class="w-10 h-10 rounded-full bg-yellow-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-star text-yellow-500 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-keel-black text-sm">Anda Mendapat Rating</p>
                            </div>
                        @elseif($notif->tipe_notifikasi == 'terima_lamaran')
                            <div class="w-10 h-10 rounded-full bg-green-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-check text-green-500 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-keel-black text-sm">Lamaran Diterima</p>
                            </div>
                        @elseif($notif->tipe_notifikasi == 'tolak_lamaran')
                            <div class="w-10 h-10 rounded-full bg-red-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-times text-red-500 text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-keel-black text-sm">Lamaran Ditolak</p>
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-full bg-blue-100 flex items-center justify-center flex-shrink-0">
                                <i class="fas fa-bell text-pelagic-blue text-lg"></i>
                            </div>
                            <div class="flex-1">
                                <p class="font-semibold text-keel-black text-sm">Pemberitahuan</p>
                            </div>
                        @endif
                    </div>

                    <!-- Message -->
                    <p class="text-gray-700 text-sm leading-relaxed ml-13">
                        {!! $notif->pesan !!}
                    </p>

                    <!-- Timestamp -->
                    <p class="text-gray-500 text-xs mt-2 ml-13">
                        {{ $notif->created_at ? \Carbon\Carbon::parse($notif->created_at)->diffForHumans() : 'Baru-baru ini' }}
                    </p>
                </div>
            @empty
                <div class="p-8 text-center" id="emptyState">
                    <div class="inline-block p-3 rounded-full bg-gray-100 mb-3">
                        <i class="fas fa-inbox text-3xl text-gray-400"></i>
                    </div>
                    <p class="text-gray-500 font-medium">Tidak ada notifikasi</p>
                    <p class="text-gray-400 text-xs mt-1">Notifikasi baru akan muncul di sini</p>
                </div>
            @endforelse
        </div>
        
        <!-- Hidden Empty Templat -->
        <div id="emptyTemplate" class="p-8 text-center hidden">
            <div class="inline-block p-3 rounded-full bg-gray-100 mb-3">
                <i class="fas fa-inbox text-3xl text-gray-400"></i>
            </div>
            <p class="text-gray-500 font-medium">Tidak ada notifikasi</p>
            <p class="text-gray-400 text-xs mt-1">Notifikasi baru akan muncul di sini</p>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- Speed Dial Navigation ---
            const dialContainer = document.getElementById('speed-dial-container');
            const dialMenu = document.getElementById('speed-dial-menu');
            const dialTrigger = document.getElementById('speed-dial-trigger');
            let isDialLocked = false;

            if (dialContainer && dialMenu && dialTrigger) {
                function toggleDial() {
                    isDialLocked = !isDialLocked;
                    if (isDialLocked) {
                        dialMenu.classList.remove('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                        dialMenu.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                        dialTrigger.classList.add('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    } else {
                        dialMenu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                        dialMenu.classList.add('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                        dialTrigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    }
                }

                function closeDial() {
                    isDialLocked = false;
                    dialMenu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                    dialMenu.classList.add('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                    dialTrigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                }

                dialTrigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleDial();
                });

                // Global click to close
                document.addEventListener('click', function(e) {
                    if (isDialLocked && !dialContainer.contains(e.target)) {
                        closeDial();
                    }
                });
            }

            // --- Filter Modal ---
            const filterToggle = document.getElementById('filterToggle');
            const filterModal = document.getElementById('filterModal');
            const filterContent = document.getElementById('filterContent');
            const closeFilter = document.getElementById('closeFilter');

            if (filterToggle && filterModal && closeFilter) {
                function openFilter() {
                    filterModal.classList.remove('hidden');
                    // Small delay to allow transition
                    requestAnimationFrame(() => {
                        filterModal.classList.remove('opacity-0');
                        filterContent.classList.remove('scale-95');
                        filterContent.classList.add('scale-100');
                    });
                }

                function closeFilterModal() {
                    filterModal.classList.add('opacity-0');
                    filterContent.classList.remove('scale-100');
                    filterContent.classList.add('scale-95');
                    
                    setTimeout(() => {
                        filterModal.classList.add('hidden');
                    }, 300); // Match transition duration
                }



                filterToggle.addEventListener('click', (e) => {
                    e.stopPropagation();
                    console.log('Filter clicked');
                    openFilter();
                });

                closeFilter.addEventListener('click', closeFilterModal);

                // Close on click outside (overlay)
                filterModal.addEventListener('click', (e) => {
                    if (e.target === filterModal) {
                        closeFilterModal();
                    }
                });
            }

            // --- Notification Dropdown ---
            const notificationBtn = document.getElementById('notificationBtn');
            const notificationDropdown = document.getElementById('notificationDropdown');
            const clearAllBtn = document.getElementById('clearAllBtn');
            const notificationList = document.getElementById('notificationList');
            const emptyTemplate = document.getElementById('emptyTemplate');
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

            if (notificationBtn && notificationDropdown) {
                notificationBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    const isClosed = notificationDropdown.classList.contains('hidden');
                    notificationDropdown.classList.toggle('hidden');

                    // If we are opening the dropdown
                    if (isClosed) {
                        // 1. Hide Badge Visually
                        const badge = this.querySelector('span.absolute');
                        if (badge) {
                            badge.style.display = 'none';
                        }
                        
                        // 2. Mark as read in backend
                        fetch('{{ route("notifikasi.markRead") }}', {
                            method: 'POST',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                        }).catch(console.error);
                    }
                });
            }
            
            // --- Clear All Notifications ---
            if (clearAllBtn && notificationList) {
                clearAllBtn.addEventListener('click', function(e) {
                    e.stopPropagation();
                    
                    
                    // Direct delete without confirmation

                    fetch('{{ route("notifikasi.deleteAll") }}', {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': csrfToken
                        }
                    })
                    .then(response => response.json())
                    .then(data => {
                        if(data.success) {
                            // 1. Clear List UI
                            notificationList.innerHTML = '';
                            
                            // 2. Show Empty State
                            const emptyState = emptyTemplate.cloneNode(true);
                            emptyState.id = ''; 
                            emptyState.classList.remove('hidden');
                            notificationList.appendChild(emptyState);
                            
                            // 3. Remove Badge Completely if exists
                            const badge = notificationBtn.querySelector('span.absolute');
                            if (badge) {
                                badge.remove();
                            }
                        }
                    })
                    .catch(console.error);
                });
            }

            // --- Global Click Handler (Close outside) ---
            document.addEventListener('click', function(e) {
                // Close Notification
                if (notificationDropdown && !notificationDropdown.classList.contains('hidden')) {
                    if (!notificationDropdown.contains(e.target) && !notificationBtn.contains(e.target)) {
                        notificationDropdown.classList.add('hidden');
                    }
                }

                // Close Speed Dial (if locked and clicked outside)
                if (isDialLocked && dialContainer && !dialContainer.contains(e.target)) {
                    isDialLocked = false;
                    dialTrigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    hideDial();
                }
            });
            // --- Range Slider Logic ---
            const minPrice = document.getElementById('minPrice');
            const maxPrice = document.getElementById('maxPrice');
            const minPriceDisplay = document.getElementById('minPriceDisplay');
            const maxPriceDisplay = document.getElementById('maxPriceDisplay');
            const rangeTrack = document.getElementById('rangeTrack');
            const presetButtons = document.querySelectorAll('.preset-btn');

            if (minPrice && maxPrice && minPriceDisplay && maxPriceDisplay && rangeTrack) {
                // Format number to Rupiah
                function formatRupiah(number) {
                    return 'Rp ' + number.toString().replace(/\B(?=(\d{3})+(?!\d))/g, '.');
                }

                // Update range display and track
                function updateRange() {
                    let minVal = parseInt(minPrice.value);
                    let maxVal = parseInt(maxPrice.value);

                    // Prevent overlap
                    if (minVal > maxVal - 100000) {
                        minVal = maxVal - 100000;
                        minPrice.value = minVal;
                    }

                    if (maxVal < minVal + 100000) {
                        maxVal = minVal + 100000;
                        maxPrice.value = maxVal;
                    }

                    // Update display
                    minPriceDisplay.textContent = formatRupiah(minVal);
                    maxPriceDisplay.textContent = formatRupiah(maxVal);

                    // Update track visual
                    const percentMin = (minVal / 10000000) * 100;
                    const percentMax = (maxVal / 10000000) * 100;
                    rangeTrack.style.left = percentMin + '%';
                    rangeTrack.style.right = (100 - percentMax) + '%';
                }

                // Event listeners for sliders
                minPrice.addEventListener('input', updateRange);
                maxPrice.addEventListener('input', updateRange);

                // Z-index management
                minPrice.addEventListener('mousedown', function() { this.style.zIndex = '5'; });
                maxPrice.addEventListener('mousedown', function() { this.style.zIndex = '5'; });
                minPrice.addEventListener('mouseup', function() { this.style.zIndex = '3'; });
                maxPrice.addEventListener('mouseup', function() { this.style.zIndex = '4'; });

                // Preset buttons
                presetButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const min = this.getAttribute('data-min');
                        const max = this.getAttribute('data-max');
                        
                        minPrice.value = min;
                        maxPrice.value = max;
                        updateRange();

                        // Visual feedback
                        presetButtons.forEach(btn => btn.classList.remove('bg-pelagic-blue', 'text-white'));
                        this.classList.add('bg-pelagic-blue', 'text-white');
                    });
                });

                // Initialize range on load
                updateRange();
            }
        });
    </script>
</body>
</html>
