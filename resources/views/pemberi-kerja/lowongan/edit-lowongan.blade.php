<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Lowongan - KerjaKita</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
                    fontFamily: {'poppins': ['Poppins', 'sans-serif']}
                }
            }
        }
    </script>
    <style>body { font-family: 'Poppins', sans-serif; background-color: #E8FBFF; }</style>
</head>
<body class="text-keel-black h-screen flex overflow-hidden">

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
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-briefcase text-xl"></i>
            </a>
        </div>
        <div class="mt-auto"></div>
    </aside>

    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        <header class="w-full px-6 py-6 flex items-center gap-4 bg-white shadow-sm">
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>
            <div class="flex-1">
                <h1 class="text-xl font-bold text-keel-black">Edit Lowongan Pekerjaan</h1>
                <p class="text-sm text-gray-500">Perbarui informasi lowongan pekerjaan ini</p>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto px-4 sm:px-8 py-6">
            <form action="{{ route('pemberi-kerja.lowongan.update', $lowongan->idLowongan) }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto">
                @csrf
                @method('PUT')
                
                <input type="hidden" name="status" value="{{ $lowongan->status }}">

                @if($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-4">
                        <strong class="font-bold">Ada kesalahan!</strong>
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <div class="space-y-6">
                        <!-- Judul -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Judul Pekerjaan</label>
                            <input type="text" name="judul" value="{{ old('judul', $lowongan->judul) }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue">
                        </div>

                        <!-- Kategori -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Kategori</label>
                            <select name="kategori" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl bg-white focus:outline-none focus:ring-2 focus:ring-pelagic-blue">
                                @php
                                    // Ambil kategori lowongan ini (relasi manual)
                                    $currentKat = DB::table('lowongan_kategori')->where('idLowongan', $lowongan->idLowongan)->value('id_kategori');
                                    $kategori = DB::table('kategori')->get();
                                @endphp
                                @foreach($kategori as $kat)
                                    <option value="{{ $kat->id_kategori }}" {{ $currentKat == $kat->id_kategori ? 'selected' : '' }}>{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Lokasi -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Lokasi Kerja</label>
                            <input type="text" name="lokasi" value="{{ old('lokasi', $lowongan->lokasi) }}" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue">
                        </div>
                    </div>

                    <div class="space-y-6">
                        <!-- Deskripsi -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Deskripsi Pekerjaan</label>
                            <textarea name="deskripsi" rows="6" required class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue resize-none">{{ old('deskripsi', $lowongan->deskripsi) }}</textarea>
                        </div>

                        <!-- Upah -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Upah</label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                <input type="text" name="upah" id="upahInput" value="{{ number_format($lowongan->upah, 0, ',', '.') }}" required class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue">
                            </div>
                        </div>

                        <!-- Buttons -->
                        <div class="flex gap-3 pt-4">
                            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="flex-1 bg-gray-200 hover:bg-gray-300 text-keel-black font-bold py-3 px-6 rounded-full text-center transition-colors">Batal</a>
                            <button type="submit" class="flex-1 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors">Simpan Perubahan</button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </main>

    <script>
        const upahInput = document.getElementById('upahInput');
        upahInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });
    </script>
</body>
</html>
