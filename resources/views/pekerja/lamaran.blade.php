<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lamaran Saya - KerjaKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        'seafoam-bloom': '#A8E6CF',
                        'shallow-reef': '#7FCFB8',
                        'pelagic-blue': '#289FB7',
                        'abyss-teal': '#146B8C',
                        'foam-white': '#F8FFFE',
                        'keel-black': '#1A1A1A'
                    }
                }
            }
        }
    </script>
    
    <style>
        body {
            background: linear-gradient(135deg, #F8FFFE 0%, #E8F5F1 100%);
        }
        
        .status-badge {
            display: inline-flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            border-radius: 9999px;
            font-size: 0.75rem;
            font-weight: 600;
        }
        
        .status-pending {
            background-color: #FEF3C7;
            color: #92400E;
        }
        
        .status-accepted {
            background-color: #D1FAE5;
            color: #065F46;
        }
        
        .status-rejected {
            background-color: #FEE2E2;
            color: #991B1B;
        }
        
        .status-working {
            background-color: #DBEAFE;
            color: #1E40AF;
        }
        
        .status-completed {
            background-color: #E0E7FF;
            color: #3730A3;
        }
    </style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">
    
    <!-- Sidebar -->
    <aside class="w-20 lg:w-24 h-screen flex flex-col items-center py-8 z-50 fixed left-0 top-0 bg-white border-r border-gray-200 shadow-sm">
        <!-- Settings Icon -->
        <div class="mb-auto">
             <a href="{{ route('pekerja.pengaturan') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-cog text-2xl"></i>
            </a>
        </div>
        
        <!-- Center Icons -->
        <div class="flex flex-col space-y-8">
            <a href="{{ route('pekerja.dashboard') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-home text-xl"></i>
            </a>
            
            <!-- Lamaran Saya Button (Active) -->
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-briefcase text-xl"></i>
            </button>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 overflow-y-auto">
        <div class="max-w-7xl mx-auto p-6 lg:p-8">
            
            <!-- Header -->
            <div class="mb-8">
                <h1 class="text-3xl font-bold text-keel-black mb-2">Lamaran Saya</h1>
                <p class="text-gray-600">Kelola dan pantau status lamaran pekerjaan Anda</p>
            </div>

            <!-- Tabs -->
            <div class="mb-6">
                <div class="border-b border-gray-200">
                    <nav class="-mb-px flex space-x-8">
                        <button onclick="switchTab('pending')" id="tab-pending" class="tab-button border-b-2 border-pelagic-blue text-pelagic-blue py-4 px-1 text-sm font-medium">
                            Menunggu Konfirmasi
                            <span class="ml-2 bg-pelagic-blue text-white rounded-full px-2 py-0.5 text-xs">{{ $pending->count() }}</span>
                        </button>
                        <button onclick="switchTab('working')" id="tab-working" class="tab-button border-b-2 border-transparent text-gray-500 hover:text-gray-700 hover:border-gray-300 py-4 px-1 text-sm font-medium">
                            Sedang Dikerjakan
                            <span class="ml-2 bg-gray-200 text-gray-700 rounded-full px-2 py-0.5 text-xs">{{ $working->count() }}</span>
                        </button>
                    </nav>
                </div>
            </div>

            <!-- Tab Content: Menunggu Konfirmasi -->
            <div id="content-pending" class="tab-content">
                <div class="space-y-4">
                    @forelse($pending as $lamaran)
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-keel-black mb-2">{{ $lamaran->judul }}</h3>
                                <p class="text-gray-600 mb-3">{{ $lamaran->nama_perusahaan }}</p>
                                
                                <div class="flex flex-wrap gap-3 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-2 text-pelagic-blue"></i>
                                        {{ $lamaran->lokasi }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar mr-2 text-pelagic-blue"></i>
                                        Dilamar: {{ \Carbon\Carbon::parse($lamaran->tanggal_lamar)->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-money-bill-wave mr-2 text-pelagic-blue"></i>
                                        Rp {{ number_format($lamaran->upah, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <span class="status-badge status-pending">
                                    <i class="fas fa-clock mr-1"></i>
                                    Menunggu Konfirmasi
                                </span>
                            </div>
                            
                            <a href="{{ route('pekerja.lowongan.detail', $lamaran->idLowongan) }}" class="ml-4 px-4 py-2 bg-pelagic-blue hover:bg-abyss-teal text-white rounded-lg transition-colors text-sm font-medium">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-2xl p-12 text-center">
                        <i class="fas fa-inbox text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Belum Ada Lamaran</h3>
                        <p class="text-gray-500 mb-6">Anda belum melamar pekerjaan apapun</p>
                        <a href="{{ route('pekerja.dashboard') }}" class="inline-block px-6 py-3 bg-pelagic-blue hover:bg-abyss-teal text-white rounded-full transition-colors font-medium">
                            Cari Pekerjaan
                        </a>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Tab Content: Sedang Dikerjakan -->
            <div id="content-working" class="tab-content hidden">
                <div class="space-y-4">
                    @forelse($working as $pekerjaan)
                    <div class="bg-white rounded-2xl p-6 shadow-md hover:shadow-lg transition-shadow">
                        <div class="flex items-start justify-between">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-keel-black mb-2">{{ $pekerjaan->judul }}</h3>
                                <p class="text-gray-600 mb-3">{{ $pekerjaan->nama_perusahaan }}</p>
                                
                                <div class="flex flex-wrap gap-3 mb-4">
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-map-marker-alt mr-2 text-pelagic-blue"></i>
                                        {{ $pekerjaan->lokasi }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-calendar-check mr-2 text-pelagic-blue"></i>
                                        Mulai: {{ \Carbon\Carbon::parse($pekerjaan->tanggal_mulai)->format('d M Y') }}
                                    </div>
                                    <div class="flex items-center text-sm text-gray-600">
                                        <i class="fas fa-money-bill-wave mr-2 text-pelagic-blue"></i>
                                        Rp {{ number_format($pekerjaan->upah, 0, ',', '.') }}
                                    </div>
                                </div>
                                
                                <span class="status-badge status-working">
                                    <i class="fas fa-briefcase mr-1"></i>
                                    Sedang Dikerjakan
                                </span>
                            </div>
                            
                            <a href="{{ route('pekerja.lowongan.detail', $pekerjaan->idLowongan) }}" class="ml-4 px-4 py-2 bg-pelagic-blue hover:bg-abyss-teal text-white rounded-lg transition-colors text-sm font-medium">
                                Lihat Detail
                            </a>
                        </div>
                    </div>
                    @empty
                    <div class="bg-white rounded-2xl p-12 text-center">
                        <i class="fas fa-briefcase text-6xl text-gray-300 mb-4"></i>
                        <h3 class="text-xl font-bold text-gray-700 mb-2">Tidak Ada Pekerjaan Aktif</h3>
                        <p class="text-gray-500">Anda belum memiliki pekerjaan yang sedang dikerjakan</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <script>
        function switchTab(tabName) {
            // Hide all tab contents
            document.querySelectorAll('.tab-content').forEach(content => {
                content.classList.add('hidden');
            });
            
            // Remove active state from all tabs
            document.querySelectorAll('.tab-button').forEach(button => {
                button.classList.remove('border-pelagic-blue', 'text-pelagic-blue');
                button.classList.add('border-transparent', 'text-gray-500');
                
                // Reset badge colors
                const badge = button.querySelector('span');
                if (badge) {
                    badge.classList.remove('bg-pelagic-blue', 'text-white');
                    badge.classList.add('bg-gray-200', 'text-gray-700');
                }
            });
            
            // Show selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            
            // Add active state to selected tab
            const activeTab = document.getElementById('tab-' + tabName);
            activeTab.classList.remove('border-transparent', 'text-gray-500');
            activeTab.classList.add('border-pelagic-blue', 'text-pelagic-blue');
            
            // Update badge color for active tab
            const activeBadge = activeTab.querySelector('span');
            if (activeBadge) {
                activeBadge.classList.remove('bg-gray-200', 'text-gray-700');
                activeBadge.classList.add('bg-pelagic-blue', 'text-white');
            }
        }
    </script>

</body>
</html>
