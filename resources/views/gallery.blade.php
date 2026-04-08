<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Galeri | Göksel Lastik</title>
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-brand-red: {{ $siteSettings['theme_color'] ?? '#D20000' }};
            --color-brand-dark: #111111;
            --color-brand-gray: #1E1E1E;
        }
        
        body {
            background-color: var(--color-brand-dark);
            color: #FFFFFF;
            overflow-x: hidden;
        }

        .glass-nav {
            background: rgba(10, 10, 10, 0.7);
            backdrop-filter: blur(12px);
            -webkit-backdrop-filter: blur(12px);
            border-bottom: 1px solid rgba(255, 255, 255, 0.05);
        }

        .red-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #ff4d4d, var(--color-brand-red));
        }

        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: 1rem;
            cursor: pointer;
            transition: transform 0.5s cubic-bezier(0.4, 0, 0.2, 1);
            border: 1px solid rgba(255,255,255,0.05);
        }
        
        .gallery-item:hover {
            transform: scale(1.02);
            border-color: var(--color-brand-red);
            box-shadow: 0 15px 30px -10px rgba(210,0,0,0.3);
        }

        .gallery-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.7s ease;
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-item-overlay {
            position: absolute;
            inset: 0;
            background: linear-gradient(to top, rgba(0,0,0,0.9) 0%, rgba(0,0,0,0) 50%);
            opacity: 0;
            transition: opacity 0.3s ease;
            display: flex;
            align-items: flex-end;
            padding: 1.5rem;
        }

        .gallery-item:hover .gallery-item-overlay {
            opacity: 1;
        }
        
        /* Temporary empty state style for gallery */
        .empty-placeholder {
            background: repeating-linear-gradient(
              45deg,
              #111,
              #111 10px,
              #161616 10px,
              #161616 20px
            );
        }
    </style>
</head>
<body class="antialiased">

    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <!-- Text/Logo -->
                <a href="/" class="z-20 flex-shrink-0 flex items-center gap-3">
                    <img src="{{ !empty($siteSettings['site_logo']) ? asset('storage/' . $siteSettings['site_logo']) : '/images/logo.webp' }}" alt="Göksel Lastik" class="h-16 w-auto object-contain transition-all">
                    <div class="hidden sm:block">
                        <span class="font-bold text-2xl tracking-tight block leading-none">Göksel <span class="text-brand-red">Lastik</span></span>
                    </div>
                </a>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Anasayfa</a>
                    <a href="{{ url('/#hizmetler') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Hizmetler</a>
                    <a href="{{ url('/galeri') }}" class="text-brand-red font-bold transition-colors text-sm uppercase tracking-wider relative after:content-[''] after:absolute after:-bottom-2 after:left-0 after:w-full after:h-0.5 after:bg-brand-red">Galeri</a>
                    <a href="{{ url('/#hakkimizda') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Hakkımızda</a>
                    <a href="tel:+905432923512" class="bg-brand-red hover:bg-red-700 text-white px-6 py-2.5 rounded-full text-sm uppercase tracking-wider font-bold transition-all shadow-[0_0_15px_rgba(210,0,0,0.3)] hover:shadow-[0_0_25px_rgba(210,0,0,0.6)]">
                        Hemen Ara
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-layer pt-32 pb-24 min-h-[80vh]">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            
            <div class="text-center mb-16 mt-12 gs-reveal">
                <span class="text-brand-red font-bold tracking-widest uppercase text-sm mb-2 block">Çalışmalarımız</span>
                <h1 class="text-5xl md:text-6xl font-black tracking-tighter">Projeler & <span class="red-gradient">Galeri</span></h1>
                <p class="text-gray-400 mt-4 max-w-2xl mx-auto">Müşterilerimize sunduğumuz profesyonel hizmetlerden bazı kareler.</p>
            </div>

            <!-- Masonry Grid for Photos -->
            @if(isset($images) && count($images) > 0)
                <div class="columns-1 md:columns-2 lg:columns-3 gap-6 space-y-6">
                    @foreach($images as $key => $image)
                        <div class="gallery-item break-inside-avoid gs-reveal relative rounded-xl overflow-hidden block">
                            <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="w-full h-auto block rounded-xl" loading="lazy">
                            <div class="gallery-item-overlay">
                                @if($image->title)
                                    <h3 class="text-white font-bold text-xl">{{ $image->title }}</h3>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <div class="text-center py-20 bg-white/5 rounded-2xl border border-white/10 gs-reveal">
                    <p class="text-gray-400">Henüz galeriye bir fotoğraf eklenmedi.</p>
                </div>
            @endif
        </div>
    </div>

        <!-- Footer / Contact -->
        <footer class="bg-[#050505] pt-24 pb-12 border-t border-white/5 relative z-10 overflow-hidden">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10">
                <div class="grid md:grid-cols-4 gap-12 mb-16">
                    <div class="md:col-span-1">
                        <img src="{{ !empty($siteSettings['site_logo']) ? asset('storage/' . $siteSettings['site_logo']) : '/images/logo.webp' }}" alt="Göksel Lastik" class="h-16 md:h-20 w-auto object-contain mb-6 bg-white/5 p-2 rounded-xl border border-white/10 backdrop-blur-sm">
                        <p class="text-gray-400 font-light mb-6">Türkiye'nin lider lastik sağlayıcısı. Güvenliğiniz için yollardayız.</p>
                        
                        <div class="flex items-center gap-4">
                            @if(!empty($siteSettings['facebook']))
                            <a href="{{ $siteSettings['facebook'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-brand-red hover:border-brand-red transition-colors">
                                <span class="sr-only">Facebook</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 2h-3a5 5 0 0 0-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 0 1 1-1h3z"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteSettings['twitter']))
                            <a href="{{ $siteSettings['twitter'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-brand-red hover:border-brand-red transition-colors">
                                <span class="sr-only">Twitter</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 4s-.7 2.1-2 3.4c1.6 10-9.4 17.3-18 11.6 2.2.1 4.4-.6 6-2C3 15.5.5 9.6 3 5c2.2 2.6 5.6 4.1 9 4-.9-4.2 4-6.6 7-3.8 1.1 0 3-1.2 3-1.2z"/></svg>
                            </a>
                            @endif
                            @if(!empty($siteSettings['instagram']))
                            <a href="{{ $siteSettings['instagram'] }}" target="_blank" class="w-10 h-10 rounded-full bg-white/5 border border-white/10 flex items-center justify-center text-white hover:bg-brand-red hover:border-brand-red transition-colors">
                                <span class="sr-only">Instagram</span>
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="20" x="2" y="2" rx="5" ry="5"/><path d="M16 11.37A4 4 0 1 1 12.63 8 4 4 0 0 1 16 11.37z"/><line x1="17.5" x2="17.51" y1="6.5" y2="6.5"/></svg>
                            </a>
                            @endif
                        </div>
                    </div>
                    
                    <div class="md:col-span-2">
                        <h4 class="text-lg font-bold mb-6 tracking-widest uppercase">İletişim</h4>
                        <ul class="space-y-4 text-gray-400 font-light">
                            <li class="flex items-start gap-4">
                                <svg class="text-brand-red shrink-0 mt-1" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M20 10c0 6-8 12-8 12s-8-6-8-12a8 8 0 0 1 16 0Z"/><circle cx="12" cy="10" r="3"/></svg>
                                <span>{{ !empty($siteSettings['address']) ? $siteSettings['address'] : '100. Yıl, Tamirci Sk. Yeni Sanayi Sitesi no:25, 59100 Süleymanpaşa/Tekirdağ' }}</span>
                            </li>
                            <li class="flex items-center gap-4">
                                <svg class="text-brand-red shrink-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                <a href="tel:{{ !empty($siteSettings['phone_1']) ? $siteSettings['phone_1'] : '+905432923512' }}" class="hover:text-white transition-colors">{{ !empty($siteSettings['phone_1']) ? $siteSettings['phone_1'] : '+90 543 292 35 12' }}</a>
                            </li>
                            @if(!empty($siteSettings['phone_2']))
                            <li class="flex items-center gap-4">
                                <svg class="text-brand-red shrink-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                <a href="tel:{{ $siteSettings['phone_2'] }}" class="hover:text-white transition-colors">{{ $siteSettings['phone_2'] }}</a>
                            </li>
                            @endif
                            @if(!empty($siteSettings['phone_3']))
                            <li class="flex items-center gap-4">
                                <svg class="text-brand-red shrink-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="14" height="20" x="5" y="2" rx="2" ry="2"/><path d="M12 18h.01"/></svg>
                                <a href="tel:{{ $siteSettings['phone_3'] }}" class="hover:text-white transition-colors">{{ $siteSettings['phone_3'] }}</a>
                            </li>
                            @endif
                            <li class="flex items-center gap-4">
                                <svg class="text-brand-red shrink-0" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="20" height="16" x="2" y="4" rx="2"/><path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"/></svg>
                                <a href="mailto:{{ !empty($siteSettings['email']) ? $siteSettings['email'] : 'destek@goksellastik.com.tr' }}" class="hover:text-white transition-colors">{{ !empty($siteSettings['email']) ? $siteSettings['email'] : 'destek@goksellastik.com.tr' }}</a>
                            </li>
                        </ul>
                    </div>

                    <div>
                        <h4 class="text-lg font-bold mb-6 tracking-widest uppercase">Çalışma Saatleri</h4>
                        <ul class="space-y-4 text-gray-400 font-light">
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>Pazartesi - Cumartesi</span>
                                <span class="text-white">08:00 - 19:00</span>
                            </li>
                            <li class="flex justify-between border-b border-white/5 pb-2">
                                <span>Pazar</span>
                                <span class="text-white">10:00 - 18:00</span>
                            </li>
                            <li class="mt-6">
                                <span class="text-brand-red text-sm font-bold uppercase tracking-wider block mb-2">Acil Yol Yardım</span>
                                <span class="text-white">7 Gün 24 Saat Aktif</span>
                            </li>
                        </ul>
                    </div>
                </div>
                
                <div class="pt-8 border-t border-white/10 text-center text-sm text-gray-500 font-light flex flex-col md:flex-row justify-between items-center">
                    <p>&copy; {{ date('Y') }} Göksel Lastik. Tüm hakları saklıdır.</p>
                    <p class="mt-2 md:mt-0">Designed by <span class="text-brand-red"><a href="https://kucukzadedijital.com" target="_blank">Küçükzade Dijital</a></span></p>
                </div>
            </div>
            
            <div class="text-[20vw] font-black absolute bottom-0 left-1/2 -translate-x-1/2 opacity-5 text-nowrap pointer-events-none uppercase tracking-tighter">
                GÖKSEL LASTİK
            </div>
        </footer>

    <script>
        // Simple entrance animations for gallery items
        gsap.utils.toArray('.gs-reveal').forEach(function(elem, i) {
            gsap.fromTo(elem, {
                y: 50,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 0.8,
                delay: i * 0.1, // Stagger effect
                ease: "power3.out"
            });
        });
    </script>
</body>
</html>
