<!DOCTYPE html>
<html lang="tr">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Yönetim Paneli | Küçükzade Dijital</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />

    <!-- Tailwind CSS -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>

    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-kz-gold: #c6a71e;
            --color-kz-gold-light: #e6c834;
            --color-kz-black: #111111;
            --color-kz-bg: #f5f6fa;
        }
        
        body { 
            background-color: var(--color-kz-bg); 
        }

        .sidebar {
            background-color: var(--color-kz-black);
            color: #ffffff;
        }

        .nav-item {
            display: flex;
            align-items: center;
            gap: 0.875rem;
            padding: 0.875rem 1.25rem;
            border-radius: 0.75rem;
            color: #9ca3af;
            font-weight: 500;
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }

        .nav-item:hover {
            color: #ffffff;
            background-color: rgba(255, 255, 255, 0.05);
        }

        .nav-item.active {
            color: var(--color-kz-gold);
            background-color: rgba(198, 167, 30, 0.08);
        }

        .nav-item.active::before {
            content: '';
            position: absolute;
            left: 0;
            top: 0;
            bottom: 0;
            width: 4px;
            background-color: var(--color-kz-gold);
            border-top-right-radius: 4px;
            border-bottom-right-radius: 4px;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--color-kz-black) 0%, #202020 100%);
            border-radius: 1.25rem;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(198, 167, 30, 0.2);
            box-shadow: 0 20px 40px -15px rgba(0,0,0,0.2);
        }

        .welcome-card::after {
            content: '';
            position: absolute;
            right: 0;
            bottom: 0;
            width: 400px;
            height: 400px;
            background: radial-gradient(circle at bottom right, rgba(198, 167, 30, 0.15) 0%, transparent 60%);
            pointer-events: none;
        }

        .welcome-card::before {
            content: '';
            position: absolute;
            left: -50px;
            top: -50px;
            width: 200px;
            height: 200px;
            background: radial-gradient(circle at top left, rgba(255, 255, 255, 0.05) 0%, transparent 70%);
            pointer-events: none;
        }

        .stat-card {
            background-color: #ffffff;
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0,0,0,0.03);
            transition: all 0.3s ease;
        }

        .stat-card:hover {
            transform: translateY(-4px);
            box-shadow: 0 12px 20px -8px rgba(0, 0, 0, 0.08);
            border-color: rgba(198, 167, 30, 0.2);
        }

        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
        }
    </style>
</head>

<body class="antialiased text-gray-800 flex h-screen overflow-hidden">

    @php
        \Carbon\Carbon::setLocale('tr');
        $hour = date('H');
        if ($hour < 12) {
            $greeting = 'Günaydın';
        } elseif ($hour < 18) {
            $greeting = 'İyi Günler';
        } else {
            $greeting = 'İyi Akşamlar';
        }
    @endphp

    <!-- Left Sidebar -->
    <aside class="sidebar w-72 flex-shrink-0 flex flex-col justify-between border-r border-[#222]">
        <div>
            <!-- Logo Area -->
            <div class="h-24 flex items-center px-8 border-b border-[#222] mb-6">
                <!-- Sitedeki footer daki gibi logoyu çektik, dark theme olduğu için bembeyaz duran versiyonunu koymak istenebilir diye filtre kullanabiliriz ya da orjinali uyar -->
                <img src="/images/kucukzade-logo.png" alt="Küçükzade Dijital" class="h-auto w-auto mr-3 invert">
            </div>

            <!-- Navigation Links -->
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="7" height="9" x="3" y="3" rx="1" />
                        <rect width="7" height="5" x="14" y="3" rx="1" />
                        <rect width="7" height="9" x="14" y="12" rx="1" />
                        <rect width="7" height="5" x="3" y="16" rx="1" />
                    </svg>
                    Genel Bakış
                </a>
                <a href="{{ route('admin.gallery') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="18" x="3" y="3" rx="2" ry="2" />
                        <circle cx="9" cy="9" r="2" />
                        <path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21" />
                    </svg>
                    Galeri Yönetimi
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z" />
                        <path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z" />
                    </svg>
                    Raporlar
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Sistem Ayarları
                </a>
            </div>
        </div>

        <div class="p-6 border-t border-[#222]">
            <form method="POST" action="{{ route('admin.logout') }}" class="mb-5">
                @csrf
                <button type="submit"
                    class="w-full flex items-center justify-center gap-2 bg-[#1a1a1a] hover:bg-[#222] text-gray-400 hover:text-white py-3 rounded-xl transition-colors font-medium border border-[#333]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none"
                        stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4" />
                        <polyline points="16 17 21 12 16 7" />
                        <line x1="21" x2="9" y1="12" y2="12" />
                    </svg>
                    Güvenli Çıkış
                </button>
            </form>
            <div class="text-center text-[0.65rem] text-[#666] font-semibold tracking-wider uppercase">
                Küçükzade Dijital Yönetim Paneli <span class="text-[#888]">v1.0</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen w-full relative">
        <!-- Top Navbar in content -->
        <header class="h-24 bg-[rgba(245,246,250,0.8)] backdrop-blur-md sticky top-0 z-10 flex items-center justify-between px-10 border-b border-gray-200/50 flex-shrink-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Panele Hoş Geldiniz</h2>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                <div class="w-10 h-10 flex-shrink-0 rounded-full bg-white flex items-center justify-center p-1 shadow-sm overflow-hidden border border-gray-200">
                    <img src="{{ !empty($siteSettings['site_logo']) ? asset('storage/' . $siteSettings['site_logo']) : '/images/logo.webp' }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-800">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-gray-500 font-medium">{{ Auth::user()->role == 'admin' ? 'Tam Yetki' : (Auth::user()->role == 'editor' ? 'İçerik Yöneticisi' : 'İzleyici') }}</div>
                </div>
            </div>
        </header>

        <!-- Scrollable content area -->
        <div class="flex-1 overflow-y-auto p-10 max-w-7xl w-full mx-auto pb-20">

            <!-- Beautiful Greeting Card -->
            <div class="welcome-card p-10 mb-10 text-white gs-reveal">
                <div class="relative z-10 flex justify-between items-center">
                    <div>
                        <span
                            class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-sm font-semibold tracking-wider text-kz-gold mb-4 border border-white/5">
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y, l') }}
                        </span>
                        <h1 class="text-4xl font-black mb-2">{{ $greeting }}, <span
                                class="text-kz-gold">{{ Auth::user()->username }}!</span>
                            👋</h1>
                        <p class="text-gray-400 text-lg max-w-2xl font-light">Sisteme başarıyla giriş yaptınız. Umarız
                            harika bir gün geçiriyorsunuzdur. İşte bugün bilmeniz gereken kısa özetler.</p>
                    </div>
                    <div class="hidden lg:block opacity-60">
                        <img src="{{ !empty($siteSettings['site_logo']) ? asset('storage/' . $siteSettings['site_logo']) : '/images/logo.webp' }}" alt="Logo" class="h-28 object-contain drop-shadow-2xl brightness-0 invert">
                    </div>
                </div>
            </div>

            <!-- Stats Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
                <!-- Stat 1 -->
                <div class="stat-card gs-reveal">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Kayıtlı E-Posta</h3>
                        <div class="icon-box bg-blue-50 text-blue-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <rect width="20" height="16" x="2" y="4" rx="2" />
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-gray-800 break-words">{{ Auth::user()->email }}</p>
                    <div class="mt-4 flex items-center text-xs text-green-600 font-medium">
                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        Doğrulanmış İletişim
                    </div>
                </div>

                <!-- Stat 2 -->
                <div class="stat-card gs-reveal">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">İşletme Adı</h3>
                        <div class="icon-box bg-purple-50 text-purple-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M3 9h18v10a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2V9Z" />
                                <path d="m3 9 2.45-4.9A2 2 0 0 1 7.24 3h9.52a2 2 0 0 1 1.8 1.1L21 9" />
                                <path d="M12 3v6" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-gray-800">{{ Auth::user()->business_name }}</p>
                    <div class="mt-4 flex items-center text-xs text-gray-500 font-medium">
                        Sistem Kaydı Aktif
                    </div>
                </div>

                <!-- Stat 3 -->
                <div class="stat-card gs-reveal">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Telefon Numarası</h3>
                        <div class="icon-box bg-green-50 text-green-600">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path
                                    d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-gray-800">{{ Auth::user()->phone ?? 'Belirtilmedi' }}</p>
                    <div class="mt-4 flex items-center text-xs text-gray-500 font-medium">
                        Ana İletişim Hattı
                    </div>
                </div>

                <!-- Stat 4 -->
                <div class="stat-card gs-reveal">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Sistem Durumu</h3>
                        <div class="icon-box bg-yellow-50 text-kz-gold-dark">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 2v20" />
                                <path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6" />
                            </svg>
                        </div>
                    </div>
                    <p class="text-xl font-bold text-gray-800">Aktif & Sağlıklı</p>
                    <div class="mt-4 flex items-center text-xs text-green-600 font-medium">
                        <svg class="mr-1" xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <path d="M22 11.08V12a10 10 0 1 1-5.93-9.14" />
                            <polyline points="22 4 12 14.01 9 11.01" />
                        </svg>
                        Tüm Servisler Çalışıyor
                    </div>
                </div>
            </div>

            <!-- Placeholder content area for future -->
            <div class="bg-white rounded-2xl border border-gray-100 p-8 shadow-sm gs-reveal">
                <div class="flex items-center justify-between mb-6">
                    <h3 class="text-lg font-bold">Hızlı İşlemler</h3>
                </div>
                <div
                    class="flex items-center justify-center py-16 border-2 border-dashed border-gray-100 rounded-xl bg-gray-50/50">
                    <div class="text-center">
                        <div
                            class="w-16 h-16 bg-white shadow-sm border border-gray-100 rounded-full flex items-center justify-center mx-auto mb-4 text-kz-gold">
                            <svg xmlns="http://www.w3.org/2000/svg" width="28" height="28" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 5v14" />
                                <path d="M5 12h14" />
                            </svg>
                        </div>
                        <p class="font-bold text-gray-800">Yeni İçerik Ekle</p>
                        <p class="text-sm text-gray-500 mt-1">İşletmenizin modüllerine bağlı olarak burası
                            şekillenecektir.</p>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        // Smooth entrance animations for dashboard elements
        gsap.utils.toArray('.gs-reveal').forEach(function (elem, i) {
            gsap.fromTo(elem, {
                y: 30,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                delay: i * 0.1,
                ease: "power3.out"
            });
        });
    </script>
</body>

</html>