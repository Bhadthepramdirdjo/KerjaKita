<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="KerjaKita - Platform Pencarian Kerja Serabutan Terpercaya di Indonesia">
    <title>KerjaKita - Temukan Pekerja & Pekerjaan dengan Mudah</title>
    
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('images/LOGO.png') }}">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&family=Poppins:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- AOS Animation Library -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    
    <style>
        * {
            font-family: 'Inter', sans-serif;
        }
        
        .font-poppins {
            font-family: 'Poppins', sans-serif;
        }
        
        /* Custom Color Palette */
        :root {
            --primary: #3B82F6;
            --primary-dark: #2563EB;
            --secondary: #10B981;
            --accent: #F59E0B;
            --dark: #1F2937;
            --light: #F9FAFB;
        }
        
        /* Gradient Background */
        .gradient-bg {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .gradient-bg-hero {
            background: linear-gradient(135deg, #3B82F6 0%, #2563EB 50%, #1D4ED8 100%);
        }
        
        .gradient-text {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
        
        /* Floating Animation */
        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }
        
        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
        
        /* Pulse Animation */
        @keyframes pulse-slow {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
        
        .pulse-slow {
            animation: pulse-slow 2s ease-in-out infinite;
        }
        
        /* Shine Effect */
        .shine {
            position: relative;
            overflow: hidden;
        }
        
        .shine::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: 0.5s;
        }
        
        .shine:hover::before {
            left: 100%;
        }
        
        /* Card Hover Effect */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-10px);
            box-shadow: 0 20px 40px rgba(0,0,0,0.15);
        }
        
        /* Smooth Scroll */
        html {
            scroll-behavior: smooth;
        }
        
        /* Navbar Scroll Effect */
        .navbar-scrolled {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
        }
        
        /* Stats Counter Animation */
        @keyframes countUp {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }
        
        .count-up {
            animation: countUp 1s ease-out;
        }
        
        /* Button Ripple Effect */
        .btn-ripple {
            position: relative;
            overflow: hidden;
        }
        
        .btn-ripple::after {
            content: '';
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            pointer-events: none;
            background-image: radial-gradient(circle, #fff 10%, transparent 10.01%);
            background-repeat: no-repeat;
            background-position: 50%;
            transform: scale(10, 10);
            opacity: 0;
            transition: transform 0.5s, opacity 1s;
        }
        
        .btn-ripple:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }
        .btn-ripple:active::after {
            transform: scale(0, 0);
            opacity: 0.3;
            transition: 0s;
        }

        /* --- NAVBAR DYNAMIC COLORS START --- */
        #navbar .nav-link, 
        #navbar .login-link, 
        #navbar .logo-text,
        #navbar .mobile-toggle {
            transition: all 0.3s ease;
        }

        /* Keadaan di Puncak (Background Transparan - Tulisan Putih) */
        #navbar:not(.navbar-scrolled) .nav-link {
            color: #ffffff !important;
        }
        #navbar:not(.navbar-scrolled) .nav-link:hover {
            color: #fbbf24 !important; /* Amber-400 */
        }
        #navbar:not(.navbar-scrolled) .login-link {
            color: #ffffff !important;
        }
        #navbar:not(.navbar-scrolled) .logo-text {
            background: none !important;
            -webkit-text-fill-color: #ffffff !important;
            color: #ffffff !important;
        }
        #navbar:not(.navbar-scrolled) .mobile-toggle {
            color: #ffffff !important;
        }
        /* --- NAVBAR DYNAMIC COLORS END --- */
    </style>
</head>
<body class="bg-gray-50">
    
    <!-- Navbar -->
    <nav class="fixed w-full z-50 transition-all duration-300" id="navbar">
        <div class="container mx-auto px-4 py-4">
            <div class="flex items-center justify-between">
                <!-- Logo -->
                <div class="flex items-center space-x-3" data-aos="fade-right">
                    <div class="flex items-center justify-center">
                        <img src="{{ asset('images/LOGO.png') }}" alt="Logo KerjaKita" class="w-12 h-12 object-contain">
                    </div>
                    <span class="text-2xl font-bold font-poppins gradient-text logo-text">KerjaKita</span>
                </div>
                
                <!-- Desktop Menu -->
                <div class="hidden md:flex items-center space-x-8" data-aos="fade-down">
                    <a href="#beranda" class="text-gray-700 hover:text-blue-600 transition-colors font-medium nav-link">Beranda</a>
                    <a href="#fitur" class="text-gray-700 hover:text-blue-600 transition-colors font-medium nav-link">Fitur</a>
                    <a href="#kategori" class="text-gray-700 hover:text-blue-600 transition-colors font-medium nav-link">Kategori</a>
                    <a href="#tentang" class="text-gray-700 hover:text-blue-600 transition-colors font-medium nav-link">Tentang</a>
                    <a href="{{ route('login') }}" class="text-blue-600 hover:text-blue-700 font-semibold transition-colors login-link">Login</a>
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 text-white px-6 py-2.5 rounded-full hover:shadow-lg transition-all shine btn-ripple font-semibold">
                        Daftar Sekarang
                    </a>
                </div>
                
                <!-- Mobile Menu Button -->
                <button class="md:hidden text-gray-700 focus:outline-none mobile-toggle" id="mobile-menu-button">
                    <i class="fas fa-bars text-2xl"></i>
                </button>
            </div>
        </div>
        
        <!-- Mobile Menu -->
        <div class="hidden md:hidden bg-white shadow-lg" id="mobile-menu">
            <div class="container mx-auto px-4 py-4 space-y-3">
                <a href="#beranda" class="block text-gray-700 hover:text-blue-600 transition-colors py-2">Beranda</a>
                <a href="#fitur" class="block text-gray-700 hover:text-blue-600 transition-colors py-2">Fitur</a>
                <a href="#kategori" class="block text-gray-700 hover:text-blue-600 transition-colors py-2">Kategori</a>
                <a href="#tentang" class="block text-gray-700 hover:text-blue-600 transition-colors py-2">Tentang</a>
                <a href="{{ route('login') }}" class="block text-blue-600 font-semibold py-2">Login</a>
                <a href="{{ route('register') }}" class="block bg-blue-600 text-white text-center px-6 py-2.5 rounded-full hover:bg-blue-700 transition-colors">
                    Daftar Sekarang
                </a>
            </div>
        </div>
    </nav>
    
    <!-- Hero Section - IMPROVED & FIXED -->
    <section id="beranda" class="relative pt-32 pb-24 md:pb-32 gradient-bg-hero overflow-hidden">
        <div class="container mx-auto px-4 md:px-6 lg:px-8">
            <div class="grid md:grid-cols-2 gap-8 md:gap-12 items-center">
                
                <!-- Left Content -->
                <div class="text-white z-10" data-aos="fade-right" data-aos-duration="1000">
                    <h1 class="text-4xl sm:text-5xl md:text-6xl font-bold font-poppins mb-6 leading-tight">
                        Temukan <span class="text-yellow-300">Pekerja</span> dan <span class="text-green-300">Pekerjaan</span> dengan Mudah
                    </h1>
                    <p class="text-lg md:text-xl text-blue-100 mb-8 leading-relaxed">
                        Platform terpercaya untuk menghubungkan pemberi kerja dengan pekerja serabutan di seluruh Indonesia. Cepat, Aman, dan Transparan.
                    </p>
                    
                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-4 mb-10">
                        <a href="{{ route('pekerja.dashboard') }}" class="bg-white text-blue-600 px-6 md:px-8 py-3 md:py-4 rounded-full font-bold hover:bg-gray-100 transition-all shadow-xl shine btn-ripple text-center">
                            <i class="fas fa-user-tie mr-2"></i> Saya Cari Kerja
                        </a>
                        <a href="{{ route('pemberi-kerja.dashboard') }}" class="bg-yellow-400 text-gray-900 px-6 md:px-8 py-3 md:py-4 rounded-full font-bold hover:bg-yellow-500 transition-all shadow-xl shine btn-ripple text-center">
                            <i class="fas fa-briefcase mr-2"></i> Saya Cari Pekerja
                        </a>
                    </div>
                    
                    <!-- Stats - IMPROVED LAYOUT WITH CARDS -->
                    <div class="grid grid-cols-3 gap-3 md:gap-6">
                        <div class="text-center count-up bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-3 md:p-4">
                            <div class="text-2xl md:text-4xl font-bold text-yellow-300 mb-1">
                                @if(isset($stats['total_pekerja']))
                                    {{ $stats['total_pekerja'] }}+
                                @else
                                    500+
                                @endif
                            </div>
                            <div class="text-xs md:text-sm text-blue-100">Pekerja Aktif</div>
                        </div>
                        
                        <div class="text-center count-up bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-3 md:p-4" style="animation-delay: 0.2s">
                            <div class="text-2xl md:text-4xl font-bold text-green-300 mb-1">
                                @if(isset($stats['total_lowongan']))
                                    {{ $stats['total_lowongan'] }}+
                                @else
                                    300+
                                @endif
                            </div>
                            <div class="text-xs md:text-sm text-blue-100">Lowongan Kerja</div>
                        </div>
                        
                        <div class="text-center count-up bg-white bg-opacity-10 backdrop-blur-sm rounded-xl p-3 md:p-4" style="animation-delay: 0.4s">
                            <div class="text-2xl md:text-4xl font-bold text-pink-300 mb-1">98%</div>
                            <div class="text-xs md:text-sm text-blue-100">Kepuasan</div>
                        </div>
                    </div>
                </div>
                
                <!-- Right Illustration - FIXED PROPORTIONS -->
                <div class="hidden md:flex justify-center items-center relative z-10" data-aos="fade-left" data-aos-duration="1000">
                    <div class="relative w-full max-w-lg">
                        <!-- Decorative Blobs -->
                        <div class="absolute top-0 -left-4 w-64 h-64 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse"></div>
                        <div class="absolute -bottom-8 right-0 w-64 h-64 bg-yellow-400 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-pulse" style="animation-delay: 1s"></div>
                        
                        <!-- Main Illustration -->
                        <div class="relative z-10">
                            <img src="https://illustrations.popsy.co/amber/remote-work.svg" 
                                 alt="Hero Illustration" 
                                 class="w-full h-auto float-animation drop-shadow-2xl">
                        </div>
                    </div>
                </div>
                
            </div>
        </div>
        
        <!-- Wave Shape Divider - Smooth Transition -->
        <div class="absolute bottom-0 left-0 w-full overflow-hidden leading-none">
            <svg class="relative block w-full h-24 md:h-32" viewBox="0 0 1200 120" preserveAspectRatio="none">
                <!-- Layer 1: Subtle gradient wave -->
                <path d="M0,0 L0,40 Q300,60 600,40 T1200,40 L1200,0 Z" 
                      fill="#1D4ED8" 
                      opacity="0.3"></path>
                
                <!-- Layer 2: Mid transition wave -->
                <path d="M0,20 L0,60 Q300,80 600,60 T1200,60 L1200,20 Z" 
                      fill="#2563EB" 
                      opacity="0.5"></path>
                
                <!-- Layer 3: Main wave -->
                <path d="M0,40 L0,80 Q300,100 600,80 T1200,80 L1200,120 L0,120 Z" 
                      fill="#F9FAFB"></path>
            </svg>
        </div>
    </section>
    
    <!-- Features Section -->
    <section id="fitur" class="py-20 bg-gray-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-poppins text-gray-900 mb-4">
                    Kenapa Pilih <span class="gradient-text">KerjaKita</span>?
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Platform terlengkap dengan fitur-fitur yang memudahkan Anda
                </p>
            </div>
            
            <!-- Features Grid -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-500 to-blue-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-search text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Pencarian Mudah</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Cari pekerjaan atau pekerja dengan filter lokasi, kategori, dan rating. Temukan yang Anda butuhkan dalam hitungan detik.
                    </p>
                </div>
                
                <!-- Feature 2 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-500 to-green-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-shield-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Aman & Terpercaya</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Sistem rating dan ulasan transparan memastikan kualitas pekerja. Data pribadi Anda terlindungi dengan enkripsi.
                    </p>
                </div>
                
                <!-- Feature 3 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-500 to-purple-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-comments text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Chat Langsung</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Komunikasi langsung dengan pemberi kerja atau pekerja melalui chat terintegrasi WhatsApp untuk negosiasi cepat.
                    </p>
                </div>
                
                <!-- Feature 4 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="100">
                    <div class="w-16 h-16 bg-gradient-to-br from-yellow-500 to-yellow-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-star text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Sistem Rating</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Beri dan lihat rating untuk membangun reputasi. Semakin tinggi rating, semakin banyak peluang kerja.
                    </p>
                </div>
                
                <!-- Feature 5 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="200">
                    <div class="w-16 h-16 bg-gradient-to-br from-red-500 to-red-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-bell text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Notifikasi Real-time</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Dapatkan notifikasi instant saat ada lamaran baru, perubahan status, atau pesan masuk.
                    </p>
                </div>
                
                <!-- Feature 6 -->
                <div class="bg-white p-8 rounded-2xl shadow-lg card-hover" data-aos="fade-up" data-aos-delay="300">
                    <div class="w-16 h-16 bg-gradient-to-br from-pink-500 to-pink-600 rounded-2xl flex items-center justify-center mb-6 shadow-lg">
                        <i class="fas fa-mobile-alt text-white text-2xl"></i>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Mobile Friendly</h3>
                    <p class="text-gray-600 leading-relaxed">
                        Akses dari mana saja, kapan saja. Interface responsif yang optimal di semua perangkat.
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- Categories Section -->
    <section id="kategori" class="py-20 bg-white">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-poppins text-gray-900 mb-4">
                    Kategori <span class="gradient-text">Pekerjaan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Berbagai kategori pekerjaan tersedia untuk Anda
                </p>
            </div>
            
            <!-- Categories Grid -->
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <!-- Category 1 -->
                <div class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-16 h-16 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-broom text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Cleaning</h4>
                    <p class="text-sm text-gray-600 mt-1">150+ pekerjaan</p>
                </div>
                
                <!-- Category 2 -->
                <div class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-16 h-16 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-hard-hat text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Konstruksi</h4>
                    <p class="text-sm text-gray-600 mt-1">120+ pekerjaan</p>
                </div>
                
                <!-- Category 3 -->
                <div class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-16 h-16 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-utensils text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Memasak</h4>
                    <p class="text-sm text-gray-600 mt-1">80+ pekerjaan</p>
                </div>
                
                <!-- Category 4 -->
                <div class="bg-gradient-to-br from-yellow-50 to-yellow-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-16 h-16 bg-yellow-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-leaf text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Tukang Kebun</h4>
                    <p class="text-sm text-gray-600 mt-1">65+ pekerjaan</p>
                </div>
                
                <!-- Category 5 -->
                <div class="bg-gradient-to-br from-red-50 to-red-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="100">
                    <div class="w-16 h-16 bg-red-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-truck text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Angkut Barang</h4>
                    <p class="text-sm text-gray-600 mt-1">90+ pekerjaan</p>
                </div>
                
                <!-- Category 6 -->
                <div class="bg-gradient-to-br from-pink-50 to-pink-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="200">
                    <div class="w-16 h-16 bg-pink-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-tools text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Perbaikan</h4>
                    <p class="text-sm text-gray-600 mt-1">75+ pekerjaan</p>
                </div>
                
                <!-- Category 7 -->
                <div class="bg-gradient-to-br from-indigo-50 to-indigo-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="300">
                    <div class="w-16 h-16 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-store text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Jaga Toko</h4>
                    <p class="text-sm text-gray-600 mt-1">55+ pekerjaan</p>
                </div>
                
                <!-- Category 8 -->
                <div class="bg-gradient-to-br from-teal-50 to-teal-100 p-6 rounded-2xl text-center card-hover cursor-pointer" data-aos="zoom-in" data-aos-delay="400">
                    <div class="w-16 h-16 bg-teal-500 rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg">
                        <i class="fas fa-car text-white text-2xl"></i>
                    </div>
                    <h4 class="font-bold text-gray-900 text-lg">Cuci Kendaraan</h4>
                    <p class="text-sm text-gray-600 mt-1">60+ pekerjaan</p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- How It Works Section -->
    <section id="tentang" class="py-20 bg-gradient-to-br from-blue-50 to-purple-50">
        <div class="container mx-auto px-4">
            <!-- Section Header -->
            <div class="text-center mb-16" data-aos="fade-up">
                <h2 class="text-4xl md:text-5xl font-bold font-poppins text-gray-900 mb-4">
                    Cara <span class="gradient-text">Menggunakan</span>
                </h2>
                <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                    Mulai dalam 3 langkah mudah
                </p>
            </div>
            
            <!-- Steps -->
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Step 1 -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="100">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-blue-500 to-blue-600 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                            <span class="text-white text-4xl font-bold">1</span>
                        </div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-blue-200 rounded-full -z-10 pulse-slow"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Daftar Akun</h3>
                    <p class="text-gray-600">
                        Buat akun gratis sebagai Pekerja atau Pemberi Kerja dalam hitungan menit
                    </p>
                </div>
                
                <!-- Step 2 -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="200">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-purple-500 to-purple-600 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                            <span class="text-white text-4xl font-bold">2</span>
                        </div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-purple-200 rounded-full -z-10 pulse-slow" style="animation-delay: 0.5s"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Cari & Lamar</h3>
                    <p class="text-gray-600">
                        Temukan pekerjaan yang sesuai atau posting lowongan untuk menarik pekerja terbaik
                    </p>
                </div>
                
                <!-- Step 3 -->
                <div class="text-center" data-aos="fade-up" data-aos-delay="300">
                    <div class="relative mb-6">
                        <div class="w-24 h-24 bg-gradient-to-br from-green-500 to-green-600 rounded-full flex items-center justify-center mx-auto shadow-2xl">
                            <span class="text-white text-4xl font-bold">3</span>
                        </div>
                        <div class="absolute top-1/2 left-1/2 -translate-x-1/2 -translate-y-1/2 w-32 h-32 bg-green-200 rounded-full -z-10 pulse-slow" style="animation-delay: 1s"></div>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-900 mb-3 font-poppins">Mulai Bekerja</h3>
                    <p class="text-gray-600">
                        Chat, negosiasi, dan mulai bekerja. Beri rating setelah selesai untuk membangun reputasi
                    </p>
                </div>
            </div>
        </div>
    </section>
    
    <!-- CTA Section -->
    <section class="py-20 gradient-bg relative overflow-hidden">
        <div class="absolute top-0 left-0 w-full h-full opacity-10">
            <div class="absolute top-10 left-10 w-20 h-20 border-4 border-white rounded-full"></div>
            <div class="absolute bottom-20 right-20 w-32 h-32 border-4 border-white rounded-lg rotate-45"></div>
            <div class="absolute top-1/2 left-1/3 w-16 h-16 bg-white rounded-full"></div>
        </div>
        
        <div class="container mx-auto px-4 relative z-10">
            <div class="text-center text-white" data-aos="zoom-in">
                <h2 class="text-4xl md:text-5xl font-bold font-poppins mb-6">
                    Siap Untuk Memulai?
                </h2>
                <p class="text-xl mb-8 max-w-2xl mx-auto">
                    Bergabunglah dengan ribuan pekerja dan pemberi kerja yang sudah mempercayai KerjaKita
                </p>
                <a href="{{ route('register') }}" class="inline-block bg-white text-blue-600 px-10 py-4 rounded-full font-bold text-lg hover:bg-gray-100 transition-all shadow-2xl shine btn-ripple">
                    <i class="fas fa-rocket mr-2"></i> Mulai Sekarang - GRATIS!
                </a>
            </div>
        </div>
    </section>
    
    <!-- Footer -->
    <footer class="bg-gray-900 text-white py-12">
        <div class="container mx-auto px-4">
            <div class="grid md:grid-cols-4 gap-8">
                <!-- About -->
                <div>
                    <div class="flex items-center space-x-3 mb-4">
                        <div class="w-10 h-10 rounded-lg flex items-center justify-center p-1.5">
                            <img src="{{ asset('images/LOGO.png') }}" alt="KerjaKita Logo" class="w-full h-full object-contain">
                        </div>
                        <span class="text-xl font-bold font-poppins">KerjaKita</span>
                    </div>
                    <p class="text-gray-400 mb-4">
                        Platform pencarian kerja serabutan terpercaya di Indonesia
                    </p>
                    <div class="flex space-x-4">
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-600 transition-colors">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-blue-400 transition-colors">
                            <i class="fab fa-twitter"></i>
                        </a>
                        <a href="#" class="w-10 h-10 bg-gray-800 rounded-full flex items-center justify-center hover:bg-pink-600 transition-colors">
                            <i class="fab fa-instagram"></i>
                        </a>
                    </div>
                </div>
                
                <!-- Quick Links -->
                <div>
                    <h4 class="font-bold text-lg mb-4 font-poppins">Menu Cepat</h4>
                    <ul class="space-y-2">
                        <li><a href="#beranda" class="text-gray-400 hover:text-white transition-colors">Beranda</a></li>
                        <li><a href="#fitur" class="text-gray-400 hover:text-white transition-colors">Fitur</a></li>
                        <li><a href="#kategori" class="text-gray-400 hover:text-white transition-colors">Kategori</a></li>
                        <li><a href="#tentang" class="text-gray-400 hover:text-white transition-colors">Tentang Kami</a></li>
                    </ul>
                </div>
                
                <!-- Support -->
                <div>
                    <h4 class="font-bold text-lg mb-4 font-poppins">Bantuan</h4>
                    <ul class="space-y-2">
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">FAQ</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Panduan</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Kebijakan Privasi</a></li>
                        <li><a href="#" class="text-gray-400 hover:text-white transition-colors">Syarat & Ketentuan</a></li>
                    </ul>
                </div>
                
                <!-- Contact -->
                <div>
                    <h4 class="font-bold text-lg mb-4 font-poppins">Kontak</h4>
                    <ul class="space-y-3">
                        <li class="flex items-start space-x-3">
                            <i class="fas fa-map-marker-alt text-blue-500 mt-1"></i>
                            <span class="text-gray-400">Jl. Dipati Ukur No. 112-114, Bandung</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-envelope text-blue-500"></i>
                            <span class="text-gray-400">info@kerjakita.com</span>
                        </li>
                        <li class="flex items-center space-x-3">
                            <i class="fas fa-phone text-blue-500"></i>
                            <span class="text-gray-400">0812-3456-7890</span>
                        </li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-gray-800 mt-8 pt-8 text-center text-gray-400">
                <p>&copy; 2025 KerjaKita. All rights reserved. Kelompok 1-RPL 2</p>
            </div>
        </div>
    </footer>
    
    <!-- AOS Animation Library -->
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    <!-- Custom JavaScript -->
    <script>
        // Initialize AOS
        AOS.init({
            duration: 800,
            easing: 'ease-in-out',
            once: true,
            mirror: false
        });
        
        // Navbar Scroll Effect
        window.addEventListener('scroll', function() {
            const navbar = document.getElementById('navbar');
            if (window.scrollY > 50) {
                navbar.classList.add('navbar-scrolled');
            } else {
                navbar.classList.remove('navbar-scrolled');
            }
        });
        
        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');
        
        mobileMenuButton.addEventListener('click', function() {
            mobileMenu.classList.toggle('hidden');
        });
        
        // Close mobile menu when clicking a link
        const mobileMenuLinks = mobileMenu.querySelectorAll('a');
        mobileMenuLinks.forEach(link => {
            link.addEventListener('click', function() {
                mobileMenu.classList.add('hidden');
            });
        });
        
        // Smooth scroll for anchor links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>
</body>
</html>