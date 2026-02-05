<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Konfirmasi Pekerja - KerjaKita</title>
    
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
        
        .no-scrollbar::-webkit-scrollbar { display: none; }
        .no-scrollbar { -ms-overflow-style: none; scrollbar-width: none; }

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

        /* Card Pulse Animation */
        @keyframes pulse-soft {
            0%, 100% { box-shadow: 0 10px 25px rgba(40, 159, 183, 0.1); }
            50% { box-shadow: 0 10px 35px rgba(40, 159, 183, 0.2); }
        }

        .pulse-card {
            animation: pulse-soft 2s ease-in-out infinite;
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
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-home text-xl"></i>
            </a>
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-user-check text-2xl"></i>
            </button>
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
        <header class="w-full px-6 py-6 flex items-center gap-4 bg-white shadow-sm border-b border-gray-200">
            <!-- Back Button -->
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <!-- Title -->
            <div class="flex-1">
                <h1 class="text-2xl font-bold text-keel-black">Konfirmasi Pekerja</h1>
                <p class="text-sm text-gray-600">Konfirmasi pekerja yang telah diterima untuk memulai pekerjaan</p>
            </div>

            <!-- Badge with count -->
            @if($pekerjaMenunggu->count() > 0)
            <div class="px-4 py-2 bg-yellow-100 rounded-full">
                <span class="text-sm font-bold text-yellow-700">
                    <i class="fas fa-clock mr-1"></i>
                    {{ $pekerjaMenunggu->count() }} Menunggu
                </span>
            </div>
            @endif

            <!-- Profile Icon -->
            <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <i class="far fa-user text-2xl text-keel-black"></i>
                @endif
            </a>
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
            
            @if($pekerjaMenunggu->isEmpty())
            <!-- Empty State -->
            <div class="text-center py-20">
                <div class="inline-block p-6 rounded-full bg-seafoam-bloom bg-opacity-20 mb-4">
                    <i class="fas fa-check-double text-5xl text-abyss-teal"></i>
                </div>
                <h3 class="text-2xl font-bold text-abyss-teal mb-2">Semua Pekerja Dikonfirmasi</h3>
                <p class="text-gray-500 mb-6">Tidak ada pekerja yang menunggu konfirmasi.</p>
                <a href="{{ route('pemberi-kerja.dashboard') }}" class="inline-block bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Kembali ke Dashboard
                </a>
            </div>
            @else
            <!-- Pekerja List Menunggu Konfirmasi -->
            <div class="max-w-5xl mx-auto space-y-4">
                
                @foreach($pekerjaMenunggu as $pekerja)
                <!-- Pekerja Card -->
                <div class="bg-white rounded-3xl shadow-lg overflow-hidden border-2 border-yellow-200 hover:shadow-xl transition-all duration-300 pulse-card">
                    <div class="p-6">
                        <div class="flex items-start gap-6">
                            <!-- Profile Picture -->
                            <div class="flex-shrink-0">
                                <div class="w-20 h-20 rounded-full bg-gradient-to-br from-pelagic-blue to-abyss-teal flex items-center justify-center shadow-lg">
                                    <span class="text-3xl font-bold text-white">
                                        {{ substr($pekerja->nama_pekerja, 0, 1) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Profile Info -->
                            <div class="flex-1">
                                <div class="flex items-start justify-between mb-3">
                                    <div>
                                        <h3 class="text-xl font-bold text-keel-black">{{ $pekerja->nama_pekerja }}</h3>
                                        <div class="flex items-center gap-2 mt-1">
                                            <div class="flex items-center">
                                                @for($i = 1; $i <= 5; $i++)
                                                    @if($i <= round($pekerja->rating_avg ?? 0))
                                                        <i class="fas fa-star text-yellow-400 text-sm"></i>
                                                    @else
                                                        <i class="far fa-star text-gray-300 text-sm"></i>
                                                    @endif
                                                @endfor
                                            </div>
                                            <span class="text-sm text-gray-600">
                                                {{ number_format($pekerja->rating_avg ?? 0, 1) }} ({{ $pekerja->total_rating ?? 0 }} ulasan)
                                            </span>
                                        </div>
                                    </div>

                                    <!-- Status Badge -->
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-yellow-100 text-yellow-700 flex items-center gap-1">
                                        <i class="fas fa-hourglass-half"></i> Menunggu Konfirmasi
                                    </span>
                                </div>

                                <!-- Details Grid -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 mb-4">
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-briefcase text-pelagic-blue w-4"></i>
                                        <span><strong>Pekerjaan:</strong> {{ $pekerja->judul }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt text-pelagic-blue w-4"></i>
                                        <span><strong>Lokasi:</strong> {{ $pekerja->lokasi }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-phone text-pelagic-blue w-4"></i>
                                        <span>{{ $pekerja->no_telp ?? 'Tidak tersedia' }}</span>
                                    </div>
                                    
                                    <div class="flex items-center gap-2 text-sm text-gray-600">
                                        <i class="fas fa-envelope text-pelagic-blue w-4"></i>
                                        <span>{{ $pekerja->email }}</span>
                                    </div>
                                </div>

                                <div class="text-xs text-gray-500 mb-4">
                                    <i class="fas fa-calendar mr-1"></i>
                                    Diterima pada {{ \Carbon\Carbon::parse($pekerja->tanggal_diterima)->format('d M Y, H:i') }}
                                </div>

                                <!-- Action Buttons -->
                                <div class="flex gap-3">
                                    <button onclick="openKonfirmasiModal('{{ $pekerja->idLamaran }}', '{{ $pekerja->nama_pekerja }}', '{{ $pekerja->judul }}')" class="flex-1 px-6 py-3 bg-green-500 hover:bg-green-600 text-white font-bold rounded-full transition-colors shadow-lg">
                                        <i class="fas fa-check mr-2"></i>
                                        Konfirmasi Pekerja
                                    </button>

                                    <button onclick="openBatalModal('{{ $pekerja->idLamaran }}', '{{ $pekerja->nama_pekerja }}')" class="flex-1 px-6 py-3 bg-red-500 hover:bg-red-600 text-white font-bold rounded-full transition-colors shadow-lg">
                                        <i class="fas fa-times mr-2"></i>
                                        Batalkan
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>
            @endif

            <!-- Pekerja yang Sudah Dikonfirmasi -->
            @if($pekerjaDikonfirmasi->count() > 0)
            <div class="mt-12">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-bold text-keel-black">Pekerja Aktif</h2>
                    <span class="px-3 py-1 bg-green-100 text-green-700 rounded-full text-sm font-bold">
                        {{ $pekerjaDikonfirmasi->count() }}
                    </span>
                </div>

                <div class="max-w-5xl mx-auto space-y-4">
                    @foreach($pekerjaDikonfirmasi as $pekerja)
                    <!-- Pekerja Aktif Card -->
                    <div class="bg-white rounded-3xl shadow-lg overflow-hidden border-2 border-green-200 hover:shadow-xl transition-all duration-300">
                        <div class="p-6">
                            <div class="flex items-start gap-6">
                                <!-- Profile Picture -->
                                <div class="flex-shrink-0">
                                    <div class="w-20 h-20 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center shadow-lg">
                                        <span class="text-3xl font-bold text-white">
                                            {{ substr($pekerja->nama_pekerja, 0, 1) }}
                                        </span>
                                    </div>
                                </div>

                                <!-- Profile Info -->
                                <div class="flex-1">
                                    <div class="flex items-start justify-between mb-3">
                                        <div>
                                            <h3 class="text-xl font-bold text-keel-black">{{ $pekerja->nama_pekerja }}</h3>
                                            <p class="text-sm text-gray-600">{{ $pekerja->judul }}</p>
                                        </div>

                                        <!-- Status Badge -->
                                        <span class="px-4 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700 flex items-center gap-1">
                                            <i class="fas fa-check-circle"></i> Sedang Bekerja
                                        </span>
                                    </div>

                                    <!-- Progress -->
                                    <div class="mb-4">
                                        <div class="flex justify-between items-center mb-2">
                                            <span class="text-sm font-semibold text-gray-700">Progress Pekerjaan</span>
                                            <span class="text-sm text-gray-600">{{ $pekerja->progress ?? '0' }}%</span>
                                        </div>
                                        <div class="w-full bg-gray-200 rounded-full h-2">
                                            <div class="bg-green-500 h-2 rounded-full" style="width: {{ $pekerja->progress ?? '0' }}%"></div>
                                        </div>
                                    </div>

                                    <div class="text-xs text-gray-500">
                                        <i class="fas fa-play-circle mr-1 text-green-500"></i>
                                        Dimulai pada {{ \Carbon\Carbon::parse($pekerja->tanggal_mulai)->format('d M Y') }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>

    <!-- Konfirmasi Modal -->
    <div id="konfirmasiModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end justify-center">
        <div class="bg-white rounded-t-3xl w-full md:w-1/2 max-h-[85vh] overflow-y-auto shadow-2xl">
            <!-- Header -->
            <div class="sticky top-0 bg-gradient-to-r from-green-400 to-green-600 px-8 py-6 rounded-t-3xl">
                <button onclick="closeKonfirmasiModal()" class="absolute top-4 right-4 text-white text-2xl hover:opacity-80">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-2xl font-bold text-white">Konfirmasi Pekerja</h2>
                <p class="text-white text-opacity-90 text-sm mt-2">Konfirmasi untuk memulai pekerjaan dengan pekerja ini</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-8 space-y-6">
                <!-- Worker Info -->
                <div class="bg-green-50 rounded-xl p-6 border-l-4 border-green-500">
                    <div class="text-sm text-gray-600 mb-2">Pekerja :</div>
                    <h3 id="namaPekerjaConfirm" class="text-lg font-bold text-keel-black mb-4"></h3>
                    <div class="text-sm text-gray-600">Pekerjaan :</div>
                    <p id="judulPekerjaanConfirm" class="font-semibold text-green-600"></p>
                </div>

                <!-- Confirmation Message -->
                <div class="bg-blue-50 border border-blue-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-info-circle text-blue-600 text-xl mt-1"></i>
                        <div>
                            <p class="text-sm font-semibold text-blue-900">Informasi Penting</p>
                            <p class="text-xs text-blue-800 mt-1">Setelah Anda mengonfirmasi, pekerja akan mulai bekerja. Status pekerjaan akan berubah menjadi "Sedang Berjalan".</p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button onclick="closeKonfirmasiModal()" class="flex-1 bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-full hover:bg-gray-400 transition-colors">
                        Batal
                    </button>
                    <form id="formKonfirmasi" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 px-4 rounded-full hover:bg-green-600 transition-colors shadow-lg">
                            <i class="fas fa-check mr-2"></i>
                            Konfirmasi
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <!-- Batalkan Modal -->
    <div id="batalModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-end justify-center">
        <div class="bg-white rounded-t-3xl w-full md:w-1/2 max-h-[85vh] overflow-y-auto shadow-2xl">
            <!-- Header -->
            <div class="sticky top-0 bg-gradient-to-r from-red-400 to-red-600 px-8 py-6 rounded-t-3xl">
                <button onclick="closeBatalModal()" class="absolute top-4 right-4 text-white text-2xl hover:opacity-80">
                    <i class="fas fa-times"></i>
                </button>
                <h2 class="text-2xl font-bold text-white">Batalkan Penerimaan</h2>
                <p class="text-white text-opacity-90 text-sm mt-2">Batalkan penerimaan pekerja ini</p>
            </div>

            <!-- Content -->
            <div class="px-8 py-8 space-y-6">
                <!-- Worker Info -->
                <div class="bg-red-50 rounded-xl p-6 border-l-4 border-red-500">
                    <div class="text-sm text-gray-600 mb-2">Pekerja :</div>
                    <h3 id="namaPekerjaBatal" class="text-lg font-bold text-keel-black mb-2"></h3>
                </div>

                <!-- Warning Message -->
                <div class="bg-red-50 border border-red-200 rounded-xl p-4">
                    <div class="flex items-start gap-3">
                        <i class="fas fa-exclamation-triangle text-red-600 text-xl mt-1"></i>
                        <div>
                            <p class="text-sm font-semibold text-red-900">Peringatan</p>
                            <p class="text-xs text-red-800 mt-1">Tindakan ini akan membatalkan penerimaan pekerja. Pekerja akan mendapat notifikasi bahwa lamaran mereka ditolak.</p>
                        </div>
                    </div>
                </div>

                <!-- Buttons -->
                <div class="flex gap-4 pt-4">
                    <button onclick="closeBatalModal()" class="flex-1 bg-gray-300 text-gray-800 font-bold py-3 px-4 rounded-full hover:bg-gray-400 transition-colors">
                        Kembali
                    </button>
                    <form id="formBatal" method="POST" class="flex-1">
                        @csrf
                        <button type="submit" class="w-full bg-red-500 text-white font-bold py-3 px-4 rounded-full hover:bg-red-600 transition-colors shadow-lg">
                            <i class="fas fa-times mr-2"></i>
                            Batalkan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openKonfirmasiModal(idLamaran, namaPekerja, judulPekerjaan) {
            document.getElementById('namaPekerjaConfirm').textContent = namaPekerja;
            document.getElementById('judulPekerjaanConfirm').textContent = judulPekerjaan;
            
            const form = document.getElementById('formKonfirmasi');
            form.action = `/pemberi-kerja/lamaran/${idLamaran}/terima`;
            
            const modal = document.getElementById('konfirmasiModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            modal.querySelector('.bg-white').classList.add('modal-animation');
        }

        function closeKonfirmasiModal() {
            const modal = document.getElementById('konfirmasiModal');
            const modalContent = modal.querySelector('.bg-white');
            
            modalContent.classList.remove('modal-animation');
            modalContent.classList.add('modal-animation-out');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                modalContent.classList.remove('modal-animation-out');
            }, 300);
        }

        function openBatalModal(idLamaran, namaPekerja) {
            document.getElementById('namaPekerjaBatal').textContent = namaPekerja;
            
            const form = document.getElementById('formBatal');
            form.action = `/pemberi-kerja/lamaran/${idLamaran}/tolak`;
            
            const modal = document.getElementById('batalModal');
            modal.classList.remove('hidden');
            modal.style.display = 'flex';
            modal.querySelector('.bg-white').classList.add('modal-animation');
        }

        function closeBatalModal() {
            const modal = document.getElementById('batalModal');
            const modalContent = modal.querySelector('.bg-white');
            
            modalContent.classList.remove('modal-animation');
            modalContent.classList.add('modal-animation-out');
            
            setTimeout(() => {
                modal.classList.add('hidden');
                modal.style.display = 'none';
                modalContent.classList.remove('modal-animation-out');
            }, 300);
        }

        // Close modal when clicking outside
        document.getElementById('konfirmasiModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeKonfirmasiModal();
            }
        });

        document.getElementById('batalModal').addEventListener('click', function(e) {
            if (e.target === this) {
                closeBatalModal();
            }
        });
    </script>

</body>
</html>
