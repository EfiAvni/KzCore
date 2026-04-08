<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Ayarları | Küçükzade Dijital</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-kz-gold: #c6a71e;
            --color-kz-gold-light: #e6c834;
            --color-kz-black: #111111;
            --color-kz-bg: #f5f6fa;
        }
        
        body { background-color: var(--color-kz-bg); }

        .sidebar { background-color: var(--color-kz-black); color: #ffffff; }

        .nav-item {
            display: flex; align-items: center; gap: 0.875rem; padding: 0.875rem 1.25rem;
            border-radius: 0.75rem; color: #9ca3af; font-weight: 500; transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }
        .nav-item:hover { color: #ffffff; background-color: rgba(255, 255, 255, 0.05); }
        .nav-item.active { color: var(--color-kz-gold); background-color: rgba(198, 167, 30, 0.08); }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background-color: var(--color-kz-gold); border-top-right-radius: 4px; border-bottom-right-radius: 4px;
        }
        
        .input-field {
            width: 100%; border: 1px solid #e5e7eb; padding: 0.75rem 1rem; border-radius: 0.75rem;
            outline: none; transition: all 0.2s ease; font-size: 0.875rem;
        }
        .input-field:focus { border-color: var(--color-kz-gold); box-shadow: 0 0 0 3px rgba(198, 167, 30, 0.1); }
        
        .section-card {
            background-color: #ffffff; border-radius: 1.25rem; padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); border: 1px solid rgba(0,0,0,0.05);
            margin-bottom: 2rem;
        }
    </style>
</head>
<body class="antialiased text-gray-800 flex h-screen overflow-hidden">

    <!-- Left Sidebar -->
    <aside class="sidebar w-72 flex-shrink-0 flex flex-col justify-between border-r border-[#222]">
        <div>
            <!-- Logo Area -->
            <div class="h-24 flex items-center px-8 border-b border-[#222] mb-6">
                <img src="/images/kucukzade-logo.png" alt="Küçükzade Dijital" class="h-auto w-auto mr-3 brightness-0 invert">
            </div>

            <!-- Navigation Links -->
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    Genel Bakış
                </a>
                <a href="{{ route('admin.gallery') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    Galeri Yönetimi
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Raporlar
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Sistem Ayarları
                </a>
            </div>
        </div>

        <div class="p-6 border-t border-[#222]">
            <form method="POST" action="{{ route('admin.logout') }}" class="mb-5">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1a1a1a] hover:bg-[#222] text-gray-400 hover:text-white py-3 rounded-xl transition-colors font-medium border border-[#333]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
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
                <h2 class="text-xl font-bold text-gray-800">Sistem Ayarları</h2>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                <div class="w-10 h-10 flex-shrink-0 rounded-full bg-white flex items-center justify-center p-1 shadow-sm overflow-hidden border border-gray-200">
                    <img src="{{ !empty($settings['site_logo']) ? asset('storage/' . $settings['site_logo']) : '/images/logo.webp' }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-800">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-gray-500 font-medium">{{ Auth::user()->role == 'admin' ? 'Tam Yetki' : (Auth::user()->role == 'editor' ? 'İçerik Yöneticisi' : 'İzleyici') }}</div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10 max-w-5xl w-full mx-auto">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- 1. GENEL AYARLAR -->
            <div class="section-card gs-reveal">
                <h3 class="text-lg font-bold mb-6 text-gray-800 border-b border-gray-100 pb-3 flex justify-between items-center">
                    Kurumsal Kimlik ve İletişim
                </h3>
                
                <form action="{{ route('admin.settings.update') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wider">Site Renk & Logo</h4>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Site Ana Teması (Marka Rengi)</label>
                                <div class="flex items-center gap-3">
                                    <input type="color" name="theme_color" value="{{ $settings['theme_color'] ?? '#D20000' }}" class="h-10 w-16 p-0 border-0 rounded cursor-pointer">
                                    <span class="text-xs text-gray-500">Müşterilerin göreceği buton ve ikon renkleri.</span>
                                </div>
                            </div>
                            
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Site Logosu (Güncellemek için seçin)</label>
                                @if(isset($settings['site_logo']))
                                    <div class="mb-2 p-2 bg-gray-100 rounded inline-block">
                                        <img src="{{ asset('storage/' . $settings['site_logo']) }}" class="h-10 object-contain">
                                    </div>
                                @endif
                                <input type="file" name="site_logo" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-xs file:font-semibold file:bg-yellow-50 file:text-kz-gold-dark hover:file:bg-yellow-100 cursor-pointer">
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wider">Adres & E-Posta</h4>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Genel E-Posta Adresi</label>
                                <input type="email" name="email" value="{{ $settings['email'] ?? 'info@ornek.com' }}" class="input-field" placeholder="Örn: info@firmadi.com">
                            </div>
                            <div class="mb-4">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Fiziksel Adres</label>
                                <textarea name="address" rows="3" class="input-field" placeholder="İşletmenin açık adresi...">{{ $settings['address'] ?? '' }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-8 border-t border-gray-100 pt-8">
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wider">Telefon Numaraları (Maks 3)</h4>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">1. Telefon (Ana Numara)</label>
                                <input type="text" name="phone_1" value="{{ $settings['phone_1'] ?? '' }}" class="input-field" placeholder="Örn: 0555 555 55 55">
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">2. Telefon (Varsa)</label>
                                <input type="text" name="phone_2" value="{{ $settings['phone_2'] ?? '' }}" class="input-field" placeholder="Örn: 0212 212 12 12">
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">3. Telefon (Varsa)</label>
                                <input type="text" name="phone_3" value="{{ $settings['phone_3'] ?? '' }}" class="input-field">
                            </div>
                        </div>

                        <div>
                            <h4 class="font-semibold text-gray-700 mb-4 text-sm uppercase tracking-wider">Sosyal Medya Linkleri</h4>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Instagram Linki</label>
                                <input type="url" name="instagram" value="{{ $settings['instagram'] ?? '' }}" class="input-field" placeholder="https://instagram.com/kullaniciadi">
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Facebook Linki</label>
                                <input type="url" name="facebook" value="{{ $settings['facebook'] ?? '' }}" class="input-field" placeholder="https://facebook.com/kullaniciadi">
                            </div>
                            <div class="mb-3">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Twitter (X) Linki</label>
                                <input type="url" name="twitter" value="{{ $settings['twitter'] ?? '' }}" class="input-field" placeholder="https://twitter.com/kullaniciadi">
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-kz-gold hover:bg-kz-gold-dark text-white px-8 py-3 rounded-xl font-bold uppercase tracking-widest text-sm transition-colors shadow-md">
                            Tüm Ayarları Kaydet
                        </button>
                    </div>
                </form>
            </div>

            <!-- 2. KULLANICI YÖNETİMİ -->
            <div class="section-card gs-reveal">
                <h3 class="text-lg font-bold mb-6 text-gray-800 border-b border-gray-100 pb-3">Kullanıcı Yönetimi (Panele Erişim)</h3>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
                    <!-- Kullanıcı Ekle -->
                    <div>
                        <h4 class="font-semibold text-gray-700 mb-4 text-sm">Yeni Yetkili Ekle</h4>
                        <form action="{{ route('admin.users.store') }}" method="POST" class="space-y-4">
                            @csrf
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Ad Soyad (*)</label>
                                <input type="text" name="username" required class="input-field">
                            </div>
                            <div>
                                <label class="block text-xs font-medium text-gray-500 mb-1">E-Posta (Giriş için kullanılacak) (*)</label>
                                <input type="email" name="email" required class="input-field">
                            </div>
                            <div class="grid grid-cols-2 gap-4">
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Şifre (*)</label>
                                    <input type="password" name="password" minlength="6" required class="input-field">
                                </div>
                                <div>
                                    <label class="block text-xs font-medium text-gray-500 mb-1">Kişisel Telefon</label>
                                    <input type="text" name="phone" class="input-field">
                                </div>
                            </div>
                            <div class="mb-4">
                                <label class="block text-xs font-medium text-gray-500 mb-1">Hesap Yetkisi (*)</label>
                                <select name="role" required class="input-field bg-white">
                                    <option value="admin">Tam Yetki (Tüm Ayarlara Erişir)</option>
                                    <option value="editor">İçerik Yönetimi (Galeri Düzenleyebilir)</option>
                                    <option value="viewer" selected>Görüntüleme (Sadece Görebilir)</option>
                                </select>
                            </div>
                            <button type="submit" class="w-full bg-gray-800 hover:bg-black text-white px-4 py-2.5 rounded-xl font-bold text-sm transition-colors mt-2">
                                Kullanıcıyı Oluştur
                            </button>
                        </form>
                    </div>

                    <!-- Kullanıcı Listesi -->
                    <div class="bg-gray-50 rounded-xl p-5 border border-gray-100 h-full max-h-96 overflow-y-auto">
                        <h4 class="font-semibold text-gray-700 mb-4 text-sm">Mevcut Yetkililer</h4>
                        <div class="space-y-3">
                            @foreach($users as $user)
                            <div class="flex items-center justify-between bg-white p-3 rounded-lg border border-gray-200">
                                <div>
                                    <p class="font-bold text-sm text-gray-800 flex items-center gap-2">
                                        {{ $user->username }} 
                                        <span class="text-[0.65rem] font-bold px-2 py-0.5 rounded-full uppercase tracking-wider {{ $user->role == 'admin' ? 'bg-red-100 text-red-700' : ($user->role == 'editor' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-700') }}">
                                            {{ $user->role == 'admin' ? 'Tam Yetki' : ($user->role == 'editor' ? 'İçerik Yönetimi' : 'Görüntüleme') }}
                                        </span>
                                    </p>
                                    <p class="text-xs text-gray-500 mt-1">{{ $user->email }} - {{ $user->phone ?? 'Telefon Yok' }}</p>
                                </div>
                                @if(Auth::id() != $user->id)
                                    <form method="POST" action="{{ route('admin.users.destroy', $user->id) }}" onsubmit="return confirm('Silmek istediğinizden emin misiniz?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-red-500 hover:bg-red-50 p-2 rounded-md transition-colors" title="Yetkiyi Kaldır">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/></svg>
                                        </button>
                                    </form>
                                @else
                                    <span class="text-xs font-bold text-green-600 bg-green-50 px-2 py-1 rounded">Siz</span>
                                @endif
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </main>

    <script>
        gsap.utils.toArray('.gs-reveal').forEach(function(elem, i) {
            gsap.fromTo(elem, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.5, delay: i * 0.1, ease: "power2.out" });
        });
    </script>
</body>
</html>
