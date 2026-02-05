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
    
    <!-- Sidebar -->
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
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-briefcase text-2xl"></i>
            </a>
        </div>
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 overflow-y-auto">
        <div class="max-w-6xl mx-auto p-6 lg:p-8">
            
            <!-- Header with Back Button -->
            <div class="mb-8 flex items-center gap-4">
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

</body>
</html>
