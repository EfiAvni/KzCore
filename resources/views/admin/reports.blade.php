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
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
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
                <a href="{{ route('admin.reports') }}" class="nav-item active">
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
        <header class="h-24 bg-[rgba(245,246,250,0.8)] backdrop-blur-md sticky top-0 z-10 flex items-center justify-between px-10 border-b border-gray-200/50 flex-shrink-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Analiz & Raporlar</h2>
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

            <!-- Coming Soon Card -->
            <div class="welcome-card p-16 text-center text-white gs-reveal flex flex-col justify-center items-center h-[50vh]">
                <div class="relative z-10 flex flex-col items-center">
                    <span class="inline-block px-4 py-1.5 bg-yellow-500/20 backdrop-blur-md rounded-full text-xs font-bold tracking-widest uppercase text-kz-gold mb-6 border border-yellow-500/30">
                        Çok Yakında
                    </span>
                    <h1 class="text-3xl md:text-5xl font-black mb-4">Genişletilmiş <span class="text-kz-gold">Raporlar</span></h1>
                    <p class="text-gray-400 text-lg md:text-xl font-light max-w-xl mx-auto leading-relaxed">
                        Google arama motorundaki istatistikleriniz, site ziyaretçileriniz ve genel SEO analizleriniz çok yakında burada listelenecek...
                    </p>
                    <div class="mt-8 flex items-center gap-3">
                        <span class="w-2 h-2 rounded-full bg-kz-gold opacity-30 animate-pulse"></span>
                        <span class="w-2 h-2 rounded-full bg-kz-gold opacity-60 animate-pulse" style="animation-delay: 0.2s"></span>
                        <span class="w-2 h-2 rounded-full bg-kz-gold opacity-100 animate-pulse" style="animation-delay: 0.4s"></span>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        gsap.utils.toArray('.gs-reveal').forEach(function(elem, i) {
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