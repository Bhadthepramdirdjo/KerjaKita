<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pengaturan - KerjaKita</title>
    
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
        <!-- Settings Icon (Active) -->
        <div class="mb-auto">
             <button class="w-12 h-12 rounded-xl flex items-center justify-center bg-keel-black text-white shadow-lg transform scale-110">
                <i class="fas fa-cog text-xl"></i>
            </button>
        </div>
        
        <!-- Center Icons -->
        <div class="flex flex-col space-y-8">
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-home text-xl"></i>
            </a>
            
            <button class="w-12 h-12 rounded-xl flex items-center justify-center text-keel-black hover:bg-seafoam-bloom transition-colors">
                <i class="fas fa-bars text-2xl"></i>
            </button>
        </div>
        
        <!-- Bottom Placeholder -->
        <div class="mt-auto"></div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 ml-20 lg:ml-24 flex flex-col h-screen relative">
        
        <!-- Header Section -->
        <header class="w-full px-6 py-6 flex items-center gap-4">
            <!-- Back Button -->
            <a href="{{ route('pemberi-kerja.dashboard') }}" class="w-10 h-10 rounded-full border-2 border-keel-black flex items-center justify-center hover:bg-gray-100 flex-shrink-0">
                <i class="fas fa-arrow-left text-keel-black"></i>
            </a>

            <!-- Search Bar -->
            <div class="flex-1 relative">
                <input type="text" 
                       placeholder="Cari pengaturan..." 
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

        <!-- Page Title -->
        <div class="px-8 pb-4">
            <h1 class="text-2xl md:text-3xl font-bold text-gray-700">Pengaturan</h1>
            <p class="text-gray-500 text-sm mt-1">Kelola akun dan preferensi Anda</p>
        </div>

        <!-- Scrollable Content Area -->
        <div class="flex-1 overflow-y-auto no-scrollbar px-4 sm:px-8 pb-20">
            
            <!-- Settings Container -->
            <div class="max-w-3xl mx-auto">
                
                <!-- Settings Card -->
                <div class="bg-white rounded-3xl shadow-xl overflow-hidden border-2 border-gray-200">
                    
                    <!-- Header -->
                    <div class="bg-gradient-to-r from-pelagic-blue to-abyss-teal p-6">
                        <h2 class="text-2xl font-bold text-white">PENGATURAN</h2>
                    </div>

                    <!-- Menu Items -->
                    <div class="divide-y divide-gray-200">
                        
                        <!-- Akun -->
                        <a href="#" class="block p-6 hover:bg-seafoam-bloom hover:bg-opacity-10 transition-colors group">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-keel-black group-hover:text-pelagic-blue transition-colors">Akun</h3>
                                    <p class="text-sm text-gray-500 mt-1">Email, Kata Sandi dan Nomor ponsel</p>
                                </div>
                                <i class="fas fa-chevron-right text-gray-400 group-hover:text-pelagic-blue transition-colors"></i>
                            </div>
                        </a>

                        <!-- Beri Masukan (Accordion) -->
                        <div class="border-b border-gray-200">
                            <button id="feedbackToggle" class="w-full p-6 hover:bg-seafoam-bloom hover:bg-opacity-10 transition-colors group text-left">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-keel-black group-hover:text-pelagic-blue transition-colors">Beri Masukan</h3>
                                        <p class="text-sm text-gray-500 mt-1">Bantu kami meningkatkan layanan</p>
                                    </div>
                                    <i id="feedbackIcon" class="fas fa-chevron-down text-gray-400 group-hover:text-pelagic-blue transition-all duration-300"></i>
                                </div>
                            </button>
                            <!-- Accordion Content -->
                            <div id="feedbackContent" class="max-h-0 overflow-hidden transition-all duration-300">
                                <div class="px-6 pb-6">
                                    <form class="space-y-4">
                                        <div>
                                            <label class="block text-sm font-semibold text-gray-700 mb-2">Pesan Anda</label>
                                            <textarea 
                                                rows="4" 
                                                placeholder="Tuliskan masukan atau saran Anda di sini..."
                                                class="w-full px-4 py-3 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent resize-none"></textarea>
                                        </div>
                                        <button type="submit" class="w-full bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                                            <i class="fas fa-paper-plane mr-2"></i>
                                            Kirim Masukan
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>

                        <!-- Bahasa (Accordion) -->
                        <div class="border-b border-gray-200">
                            <button id="languageToggle" class="w-full p-6 hover:bg-seafoam-bloom hover:bg-opacity-10 transition-colors group text-left">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <h3 class="text-lg font-bold text-keel-black group-hover:text-pelagic-blue transition-colors">Bahasa</h3>
                                        <p class="text-sm text-gray-500 mt-1">Indonesia (Default)</p>
                                    </div>
                                    <i id="languageIcon" class="fas fa-chevron-down text-gray-400 group-hover:text-pelagic-blue transition-all duration-300"></i>
                                </div>
                            </button>
                            <!-- Accordion Content -->
                            <div id="languageContent" class="max-h-0 overflow-hidden transition-all duration-300">
                                <div class="px-6 pb-6">
                                    <label class="block text-sm font-semibold text-gray-700 mb-2">Pilih Bahasa</label>
                                    <select class="w-full px-4 py-3 border-2 border-gray-300 rounded-2xl focus:outline-none focus:ring-2 focus:ring-pelagic-blue focus:border-transparent bg-white">
                                        <option value="id" selected>Bahasa Indonesia</option>
                                        <option value="en">English (Inggris)</option>
                                    </select>
                                    <button class="w-full mt-4 bg-pelagic-blue hover:bg-abyss-teal text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                                        <i class="fas fa-check mr-2"></i>
                                        Simpan Perubahan
                                    </button>
                                </div>
                            </div>
                        </div>

                        <!-- Keluar -->
                        <button id="logoutBtn" class="w-full p-6 hover:bg-red-50 transition-colors group text-left">
                            <div class="flex items-center justify-between">
                                <div>
                                    <h3 class="text-lg font-bold text-red-600 group-hover:text-red-700 transition-colors">Keluar</h3>
                                    <p class="text-sm text-gray-500 mt-1">Logout dari akun Anda</p>
                                </div>
                                <i class="fas fa-sign-out-alt text-red-600 group-hover:text-red-700 transition-colors"></i>
                            </div>
                        </button>

                    </div>
                </div>

                <!-- Logout Modal -->
                <div id="logoutModal" class="fixed inset-0 z-50 hidden items-center justify-center">
                    <!-- Backdrop Blur -->
                    <div class="absolute inset-0 bg-black bg-opacity-60 backdrop-blur-sm"></div>
                    
                    <!-- Modal Content -->
                    <div class="relative bg-white rounded-3xl shadow-2xl p-8 max-w-md w-full mx-4 transform transition-all">
                        <!-- Icon -->
                        <div class="w-16 h-16 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-sign-out-alt text-3xl text-red-600"></i>
                        </div>
                        
                        <!-- Title -->
                        <h3 class="text-2xl font-bold text-center text-keel-black mb-2">Konfirmasi Keluar</h3>
                        <p class="text-center text-gray-600 mb-6">Apakah Anda yakin ingin keluar dari akun Anda?</p>
                        
                        <!-- Buttons -->
                        <div class="flex gap-3">
                            <button id="cancelLogout" class="flex-1 bg-gray-200 hover:bg-gray-300 text-keel-black font-bold py-3 px-6 rounded-full transition-colors">
                                Batal
                            </button>
                            <button id="confirmLogout" class="flex-1 bg-red-600 hover:bg-red-700 text-white font-bold py-3 px-6 rounded-full transition-colors shadow-lg">
                                Keluar
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Info Card -->
                <div class="mt-6 bg-white rounded-2xl shadow-lg p-6 border-2 border-gray-200">
                    <div class="flex items-start gap-4">
                        <div class="w-12 h-12 rounded-full bg-pelagic-blue bg-opacity-20 flex items-center justify-center flex-shrink-0">
                            <i class="fas fa-info-circle text-pelagic-blue text-xl"></i>
                        </div>
                        <div>
                            <h3 class="font-bold text-keel-black mb-1">Informasi</h3>
                            <p class="text-sm text-gray-600">
                                Untuk mengubah informasi profil seperti nama, foto, dan keahlian, silakan kunjungi halaman <span class="font-semibold text-pelagic-blue">Profil Saya</span>.
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Version Info -->
                <div class="mt-6 text-center text-gray-400 text-sm">
                    <p>KerjaKita v1.0.0</p>
                    <p class="mt-1">© 2026 KerjaKita. All rights reserved.</p>
                </div>

            </div>
        </div>
    </main>

    <script>
        // Accordion Toggle - Beri Masukan
        const feedbackToggle = document.getElementById('feedbackToggle');
        const feedbackContent = document.getElementById('feedbackContent');
        const feedbackIcon = document.getElementById('feedbackIcon');

        feedbackToggle.addEventListener('click', () => {
            if (feedbackContent.style.maxHeight && feedbackContent.style.maxHeight !== '0px') {
                feedbackContent.style.maxHeight = '0px';
                feedbackIcon.classList.remove('fa-chevron-up');
                feedbackIcon.classList.add('fa-chevron-down');
            } else {
                feedbackContent.style.maxHeight = feedbackContent.scrollHeight + 'px';
                feedbackIcon.classList.remove('fa-chevron-down');
                feedbackIcon.classList.add('fa-chevron-up');
                // Close language accordion if open
                languageContent.style.maxHeight = '0px';
                languageIcon.classList.remove('fa-chevron-up');
                languageIcon.classList.add('fa-chevron-down');
            }
        });

        // Accordion Toggle - Bahasa
        const languageToggle = document.getElementById('languageToggle');
        const languageContent = document.getElementById('languageContent');
        const languageIcon = document.getElementById('languageIcon');

        languageToggle.addEventListener('click', () => {
            if (languageContent.style.maxHeight && languageContent.style.maxHeight !== '0px') {
                languageContent.style.maxHeight = '0px';
                languageIcon.classList.remove('fa-chevron-up');
                languageIcon.classList.add('fa-chevron-down');
            } else {
                languageContent.style.maxHeight = languageContent.scrollHeight + 'px';
                languageIcon.classList.remove('fa-chevron-down');
                languageIcon.classList.add('fa-chevron-up');
                // Close feedback accordion if open
                feedbackContent.style.maxHeight = '0px';
                feedbackIcon.classList.remove('fa-chevron-up');
                feedbackIcon.classList.add('fa-chevron-down');
            }
        });

        // Logout Modal
        const logoutBtn = document.getElementById('logoutBtn');
        const logoutModal = document.getElementById('logoutModal');
        const cancelLogout = document.getElementById('cancelLogout');
        const confirmLogout = document.getElementById('confirmLogout');

        // Open modal
        logoutBtn.addEventListener('click', () => {
            logoutModal.classList.remove('hidden');
            logoutModal.classList.add('flex');
        });

        // Close modal
        cancelLogout.addEventListener('click', () => {
            logoutModal.classList.add('hidden');
            logoutModal.classList.remove('flex');
        });

        // Confirm logout (nanti akan redirect ke logout route)
        confirmLogout.addEventListener('click', () => {
            // Buat form untuk submit POST logout
            const logoutForm = document.createElement('form');
            logoutForm.method = 'POST';
            logoutForm.action = '{{ route("logout") }}';
            
            // Tambahkan CSRF token
            const csrfToken = document.createElement('input');
            csrfToken.type = 'hidden';
            csrfToken.name = '_token';
            csrfToken.value = '{{ csrf_token() }}';
            
            logoutForm.appendChild(csrfToken);
            document.body.appendChild(logoutForm);
            logoutForm.submit();
        });

        // Close modal when clicking backdrop
        logoutModal.addEventListener('click', (e) => {
            if (e.target === logoutModal) {
                logoutModal.classList.add('hidden');
                logoutModal.classList.remove('flex');
            }
        });
    </script>

</body>
</html>
