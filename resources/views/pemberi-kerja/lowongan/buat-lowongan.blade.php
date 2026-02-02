<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Lowongan - KerjaKita</title>
    
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

        /* Custom file upload styling */
        .file-upload-area {
            border: 2px dashed #9FE7E7;
            transition: all 0.3s;
        }

        .file-upload-area:hover {
            border-color: #289FB7;
            background-color: #f0fffe;
        }

        .file-upload-area.dragover {
            border-color: #146B8C;
            background-color: #e0f7ff;
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

            <!-- Add Job Icon (Active) -->
            <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-briefcase text-xl"></i>
            </button>
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

            <!-- Title -->
            <div class="flex-1">
                <h1 class="text-xl font-bold text-keel-black">Buat Lowongan Pekerjaan</h1>
                <p class="text-sm text-gray-500">Isi formulir di bawah untuk membuka lowongan baru</p>
            </div>

            <!-- Profile Icon -->
            <button class="w-12 h-12 rounded-full border-2 border-keel-black flex items-center justify-center overflow-hidden bg-white hover:bg-gray-50 flex-shrink-0">
                <i class="far fa-user text-2xl text-keel-black"></i>
            </button>
        </header>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 sm:px-8 py-6">
            
            <form action="{{ route('pemberi-kerja.simpan-lowongan') }}" method="POST" enctype="multipart/form-data" class="max-w-5xl mx-auto">
                @csrf
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    
                    <!-- Left Column -->
                    <div class="space-y-6">
                        
                        <!-- Pekerjaan yang Dibutuhkan -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Pekerjaan yang Dibutuhkan <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="judul" 
                                placeholder="Contoh: Tukang Bangunan, Desainer Grafis, dll"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent">
                        </div>

                        <!-- Kategori Pekerjaan -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Kategori Pekerjaan <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="kategori" 
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent bg-white">
                                <option value="">Pilih Kategori</option>
                                @php
                                    $kategori = DB::table('kategori')->get();
                                @endphp
                                @foreach($kategori as $kat)
                                <option value="{{ $kat->id_kategori }}">{{ $kat->nama_kategori }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Jenis Pekerjaan -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-3">
                                Jenis Pekerjaan <span class="text-red-500">*</span>
                            </label>
                            <div class="space-y-3">
                                <label class="flex items-center p-3 rounded-xl hover:bg-seafoam-bloom hover:bg-opacity-20 cursor-pointer transition-colors">
                                    <input type="radio" name="jenis_pekerjaan" value="onsite" required class="w-5 h-5 text-pelagic-blue focus:ring-pelagic-blue">
                                    <span class="ml-3 text-gray-700">On-site (langsung di lokasi)</span>
                                </label>
                                <label class="flex items-center p-3 rounded-xl hover:bg-seafoam-bloom hover:bg-opacity-20 cursor-pointer transition-colors">
                                    <input type="radio" name="jenis_pekerjaan" value="remote" required class="w-5 h-5 text-pelagic-blue focus:ring-pelagic-blue">
                                    <span class="ml-3 text-gray-700">Remote (dapat dilakukan jauh/jarak jauh)</span>
                                </label>
                            </div>
                        </div>

                        <!-- Lokasi Kerja -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Lokasi Kerja <span class="text-red-500">*</span>
                            </label>
                            <input 
                                type="text" 
                                name="lokasi" 
                                placeholder="Jalan Kenagan, Kota masalalu, kabupaten harapan, kecamatan perasaan"
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent">
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Tulis alamat lengkap lokasi pekerjaan
                            </p>
                        </div>

                        <!-- Upload Foto Pekerjaan -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Upload Foto Pekerjaan (Opsional)
                            </label>
                            <div class="file-upload-area rounded-xl p-8 text-center cursor-pointer" id="fileUploadArea">
                                <input 
                                    type="file" 
                                    name="gambar[]" 
                                    id="fileInput"
                                    multiple
                                    accept="image/*"
                                    class="hidden">
                                <div id="uploadPlaceholder">
                                    <i class="fas fa-cloud-upload-alt text-5xl text-pelagic-blue mb-3"></i>
                                    <p class="text-gray-700 font-semibold">Klik atau seret foto ke sini</p>
                                    <p class="text-sm text-gray-500 mt-1">Maksimal 5 foto (JPG, PNG)</p>
                                </div>
                                <div id="filePreview" class="grid grid-cols-3 gap-3 mt-4 hidden"></div>
                            </div>
                        </div>

                    </div>

                    <!-- Right Column -->
                    <div class="space-y-6">
                        
                        <!-- Deskripsi Pekerjaan -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Deskripsi Pekerjaan <span class="text-red-500">*</span>
                            </label>
                            <textarea 
                                name="deskripsi" 
                                rows="6"
                                placeholder="Jelaskan detail pekerjaan, tanggung jawab, dan kualifikasi yang dibutuhkan..."
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent resize-none"></textarea>
                        </div>

                        <!-- Durasi Kerja -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Durasi Kerja <span class="text-red-500">*</span>
                            </label>
                            <select 
                                name="durasi_kerja" 
                                required
                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent bg-white">
                                <option value="">Pilih Durasi</option>
                                <option value="1-hari">1 Hari</option>
                                <option value="2-3-hari">2-3 Hari</option>
                                <option value="1-minggu">1 Minggu</option>
                                <option value="2-minggu">2 Minggu</option>
                                <option value="1-bulan">1 Bulan</option>
                                <option value="3-bulan">3 Bulan</option>
                                <option value="6-bulan">6 Bulan</option>
                                <option value="kontrak">Kontrak</option>
                                <option value="tetap">Tetap</option>
                            </select>
                        </div>

                        <!-- Upah & Tipe Pembayaran -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Upah <span class="text-red-500">*</span>
                            </label>
                            <div class="flex gap-3">
                                <div class="flex-1 relative">
                                    <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500 font-semibold">Rp</span>
                                    <input 
                                        type="text" 
                                        name="upah" 
                                        id="upahInput"
                                        placeholder="500.000"
                                        required
                                        class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent">
                                </div>
                                <select 
                                    name="tipe_pembayaran" 
                                    required
                                    class="px-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent bg-white">
                                    <option value="proyek">Proyek</option>
                                    <option value="per-jam">Per Jam</option>
                                    <option value="per-hari">Per Hari</option>
                                    <option value="per-minggu">Per Minggu</option>
                                    <option value="per-bulan">Per Bulan</option>
                                </select>
                            </div>
                        </div>

                        <!-- Nomor Telepon -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200">
                            <label class="block text-sm font-bold text-gray-700 mb-2">
                                Nomor Telepon <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <span class="absolute left-4 top-1/2 transform -translate-y-1/2 text-gray-500">
                                    <i class="fas fa-phone"></i>
                                </span>
                                <input 
                                    type="tel" 
                                    name="no_telp" 
                                    placeholder="+62 123654789874"
                                    required
                                    class="w-full pl-12 pr-4 py-3 border-2 border-gray-300 rounded-xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent">
                            </div>
                            <p class="text-xs text-gray-500 mt-2">
                                <i class="fas fa-info-circle mr-1"></i>
                                Nomor yang dapat dihubungi oleh pelamar
                            </p>
                        </div>

                        <!-- Action Buttons -->
                        <div class="bg-white rounded-2xl p-6 shadow-lg border-2 border-gray-200 space-y-3">
                            <button 
                                type="button"
                                id="publikasiBtn"
                                class="w-full bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-4 px-6 rounded-full transition-colors shadow-lg">
                                <i class="fas fa-paper-plane mr-2"></i>
                                Publikasikan
                            </button>
                            
                            <button 
                                type="button"
                                id="draftBtn"
                                class="w-full bg-gray-200 hover:bg-gray-300 text-keel-black font-bold py-4 px-6 rounded-full transition-colors">
                                <i class="fas fa-save mr-2"></i>
                                Simpan Draft
                            </button>

                            <div class="text-center pt-2">
                                <a href="{{ route('pemberi-kerja.rekomendasi-pekerja') }}" class="text-pelagic-blue hover:text-abyss-teal font-semibold text-sm">
                                    Butuh <span class="underline">Rekomendasi</span> Pekerja?
                                </a>
                            </div>
                        </div>

                    </div>

                </div>
            </form>

        </div>
    </main>

    <!-- Modal Konfirmasi -->
    <div id="konfirmasiModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
            <!-- Icon -->
            <div class="w-16 h-16 rounded-full bg-yellow-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-exclamation-triangle text-3xl text-yellow-600"></i>
            </div>
            
            <!-- Title -->
            <h3 class="text-2xl font-bold text-center text-keel-black mb-2">Konfirmasi Lowongan</h3>
            <p class="text-center text-gray-600 mb-4">
                Pastikan semua informasi yang Anda masukkan sudah benar:
            </p>
            
            <!-- Checklist -->
            <div class="bg-foam-white rounded-2xl p-4 mb-6 space-y-2 text-sm">
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span class="text-gray-700">Judul pekerjaan sudah sesuai</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span class="text-gray-700">Upah yang ditawarkan sudah benar</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span class="text-gray-700">Deskripsi pekerjaan sudah lengkap</span>
                </div>
                <div class="flex items-start gap-2">
                    <i class="fas fa-check-circle text-green-600 mt-1"></i>
                    <span class="text-gray-700">Nomor kontak dapat dihubungi</span>
                </div>
            </div>
            
            <p class="text-center text-sm text-pelagic-blue font-semibold mb-6">
                <span id="modalActionText">Publikasikan</span> lowongan ini sekarang?
            </p>
            
            <!-- Buttons -->
            <div class="flex gap-3">
                <button id="cancelKonfirmasi" class="flex-1 bg-gray-200 hover:bg-gray-300 text-keel-black font-bold py-3 px-6 rounded-full transition-colors">
                    Batal
                </button>
                <button id="confirmAction" class="flex-1 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                    Lanjutkan
                </button>
            </div>
        </div>
    </div>

    <!-- Modal Sukses -->
    <div id="suksesModal" class="fixed inset-0 z-50 hidden items-center justify-center">
        <!-- Backdrop Blur -->
        <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
        
        <!-- Modal Content -->
        <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
            <!-- Icon Success -->
            <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-4">
                <i class="fas fa-check text-4xl text-green-600"></i>
            </div>
            
            <!-- Title -->
            <h3 class="text-2xl font-bold text-center text-keel-black mb-2" id="suksesTitle">Pekerjaan berhasil di publikasi</h3>
            <p class="text-center text-gray-600 mb-6" id="suksesMessage">
                Terimakasih sudah menyediakan Lapangan Kerja seperti yang dijanjikan oleh <span class="font-bold text-pelagic-blue">presiden Prabowo</span>.<br><br>
                Jangan lupa berikan upah kepada pekerja
            </p>
            
            <!-- Button -->
            <button id="okeSukses" class="w-full bg-green-600 hover:bg-green-700 text-white font-bold py-4 px-6 rounded-full transition-colors shadow-lg">
                OKE
            </button>
        </div>
    </div>

    <script>
        // Format Rupiah Input
        const upahInput = document.getElementById('upahInput');
        upahInput.addEventListener('input', function(e) {
            let value = e.target.value.replace(/\D/g, '');
            e.target.value = value.replace(/\B(?=(\d{3})+(?!\d))/g, '.');
        });

        // File Upload Handler
        const fileUploadArea = document.getElementById('fileUploadArea');
        const fileInput = document.getElementById('fileInput');
        const uploadPlaceholder = document.getElementById('uploadPlaceholder');
        const filePreview = document.getElementById('filePreview');
        let selectedFiles = [];

        // Click to upload
        fileUploadArea.addEventListener('click', () => fileInput.click());

        // File selection
        fileInput.addEventListener('change', handleFiles);

        // Drag and drop
        fileUploadArea.addEventListener('dragover', (e) => {
            e.preventDefault();
            fileUploadArea.classList.add('dragover');
        });

        fileUploadArea.addEventListener('dragleave', () => {
            fileUploadArea.classList.remove('dragover');
        });

        fileUploadArea.addEventListener('drop', (e) => {
            e.preventDefault();
            fileUploadArea.classList.remove('dragover');
            const files = Array.from(e.dataTransfer.files).filter(file => file.type.startsWith('image/'));
            handleFileList(files);
        });

        function handleFiles(e) {
            const files = Array.from(e.target.files);
            handleFileList(files);
        }

        function handleFileList(files) {
            // Limit to 5 files
            const newFiles = files.slice(0, 5 - selectedFiles.length);
            selectedFiles = [...selectedFiles, ...newFiles].slice(0, 5);

            if (selectedFiles.length > 0) {
                uploadPlaceholder.classList.add('hidden');
                filePreview.classList.remove('hidden');
                displayPreviews();
            }
        }

        function displayPreviews() {
            filePreview.innerHTML = '';
            selectedFiles.forEach((file, index) => {
                const reader = new FileReader();
                reader.onload = (e) => {
                    const div = document.createElement('div');
                    div.className = 'relative group';
                    div.innerHTML = `
                        <img src="${e.target.result}" class="w-full h-24 object-cover rounded-lg border-2 border-gray-300">
                        <button type="button" onclick="removeFile(${index})" class="absolute -top-2 -right-2 w-6 h-6 bg-red-500 text-white rounded-full flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                            <i class="fas fa-times text-xs"></i>
                        </button>
                    `;
                    filePreview.appendChild(div);
                };
                reader.readAsDataURL(file);
            });
        }

        function removeFile(index) {
            selectedFiles.splice(index, 1);
            if (selectedFiles.length === 0) {
                uploadPlaceholder.classList.remove('hidden');
                filePreview.classList.add('hidden');
            } else {
                displayPreviews();
            }
        }

        // Modal Logic
        const publikasiBtn = document.getElementById('publikasiBtn');
        const draftBtn = document.getElementById('draftBtn');
        const konfirmasiModal = document.getElementById('konfirmasiModal');
        const suksesModal = document.getElementById('suksesModal');
        const cancelKonfirmasi = document.getElementById('cancelKonfirmasi');
        const confirmAction = document.getElementById('confirmAction');
        const okeSukses = document.getElementById('okeSukses');
        const modalActionText = document.getElementById('modalActionText');
        const suksesTitle = document.getElementById('suksesTitle');
        const suksesMessage = document.getElementById('suksesMessage');

        let currentAction = '';

        // Publikasi button
        publikasiBtn.addEventListener('click', () => {
            currentAction = 'publish';
            modalActionText.textContent = 'Publikasikan';
            konfirmasiModal.classList.remove('hidden');
            konfirmasiModal.classList.add('flex');
        });

        // Draft button - langsung ke modal sukses tanpa konfirmasi
        draftBtn.addEventListener('click', () => {
            currentAction = 'draft';
            
            // Update sukses modal content untuk draft
            suksesTitle.textContent = 'Draft berhasil disimpan';
            suksesMessage.innerHTML = 'Lowongan pekerjaan Anda telah disimpan sebagai draft.<br><br>Anda dapat melanjutkan atau mempublikasikannya nanti.';
            
            // Langsung show sukses modal
            suksesModal.classList.remove('hidden');
            suksesModal.classList.add('flex');
            
            // TODO: Submit form ke backend
            // document.querySelector('form').submit();
        });

        // Cancel konfirmasi
        cancelKonfirmasi.addEventListener('click', () => {
            konfirmasiModal.classList.add('hidden');
            konfirmasiModal.classList.remove('flex');
        });

        // Confirm action
        confirmAction.addEventListener('click', () => {
            // Close konfirmasi modal
            konfirmasiModal.classList.add('hidden');
            konfirmasiModal.classList.remove('flex');

            // Update sukses modal content
            if (currentAction === 'publish') {
                suksesTitle.textContent = 'Pekerjaan berhasil di publikasi';
                suksesMessage.innerHTML = 'Terimakasih sudah menyediakan Lapangan Kerja seperti yang dijanjikan oleh <span class="font-bold text-pelagic-blue">presiden Prabowo</span>.<br><br>Jangan lupa berikan upah kepada pekerja';
            } else {
                suksesTitle.textContent = 'Draft berhasil disimpan';
                suksesMessage.innerHTML = 'Lowongan pekerjaan Anda telah disimpan sebagai draft.<br><br>Anda dapat melanjutkan atau mempublikasikannya nanti.';
            }

            // Show sukses modal
            suksesModal.classList.remove('hidden');
            suksesModal.classList.add('flex');

            // TODO: Submit form ke backend
            // document.querySelector('form').submit();
        });

        // OKE button on sukses modal
        okeSukses.addEventListener('click', () => {
            suksesModal.classList.add('hidden');
            suksesModal.classList.remove('flex');
            
            // Redirect to dashboard
            window.location.href = "{{ route('pemberi-kerja.dashboard') }}";
        });

        // Close modal when clicking backdrop
        konfirmasiModal.addEventListener('click', (e) => {
            if (e.target === konfirmasiModal) {
                konfirmasiModal.classList.add('hidden');
                konfirmasiModal.classList.remove('flex');
            }
        });

        suksesModal.addEventListener('click', (e) => {
            if (e.target === suksesModal) {
                suksesModal.classList.add('hidden');
                suksesModal.classList.remove('flex');
            }
        });
    </script>

</body>
</html>
