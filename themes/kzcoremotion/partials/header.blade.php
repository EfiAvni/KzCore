@php($siteSettings = $siteSettings ?? [])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? ($brandName . ' | KzCoreMotion') }}</title>
    <meta name="description" content="{{ $pageDescription ?? 'Modern, guclu ve donusum odakli hizmet temasi.' }}">
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-motion-dark: #1b1d24;
            --color-motion-surface: #232936;
            --color-motion-orange: #ff6a3d;
            --color-motion-red: #ff4d5e;
            --color-motion-blue: #0c89d8;
        }

        body {
            background:
                radial-gradient(circle at top right, rgba(12,137,216,0.18), transparent 22%),
                radial-gradient(circle at left top, rgba(255,106,61,0.12), transparent 20%),
                linear-gradient(180deg, #16181f 0%, #1b1d24 55%, #f7f7f8 55%, #f7f7f8 100%);
            color: #fff;
        }

        .motion-shell { @apply mx-auto max-w-7xl px-4 sm:px-6 lg:px-8; }
        .motion-card {
            @apply rounded-[1.75rem] border shadow-[0_28px_70px_-40px_rgba(0,0,0,0.55)];
            border-color: rgba(255,255,255,0.08);
            background: rgba(255,255,255,0.04);
            backdrop-filter: blur(10px);
        }

        .motion-light-card {
            @apply rounded-[1.75rem] border border-slate-200 bg-white shadow-[0_22px_60px_-40px_rgba(15,23,42,0.28)];
        }

        .motion-nav {
            background: rgba(18, 20, 27, 0.8);
            backdrop-filter: blur(16px);
            border-bottom: 1px solid rgba(255,255,255,0.08);
        }

        .motion-link {
            @apply text-sm font-semibold uppercase tracking-[0.24em] text-white/72 transition-colors hover:text-white;
        }

        .motion-link.active {
            color: var(--color-motion-orange);
        }

        .motion-cta {
            @apply inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-black uppercase tracking-[0.2em] text-white transition-all;
            background: linear-gradient(135deg, var(--color-motion-orange), var(--color-motion-red));
        }

        .motion-cta-blue {
            @apply inline-flex items-center justify-center rounded-full px-6 py-3 text-sm font-black uppercase tracking-[0.2em] text-white transition-all;
            background: linear-gradient(135deg, var(--color-motion-blue), #39a9f3);
        }

        .motion-outline {
            @apply inline-flex items-center justify-center rounded-full border border-white/15 px-6 py-3 text-sm font-black uppercase tracking-[0.2em] text-white;
        }

        .section-label {
            @apply text-xs font-black uppercase tracking-[0.32em];
            color: var(--color-motion-orange);
        }
    </style>
</head>
<body class="antialiased">
    <header class="motion-nav sticky top-0 z-50">
        <div class="motion-shell">
            <div class="flex h-24 items-center justify-between gap-6">
                <a href="{{ route('theme.home') }}" class="flex items-center gap-4">
                    @if(!empty($siteSettings['site_logo']))
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="h-14 w-auto object-contain">
                    @else
                        <div class="flex h-14 w-14 items-center justify-center rounded-2xl border border-white/10 bg-white/5 text-[0.6rem] font-bold uppercase tracking-[0.24em] text-white/80">Logo</div>
                    @endif
                    <div>
                        <div class="text-2xl font-black text-white">{{ $brandName }}</div>
                        <div class="text-[0.6rem] uppercase tracking-[0.34em] text-white/45">KzCoreMotion</div>
                    </div>
                </a>
                <nav class="hidden items-center gap-6 lg:flex">
                    <a href="{{ route('theme.home') }}" class="motion-link {{ request()->routeIs('theme.home') ? 'active' : '' }}">Anasayfa</a>
                    <a href="{{ route('theme.services') }}" class="motion-link {{ request()->routeIs('theme.services') ? 'active' : '' }}">Hizmetler</a>
                    <a href="{{ route('theme.about') }}" class="motion-link {{ request()->routeIs('theme.about') ? 'active' : '' }}">Neden Biz</a>
                    <a href="{{ route('theme.gallery') }}" class="motion-link {{ request()->routeIs('theme.gallery') ? 'active' : '' }}">Projeler</a>
                    <a href="{{ route('theme.contact') }}" class="motion-link {{ request()->routeIs('theme.contact') ? 'active' : '' }}">Iletisim</a>
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="motion-cta">Hemen Ara</a>
                </nav>
            </div>
        </div>
    </header>
