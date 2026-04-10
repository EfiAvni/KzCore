@php($siteSettings = $siteSettings ?? [])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? ($brandName . ' | Kurumsal Web Sitesi') }}</title>
    <meta name="description" content="{{ $pageDescription ?? 'Kurumsal web sitesi icerikleri yonetim panelinden guncellenebilir.' }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-brand-red: {{ $siteSettings['theme_color'] ?? '#D20000' }};
            --color-brand-dark: #0a0a0a;
            --color-brand-gray: #1a1a1a;
        }

        body {
            background:
                radial-gradient(circle at top, rgba(255,255,255,0.03), transparent 35%),
                linear-gradient(180deg, #050505 0%, #0a0a0a 40%, #111 100%);
            color: #fff;
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(10, 10, 10, 0.75);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.06);
        }

        .theme-card {
            background: linear-gradient(180deg, rgba(255,255,255,0.05), rgba(255,255,255,0.03));
            border: 1px solid rgba(255,255,255,0.08);
            box-shadow: 0 24px 60px -30px rgba(0,0,0,0.55);
            backdrop-filter: blur(10px);
        }

        .section-shell {
            @apply max-w-7xl mx-auto px-4 sm:px-6 lg:px-8;
        }

        .red-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #ff8383, var(--color-brand-red));
        }

        .nav-link {
            @apply text-sm uppercase tracking-[0.22em] font-semibold text-gray-300 transition-colors hover:text-white;
        }

        .nav-link.active {
            color: var(--color-brand-red);
        }

        .btn-primary {
            @apply inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition-all;
            background: linear-gradient(135deg, var(--color-brand-red), #ff4d4d);
            box-shadow: 0 0 20px rgba(210, 0, 0, 0.3);
        }

        .btn-secondary {
            @apply inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-sm font-bold uppercase tracking-[0.18em] text-white transition-all hover:border-white/30 hover:bg-white/5;
        }

        .page-hero {
            position: relative;
            overflow: hidden;
        }

        .page-hero::before {
            content: '';
            position: absolute;
            inset: 10% auto auto 50%;
            width: 34rem;
            height: 34rem;
            transform: translateX(-50%);
            background: radial-gradient(circle, rgba(210,0,0,0.25), transparent 65%);
            filter: blur(10px);
            pointer-events: none;
        }
    </style>
</head>
<body class="antialiased">
    <nav class="glass-nav fixed inset-x-0 top-0 z-50">
        <div class="section-shell">
            <div class="flex h-24 items-center justify-between gap-6">
                <a href="{{ route('theme.home') }}" class="flex items-center gap-4">
                    @if(!empty($siteSettings['site_logo']))
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="h-16 w-auto object-contain">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-[0.65rem] font-bold uppercase tracking-[0.25em] text-gray-300">
                            Logo
                        </div>
                    @endif
                    <div class="hidden sm:block">
                        <div class="text-xl font-black tracking-tight">{{ $brandName }}</div>
                        <div class="text-[0.65rem] uppercase tracking-[0.35em] text-gray-500">oto-lastik theme</div>
                    </div>
                </a>

                <div class="hidden md:flex items-center gap-7">
                    <a href="{{ route('theme.home') }}" class="nav-link {{ request()->routeIs('theme.home') ? 'active' : '' }}">Anasayfa</a>
                    <a href="{{ route('theme.about') }}" class="nav-link {{ request()->routeIs('theme.about') ? 'active' : '' }}">Hakkimizda</a>
                    <a href="{{ route('theme.services') }}" class="nav-link {{ request()->routeIs('theme.services') ? 'active' : '' }}">Hizmetler</a>
                    <a href="{{ route('theme.gallery') }}" class="nav-link {{ request()->routeIs('theme.gallery') ? 'active' : '' }}">Galeri</a>
                    <a href="{{ route('theme.contact') }}" class="nav-link {{ request()->routeIs('theme.contact') ? 'active' : '' }}">Iletisim</a>
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="btn-primary">Hemen Ara</a>
                </div>
            </div>
        </div>
    </nav>
