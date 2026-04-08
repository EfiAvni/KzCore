<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Göksel Lastik | Tekirdağ Profesyonel Lastik Hizmeti</title>
    <meta name="description" content="Göksel Lastik Tekirdağ Lastikçi, Tekirdağ Lastik Tamiri ve yol yardımı hizmetleriyle güvenilir ve hızlı çözümler sunar. Bize Ulaşın!">
    
    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800,900&display=swap" rel="stylesheet" />
    
    <!-- Tailwind CSS (via CDN for immediate dev loading, using v4 compiler) -->
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    
    <!-- GSAP for Animations -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/ScrollTrigger.min.js"></script>

    <!-- Custom Theme Configuration -->
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-brand-red: {{ $siteSettings['theme_color'] ?? '#D20000' }};
            --color-brand-dark: #0A0A0A;
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

        .card-glass {
            background: rgba(30, 30, 30, 0.4);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(255, 255, 255, 0.05);
            transition: all 0.3s ease;
        }

        .card-glass:hover {
            border-color: rgba(210, 0, 0, 0.5);
            transform: translateY(-5px);
            box-shadow: 0 10px 30px -10px rgba(210, 0, 0, 0.2);
        }

        /* Tire & Track Animation elements */
        #tire-bg {
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            width: 100%;
            height: 100%;
            pointer-events: none;
            z-index: 0;
            overflow: hidden;
        }

        .tire-track-container {
            position: absolute;
            top: 96px;
            left: 50%;
            transform: translateX(-50%);
            width: 200px;
            height: 100%;
            z-index: 0;
            opacity: 0.15;
            mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 15%, black 85%, transparent);
        }

        .tire-pattern {
            width: 100%;
            height: 0; /* Will be grown by GSAP */
            background-color: #000;
            background-image: 
                linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111), 
                linear-gradient(45deg, #111 25%, transparent 25%, transparent 75%, #111 75%, #111);
            background-size: 40px 40px;
            background-position: 0 0, 20px 20px;
            box-shadow: 0 0 30px rgba(0,0,0,0.8) inset;
        }

        #rolling-tire {
            position: absolute;
            top: 96px;
            left: 50%;
            transform: translateX(-50%);
            width: 250px;
            height: auto;
            opacity: 0.25;
            z-index: 1;
            filter: drop-shadow(0 20px 20px rgba(0,0,0,0.5));
        }

        .content-layer {
            position: relative;
            z-index: 10;
        }

        .text-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #ffffff, #888888);
        }
        
        .red-gradient {
            background-clip: text;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-image: linear-gradient(to right, #ff4d4d, #D20000);
        }

        /* Hero glow */
        .hero-glow {
            position: absolute;
            top: -10%;
            left: 50%;
            transform: translateX(-50%);
            width: 60vw;
            height: 400px;
            background: radial-gradient(circle, rgba(210,0,0,0.15) 0%, rgba(10,10,10,0) 70%);
            z-index: -1;
            pointer-events: none;
        }

        .brand-marquee {
            overflow: hidden;
            mask-image: linear-gradient(to right, transparent, black 12%, black 88%, transparent);
            -webkit-mask-image: linear-gradient(to right, transparent, black 12%, black 88%, transparent);
        }

        .brand-marquee-track {
            display: flex;
            width: max-content;
            animation: brandMarquee 28s linear infinite;
        }

        .brand-marquee:hover .brand-marquee-track {
            animation-play-state: paused;
        }

        .brand-logo-card {
            min-width: 210px;
            min-height: 92px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            gap: 10px;
            margin-right: 24px;
            padding: 18px 22px;
            border-radius: 20px;
            border: 1px solid rgba(255, 255, 255, 0.08);
            background: linear-gradient(135deg, rgba(255,255,255,0.08), rgba(255,255,255,0.02));
            box-shadow: inset 0 1px 0 rgba(255,255,255,0.08), 0 20px 45px rgba(0,0,0,0.18);
        }

        .brand-logo-card img {
            width: 150px;
            height: 50px;
            object-fit: contain;
            filter: drop-shadow(0 10px 18px rgba(0,0,0,0.22));
        }

        .brand-logo-subtitle {
            display: block;
            color: var(--color-brand-red);
            font-size: 0.62rem;
            font-weight: 900;
            letter-spacing: 0.22em;
            line-height: 1;
            text-transform: uppercase;
            text-align: center;
        }

        @keyframes brandMarquee {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(-50%);
            }
        }
    </style>
</head>
<body class="antialiased">

    <!-- Background Tire Animation Layer -->
    <div id="tire-bg">
        <div class="tire-track-container">
            <div id="tire-track-pattern" class="tire-pattern"></div>
        </div>
        <img id="rolling-tire" src="/images/tire.png" alt="Tire Background">
    </div>
    
    <!-- Navigation -->
    <nav class="glass-nav fixed w-full z-50 transition-all duration-300">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-24">
                <a href="#" class="z-20">
                    <img src="{{ !empty($siteSettings['site_logo']) ? asset('storage/' . $siteSettings['site_logo']) : '/images/logo.webp' }}" alt="Göksel Lastik" class="h-16 md:h-20 w-auto object-contain transition-all">
                </a>
                
                <div class="hidden md:flex space-x-8 items-center">
                    <a href="{{ url('/') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Anasayfa</a>
                    <a href="{{ url('/#hizmetler') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Hizmetler</a>
                    <a href="{{ url('/galeri') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Galeri</a>
                    <a href="{{ url('/#hakkimizda') }}" class="text-gray-300 hover:text-white transition-colors text-sm uppercase tracking-wider font-medium">Hakkımızda</a>
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '+905432923512' }}" class="bg-brand-red hover:bg-red-700 text-white px-6 py-2.5 rounded-full text-sm uppercase tracking-wider font-bold transition-all shadow-[0_0_15px_rgba(210,0,0,0.3)] hover:shadow-[0_0_25px_rgba(210,0,0,0.6)]">
                        Hemen Ara
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <!-- Main Content -->
    <div class="content-layer">
        
        <!-- Hero Section -->
        <section class="relative pt-48 pb-32 flex items-center min-h-[90vh]">
            <div class="hero-glow"></div>
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 w-full">
                <div class="max-w-4xl">
                    <div class="inline-flex items-center gap-2 px-4 py-2 rounded-full border border-white/10 bg-white/5 backdrop-blur-md mb-8 gs-reveal">
                        <span class="w-2 h-2 rounded-full bg-brand-red animate-pulse"></span>
                        <span class="text-xs uppercase tracking-widest text-gray-300">100. Yıl Sanayi Sitesi, Tekirdağ</span>
                    </div>
                    
                    <h1 class="text-6xl md:text-8xl font-black mb-6 leading-[1.1] tracking-tighter gs-reveal">
                        Ustadan Güvene <br/>
                        <span class="red-gradient">Profesyonel</span> Dokunuş.
                    </h1>
                    
                    <p class="text-xl md:text-2xl text-gray-400 mb-10 max-w-2xl leading-relaxed font-light gs-reveal">
                        Tekirdağ'ın en güvenilir lastik ve rot balans merkezi. Her balans ayarında bir imzamız var.
                    </p>
                    
                    <div class="flex flex-col sm:flex-row gap-4 gs-reveal">
                        <a href="#hizmetler" class="bg-white text-black hover:bg-gray-200 px-8 py-4 rounded-full text-center font-bold uppercase tracking-wider transition-colors inline-flex items-center justify-center gap-2">
                            Hizmetleri İncele
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                        <a href="tel:{{ $siteSettings['phone_1'] ?? '+905432923512' }}" class="border border-white/20 hover:border-brand-red hover:bg-brand-red/10 px-8 py-4 rounded-full text-center font-bold uppercase tracking-wider transition-all inline-flex items-center justify-center gap-2 backdrop-blur-sm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                            {{ $siteSettings['phone_1'] ?? '+90 543 292 35 12' }}
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Stats/Brands Section -->
        <section class="py-12 border-y border-white/5 bg-brand-gray/30 backdrop-blur-sm">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center divide-x divide-white/5">
                    <div class="gs-reveal">
                        <div class="text-4xl font-black text-brand-red mb-1">10+</div>
                        <div class="text-xs text-gray-400 uppercase tracking-widest">Yıllık Tecrübe</div>
                    </div>
                    <div class="gs-reveal">
                        <div class="text-4xl font-black text-white mb-1">%100</div>
                        <div class="text-xs text-gray-400 uppercase tracking-widest">Müşteri Memnuniyeti</div>
                    </div>
                    <div class="gs-reveal">
                        <div class="text-4xl font-black text-white mb-1">7/24</div>
                        <div class="text-xs text-gray-400 uppercase tracking-widest">Acil Yol Yardım</div>
                    </div>
                    <div class="gs-reveal flex items-center justify-center">
                        <div class="text-2xl font-black text-gray-300 uppercase tracking-widest">Profesyonel<br><span class="text-xs text-brand-red">Lastik Hizmeti</span></div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Services Section -->
        <section id="hizmetler" class="py-32 relative">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-20 gs-reveal">
                    <span class="text-brand-red font-bold tracking-widest uppercase text-sm mb-2 block">Uzmanlık Alanlarımız</span>
                    <h2 class="text-4xl md:text-5xl font-black tracking-tighter">Size Nasıl Yardımcı Olabiliriz?</h2>
                </div>
                
                <div class="grid md:grid-cols-3 gap-8">
                    <!-- Service 1 -->
                    <div class="card-glass rounded-2xl p-8 gs-reveal">
                        <div class="w-16 h-16 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><circle cx="12" cy="12" r="4"/><path d="M12 2v2"/><path d="M12 20v2"/><path d="m4.93 4.93 1.41 1.41"/><path d="m17.66 17.66 1.41 1.41"/><path d="M2 12h2"/><path d="M20 12h2"/><path d="m6.34 17.66-1.41 1.41"/><path d="m19.07 4.93-1.41 1.41"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Lastik Değişimi</h3>
                        <p class="text-gray-400 mb-6 font-light">Profesyonel ekipmanlarla aracınızın lastiklerini güvenli ve hızlı bir şekilde değiştiriyoruz. Yeni lastik satışımız mevcuttur.</p>
                        <a href="#" class="text-brand-red font-semibold inline-flex items-center gap-2 hover:gap-3 transition-all uppercase text-sm tracking-wider">
                            Detaylı Bilgi
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Service 2 -->
                    <div class="card-glass rounded-2xl p-8 gs-reveal">
                        <div class="w-16 h-16 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M14.7 6.3a1 1 0 0 0 0 1.4l1.6 1.6a1 1 0 0 0 1.4 0l3.77-3.77a6 6 0 0 1-7.94 7.94l-6.91 6.91a2.12 2.12 0 0 1-3-3l6.91-6.91a6 6 0 0 1 7.94-7.94l-3.76 3.76z"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Lastik Tamiri</h3>
                        <p class="text-gray-400 mb-6 font-light">Yolda kaldığınızda ya da lastiğiniz hasar gördüğünde uzman kadromuz ile kesin çözüm üretiyoruz.</p>
                        <a href="#" class="text-brand-red font-semibold inline-flex items-center gap-2 hover:gap-3 transition-all uppercase text-sm tracking-wider">
                            Detaylı Bilgi
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>

                    <!-- Service 3 -->
                    <div class="card-glass rounded-2xl p-8 gs-reveal">
                        <div class="w-16 h-16 bg-brand-red/10 rounded-xl flex items-center justify-center text-brand-red mb-6">
                            <svg xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M12 2v20"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/></svg>
                        </div>
                        <h3 class="text-2xl font-bold mb-4">Balans Ayarı</h3>
                        <p class="text-gray-400 mb-6 font-light">Sürüş güvenliğiniz ve konforunuz için bilgisayarlı sistemlerle hassas rot ve balans ayarı hizmetimiz.</p>
                        <a href="#" class="text-brand-red font-semibold inline-flex items-center gap-2 hover:gap-3 transition-all uppercase text-sm tracking-wider">
                            Detaylı Bilgi
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M5 12h14"/><path d="m12 5 7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        <!-- Tire Brand Slider -->
        <section class="py-14 border-y border-white/5 bg-black/20">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex flex-col md:flex-row md:items-end md:justify-between gap-4 mb-8 gs-reveal">
                    <div>
                        <span class="text-brand-red font-bold tracking-widest uppercase text-sm mb-2 block">Çalıştığımız Markalar</span>
                        <h2 class="text-3xl md:text-4xl font-black tracking-tighter">Güvenilir Lastik Markaları</h2>
                    </div>
                    <p class="text-gray-400 font-light max-w-xl">İhtiyacınıza uygun lastik seçenekleri için sektörün bilinen markalarıyla çözüm sunuyoruz.</p>
                </div>

                @php
                    $tireBrands = [
                        ['name' => 'Pirelli', 'sub' => 'Performance', 'logo' => 'pirelli.svg'],
                        ['name' => 'Goodyear', 'sub' => 'Tyres', 'logo' => 'goodyear.svg'],
                        ['name' => 'Nokian Tyres', 'sub' => 'Tyres', 'logo' => 'nokian-tyres.svg'],
                        ['name' => 'Michelin', 'sub' => 'Premium', 'logo' => 'michelin.svg'],
                        ['name' => 'Bridgestone', 'sub' => 'Global', 'logo' => 'bridgestone.svg'],
                        ['name' => 'Continental', 'sub' => 'Mobility', 'logo' => 'continental.svg'],
                        ['name' => 'Hankook', 'sub' => 'Driving', 'logo' => 'hankook.svg'],
                        ['name' => 'Lassa', 'sub' => 'Lastik', 'logo' => 'lassa.svg'],
                    ];
                @endphp

                <div class="brand-marquee gs-reveal" aria-label="Lastik markaları">
                    <div class="brand-marquee-track">
                        @foreach(array_merge($tireBrands, $tireBrands) as $brand)
                            <div class="brand-logo-card">
                                <img src="{{ asset('images/brands/' . $brand['logo']) }}" alt="{{ $brand['name'] }} logosu" loading="lazy">
                                <span class="brand-logo-subtitle">{{ $brand['sub'] }}</span>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <!-- Reviews Section -->
        <section class="py-32 bg-gradient-to-b from-transparent to-brand-gray/50">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-16 gs-reveal">
                    <span class="text-brand-red font-bold tracking-widest uppercase text-sm mb-2 block">Müşteri Yorumları</span>
                    <h2 class="text-4xl md:text-5xl font-black tracking-tighter">Hakkımızda Neler Dediler?</h2>
                </div>
                
                <div class="grid md:grid-cols-2 gap-8 max-w-4xl mx-auto">
                    <!-- Review 1 -->
                    <div class="card-glass p-8 rounded-2xl relative gs-reveal">
                        <div class="text-brand-red absolute top-6 right-8 opacity-20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.999v2C17.999 16 17 19 14 19c-1 0-1 .008-1 1.031V20c0 1 0 1 1 1z"/></svg>
                        </div>
                        <div class="flex items-center gap-1 mb-4 text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <p class="text-xl italic mb-6 leading-relaxed relative z-10 font-light">"Her zaman güvenerek lastik işimizi teslim ettiğimiz yer. İşçilik ve ilgi gerçekten harika. Güler yüzlü, dürüst ve işinin ehli. Gönül rahatlığıyla tavsiye ederim."</p>
                        <div class="font-bold uppercase tracking-wider text-sm text-gray-300">Melis Akbulutlar</div>
                        <div class="text-xs text-gray-500 mt-1">Google Doğrulanmış İnceleme</div>
                    </div>

                    <!-- Review 2 -->
                    <div class="card-glass p-8 rounded-2xl relative gs-reveal">
                        <div class="text-brand-red absolute top-6 right-8 opacity-20">
                            <svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 24 24" fill="currentColor"><path d="M3 21c3 0 7-1 7-8V5c0-1.25-.756-2.017-2-2H4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2 1 0 1 0 1 1v1c0 1-1 2-2 2s-1 .008-1 1.031V20c0 1 0 1 1 1z"/><path d="M15 21c3 0 7-1 7-8V5c0-1.25-.757-2.017-2-2h-4c-1.25 0-2 .75-2 1.972V11c0 1.25.75 2 2 2h.999v2C17.999 16 17 19 14 19c-1 0-1 .008-1 1.031V20c0 1 0 1 1 1z"/></svg>
                        </div>
                        <div class="flex items-center gap-1 mb-4 text-yellow-400">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="currentColor"><polygon points="12 2 15.09 8.26 22 9.27 17 14.14 18.18 21.02 12 17.77 5.82 21.02 7 14.14 2 9.27 8.91 8.26 12 2"/></svg>
                        </div>
                        <p class="text-xl italic mb-6 leading-relaxed relative z-10 font-light">"İşini iyi yapan, aracınızı güvenle teslim edebileceğiniz güler yüzlü bir işletme herkese tavsiye ederim."</p>
                        <div class="font-bold uppercase tracking-wider text-sm text-gray-300">Mikail Gündoğdu</div>
                        <div class="text-xs text-gray-500 mt-1">Google Doğrulanmış İnceleme</div>
                    </div>
                </div>
            </div>
        </section>

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
    </div>

    <!-- Animation Scripts -->
    <script>
        gsap.registerPlugin(ScrollTrigger);

        // General Reveal Animations
        gsap.utils.toArray('.gs-reveal').forEach(function(elem) {
            gsap.fromTo(elem, {
                y: 50,
                opacity: 0
            }, {
                y: 0,
                opacity: 1,
                duration: 1,
                ease: "power3.out",
                scrollTrigger: {
                    trigger: elem,
                    start: "top 85%",
                }
            });
        });

        // The Tire Animation Timeline!
        const tireWrapper = document.getElementById('tire-bg');
        const tire = document.getElementById('rolling-tire');
        const track = document.getElementById('tire-track-pattern');
        const totalScrollHeight = document.body.scrollHeight - window.innerHeight;

        // Set initial state
        const tireTimeline = gsap.timeline({
            scrollTrigger: {
                trigger: document.body,
                start: "top top",
                end: "bottom bottom",
                scrub: true, // Smooth scrubbing without delay
            }
        });

        // Calculate the maximum Y pixel value the tire can travel
        // We want it to travel down the body. But tireWrapper is fixed. 
        // Oh wait, tireWrapper is absolute! 
        // If it's absolute, it stays at the top. We need it to move down the page.
        
        let moveDownDistance = totalScrollHeight + window.innerHeight * 0.4; // Go slightly beyond viewport
        
        tireTimeline
            // Move tire Y down the page and rotate
            .to(tire, {
                y: moveDownDistance,
                rotation: 1080,
                ease: "none"
            }, 0)
            
            // Draw the track behind it
            .to(track, {
                height: moveDownDistance + 250, // height matches the Y movement + tire vertical offset
                ease: "none"
            }, 0);
            
            // Wait, if tire Wrapper is absolute, 'y' moves it exactly px by px. 
            // So if you scroll 500px, tire moves 500px? If scrub covers 0% to 100% of document scroll,
            // Then setting y: totalScrollHeight will mean the tire stays exactly in the same place in the viewport! (Parallax effect matching scroll speed)
            // Let's make it slightly slower than scroll speed so it visually descends down the backgrounds!
            // Actually, if y is exactly totalScrollHeight, it behaves like position: fixed.
            // But we want it to leave a trace. The trace height grows exactly with the tire Y.
            
            
            // Change tire wrapper to give context
            tireWrapper.style.height = document.body.scrollHeight + 'px';
            
    </script>
</body>
</html>
