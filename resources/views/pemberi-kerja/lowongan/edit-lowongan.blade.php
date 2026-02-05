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
            <a href="{{ route('pemberi-kerja.lowongan-saya') }}" class="w-12 h-12 rounded-full bg-keel-black text-white shadow-lg flex items-center justify-center hover:bg-keel-black hover:text-white transition-all duration-200 transform hover:scale-110" title="Lowongan Saya">
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
    <main class="flex-1 flex flex-col h-screen relative w-full">
        <div class="w-full px-6 pt-8 pb-4 flex items-center gap-4 ml-16">
            <div class="flex-1">
                <h1 class="text-3xl font-bold text-keel-black">Edit Lowongan Pekerjaan</h1>
                <p class="text-base text-gray-600 mt-1">Perbarui informasi lowongan pekerjaan ini</p>
            </div>
        </div>

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

                        <!-- Gambar -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Gambar Pendukung (Opsional)</label>
                            
                            <!-- Image Preview Area -->
                            <div class="mb-4 relative group" id="imagePreviewContainer" style="{{ $lowongan->gambar ? '' : 'display: none;' }}">
                                <img id="imagePreview" src="{{ $lowongan->gambar ? asset('storage/' . $lowongan->gambar) : '' }}" alt="Preview" class="w-full h-48 object-cover rounded-xl border border-gray-200">
                                <button type="button" id="removeImageBtn" class="absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white p-2 rounded-full shadow-md transition-colors" title="Hapus Gambar">
                                    <i class="fas fa-trash-alt"></i>
                                </button>
                                <input type="hidden" name="delete_image" id="deleteImageInput" value="0">
                            </div>

                            <!-- Upload Button -->
                            <div class="relative">
                                <input type="file" name="gambar" id="gambarInput" accept="image/*" class="hidden">
                                <label for="gambarInput" class="flex flex-col items-center justify-center w-full h-32 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer hover:bg-gray-50 hover:border-pelagic-blue transition-colors">
                                    <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                        <i class="fas fa-cloud-upload-alt text-3xl text-gray-400 mb-2"></i>
                                        <p class="mb-1 text-sm text-gray-500"><span class="font-semibold">Klik untuk upload</span></p>
                                        <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                    </div>
                                </label>
                            </div>
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

        // Image Handling
        const gambarInput = document.getElementById('gambarInput');
        const imagePreviewContainer = document.getElementById('imagePreviewContainer');
        const imagePreview = document.getElementById('imagePreview');
        const removeImageBtn = document.getElementById('removeImageBtn');
        const deleteImageInput = document.getElementById('deleteImageInput');

        // Show preview when file selected
        gambarInput.addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                // Validate size
                if (file.size > 2 * 1024 * 1024) {
                    alert('Ukuran file terlalu besar! Maksimal 2MB.');
                    this.value = '';
                    return;
                }

                const reader = new FileReader();
                reader.onload = function(e) {
                    imagePreview.src = e.target.result;
                    imagePreviewContainer.style.display = 'block';
                    deleteImageInput.value = '0'; // Reset delete flag
                }
                reader.readAsDataURL(file);
            }
        });

        // Handle remove image
        removeImageBtn.addEventListener('click', function() {
            imagePreview.src = '';
            imagePreviewContainer.style.display = 'none';
            gambarInput.value = ''; // Clear file input
            deleteImageInput.value = '1'; // Set delete flag
        });

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
