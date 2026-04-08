<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Küçükzade Dijital - Giriş</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-kz-gold: #c6a71e;
            --color-kz-gold-light: #e6c834;
            --color-kz-gold-dark: #a18613;
            --color-kz-black: #111111;
        }

        body {
            background-color: #fafafa;
            color: var(--color-kz-black);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background-image: 
                radial-gradient(circle at 100% 100%, rgba(198, 167, 30, 0.05) 0%, transparent 50%),
                radial-gradient(circle at 0% 0%, rgba(198, 167, 30, 0.08) 0%, transparent 40%);
        }

        .login-card {
            background: white;
            border-radius: 24px;
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.05),
                        0 0 0 1px rgba(0,0,0,0.02);
            overflow: hidden;
            width: 100%;
            max-width: 440px;
            position: relative;
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(to right, var(--color-kz-gold), var(--color-kz-gold-light));
        }

        .input-field {
            width: 100%;
            border: 2px solid #f0f0f0;
            padding: 0.875rem 1rem;
            border-radius: 12px;
            outline: none;
            transition: all 0.2s ease;
            font-size: 0.95rem;
        }

        .input-field:focus {
            border-color: var(--color-kz-gold);
            box-shadow: 0 0 0 4px rgba(198, 167, 30, 0.1);
        }

        .btn-primary {
            background: var(--color-kz-black);
            color: white;
            width: 100%;
            padding: 0.875rem;
            border-radius: 12px;
            font-weight: 600;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .btn-primary:hover {
            background: var(--color-kz-gold);
            transform: translateY(-1px);
            box-shadow: 0 10px 20px -10px rgba(198, 167, 30, 0.5);
        }

        .btn-error {
            background-color: #fee2e2;
            border-left: 4px solid #ef4444;
            color: #b91c1c;
            padding: 1rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            font-size: 0.875rem;
        }
    </style>
</head>
<body>

    <div class="login-card p-10 mx-4">
        
        <!-- Logo Area -->
        <div class="text-center mb-10">
            <img src="/images/kucukzade-logo.png" alt="Küçükzade Dijital" class="mx-auto h-16 w-auto object-contain mb-4">
            <p class="text-sm text-gray-400 tracking-wider uppercase font-medium">Yönetim Paneli</p>
        </div>

        @if ($errors->any())
            <div class="btn-error">
                <ul class="list-disc pl-5">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Login Form -->
        <form action="{{ route('admin.login.submit') }}" method="POST" class="space-y-5">
            @csrf
            <div>
                <label for="email" class="block text-sm font-semibold text-gray-700 mb-1.5 ml-1">E-Posta Adresi</label>
                <input type="email" id="email" name="email" class="input-field" placeholder="admin@kucukzadedijital.com" value="{{ old('email') }}" required autofocus>
            </div>

            <div>
                <div class="flex justify-between items-center mb-1.5 ml-1">
                    <label for="password" class="block text-sm font-semibold text-gray-700">Şifre</label>
                </div>
                <input type="password" id="password" name="password" class="input-field" placeholder="••••••••" required>
            </div>

            <div class="pt-4">
                <button type="submit" class="btn-primary">
                    Oturum Aç
                </button>
            </div>
        </form>

        <!-- Footer -->
        <div class="mt-8 text-center">
            <p class="text-xs text-gray-400 font-medium">
                &copy; {{ date('Y') }} Küçükzade Dijital. Tüm hakları saklıdır.
            </p>
        </div>

    </div>

</body>
</html>
