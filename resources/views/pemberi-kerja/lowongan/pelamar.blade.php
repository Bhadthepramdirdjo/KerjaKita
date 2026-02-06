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

            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-briefcase text-xl"></i>
            </a>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4 bg-white shadow-sm">
            <!-- Back Button -->
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <!-- Title -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-keel-black">{{ $lowongan->judul }}</h1>
                <p class="text-sm text-gray-600">
                    <i class="fas fa-map-marker-alt mr-1"></i>
                    {{ $lowongan->lokasi }}
                </p>
            </div>

            <!-- Profile Icon -->
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="far fa-user text-2xl text-keel-black"></i>
            </button>
        </header>

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
                                    @if($p->status_lamaran == 'menunggu')
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

                                <!-- Action Buttons -->
                                @if($p->status_lamaran == 'menunggu')
                                <div class="flex gap-3">
                                    <form action="{{ route('pemberi-kerja.lamaran.terima', $p->idLamaran) }}" method="POST" class="flex-1">
                                        @csrf
                                        <button type="submit" onclick="return confirm('Yakin ingin menerima pelamar ini? Lamaran lain akan otomatis ditolak.')" class="w-full px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full transition-colors shadow-lg">
                                            <i class="fas fa-check mr-2"></i>
                                            Terima Pelamar
                                        </button>
                                    </form>

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

</body>
</html>