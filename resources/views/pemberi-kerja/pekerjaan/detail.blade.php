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

        /* Modal styles */
        .modal {
            display: none;
            position: fixed;
            z-index: 1000;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0,0,0,0.5);
        }
        
        .modal.show {
            display: flex;
            align-items: center;
            justify-content: center;
        }
    </style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">

    <!-- Sidebar -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <div class="mb-auto">
            <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </a>
        </div>
        
        <div class="flex flex-col space-y-8">
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-home text-xl"></i>
            </a>
            
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>

            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-briefcase text-xl"></i>
            </a>
        </div>
        
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4 bg-white shadow-sm">
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <div class="flex-1">
                <h1 class="text-2xl font-bold text-keel-black">Detail Pekerjaan</h1>
            </div>

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

        <!-- Content -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-6 py-6">
            <div class="max-w-4xl mx-auto">
                
                <!-- Status Card -->
                <div class="bg-white rounded-3xl shadow-lg p-6 mb-6 border-2 border-gray-200">
                    <div class="flex items-center justify-between">
                        <div>
                            <h2 class="text-2xl font-bold text-keel-black mb-2">{{ $pekerjaan->judul }}</h2>
                            <div class="flex items-center gap-4 text-sm text-gray-600">
                                <span>
                                    <i class="fas fa-calendar-alt mr-1"></i>
                                    Mulai: {{ \Carbon\Carbon::parse($pekerjaan->tanggal_mulai)->format('d M Y') }}
                                </span>
                                @if($pekerjaan->tanggal_selesai)
                                <span>
                                    <i class="fas fa-calendar-check mr-1"></i>
                                    Selesai: {{ \Carbon\Carbon::parse($pekerjaan->tanggal_selesai)->format('d M Y') }}
                                </span>
                                @endif
                            </div>
                        </div>

                        @if($pekerjaan->status_pekerjaan == 'berjalan')
                            <span class="px-6 py-2 rounded-full text-sm font-bold bg-blue-100 text-blue-700">
                                <i class="fas fa-sync fa-spin mr-2"></i>
                                Sedang Berjalan
                            </span>
                        @else
                            <span class="px-6 py-2 rounded-full text-sm font-bold bg-green-100 text-green-700">
                                <i class="fas fa-check-circle mr-2"></i>
                                Selesai
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Job Details -->
                <div class="bg-white rounded-3xl shadow-lg p-6 mb-6 border-2 border-gray-200">
                    <h3 class="text-xl font-bold text-keel-black mb-4">Informasi Pekerjaan</h3>
                    
                    <div class="space-y-3">
                        <div class="flex items-start gap-3">
                            <i class="fas fa-align-left text-pelagic-blue w-5 mt-1"></i>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-700">Deskripsi</p>
                                <p class="text-gray-600">{{ $pekerjaan->deskripsi }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <i class="fas fa-map-marker-alt text-pelagic-blue w-5"></i>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-700">Lokasi</p>
                                <p class="text-gray-600">{{ $pekerjaan->lokasi }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3">
                            <i class="fas fa-money-bill-wave text-pelagic-blue w-5"></i>
                            <div class="flex-1">
                                <p class="font-semibold text-gray-700">Upah</p>
                                <p class="text-gray-600">Rp {{ number_format($pekerjaan->upah, 0, ',', '.') }}</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Worker Details -->
                <div class="bg-white rounded-3xl shadow-lg p-6 mb-6 border-2 border-gray-200">
                    <h3 class="text-xl font-bold text-keel-black mb-4">Informasi Pekerja</h3>
                    
                    <div class="flex items-center gap-4 mb-4">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-pelagic-blue to-abyss-teal flex items-center justify-center shadow-lg">
                            <span class="text-2xl font-bold text-white">
                                {{ substr($pekerjaan->nama_pekerja, 0, 1) }}
                            </span>
                        </div>
                        <div>
                            <h4 class="text-lg font-bold text-keel-black">{{ $pekerjaan->nama_pekerja }}</h4>
                            <p class="text-sm text-gray-600">{{ $pekerjaan->email_pekerja }}</p>
                        </div>
                    </div>

                    <div class="space-y-2">
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fas fa-tools text-pelagic-blue w-5"></i>
                            <span><strong>Keahlian:</strong> {{ $pekerjaan->keahlian ?? 'Tidak disebutkan' }}</span>
                        </div>
                        <div class="flex items-center gap-3 text-sm">
                            <i class="fas fa-phone text-pelagic-blue w-5"></i>
                            <span><strong>No. HP:</strong> {{ $pekerjaan->noHP ?? 'Tidak tersedia' }}</span>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                @if($pekerjaan->status_pekerjaan == 'berjalan')
                <div class="bg-white rounded-3xl shadow-lg p-6 border-2 border-gray-200">
                    <h3 class="text-xl font-bold text-keel-black mb-4">Aksi</h3>
                    
                    <form action="{{ route('pemberi-kerja.pekerjaan.selesai', $pekerjaan->idPekerjaan) }}" method="POST">
                        @csrf
                        <button type="submit" onclick="return confirm('Yakin pekerjaan sudah selesai? Anda dapat memberikan rating setelah ini.')" class="w-full px-6 py-4 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full transition-colors shadow-lg">
                            <i class="fas fa-check-circle mr-2"></i>
                            Konfirmasi Pekerjaan Selesai
                        </button>
                    </form>
                </div>
                @elseif($pekerjaan->status_pekerjaan == 'selesai')
                <div class="bg-white rounded-3xl shadow-lg p-6 border-2 border-gray-200">
                    <h3 class="text-xl font-bold text-keel-black mb-4">Berikan Rating</h3>
                    
                    @if($rating)
                    <!-- Rating Already Given -->
                    <div class="bg-green-50 border-2 border-green-200 rounded-2xl p-4">
                        <div class="flex items-center justify-between mb-3">
                            <span class="font-bold text-gray-700">Rating Anda:</span>
                            <div class="flex items-center gap-1">
                                @for($i = 1; $i <= 5; $i++)
                                    @if($i <= $rating->nilai_rating)
                                        <i class="fas fa-star text-yellow-400 text-xl"></i>
                                    @else
                                        <i class="far fa-star text-gray-300 text-xl"></i>
                                    @endif
                                @endfor
                            </div>
                        </div>
                        @if($rating->komentar)
                        <p class="text-sm text-gray-600 italic">"{{ $rating->komentar }}"</p>
                        @endif
                        <p class="text-xs text-gray-500 mt-2">
                            Diberikan pada {{ \Carbon\Carbon::parse($rating->tanggal_rating)->format('d M Y, H:i') }}
                        </p>
                    </div>
                    @else
                    <!-- Rating Form -->
                    <button onclick="openRatingModal()" class="w-full px-6 py-4 bg-yellow-500 hover:bg-yellow-600 text-white font-bold rounded-full transition-colors shadow-lg">
                        <i class="fas fa-star mr-2"></i>
                        Beri Rating Pekerja
                    </button>
                    @endif
                </div>
                @endif

            </div>
        </div>
    </main>

    <!-- Rating Modal -->
    <div id="ratingModal" class="modal">
        <div class="bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4">
            <div class="flex items-center justify-between mb-6">
                <h3 class="text-2xl font-bold text-keel-black">Beri Rating</h3>
                <button onclick="closeRatingModal()" class="text-gray-400 hover:text-gray-600">
                    <i class="fas fa-times text-2xl"></i>
                </button>
            </div>

            <form action="{{ route('rating.beri') }}" method="POST">
                @csrf
                <input type="hidden" name="idPekerjaan" value="{{ $pekerjaan->idPekerjaan }}">
                <input type="hidden" name="pemberi_rating" value="pemberi_kerja">
                <input type="hidden" name="nilai_rating" id="nilai_rating" value="5">

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-3">Rating</label>
                    <div class="flex justify-center gap-2" id="starRating">
                        <i class="fas fa-star text-5xl text-yellow-400 cursor-pointer hover:scale-110 transition-transform" data-rating="1"></i>
                        <i class="fas fa-star text-5xl text-yellow-400 cursor-pointer hover:scale-110 transition-transform" data-rating="2"></i>
                        <i class="fas fa-star text-5xl text-yellow-400 cursor-pointer hover:scale-110 transition-transform" data-rating="3"></i>
                        <i class="fas fa-star text-5xl text-yellow-400 cursor-pointer hover:scale-110 transition-transform" data-rating="4"></i>
                        <i class="fas fa-star text-5xl text-yellow-400 cursor-pointer hover:scale-110 transition-transform" data-rating="5"></i>
                    </div>
                </div>

                <div class="mb-6">
                    <label class="block text-sm font-bold text-gray-700 mb-2">Komentar (Opsional)</label>
                    <textarea name="komentar" rows="4" class="w-full border-2 border-gray-300 rounded-xl px-4 py-2 focus:outline-none focus:ring-2 focus:ring-pelagic-blue" placeholder="Tulis komentar Anda..."></textarea>
                </div>

                <div class="flex gap-3">
                    <button type="button" onclick="closeRatingModal()" class="flex-1 px-6 py-3 bg-gray-200 hover:bg-gray-300 text-keel-black font-bold rounded-full transition-colors">
                        Batal
                    </button>
                    <button type="submit" class="flex-1 px-6 py-3 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold rounded-full transition-colors">
                        Kirim Rating
                    </button>
                </div>
            </form>
        </div>
    </div>

    <script>
        // Rating Modal Functions
        function openRatingModal() {
            document.getElementById('ratingModal').classList.add('show');
        }

        function closeRatingModal() {
            document.getElementById('ratingModal').classList.remove('show');
        }

        // Star Rating System
        const stars = document.querySelectorAll('#starRating i');
        const ratingInput = document.getElementById('nilai_rating');

        stars.forEach(star => {
            star.addEventListener('click', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                ratingInput.value = rating;
                
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.classList.remove('far');
                        s.classList.add('fas');
                        s.classList.add('text-yellow-400');
                    } else {
                        s.classList.remove('fas');
                        s.classList.add('far');
                        s.classList.remove('text-yellow-400');
                    }
                });
            });

            star.addEventListener('mouseenter', function() {
                const rating = parseInt(this.getAttribute('data-rating'));
                stars.forEach((s, index) => {
                    if (index < rating) {
                        s.style.opacity = '1';
                    } else {
                        s.style.opacity = '0.5';
                    }
                });
            });
        });

        document.getElementById('starRating').addEventListener('mouseleave', function() {
            stars.forEach(s => {
                s.style.opacity = '1';
            });
        });

        // Close modal on outside click
        window.onclick = function(event) {
            const modal = document.getElementById('ratingModal');
            if (event.target == modal) {
                closeRatingModal();
            }
        }
    </script>

</body>
</html>