<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - KerjaKita</title>

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
        }

        .login-container {
            background: #b8c5d6;
            padding: 40px 50px;
            border-radius: 12px;
            width: 100%;
            max-width: 350px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.3);
        }

        .login-title {
            text-align: center;
            font-size: 18px;
            font-weight: 600;
            color: #1a1a2e;
            margin-bottom: 25px;
            letter-spacing: 1px;
        }

        .avatar-icon {
            width: 60px;
            height: 60px;
            margin: 0 auto 25px;
            background: #9ca3af;
            border: 3px solid #6b7280;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #374151;
            font-size: 32px;
        }

        .form-group {
            margin-bottom: 16px;
        }

        .form-label {
            display: block;
            color: #374151;
            font-size: 14px;
            font-weight: 500;
            margin-bottom: 8px;
        }

        .form-input {
            width: 100%;
            padding: 10px 12px;
            background: #6b7280;
            border: none;
            border-radius: 4px;
            color: #fff;
            font-size: 13px;
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

        .remember-me {
            display: flex;
            align-items: center;
            gap: 8px;
            margin-bottom: 16px;
        }

        .remember-me input[type="checkbox"] {
            width: 16px;
            height: 16px;
            cursor: pointer;
            accent-color: #10b981;
        }

        .remember-me label {
            color: #374151;
            font-size: 12px;
            cursor: pointer;
            margin: 0;
        }

        .login-btn {
            width: 100%;
            padding: 12px;
            background: #10b981;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .login-btn:hover {
            background: #059669;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(16, 185, 129, 0.4);
        }

        .login-btn:active {
            transform: translateY(0);
        }

        .back-btn {
            width: 100%;
            padding: 9px;
            background: #6b7280;
            color: white;
            border: none;
            border-radius: 4px;
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

        .register-link {
            text-align: center;
            margin-top: 15px;
            font-size: 12px;
            color: #4b5563;
        }

        .register-link a {
            color: #3b82f6;
            text-decoration: none;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .register-link a:hover {
            color: #1d4ed8;
            text-decoration: underline;
        }

        .error-message {
            color: #dc2626;
            font-size: 12px;
            margin-top: 4px;
        }

        .success-message {
            background: #d1fae5;
            color: #065f46;
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 13px;
        }

        .alert-box {
            padding: 12px;
            border-radius: 4px;
            margin-bottom: 16px;
            font-size: 12px;
        }

        .alert-error {
            background: #fee2e2;
            color: #991b1b;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h1 class="login-title">LOGIN</h1>

        <div class="avatar-icon">
            <i class="fas fa-user"></i>
        </div>

        @if ($errors->any())
            <div class="alert-box alert-error">
                @foreach ($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        @if (session('success'))
            <div class="success-message">
                {{ session('success') }}
            </div>
        @endif

        <form action="{{ route('login.post') }}" method="POST">
            @csrf

            <div class="form-group">
                <label class="form-label">Username</label>
                <input
                    type="text"
                    name="username"
                    class="form-input"
                    placeholder="Masukkan username"
                    value="{{ old('username') }}"
                    required
                    autofocus
                >
                @error('username')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="form-group">
                <label class="form-label">Password</label>
                <input
                    type="password"
                    name="password"
                    class="form-input"
                    placeholder="Masukkan password"
                    required
                >
                @error('password')
                    <span class="error-message">{{ $message }}</span>
                @enderror
            </div>

            <div class="remember-me">
                <input
                    type="checkbox"
                    id="remember"
                    name="remember"
                >
                <label for="remember">Ingat Saya</label>
            </div>

            <button type="submit" class="login-btn">
                LOGIN
            </button>

            <a href="{{ route('home') }}" class="back-btn">
                Kembali ke Dashboard
            </a>
        </form>

        <div class="register-link">
            Belum punya akun? <a href="{{ route('register') }}">daftar disini</a>
        </div>
    </div>
</body>
</html>