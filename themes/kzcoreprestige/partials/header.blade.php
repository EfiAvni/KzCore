@php($siteSettings = $siteSettings ?? [])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? ($brandName . ' | KzCorePrestige') }}</title>
    <meta name="description" content="{{ $pageDescription ?? 'Premium kurumsal hizmet temasi.' }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=playfair-display:500,600,700,800|manrope:400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Manrope', sans-serif;
            --font-serif: 'Playfair Display', serif;
            --color-prestige-navy: #0d1b34;
            --color-prestige-navy-soft: #172645;
            --color-prestige-ivory: #f5f1e8;
            --color-prestige-gray: #d9dde4;
            --color-prestige-copper: #b78d52;
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(183, 141, 82, 0.08), transparent 22%),
                linear-gradient(180deg, #0a1225 0%, #101c34 42%, #f5f1e8 42%, #f5f1e8 100%);
            color: #0f172a;
        }

        .prestige-shell { @apply mx-auto max-w-7xl px-4 sm:px-6 lg:px-8; }
        .prestige-card {
            @apply rounded-[2rem] border shadow-[0_30px_80px_-45px_rgba(15,23,42,0.45)];
            background: rgba(255,255,255,0.78);
            border-color: rgba(15, 23, 42, 0.08);
            backdrop-filter: blur(12px);
        }

        .nav-blur {
            background: rgba(9, 17, 33, 0.78);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .nav-link {
            @apply text-sm font-semibold uppercase tracking-[0.24em] text-white/70 transition-colors hover:text-white;
        }

        .nav-link.active {
            color: var(--color-prestige-copper);
        }

        .prestige-button {
            @apply inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-bold uppercase tracking-[0.22em] transition-all;
            background: linear-gradient(135deg, #b78d52, #d0ae7a);
            color: #0d1b34;
        }

        .prestige-outline {
            @apply inline-flex items-center justify-center rounded-full border px-6 py-3 text-sm font-bold uppercase tracking-[0.22em] transition-all;
            border-color: rgba(255,255,255,0.18);
            color: white;
            background: rgba(255,255,255,0.03);
        }

        .section-eyebrow {
            @apply text-xs font-bold uppercase tracking-[0.34em];
            color: var(--color-prestige-copper);
        }
    </style>
</head>
<body class="antialiased">
    <header class="nav-blur sticky top-0 z-50">
        <div class="prestige-shell">
            <div class="flex h-24 items-center justify-between gap-6">
                <a href="{{ route('theme.home') }}" class="flex items-center gap-4">
                    @if(!empty($siteSettings['site_logo']))
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="h-14 w-auto object-contain">
                    @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-[0.6rem] font-bold uppercase tracking-[0.28em] text-white/75">
                            Logo
                        </div>
                    @endif
                    <div>
                        <div class="font-serif text-2xl font-bold text-white">{{ $brandName }}</div>
                        <div class="text-[0.6rem] uppercase tracking-[0.34em] text-white/45">KzCorePrestige</div>
                    </div>
                </a>
                <nav class="hidden items-center gap-7 lg:flex">
                    <a href="{{ route('theme.home') }}" class="nav-link {{ request()->routeIs('theme.home') ? 'active' : '' }}">Anasayfa</a>
                    <a href="{{ route('theme.about') }}" class="nav-link {{ request()->routeIs('theme.about') ? 'active' : '' }}">Hakkimizda</a>
                    <a href="{{ route('theme.services') }}" class="nav-link {{ request()->routeIs('theme.services') ? 'active' : '' }}">Hizmetler</a>
                    <a href="{{ route('theme.gallery') }}" class="nav-link {{ request()->routeIs('theme.gallery') ? 'active' : '' }}">Galeri</a>
                    <a href="{{ route('theme.contact') }}" class="nav-link {{ request()->routeIs('theme.contact') ? 'active' : '' }}">Iletisim</a>
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="prestige-button">Bize Ulasin</a>
                </nav>
            </div>
        </div>
    </header>
