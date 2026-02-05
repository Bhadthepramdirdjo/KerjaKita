<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lowongan Saya - KerjaKita</title>
    
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

            <!-- Briefcase Icon (Active) -->
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
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 relative">
                <input type="text" 
                       id="searchInput"
                       placeholder="Cari lowongan..." 
                       class="w-full bg-white border-2 border-keel-black rounded-full py-2 px-6 focus:outline-none focus:ring-2 focus:ring-pelagic-blue shadow-sm">
                <button class="absolute right-2 top-1/2 transform -translate-y-1/2 w-8 h-8 flex items-center justify-center">
                    <i class="fas fa-search text-keel-black"></i>
                </button>
            </div>

            <!-- Profile Icon -->
            <a href="{{ route('pemberi-kerja.profil') }}" class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                @if(auth()->user()->foto_profil)
                    <img src="{{ asset('storage/' . auth()->user()->foto_profil) }}" alt="Foto Profil" class="w-full h-full object-cover">
                @else
                    <i class="far fa-user text-2xl text-keel-black"></i>
                @endif
            </a>
        </header>

        <!-- Filter Tabs -->
        <div class="px-6 py-4 bg-white border-b border-gray-200">
            <div class="flex gap-3">
                <button class="filter-tab active px-6 py-2 rounded-full font-semibold transition-colors bg-keel-black text-white" data-filter="all">
                    Semua
                </button>
                <button class="filter-tab px-6 py-2 rounded-full font-semibold transition-colors bg-gray-200 text-keel-black hover:bg-gray-300" data-filter="aktif">
                    Aktif
                </button>
                <button class="filter-tab px-6 py-2 rounded-full font-semibold transition-colors bg-gray-200 text-keel-black hover:bg-gray-300" data-filter="draft">
                    Draft
                </button>
                <button class="filter-tab px-6 py-2 rounded-full font-semibold transition-colors bg-gray-200 text-keel-black hover:bg-gray-300" data-filter="selesai">
                    Selesai
                </button>
            </div>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-6 py-6">
            
            <!-- Alert Messages -->
            @if(session('success'))
                <div class="max-w-6xl mx-auto mb-4 bg-green-100 border-l-4 border-green-500 text-green-700 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="py-1"><i class="fas fa-check-circle mr-3"></i></div>
                        <div>
                            <p class="font-bold">Berhasil</p>
                            <p class="text-sm">{{ session('success') }}</p>
                        </div>
                    </div>
                </div>
            @endif

            @if(session('error'))
                <div class="max-w-6xl mx-auto mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-md shadow-sm" role="alert">
                    <div class="flex">
                        <div class="py-1"><i class="fas fa-exclamation-circle mr-3"></i></div>
                        <div>
                            <p class="font-bold">Error</p>
                            <p class="text-sm">{{ session('error') }}</p>
                        </div>
                    </div>
                </div>
            @endif
            
            <!-- Lowongan Cards -->
            <div class="max-w-6xl mx-auto space-y-4" id="lowonganContainer">
                
                @foreach($lowongan as $job)
                @php
                    $cardStatus = $job->status;
                    if($job->status_pekerjaan == 'selesai') {
                        $cardStatus = 'selesai';
                    } elseif($job->status_pekerjaan == 'berjalan') {
                        $cardStatus = 'aktif';
                    }
                @endphp
                <!-- Lowongan Card -->
                <div class="lowongan-card bg-white rounded-3xl shadow-lg overflow-hidden border-2 border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-status="{{ $cardStatus }}">
                    <div class="p-6">
                        <div class="flex items-start justify-between mb-4">
                            <!-- Job Info -->
                            <div class="flex-1">
                                <h3 class="text-xl font-bold text-keel-black mb-2">{{ $job->judul }}</h3>
                                
                                <div class="space-y-1 text-sm text-gray-600">
                                    <div class="flex items-center gap-2">
                                        <i class="fas fa-map-marker-alt text-pelagic-blue w-4"></i>
                                        <span>{{ $job->lokasi }}</span>
                                    </div>
                                </div>
                            </div>

                            <!-- Status Badge -->
                            <div>
                                <!-- Status Logic -->
                                @if($job->status_pekerjaan == 'berjalan')
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Sedang Dikerjakan</span>
                                @elseif($job->status_pekerjaan == 'selesai')
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Selesai</span>
                                @elseif($job->status == 'aktif')
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Aktif</span>
                                @elseif($job->status == 'draft')
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-700">Draft</span>
                                @else
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-red-100 text-red-700">Tidak Aktif</span>
                                @endif
                            </div>
                        </div>

                        <!-- Applicants -->
                        <div class="flex items-center justify-between pt-4 border-t border-gray-200">
                            <div class="flex items-center gap-2">
                                <div class="flex -space-x-2">
                                    @for($i = 0; $i < min($job->total_pelamar, 5); $i++)
                                    <div class="w-8 h-8 rounded-full bg-gray-300 border-2 border-white flex items-center justify-center">
                                        <i class="fas fa-user text-xs text-gray-600"></i>
                                    </div>
                                    @endfor
                                    
                                    @if($job->total_pelamar > 5)
                                    <div class="w-8 h-8 rounded-full bg-pelagic-blue border-2 border-white flex items-center justify-center">
                                        <span class="text-xs text-white font-bold">+{{ $job->total_pelamar - 5 }}</span>
                                    </div>
                                    @endif
                                </div>
                                
                                <span class="text-sm text-gray-600 font-semibold">
                                    {{ $job->total_pelamar }} Pelamar
                                </span>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex gap-2">
                                @if($job->status_pekerjaan == 'berjalan')
                                    <button onclick="openSelesaiModal('{{ $job->idPekerjaan }}', '{{ $job->judul }}')" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full transition-colors text-sm">
                                        <i class="fas fa-check mr-1"></i>
                                        Selesai
                                    </button>
                                @endif

                                @if($job->status_pekerjaan == 'selesai')
                                    @if($job->is_rated > 0)
                                        <button disabled class="px-4 py-2 bg-gray-100 text-gray-400 font-semibold rounded-full text-sm cursor-not-allowed border border-gray-200">
                                            <i class="fas fa-star text-yellow-400 mr-1"></i>
                                            Sudah Dirating
                                        </button>
                                    @else
                                        <button onclick="openRatingModal('{{ $job->idPekerjaan }}', '{{ $job->judul }}', '{{ $job->nama_pekerja ?? 'Pekerja' }}')" class="px-4 py-2 bg-pelagic-blue hover:bg-abyss-teal text-white font-semibold rounded-full transition-colors text-sm shadow-md">
                                            <i class="far fa-star mr-1"></i>
                                            Beri Rating
                                        </button>
                                    @endif
                                @elseif($job->status == 'draft')
                                    <!-- Button untuk publikasi draft -->
                                    <form action="{{ route('pemberi-kerja.lowongan.publikasi', $job->idLowongan) }}" method="POST" class="inline">
                                        @csrf
                                        <button type="submit" class="px-4 py-2 bg-green-500 hover:bg-green-600 text-white font-semibold rounded-full transition-colors text-sm">
                                            <i class="fas fa-rocket mr-1"></i>
                                            Publikasi
                                        </button>
                                    </form>
                                    <a href="{{ route('pemberi-kerja.lowongan.edit', $job->idLowongan) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-keel-black font-semibold rounded-full transition-colors text-sm">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                @else
                                    <a href="{{ route('pemberi-kerja.lowongan.pelamar', $job->idLowongan) }}" class="px-4 py-2 bg-pelagic-blue hover:bg-abyss-teal text-white font-semibold rounded-full transition-colors text-sm">
                                        <i class="fas fa-eye mr-1"></i>
                                        Lihat
                                    </a>
                                    <a href="{{ route('pemberi-kerja.lowongan.edit', $job->idLowongan) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-keel-black font-semibold rounded-full transition-colors text-sm">
                                        <i class="fas fa-edit mr-1"></i>
                                        Edit
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach

            </div>

            <!-- Empty State -->
            <div id="emptyState" class="hidden text-center py-20">
                <div class="inline-block p-6 rounded-full bg-seafoam-bloom bg-opacity-20 mb-4">
                    <i class="fas fa-briefcase text-5xl text-abyss-teal"></i>
                </div>
                <h3 class="text-2xl font-bold text-abyss-teal mb-2">Tidak Ada Lowongan</h3>
                <p class="text-gray-500 mb-6">Belum ada lowongan yang sesuai dengan filter.</p>
                <a href="{{ route('pemberi-kerja.buat-lowongan') }}" class="inline-block bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                    <i class="fas fa-plus mr-2"></i>
                    Buat Lowongan Baru
                </a>
            </div>

        </div>
    </main>

    <!-- Modal Konfirmasi Selesai -->
    <div id="selesaiModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <!-- Background backdrop -->
        <div class="fixed inset-0 bg-gray-500 bg-opacity-75 transition-opacity backdrop-filter backdrop-blur-sm"></div>

        <div class="flex items-end justify-center min-h-screen pt-4 px-4 pb-20 text-center sm:block sm:p-0">
            <span class="hidden sm:inline-block sm:align-middle sm:h-screen" aria-hidden="true">&#8203;</span>

            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full">
                <div class="bg-white px-4 pt-5 pb-4 sm:p-6 sm:pb-4">
                    <div class="sm:flex sm:items-start">
                        <div class="mx-auto flex-shrink-0 flex items-center justify-center h-12 w-12 rounded-full bg-green-100 sm:mx-0 sm:h-10 sm:w-10">
                            <i class="fas fa-check text-green-600"></i>
                        </div>
                        <div class="mt-3 text-center sm:mt-0 sm:ml-4 sm:text-left">
                            <h3 class="text-lg leading-6 font-medium text-gray-900" id="modal-title">
                                Konfirmasi Pekerjaan Selesai
                            </h3>
                            <div class="mt-2">
                                <p class="text-sm text-gray-500">
                                    Apakah Anda yakin ingin menandai pekerjaan <span id="modalJobTitle" class="font-bold text-keel-black"></span> sebagai selesai? 
                                    Ini akan menyelesaikan proses kerja sama dan Anda dapat memberikan rating kepada pekerja.
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                    <form id="formSelesai" method="POST" action="">
                        @csrf
                        <button type="submit" class="w-full inline-flex justify-center rounded-xl border border-transparent shadow-sm px-4 py-2 bg-green-600 text-base font-medium text-white hover:bg-green-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-green-500 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                            Ya, Selesai
                        </button>
                    </form>
                    <button type="button" onclick="closeSelesaiModal()" class="mt-3 w-full inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pelagic-blue sm:mt-0 sm:ml-3 sm:w-auto sm:text-sm transition-colors">
                        Batal
                    </button>
                </div>
            </div>
        </div>
    </div>

    <script>
        function openSelesaiModal(id, title) {
            const modal = document.getElementById('selesaiModal');
            const jobTitle = document.getElementById('modalJobTitle');
            const form = document.getElementById('formSelesai');
            
            // Set data
            jobTitle.textContent = title;
            const baseUrl = "{{ route('pemberi-kerja.pekerjaan.selesai', 'ID_PLACEHOLDER') }}";
            form.action = baseUrl.replace('ID_PLACEHOLDER', id);
            
            // Show modal
            modal.classList.remove('hidden');
        }

        function closeSelesaiModal() {
            const modal = document.getElementById('selesaiModal');
            modal.classList.add('hidden');
        }
    </script>

    <script>
        // Filter functionality
        const filterTabs = document.querySelectorAll('.filter-tab');
        const lowonganCards = document.querySelectorAll('.lowongan-card');
        const emptyState = document.getElementById('emptyState');
        const lowonganContainer = document.getElementById('lowonganContainer');

        filterTabs.forEach(tab => {
            tab.addEventListener('click', () => {
                // Update active tab
                filterTabs.forEach(t => {
                    t.classList.remove('active', 'bg-keel-black', 'text-white');
                    t.classList.add('bg-gray-200', 'text-keel-black');
                });
                tab.classList.add('active', 'bg-keel-black', 'text-white');
                tab.classList.remove('bg-gray-200', 'text-keel-black');

                // Filter cards
                const filter = tab.dataset.filter;
                let visibleCount = 0;

                lowonganCards.forEach(card => {
                    if (filter === 'all' || card.dataset.status === filter) {
                        card.classList.remove('hidden');
                        visibleCount++;
                    } else {
                        card.classList.add('hidden');
                    }
                });

                // Show/hide empty state
                if (visibleCount === 0) {
                    lowonganContainer.classList.add('hidden');
                    emptyState.classList.remove('hidden');
                } else {
                    lowonganContainer.classList.remove('hidden');
                    emptyState.classList.add('hidden');
                }
            });
        });

        // Search functionality
        const searchInput = document.getElementById('searchInput');
        searchInput.addEventListener('input', (e) => {
            const searchTerm = e.target.value.toLowerCase();
            let visibleCount = 0;

            lowonganCards.forEach(card => {
                const jobName = card.querySelector('h3').textContent.toLowerCase();
                const location = card.querySelector('.fa-map-marker-alt').parentElement.textContent.toLowerCase();
                const category = card.querySelector('.fa-tag').parentElement.textContent.toLowerCase();

                if (jobName.includes(searchTerm) || location.includes(searchTerm) || category.includes(searchTerm)) {
                    card.classList.remove('hidden');
                    visibleCount++;
                } else {
                    card.classList.add('hidden');
                }
            });

            // Show/hide empty state
            if (visibleCount === 0) {
                lowonganContainer.classList.add('hidden');
                emptyState.classList.remove('hidden');
            } else {
                lowonganContainer.classList.remove('hidden');
                emptyState.classList.add('hidden');
            }
        });
    </script>

    <style>
        .star-interact { cursor: pointer; transition: transform 0.1s, color 0.1s; }
        .star-interact:hover { transform: scale(1.2); }
        .star-interact.active { color: #FBBF24; /* yellow-400 */ }
        .star-interact.inactive { color: #D1D5DB; /* gray-300 */ }
    </style>

    <!-- Modal Rating -->
    <div id="ratingModal" class="fixed inset-0 z-50 hidden overflow-y-auto" aria-labelledby="modal-title" role="dialog" aria-modal="true">
        <div class="fixed inset-0 bg-gray-900 bg-opacity-75 transition-opacity backdrop-filter backdrop-blur-sm"></div>

        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:p-0">
            <div class="inline-block align-bottom bg-white rounded-2xl text-left overflow-hidden shadow-2xl transform transition-all sm:my-8 sm:align-middle sm:max-w-lg sm:w-full border border-gray-100">
                
                <form action="{{ route('rating.beri') }}" method="POST" id="ratingForm">
                    @csrf
                    <input type="hidden" name="idPekerjaan" id="ratingIdPekerjaan">
                    
                    <div class="bg-gray-50 px-6 py-6 border-b border-gray-100">
                        <h3 class="text-xl font-bold text-keel-black mb-2" id="modal-title">Beri Penilaian</h3>
                        <div class="space-y-1 text-sm text-gray-600">
                            <p><strong>Pemberi Kerja:</strong> {{ auth()->user()->nama }}</p>
                            <p><strong>Pekerjaan:</strong> <span id="ratingJudulJob"></span></p>
                            <p><strong>Menilai Pekerja:</strong> <span id="ratingNamaPekerja"></span></p>
                        </div>
                    </div>

                    <div class="px-6 py-6 space-y-6">
                        <!-- Main Rating -->
                        <div class="text-center">
                            <label class="block text-sm font-medium text-gray-700 mb-2">Rating Utama</label>
                            <div class="flex justify-center space-x-2" id="mainStarContainer">
                                @for($i=1; $i<=5; $i++)
                                <i class="far fa-star text-3xl star-interact inactive" data-val="{{ $i }}" onclick="setRating('main', {{ $i }})"></i>
                                @endfor
                            </div>
                            <input type="hidden" name="nilai_rating" id="inputMainRating" required>
                        </div>

                        <!-- Detail Aspects -->
                        <div class="space-y-3 bg-gray-50 p-4 rounded-xl">
                            @foreach(['Kualitas Pekerjaan' => 'kualitas', 'Ketepatan Waktu' => 'waktu', 'Kelancaran Komunikasi' => 'komunikasi', 'Inisiatif' => 'inisiatif'] as $label => $name)
                            <div class="flex items-center justify-between">
                                <span class="text-sm text-gray-600">{{ $label }}</span>
                                <div class="flex space-x-1" id="starContainer_{{ $name }}">
                                    @for($i=1; $i<=5; $i++)
                                    <i class="far fa-star text-sm star-interact inactive" data-val="{{ $i }}" onclick="setRating('{{ $name }}', {{ $i }})"></i>
                                    @endfor
                                    <input type="hidden" name="{{ $name }}" id="input_{{ $name }}">
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Ulasan -->
                        <div>
                            <textarea name="ulasan" rows="3" placeholder="Tulis pengalamammu secara singkat (opsional)" class="w-full border border-gray-300 rounded-xl p-3 focus:outline-none focus:ring-2 focus:ring-pelagic-blue text-sm"></textarea>
                        </div>

                        <!-- Bersedia Bekerja Lagi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">Apakah kamu bersedia bekerja lagi dengan pemberi kerja ini?</label>
                            <div class="flex space-x-4">
                                <label class="inline-flex items-center">
                                    <input type="radio" name="bersedia_kembali" value="Ya" class="form-radio text-pelagic-blue">
                                    <span class="ml-2 text-sm text-gray-700">Ya</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="bersedia_kembali" value="Tidak Yakin" class="form-radio text-pelagic-blue">
                                    <span class="ml-2 text-sm text-gray-700">Tidak yakin</span>
                                </label>
                                <label class="inline-flex items-center">
                                    <input type="radio" name="bersedia_kembali" value="Tidak" class="form-radio text-pelagic-blue">
                                    <span class="ml-2 text-sm text-gray-700">Tidak</span>
                                </label>
                            </div>
                        </div>
                    </div>

                    <div class="bg-gray-50 px-6 py-4 flex flex-row-reverse gap-3">
                        <button type="submit" class="inline-flex justify-center rounded-xl border border-transparent shadow-sm px-6 py-2 bg-pelagic-blue text-base font-medium text-white hover:bg-abyss-teal focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-pelagic-blue sm:text-sm transition-colors">
                            Kirim Rating
                        </button>
                        <button type="button" onclick="closeRatingModal()" class="inline-flex justify-center rounded-xl border border-gray-300 shadow-sm px-4 py-2 bg-white text-base font-medium text-gray-700 hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-pelagic-blue sm:text-sm transition-colors">
                            Batal
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        function openRatingModal(id, judul, pekerja) {
            document.getElementById('ratingModal').classList.remove('hidden');
            document.getElementById('ratingIdPekerjaan').value = id;
            document.getElementById('ratingJudulJob').textContent = judul;
            document.getElementById('ratingNamaPekerja').textContent = pekerja;
            
            // Reset form
            document.getElementById('ratingForm').reset();
            resetStars();
        }

        function closeRatingModal() {
            document.getElementById('ratingModal').classList.add('hidden');
        }

        function setRating(type, val) {
            let container;
            let input;
            
            if (type === 'main') {
                container = document.getElementById('mainStarContainer');
                input = document.getElementById('inputMainRating');
            } else {
                container = document.getElementById('starContainer_' + type);
                input = document.getElementById('input_' + type);
            }
            
            if (!input) return; // Safety check
            
            input.value = val;
            const stars = container.querySelectorAll('i');
            
            stars.forEach(star => {
                const starVal = parseInt(star.dataset.val);
                if (starVal <= val) {
                    star.classList.remove('far', 'inactive');
                    star.classList.add('fas', 'active');
                    star.style.color = '#FBBF24';
                } else {
                    star.classList.remove('fas', 'active');
                    star.classList.add('far', 'inactive');
                    star.style.color = '#D1D5DB';
                }
            });
        }
        
        function resetStars() {
            const allStars = document.querySelectorAll('.star-interact');
            allStars.forEach(star => {
                star.classList.remove('fas', 'active');
                star.classList.add('far', 'inactive');
                star.style.color = '#D1D5DB';
            });
            document.querySelectorAll('input[type="hidden"][name^="input"]').forEach(i => i.value = '');
            document.querySelectorAll('input[type="hidden"][name="nilai_rating"]').forEach(i => i.value = '');
        }
    </script>
</body>
</html>
