@php($siteSettings = $siteSettings ?? [])
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $pageTitle ?? 'Endustriyel Tema' }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-accent: #f97316;
        }
        body { background: #0f172a; color: #e5e7eb; }
        .shell { @apply mx-auto max-w-7xl px-4 sm:px-6 lg:px-8; }
        .panel { @apply rounded-[1.75rem] border border-white/10 bg-white/5 shadow-2xl; }
        .link { @apply text-sm uppercase tracking-[0.24em] text-slate-300 hover:text-white; }
    </style>
</head>
<body class="font-sans">
    <header class="border-b border-white/10 bg-slate-950/80 backdrop-blur">
        <div class="shell flex h-24 items-center justify-between">
            <a href="{{ route('theme.home') }}" class="text-xl font-black uppercase tracking-[0.35em]">Endustriyel</a>
            <nav class="hidden md:flex items-center gap-6">
                <a href="{{ route('theme.home') }}" class="link">Home</a>
                <a href="{{ route('theme.about') }}" class="link">About</a>
                <a href="{{ route('theme.services') }}" class="link">Services</a>
                <a href="{{ route('theme.contact') }}" class="link">Contact</a>
                <a href="{{ route('theme.gallery') }}" class="link">Gallery</a>
            </nav>
        </div>
    </header>
