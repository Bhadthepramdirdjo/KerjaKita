<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - KerjaKita</title>

    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- Font Awesome for Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">

    <style>
        * {
            font-family: 'Inter', sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1a1a2e 0%, #16213e 50%, #0f3460 100%);
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }

        .register-container {
            background: #b8c5d6;
            padding: 45px 50px;
            border-radius: 12px;
            width: 100%;
            max-width: 480px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .register-title {
            text-align: center;
            font-size: 20px;
            font-weight: 700;
            color: #1a1a2e;
            margin-bottom: 28px;
        }

        .form-grid {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
            margin-bottom: 15px;
        }

        .form-group {
            margin-bottom: 0;
        }

        .form-group.full-width {
            grid-column: 1 / -1;
        }

        .form-label {
            display: block;
            color: #374151;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 5px;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            background: #6b7280;
            border: none;
            border-radius: 5px;
            color: #fff;
            font-size: 12px;
            transition: all 0.3s ease;
        }

        .form-input::placeholder {
            color: #d1d5db;
        }

        .form-input:focus {
            outline: none;
            background: #4b5563;
            box-shadow: 0 0 0 2px rgba(59, 130, 246, 0.5);
        }

        .password-wrapper {
            position: relative;
            width: 100%;
        }

        .password-wrapper .form-input {
            padding-right: 40px;
        }

        .toggle-password {
            position: absolute;
            right: 12px;
            top: 50%;
            transform: translateY(-50%);
            cursor: pointer;
            color: #d1d5db;
            font-size: 14px;
            transition: color 0.3s ease;
            user-select: none;
        }

        .toggle-password:hover {
            color: #fff;
        }

        .form-section {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 30px;
            margin-bottom: 20px;
        }

        .radio-section {
            margin-bottom: 0;
        }

        .radio-section-title {
            display: block;
            color: #374151;
            font-size: 12px;
            font-weight: 600;
            margin-bottom: 8px;
        }

        .radio-group {
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .radio-item {
            display: flex;
            align-items: center;
            gap: 8px;
        }

        .radio-item input[type="radio"] {
            cursor: pointer;
            width: 17px;
            height: 17px;
            accent-color: #10b981;
        }

        .radio-item label {
            color: #374151;
            font-size: 13px;
            cursor: pointer;
            margin: 0;
        }

        .register-btn {
            width: 100%;
            padding: 11px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 14px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 15px;
        }

        .register-btn:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        .back-btn {
            width: 100%;
            padding: 9px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 5px;
            font-size: 12px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 6px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
        }

        .back-btn:hover {
            background: #4b5563;
            transform: translateY(-2px);
        }

        .login-link {
            text-align: center;
            margin-top: 12px;
            font-size: 12px;
            color: #4b5563;
        }

        .login-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .login-link a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 10px;
            margin-top: 2px;
        }
    </style>
</head>
<body>
    <div class="register-container">
        <h1 class="register-title">Register</h1>

        @if ($errors->any())
            <div style="background: #fee2e2; color: #991b1b; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 11px;">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div style="background: #d1fae5; color: #065f46; padding: 10px; border-radius: 4px; margin-bottom: 15px; font-size: 11px;">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('register.post') }}" method="POST">
            @csrf

            <div class="form-grid">
                <div class="form-group">
                    <label class="form-label">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        class="form-input"
                        placeholder="Nama Lengkap"
                        value="{{ old('nama') }}"
                        required
                    >
                    @error('nama')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Username</label>
                    <input
                        type="text"
                        name="username"
                        class="form-input"
                        placeholder="Username"
                        value="{{ old('username') }}"
                        required
                    >
                    @error('username')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Email</label>
                    <input
                        type="email"
                        name="email"
                        class="form-input"
                        placeholder="Email"
                        value="{{ old('email') }}"
                        required
                    >
                    @error('email')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">No HP</label>
                    <input
                        type="text"
                        name="no_hp"
                        class="form-input"
                        placeholder="No HP"
                        value="{{ old('no_hp') }}"
                    >
                    @error('no_hp')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group full-width">
                    <label class="form-label">Alamat Lengkap</label>
                    <input
                        type="text"
                        name="alamat"
                        class="form-input"
                        placeholder="Alamat"
                        value="{{ old('alamat') }}"
                    >
                    @error('alamat')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password"
                            id="password"
                            class="form-input"
                            placeholder="Password"
                            required
                        >
                        <i class="fas fa-eye toggle-password" id="togglePassword"></i>
                    </div>
                    @error('password')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label">Konfirmasi Password</label>
                    <div class="password-wrapper">
                        <input
                            type="password"
                            name="password_confirmation"
                            id="password_confirmation"
                            class="form-input"
                            placeholder="Konfirmasi Password"
                            required
                        >
                        <i class="fas fa-eye toggle-password" id="togglePasswordConfirmation"></i>
                    </div>
                </div>
            </div>

            <div class="form-section">
                <div class="radio-section">
                    <label class="radio-section-title">Jenis Kelamin</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input
                                type="radio"
                                id="laki"
                                name="jenis_kelamin"
                                value="Laki-laki"
                                {{ old('jenis_kelamin') == 'Laki-laki' ? 'checked' : '' }}
                                required
                            >
                            <label for="laki">Laki Laki</label>
                        </div>
                        <div class="radio-item">
                            <input
                                type="radio"
                                id="perempuan"
                                name="jenis_kelamin"
                                value="Perempuan"
                                {{ old('jenis_kelamin') == 'Perempuan' ? 'checked' : '' }}
                            >
                            <label for="perempuan">Perempuan</label>
                        </div>
                    </div>
                    @error('jenis_kelamin')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>

                <div class="radio-section">
                    <label class="radio-section-title">Sebagai</label>
                    <div class="radio-group">
                        <div class="radio-item">
                            <input
                                type="radio"
                                id="penyedia"
                                name="tipe_user"
                                value="PemberiKerja"
                                {{ old('tipe_user') == 'PemberiKerja' ? 'checked' : '' }}
                                required
                            >
                            <label for="penyedia">Penyedia kerja</label>
                        </div>
                        <div class="radio-item">
                            <input
                                type="radio"
                                id="pencari"
                                name="tipe_user"
                                value="Pekerja"
                                {{ old('tipe_user') == 'Pekerja' ? 'checked' : '' }}
                            >
                            <label for="pencari">Pencari Kerja</label>
                        </div>
                    </div>
                    @error('tipe_user')
                        <span class="error-message">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <button type="submit" class="register-btn">
                Daftar sekarang
            </button>

            <a href="{{ route('home') }}" class="back-btn">
                Kembali ke Dashboard
            </a>
        </form>

        <div class="login-link">
            Sudah punya akun? klik <a href="{{ route('login') }}">login disini</a>
        </div>
    </div>

    <script>
        // Toggle Password Visibility
        const togglePassword = document.getElementById('togglePassword');
        const passwordInput = document.getElementById('password');

        togglePassword.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordInput.setAttribute('type', type);
            
            // Toggle the icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });

        // Toggle Password Confirmation Visibility
        const togglePasswordConfirmation = document.getElementById('togglePasswordConfirmation');
        const passwordConfirmationInput = document.getElementById('password_confirmation');

        togglePasswordConfirmation.addEventListener('click', function() {
            // Toggle the type attribute
            const type = passwordConfirmationInput.getAttribute('type') === 'password' ? 'text' : 'password';
            passwordConfirmationInput.setAttribute('type', type);
            
            // Toggle the icon
            this.classList.toggle('fa-eye');
            this.classList.toggle('fa-eye-slash');
        });
    </script>
</body>
</html>