<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil Pelamar - KerjaKita</title>
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
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Dashboard">
                <i class="fas fa-home text-lg"></i>
            </a>
            
            <!-- Lowongan Saya -->
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Lowongan Saya">
                <i class="fas fa-briefcase text-lg"></i>
            </a>

            <!-- Profil -->
            <a href="{{ route('pemberi-kerja.profil') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Profil">
                <i class="fas fa-user text-lg"></i>
            </a>

            <!-- Pengaturan -->
            <a href="{{ route('pemberi-kerja.pengaturan') }}" class="w-12 h-12 rounded-full bg-white text-keel-black shadow-lg flex items-center justify-center hover:bg-seafoam-bloom hover:text-white transition-all duration-200 transform hover:scale-110" title="Pengaturan">
                <i class="fas fa-cog text-lg"></i>
            </a>
        </div>
    </div>

    <!-- Main Content -->
    <main class="flex-1 overflow-y-auto no-scrollbar">
        <div class="max-w-6xl mx-auto p-6 lg:p-8">
            
            <!-- Header with Back Button -->
            <div class="mb-8 flex items-center gap-4 ml-20">
                <button onclick="history.back()" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 transition-colors">
                    <i class="fas fa-arrow-left text-keel-black"></i>
                </button>
                <h1 class="text-3xl font-bold text-keel-black">Profil Pelamar</h1>
            </div>

            <!-- Main Profile Card -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-6">
                <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
                    
                    <!-- Left Column - Photo & Rating -->
                    <div class="flex flex-col items-center">
                        <!-- Profile Photo -->
                        <div class="w-40 h-40 rounded-full bg-gray-200 border-4 border-pelagic-blue flex items-center justify-center mb-4 overflow-hidden relative">
                            @if($pekerja->foto_profil)
                                <img src="{{ asset('storage/' . $pekerja->foto_profil) }}" 
                                     alt="Foto Profil" 
                                     class="w-full h-full object-cover">
                            @else
                                <i class="fas fa-user text-6xl text-gray-400"></i>
                            @endif
                        </div>
                        
                        <!-- Rating -->
                        <div class="bg-seafoam-bloom bg-opacity-30 rounded-2xl p-4 w-full text-center">
                            <p class="text-sm text-gray-600 mb-1">Rating Pekerja</p>
                            <div class="flex items-center justify-center gap-2">
                                <div class="flex text-yellow-400">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($rating))
                                            <i class="fas fa-star"></i>
                                        @elseif($i - $rating < 1)
                                            <i class="fas fa-star-half-alt"></i>
                                        @else
                                            <i class="far fa-star"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-2xl font-bold text-keel-black">{{ number_format($rating, 1) }}</span>
                            </div>
                            <p class="text-xs text-gray-500 mt-1">{{ $totalRating }} ulasan</p>
                        </div>
                    </div>
                    
                    <!-- Right Column - Profile Info -->
                    <div class="lg:col-span-2 space-y-4">
                        <div>
                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nama Pekerja</label>
                            <div class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black font-medium">
                                {{ $pekerja->nama }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Usia Pekerja</label>
                            <div class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black">
                                {{ $pekerja->usia ?? '-' }} Tahun
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Alamat Rumah</label>
                            <div class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black">
                                {{ $pekerja->alamat ?? '-' }}
                            </div>
                        </div>
                        
                        <div>
                            <label class="text-sm font-bold text-gray-600 uppercase tracking-wider">Nomor Kontak</label>
                            <div class="w-full mt-1 px-4 py-3 bg-gray-100 border border-gray-300 rounded-lg text-keel-black">
                                {{ $pekerja->no_telp ?? '-' }}
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Skills Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mb-6">
                <h2 class="text-2xl font-bold text-keel-black mb-6">Keahlian</h2>
                <div class="flex flex-wrap gap-3">
                    @if(!empty($pekerja->keahlian))
                        @foreach(explode(',', $pekerja->keahlian) as $skill)
                            <span class="px-4 py-2 bg-pelagic-blue text-white rounded-full font-medium text-sm">
                                {{ trim($skill) }}
                            </span>
                        @endforeach
                    @else
                        <p class="text-gray-500 italic">Belum ada keahlian ditambahkan</p>
                    @endif
                </div>
            </div>

            <!-- Work Experience Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8">
                <h2 class="text-2xl font-bold text-keel-black mb-6">Pengalaman Pekerjaan</h2>
                
                <div class="space-y-4">
                    @forelse($pengalamanKerja as $pengalaman)
                    <div class="bg-gray-50 rounded-2xl p-6 border border-gray-200">
                        <div class="flex items-start justify-between mb-3">
                            <div class="flex-1">
                                <h3 class="text-lg font-bold text-keel-black mb-1">{{ $pengalaman->judul }}</h3>
                                <p class="text-gray-600 text-sm mb-2">{{ $pengalaman->nama_perusahaan }}</p>
                            </div>
                        </div>
                        
                        <p class="text-gray-700 mb-3">{{ $pengalaman->deskripsi ?? 'Tidak ada deskripsi' }}</p>
                        
                        <div class="flex items-center gap-4 text-sm text-gray-600">
                            <div class="flex items-center gap-2">
                                <i class="fas fa-clock text-pelagic-blue"></i>
                                <span>Durasi: {{ $pengalaman->durasi ?? '-' }}</span>
                            </div>
                            @if($pengalaman->tanggal_selesai)
                            <div class="flex items-center gap-2">
                                <i class="fas fa-calendar-check text-green-600"></i>
                                <span>Selesai: {{ \Carbon\Carbon::parse($pengalaman->tanggal_selesai)->format('M Y') }}</span>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="bg-gray-50 rounded-2xl p-12 text-center border-2 border-dashed border-gray-300">
                        <i class="fas fa-briefcase text-5xl text-gray-300 mb-3"></i>
                        <p class="text-gray-500 font-medium">Belum ada pengalaman pekerjaan</p>
                    </div>
                    @endforelse
                </div>
            </div>

            <!-- Reviews Section -->
            <div class="bg-white rounded-3xl shadow-xl p-8 mt-6 mb-10">
                <div class="flex items-center gap-3 mb-6">
                    <h2 class="text-2xl font-bold text-keel-black">Ulasan & Rating</h2>
                    <span class="bg-seafoam-bloom text-abyss-teal text-xs font-bold px-3 py-1 rounded-full">
                        {{ $totalRating ?? 0 }} Total
                    </span>
                </div>
                
                <div class="space-y-6">
                    @forelse($ulasanList as $review)
                    <div class="border-b border-gray-100 last:border-0 pb-6 last:pb-0">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-full bg-pelagic-blue flex items-center justify-center text-white text-lg font-bold">
                                    {{ substr($review->nama_pemberi_kerja, 0, 1) }}
                                </div>
                                <div>
                                    <h4 class="font-bold text-keel-black">{{ $review->nama_pemberi_kerja }}</h4>
                                    <p class="text-xs text-gray-500">{{ $review->judul_pekerjaan }}</p>
                                </div>
                            </div>
                            <div class="text-right">
                                <div class="flex items-center justify-end gap-1 text-yellow-400 mb-1">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= $review->nilai_rating)
                                            <i class="fas fa-star text-sm"></i>
                                        @else
                                            <i class="far fa-star text-sm text-gray-300"></i>
                                        @endif
                                    @endfor
                                    <span class="text-sm font-bold text-gray-700 ml-1">{{ $review->nilai_rating }}.0</span>
                                </div>
                                <p class="text-xs text-gray-400">
                                    {{ \Carbon\Carbon::parse($review->created_at)->translatedFormat('d F Y') }}
                                </p>
                            </div>
                        </div>
                        
                        <div class="bg-gray-50 rounded-xl p-4 text-sm text-gray-700 whitespace-pre-line leading-relaxed">
                            @php
                                $ulasan = $review->ulasan;
                                // Remove "Bersedia bekerja lagi" line
                                $ulasan = preg_replace('/\n*Bersedia bekerja lagi:.*$/m', '', $ulasan);
                                $ulasan = trim($ulasan);
                            @endphp
                            {{ $ulasan }}
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-8">
                        <div class="w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-3 text-gray-400">
                            <i class="far fa-comment-dots text-2xl"></i>
                        </div>
                        <p class="text-gray-500">Belum ada ulasan yang diterima.</p>
                    </div>
                    @endforelse
                </div>
            </div>

        </div>
    </main>

    <script>
        // Speed Dial Navigation Logic
        document.addEventListener('DOMContentLoaded', () => {
            const container = document.getElementById('speed-dial-container');
            const menu = document.getElementById('speed-dial-menu');
            const trigger = document.getElementById('speed-dial-trigger');
            let isLocked = false;

            if (container && menu && trigger) {
                function toggleMenu() {
                    isLocked = !isLocked;
                    if (isLocked) {
                        menu.classList.remove('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                        menu.classList.add('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                        trigger.classList.add('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    } else {
                        menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                        menu.classList.add('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                        trigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                    }
                }

                function closeMenu() {
                    isLocked = false;
                    menu.classList.remove('opacity-100', 'translate-y-0', 'scale-100', 'pointer-events-auto');
                    menu.classList.add('opacity-0', '-translate-y-4', 'scale-90', 'pointer-events-none');
                    trigger.classList.remove('ring-4', 'ring-pelagic-blue', 'ring-opacity-30');
                }

                trigger.addEventListener('click', (e) => {
                    e.stopPropagation();
                    toggleMenu();
                });

                // Close if clicked outside
                document.addEventListener('click', (e) => {
                    if (isLocked && !container.contains(e.target)) {
                        closeMenu();
                    }
                });
            }
        });
    </script>
</body>
</html>
