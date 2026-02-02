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
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="far fa-user text-2xl text-keel-black"></i>
            </button>
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
            
            <!-- Lowongan Cards -->
            <div class="max-w-6xl mx-auto space-y-4" id="lowonganContainer">
                
                @foreach($lowongan as $job)
                <!-- Lowongan Card -->
                <div class="lowongan-card bg-white rounded-3xl shadow-lg overflow-hidden border-2 border-gray-200 hover:shadow-xl transition-all duration-300 transform hover:-translate-y-1" data-status="{{ $job->status }}">
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
                                @if($job->status == 'aktif')
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-green-100 text-green-700">Aktif</span>
                                @elseif($job->status == 'draft')
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-gray-200 text-gray-700">Draft</span>
                                @else
                                    <span class="px-4 py-1 rounded-full text-xs font-bold bg-blue-100 text-blue-700">Selesai</span>
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
                                <a href="{{ route('pemberi-kerja.lowongan.pelamar', $job->idLowongan) }}" class="px-4 py-2 bg-pelagic-blue hover:bg-abyss-teal text-white font-semibold rounded-full transition-colors text-sm">
                                    <i class="fas fa-eye mr-1"></i>
                                    Lihat
                                </a>
                                <a href="{{ route('pemberi-kerja.lowongan.edit', $job->idLowongan) }}" class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-keel-black font-semibold rounded-full transition-colors text-sm">
                                    <i class="fas fa-edit mr-1"></i>
                                    Edit
                                </a>
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

</body>
</html>
