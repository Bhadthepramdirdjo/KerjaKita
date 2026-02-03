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

        /* Modal Animation */
        @keyframes slideInUp {
            from {
                transform: translateY(100px);
                opacity: 0;
            }
            to {
                transform: translateY(0);
                opacity: 1;
            }
        }

        @keyframes slideOutDown {
            from {
                transform: translateY(0);
                opacity: 1;
            }
            to {
                transform: translateY(100px);
                opacity: 0;
            }
        }

        .modal-animation {
            animation: slideInUp 0.4s cubic-bezier(0.34, 1.56, 0.64, 1);
        }

        .modal-animation-out {
            animation: slideOutDown 0.3s ease-in-out;
        }

        /* Star Rating Styles */
        .star-rating {
            display: flex;
            gap: 0.5rem;
            justify-content: center;
        }

        .star-input {
            cursor: pointer;
            font-size: 2.5rem;
            color: #ccc;
            transition: color 0.2s;
        }

        .star-input:hover,
        .star-input.active {
            color: #FFD700;
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
            <a href="{{ route('pemberi-kerja.konfirmasi-pekerja') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors relative">
                <i class="fas fa-user-check text-2xl"></i>
                <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $pekerjaMenunggu ?? 0 }}</span>
            </a>
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="relative w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-briefcase text-2xl"></i>
                @if(isset($notifikasiLamaranBaru) && $notifikasiLamaranBaru > 0)
                    <span class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs rounded-full flex items-center justify-center font-bold">{{ $notifikasiLamaranBaru }}</span>
                @endif
            </a>
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
                            @if($job->idPekerjaan)
                                <!-- Jika ada pekerjaan -->
                                @if($job->status_pekerjaan == 'berjalan')
                                    <!-- Jika masih berjalan, tampilkan tombol lihat pelamar dan konfirmasi selesai -->
                                    <a href="{{ route('pemberi-kerja.lowongan.pelamar', $job->idLowongan) }}" class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-seafoam-bloom transition-colors shadow-lg text-sm tracking-wide text-center">
                                        Lihat Pelamar
                                    </a>
                                    <form action="{{ route('pekerjaan.selesai', $job->idPekerjaan) }}" method="POST" class="w-full">
                                        @csrf
                                        <button type="submit" class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-green-100 transition-colors shadow-lg text-sm tracking-wide text-center">
                                            Konfirmasi Selesai
                                        </button>
                                    </form>
                                @else
                                    <!-- Jika sudah selesai, tampilkan tombol beri rating -->
                                    <button onclick="openRatingModal({{ $job->idPekerjaan }}, '{{ $job->judul }}', '{{ $job->nama_pekerja }}')" class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-seafoam-bloom transition-colors shadow-lg text-sm tracking-wide text-center">
                                        Beri Rating
                                    </button>
                                    <a href="{{ route('pemberi-kerja.pekerjaan.detail', $job->idPekerjaan) }}" class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-foam-white transition-colors shadow-lg text-sm tracking-wide text-center">
                                        Lihat Detail
                                    </a>
                                @endif
                            @else
                                <!-- Jika lowongan baru tanpa pekerjaan -->
                                <a href="{{ route('pemberi-kerja.lowongan.pelamar', $job->idLowongan) }}" class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-seafoam-bloom transition-colors shadow-lg text-sm tracking-wide text-center">
                                    Lihat Pelamar
                                </a>
                                <a href="{{ route('pemberi-kerja.lowongan.edit', $job->idLowongan) }}" class="w-full bg-white text-keel-black font-bold py-2.5 px-4 rounded-full hover:bg-foam-white transition-colors shadow-lg text-sm tracking-wide text-center">
                                    Edit Lowongan
                                </a>
                            @endif
                        </div>
                        <!-- Right Icon (Absolutely Positioned Bottom-Right) -->
                        <div class="absolute bottom-6 right-6 flex flex-col items-center">
                            <span class="text-[10px] text-white opacity-60 mb-1">Lokasi</span>
                            <i class="fas fa-map-marker-alt text-2xl text-white"></i>
                        </div>
                    </div>
                </div>
                @empty
                 <!-- Empty State -->
                 <div class="col-span-full text-center py-20">
                    <div class="inline-block p-6 rounded-full bg-seafoam-bloom bg-opacity-20 mb-4">
                        <i class="fas fa-briefcase text-5xl text-abyss-teal"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-abyss-teal mb-2">Tidak Ada Pekerjaan</h3>
                    <p class="text-gray-500 mb-6">Belum ada pekerjaan yang sesuai dengan filter.</p>
                    <a href="{{ route('pemberi-kerja.buat-lowongan') }}" class="inline-block bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                        <i class="fas fa-plus mr-2"></i>
                        Buat Lowongan Baru
                    </a>
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

        // Rating Modal Functions
        let selectedRating = 0;
        let currentIdPekerjaan = null;

        function openRatingModal(idPekerjaan, judulLowongan, namaPekerja) {
            currentIdPekerjaan = idPekerjaan;
            selectedRating = 0;
            
            document.getElementById('judulLowongan').textContent = judulLowongan;
            document.getElementById('namaPekerja').textContent = namaPekerja;
            document.getElementById('ratingValue').textContent = '0';
            document.getElementById('ulasanInput').value = '';
            
            // Reset stars
            document.querySelectorAll('.star-input').forEach(star => {
                star.classList.remove('active');
            });
            
            // Show modal with animation
            const modal = document.getElementById('ratingModal');
            modal.style.display = 'flex';
            modal.querySelector('.bg-white').classList.add('modal-animation');
        }

        function closeRatingModal() {
            const modal = document.getElementById('ratingModal');
            const modalContent = modal.querySelector('.bg-white');
            
            modalContent.classList.remove('modal-animation');
            modalContent.classList.add('modal-animation-out');
            
            setTimeout(() => {
                modal.style.display = 'none';
                modalContent.classList.remove('modal-animation-out');
            }, 300);
        }

        // Star rating functionality
        function setRating(rating) {
            selectedRating = rating;
            document.getElementById('ratingValue').textContent = rating;
            
            document.querySelectorAll('.star-input').forEach((star, index) => {
                if (index < rating) {
                    star.classList.add('active');
                } else {
                    star.classList.remove('active');
                }
            });
        }

        function submitRating() {
            if (selectedRating === 0) {
                alert('Silakan pilih rating terlebih dahulu!');
                return;
            }

            const ulasan = document.getElementById('ulasanInput').value;
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = '{{ route("rating.beri") }}';
            
            form.innerHTML = `
                <input type="hidden" name="_token" value="{{ csrf_token() }}">
                <input type="hidden" name="idPekerjaan" value="${currentIdPekerjaan}">
                <input type="hidden" name="nilai_rating" value="${selectedRating}">
                <input type="hidden" name="ulasan" value="${ulasan}">
            `;
            
            document.body.appendChild(form);
            form.submit();
        }

        // Close modal when clicking outside
        document.getElementById('ratingModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeRatingModal();
            }
        });
    </script>

    <!-- Rating Modal -->
    <div id="ratingModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end justify-center">
        <div class="bg-white rounded-t-3xl w-full md:w-1/2 max-h-[85vh] overflow-y-auto shadow-2xl">
            <!-- Header -->
            <div class="sticky top-0 bg-gradient-to-r from-pelagic-blue to-shallow-reef px-8 py-6 rounded-t-3xl">
                <button onclick="closeRatingModal()" class="absolute top-4 right-4 text-white text-2xl hover:opacity-80">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-2xl font-bold text-white">Berikan Rating</h2>
                <p class="text-white text-opacity-90 text-sm mt-2">Beri penilaian untuk pekerja yang telah menyelesaikan pekerjaan</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-8 space-y-6">
                <!-- Job Info -->
                <div class="bg-foam-white rounded-xl p-6 border-l-4 border-pelagic-blue">
                    <div class="text-sm text-gray-600 mb-2">Pekerjaan :</div>
                    <h3 id="judulLowongan" class="text-lg font-bold text-keel-black mb-4"></h3>
                    <div class="text-sm text-gray-600">Pekerja :</div>
                    <p id="namaPekerja" class="font-semibold text-pelagic-blue"></p>
                </div>

                <!-- Star Rating -->
                <div class="space-y-4">
                    <label class="block text-sm font-bold text-gray-700">Berikan Rating :</label>
                    <div class="space-y-2">
                        <div class="star-rating">
                            <button type="button" onclick="setRating(1)" class="star-input" title="Buruk">★</button>
                            <button type="button" onclick="setRating(2)" class="star-input" title="Kurang">★</button>
                            <button type="button" onclick="setRating(3)" class="star-input" title="Baik">★</button>
                            <button type="button" onclick="setRating(4)" class="star-input" title="Sangat Baik">★</button>
                            <button type="button" onclick="setRating(5)" class="star-input" title="Sempurna">★</button>
                        </div>
                        <div class="text-center">
                            <span class="text-2xl font-bold text-pelagic-blue"><span id="ratingValue">0</span>/5</span>
                        </div>
                    </div>
                </div>

                <!-- Ulasan -->
                <div class="space-y-2">
                    <label for="ulasanInput" class="block text-sm font-bold text-gray-700">Ulasan (Opsional) :</label>
                    <textarea id="ulasanInput" class="w-full border-2 border-gray-300 rounded-lg px-4 py-3 focus:outline-none focus:border-pelagic-blue resize-none" rows="4" placeholder="Tulis ulasan Anda tentang pekerja ini..."></textarea>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button onclick="closeRatingModal()" class="flex-1 bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-full hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <button onclick="submitRating()" class="flex-1 bg-pelagic-blue text-white font-bold py-3 px-4 rounded-full hover:bg-abyss-teal transition-colors shadow-lg">
                        Kirim Rating
                    </button>
                </div>
            </div>
        </div>
    </div>

</body>
</html>
