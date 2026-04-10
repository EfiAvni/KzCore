<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KzCore Super Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-kz-gold: #c6a71e;
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
            box-shadow: 0 20px 40px -15px rgba(0, 0, 0, 0.2);
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

        .stat-card,
        .panel-card {
            background-color: #ffffff;
            border-radius: 1.25rem;
            padding: 1.5rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02), 0 2px 4px -2px rgba(0, 0, 0, 0.02);
            border: 1px solid rgba(0, 0, 0, 0.03);
        }

        .icon-box {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 3rem;
            height: 3rem;
            border-radius: 0.75rem;
        }

        .field {
            width: 100%;
            border-radius: 0.9rem;
            border: 1px solid #d1d5db;
            background: #fff;
            padding: 0.8rem 1rem;
            font-size: 0.95rem;
            color: #111827;
        }

        .field:focus {
            outline: none;
            border-color: #c6a71e;
            box-shadow: 0 0 0 4px rgba(198, 167, 30, 0.12);
        }

        .theme-option {
            position: relative;
            display: block;
            overflow: hidden;
            border-radius: 1.5rem;
            border: 1px solid #e5e7eb;
            background: #fff;
            transition: all 0.25s ease;
            cursor: pointer;
        }

        .theme-option:hover {
            transform: translateY(-3px);
            box-shadow: 0 18px 40px -24px rgba(17, 24, 39, 0.35);
        }

        .theme-radio:checked + .theme-option {
            border-color: #c6a71e;
            box-shadow: 0 0 0 4px rgba(198, 167, 30, 0.16);
        }
    </style>
</head>
<body class="antialiased text-gray-800 flex h-screen overflow-hidden">
    @php
        \Carbon\Carbon::setLocale('tr');
        $currentSection = in_array($activeSection, ['overview', 'create-tenant', 'edit-tenant', 'create-user'], true)
            ? $activeSection
            : 'overview';
        $selectedTheme = old('theme_code', 'classic');
    @endphp

    <aside class="sidebar w-72 flex-shrink-0 flex flex-col justify-between border-r border-[#222]">
        <div>
            <div class="h-24 flex items-center px-8 border-b border-[#222] mb-6">
                <img src="/images/kucukzade-logo.png" alt="Küçükzade Dijital" class="h-auto w-auto mr-3 invert">
            </div>

            <div class="px-4 space-y-2">
                <a href="{{ route('kzcore.dashboard', ['section' => 'overview']) }}" class="nav-item {{ $currentSection === 'overview' ? 'active' : '' }}">
                    <span>Genel Bakis</span>
                </a>
                <a href="{{ route('kzcore.dashboard', ['section' => 'create-tenant']) }}" class="nav-item {{ $currentSection === 'create-tenant' ? 'active' : '' }}">
                    <span>Tenant Ekle</span>
                </a>
                <a href="{{ route('kzcore.dashboard', ['section' => 'create-user']) }}" class="nav-item {{ $currentSection === 'create-user' ? 'active' : '' }}">
                    <span>Tenant Kullanici</span>
                </a>
                @if($editingTenant)
                    <a href="{{ route('kzcore.dashboard', ['section' => 'edit-tenant', 'tenant' => $editingTenant->id]) }}" class="nav-item active">
                        <span>Tenant Duzenle</span>
                    </a>
                @endif
            </div>
        </div>

        <div class="p-6 border-t border-[#222]">
            <form method="POST" action="{{ route('admin.logout') }}" class="mb-5">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1a1a1a] hover:bg-[#222] text-gray-400 hover:text-white py-3 rounded-xl transition-colors font-medium border border-[#333]">
                    Guvenli Cikis
                </button>
            </form>
            <div class="text-center text-[0.65rem] text-[#666] font-semibold tracking-wider uppercase">
                KzCore Super Admin <span class="text-[#888]">v1.0</span>
            </div>
        </div>
    </aside>

    <main class="flex-1 flex flex-col h-screen w-full relative">
        <header class="h-24 bg-[rgba(245,246,250,0.8)] backdrop-blur-md sticky top-0 z-10 flex items-center justify-between px-10 border-b border-gray-200/50 flex-shrink-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Tenant Yonetim Paneli</h2>
                <p class="text-sm text-gray-500">Super user tarafindaki tum tenant operasyonlari tek panelde.</p>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                <div class="w-10 h-10 flex-shrink-0 rounded-full bg-white flex items-center justify-center shadow-sm overflow-hidden border border-gray-200">
                    <span class="text-sm font-bold text-[#c6a71e]">KZ</span>
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-800">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-gray-500 font-medium">{{ Auth::user()->getRoleLabel() }}</div>
                </div>
            </div>
        </header>

        <div class="flex-1 overflow-y-auto p-10 max-w-7xl w-full mx-auto pb-20">
            @if($errors->any())
                <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 px-5 py-4 text-sm text-red-700">
                    {{ $errors->first() }}
                </div>
            @endif

            @if(session('success'))
                <div class="mb-6 rounded-2xl border border-green-200 bg-green-50 px-5 py-4 text-sm text-green-700">
                    {{ session('success') }}
                </div>
            @endif

            <div class="welcome-card p-10 mb-10 text-white">
                <div class="relative z-10 flex justify-between items-center gap-6">
                    <div>
                        <span class="inline-block px-3 py-1 bg-white/10 backdrop-blur-md rounded-full text-sm font-semibold tracking-wider text-[#c6a71e] mb-4 border border-white/5">
                            {{ \Carbon\Carbon::now()->translatedFormat('d F Y, l') }}
                        </span>
                        <h1 class="text-4xl font-black mb-3">Tenant Yonetim Alani</h1>
                        <p class="text-lg font-semibold text-[#c6a71e] mb-3">KzCore Super User Kontrol Merkezi</p>
                        <p class="text-gray-300 text-lg max-w-3xl font-light">Tenant olusturma, duzenleme, domain ve kullanici akislari tenant paneliyle ayni tasarim dili icinde toplandi.</p>
                    </div>
                    <div class="hidden lg:flex w-28 h-28 rounded-3xl border border-white/10 bg-white/5 items-center justify-center text-3xl font-black text-[#c6a71e]">
                        {{ $tenantCount }}
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-4 gap-6 mb-10">
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Toplam Tenant</h3>
                        <div class="icon-box bg-yellow-50 text-[#c6a71e]">{{ $tenantCount }}</div>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $tenantCount }}</p>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Aktif Tenant</h3>
                        <div class="icon-box bg-green-50 text-green-600">{{ $activeTenantCount }}</div>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $activeTenantCount }}</p>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Domain</h3>
                        <div class="icon-box bg-blue-50 text-blue-600">{{ $configuredDomainCount }}</div>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $configuredDomainCount }}</p>
                </div>
                <div class="stat-card">
                    <div class="flex items-center justify-between mb-4">
                        <h3 class="text-sm font-bold text-gray-500 uppercase tracking-wider">Tenant Admin</h3>
                        <div class="icon-box bg-purple-50 text-purple-600">{{ $tenantUserCount }}</div>
                    </div>
                    <p class="text-3xl font-black text-gray-900">{{ $tenantUserCount }}</p>
                </div>
            </div>

            @if($currentSection === 'create-tenant')
                <section class="panel-card mb-10">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">Yeni Tenant Acilisi</h3>
                            <p class="text-sm text-gray-500 mt-2">Tenant, admin hesabi, tema secimi, onizleme ve site logosu tek adimda tanimlanir.</p>
                        </div>
                    </div>

                    <form method="POST" action="{{ route('kzcore.tenants.store') }}" enctype="multipart/form-data" class="space-y-8">
                        @csrf
                        <div>
                            <div class="flex items-center justify-between gap-4 mb-4">
                                <div>
                                    <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-700">Tema Secimi</h4>
                                    <p class="text-sm text-gray-500 mt-2">Tenant daha olusurken aktif tema secilsin. Kartlar mini onizleme olarak calisir.</p>
                                </div>
                            </div>
                            <div class="grid grid-cols-1 xl:grid-cols-2 gap-5">
                                @foreach($themeOptions as $themeKey => $theme)
                                    <label class="block">
                                        <input type="radio" name="theme_code" value="{{ $themeKey }}" class="theme-radio sr-only" @checked($selectedTheme === $themeKey)>
                                        <div class="theme-option">
                                            <div class="h-40 p-5 text-white" style="background: {{ $theme['preview']['surface'] }};">
                                                <div class="flex items-start justify-between gap-4">
                                                    <div>
                                                        <div class="text-[0.65rem] uppercase tracking-[0.3em] text-white/70">Tema Onizleme</div>
                                                        <div class="mt-3 text-2xl font-black leading-tight">{{ $theme['name'] }}</div>
                                                    </div>
                                                    <div class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.2em]" style="background-color: {{ $theme['accent'] }};">
                                                        {{ $themeKey }}
                                                    </div>
                                                </div>
                                                <div class="mt-8 max-w-xs text-sm font-medium text-white/85">
                                                    {{ $theme['preview']['hero'] }}
                                                </div>
                                            </div>
                                            <div class="p-5">
                                                <div class="flex items-center justify-between gap-3">
                                                    <div>
                                                        <div class="text-lg font-black text-gray-900">{{ $theme['name'] }}</div>
                                                        <div class="mt-2 text-sm leading-6 text-gray-500">{{ $theme['description'] }}</div>
                                                    </div>
                                                    <div class="w-12 h-12 rounded-2xl border border-gray-200" style="background-color: {{ $theme['accent'] }};"></div>
                                                </div>
                                                <div class="mt-4 flex gap-2">
                                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">home</span>
                                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">about</span>
                                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">services</span>
                                                    <span class="rounded-full bg-gray-100 px-3 py-1 text-xs font-semibold text-gray-600">contact</span>
                                                </div>
                                            </div>
                                        </div>
                                    </label>
                                @endforeach
                            </div>
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Tenant Adi</label>
                                <input type="text" name="name" value="{{ old('name') }}" required class="field" placeholder="Ornek: Goksel Lastik">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Slug</label>
                                <input type="text" name="slug" value="{{ old('slug') }}" class="field" placeholder="ornek-tenant">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Domain</label>
                                <input type="text" name="domain" value="{{ old('domain') }}" class="field" placeholder="ornek.com">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Panel Path</label>
                                <input type="text" name="panel_path" value="{{ old('panel_path', '/admin') }}" class="field">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Durum</label>
                                <select name="status" class="field">
                                    @foreach($statusOptions as $option)
                                        <option value="{{ $option }}" @selected(old('status', 'active') === $option)>{{ strtoupper($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Paket</label>
                                <select name="package_name" class="field">
                                    <option value="">Paket secin</option>
                                    @foreach($packageNameOptions as $option)
                                        <option value="{{ $option }}" @selected(old('package_name') === $option)>{{ strtoupper($option) }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Tema Rengi</label>
                                <input type="color" name="theme_color" value="{{ old('theme_color', '#D20000') }}" class="field h-14">
                            </div>
                            <div>
                                <label class="block text-sm font-semibold text-gray-600 mb-2">Site Logosu</label>
                                <input type="file" name="site_logo" accept="image/*" class="field file:mr-4 file:rounded-full file:border-0 file:bg-yellow-50 file:px-4 file:py-2 file:text-xs file:font-semibold file:text-[#8a7315]">
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-700 mb-4">Musteri Admin Hesabi</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Kullanici Adi</label>
                                    <input type="text" name="admin_username" value="{{ old('admin_username') }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">E-Posta</label>
                                    <input type="email" name="admin_email" value="{{ old('admin_email') }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Telefon</label>
                                    <input type="text" name="admin_phone" value="{{ old('admin_phone') }}" class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Sifre</label>
                                    <input type="password" name="admin_password" required minlength="6" class="field">
                                </div>
                            </div>
                        </div>

                        <div class="border-t border-gray-200 pt-6">
                            <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-700 mb-4">Varsayilan Ayarlar</h4>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Iletisim E-Postasi</label>
                                    <input type="email" name="settings_email" value="{{ old('settings_email') }}" class="field" placeholder="Bos birakilirsa admin e-postasi kullanilir">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Telefon 1</label>
                                    <input type="text" name="phone_1" value="{{ old('phone_1') }}" class="field" placeholder="Bos birakilirsa admin telefonu kullanilir">
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Adres</label>
                                    <textarea name="address" rows="4" class="field" placeholder="Musteri adresi">{{ old('address') }}</textarea>
                                </div>
                            </div>
                        </div>

                        <button type="submit" class="rounded-2xl bg-[#111111] px-6 py-3 font-semibold text-white hover:bg-[#222] transition-colors">
                            Tenant Kurulumunu Tamamla
                        </button>
                    </form>
                </section>
            @elseif($currentSection === 'create-user')
                @php
                    $tenantUsersPreview = $tenants->map(function ($tenant) {
                        return [
                            'id' => $tenant->id,
                            'name' => $tenant->name,
                            'domain' => $tenant->domain,
                            'users_count' => $tenant->users_count,
                            'users' => $tenant->users->map(fn ($user) => [
                                'username' => $user->username,
                                'email' => $user->email,
                                'phone' => $user->phone,
                                'role' => $user->getRoleLabel(),
                            ])->values(),
                        ];
                    })->values();
                @endphp
                <section class="panel-card mb-10">
                    <div class="grid grid-cols-1 lg:grid-cols-[1.1fr_0.9fr] gap-6">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900 mb-2">Tenant Kullanicisi Olustur</h3>
                            <p class="text-sm text-gray-500 mb-6">Mevcut tenantlardan birine yeni panel kullanicisi bagla.</p>
                            <form method="POST" action="{{ route('kzcore.tenant-users.store') }}" class="space-y-5">
                                @csrf
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Tenant</label>
                                    <select name="tenant_id" id="tenant-user-tenant-select" required class="field">
                                        <option value="">Tenant secin</option>
                                        @foreach($tenants as $tenant)
                                            <option value="{{ $tenant->id }}" @selected(old('tenant_id') == $tenant->id)>{{ $tenant->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Kullanici Adi</label>
                                    <input type="text" name="username" value="{{ old('username') }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">E-Posta</label>
                                    <input type="email" name="email" value="{{ old('email') }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Telefon</label>
                                    <input type="text" name="phone" value="{{ old('phone') }}" class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Sifre</label>
                                    <input type="password" name="password" required minlength="6" class="field">
                                </div>
                                <button type="submit" class="rounded-2xl bg-[#111111] px-6 py-3 font-semibold text-white hover:bg-[#222] transition-colors">
                                    Kullaniciyi Olustur
                                </button>
                            </form>
                        </div>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                            <div class="flex items-start justify-between gap-4 mb-5">
                                <div>
                                    <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-600">Mevcut Kullanicilar</h4>
                                    <p class="mt-2 text-sm text-gray-500">Tenant secildiginde mevcut kullanicilar burada listelenir.</p>
                                </div>
                                <div id="tenant-user-count-badge" class="rounded-full bg-white px-3 py-1 text-xs font-bold text-gray-600 border border-gray-200">0 Kullanici</div>
                            </div>
                            <div class="mb-4">
                                <div class="text-sm font-semibold text-gray-900" id="tenant-user-panel-title">Tenant secilmedi</div>
                                <div class="mt-1 text-xs text-gray-500" id="tenant-user-panel-domain">Lutfen soldan bir tenant secin.</div>
                            </div>
                            <div id="tenant-user-list" class="space-y-3">
                                <div class="rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-5 text-sm text-gray-500">
                                    Tenant secildiginde kullanici listesi burada gorunecek.
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @elseif($currentSection === 'edit-tenant' && $editingTenant)
                @php
                    $siteLogo = optional($editingTenant->settings->firstWhere('key', 'site_logo'))->value;
                    $currentThemeKey = old('theme_code', $editingTenant->theme_code ?? 'classic');
                @endphp
                <section class="panel-card mb-10">
                    <div class="flex items-start justify-between gap-4 mb-6">
                        <div>
                            <h3 class="text-2xl font-black text-gray-900">{{ $editingTenant->name }} Tenant Duzenle</h3>
                            <p class="text-sm text-gray-500 mt-2">Ayrı sayfa yerine dashboard icinde secili tenanti duzenliyorsun.</p>
                        </div>
                        <a href="{{ route('kzcore.dashboard', ['section' => 'overview']) }}" class="rounded-2xl border border-gray-300 px-4 py-2 text-sm font-semibold text-gray-700">
                            Listeye Don
                        </a>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-[1.2fr_0.8fr] gap-6">
                        <form method="POST" action="{{ route('kzcore.tenants.update', $editingTenant) }}" class="space-y-5" id="tenant-edit-form">
                            @csrf
                            @method('PUT')
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Tenant Adi</label>
                                    <input type="text" name="name" value="{{ old('name', $editingTenant->name) }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Slug</label>
                                    <input type="text" name="slug" value="{{ old('slug', $editingTenant->slug) }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Domain</label>
                                    <input type="text" name="domain" value="{{ old('domain', $editingTenant->domain) }}" class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Panel Path</label>
                                    <input type="text" name="panel_path" value="{{ old('panel_path', $editingTenant->panel_path) }}" required class="field">
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Durum</label>
                                    <select name="status" class="field">
                                        @foreach($statusOptions as $option)
                                            <option value="{{ $option }}" @selected(old('status', $editingTenant->status) === $option)>{{ strtoupper($option) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div>
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Paket</label>
                                    <select name="package_name" class="field">
                                        <option value="">Paket secin</option>
                                        @foreach($packageNameOptions as $option)
                                            <option value="{{ $option }}" @selected(old('package_name', $editingTenant->package_name) === $option)>{{ strtoupper($option) }}</option>
                                        @endforeach
                                    </select>
                                </div>
                                <div class="md:col-span-2">
                                    <label class="block text-sm font-semibold text-gray-600 mb-2">Tema</label>
                                    <input type="hidden" id="current-theme-value" value="{{ $editingTenant->theme_code ?? 'classic' }}">
                                    <select name="theme_code" id="site-theme-select" class="field">
                                        @foreach($themeOptions as $themeKey => $theme)
                                            <option value="{{ $themeKey }}" @selected($currentThemeKey === $themeKey)>{{ $theme['name'] }} ({{ $themeKey }})</option>
                                        @endforeach
                                    </select>
                                    <p class="mt-2 text-xs text-gray-500">Tema degisirse site on yuzu yeni secilen tema tasarimina gececektir.</p>
                                </div>
                            </div>
                            <button type="submit" class="rounded-2xl bg-[#111111] px-6 py-3 font-semibold text-white hover:bg-[#222] transition-colors">
                                Tenant Bilgilerini Guncelle
                            </button>
                        </form>
                        <form method="POST" action="{{ route('kzcore.tenants.destroy', $editingTenant) }}" onsubmit="return confirm('Bu tenanti ve bagli tum verileri kalici olarak silmek istediginize emin misiniz?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-2xl border border-red-200 bg-red-50 px-6 py-3 font-semibold text-red-700 hover:bg-red-100 transition-colors">
                                Tenanti Sil
                            </button>
                        </form>

                        <div class="rounded-2xl border border-gray-200 bg-gray-50 p-6">
                            <h4 class="text-sm font-bold uppercase tracking-[0.2em] text-gray-600 mb-4">Hizli Ozet</h4>
                            <div class="space-y-4 text-sm text-gray-600">
                                <div>
                                    <div class="font-semibold text-gray-900">Mevcut Domain</div>
                                    <div>{{ $editingTenant->domain ?: 'Tanimlanmadi' }}</div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Kullanici Sayisi</div>
                                    <div>{{ $editingTenant->users_count }}</div>
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Logo</div>
                                    @if($siteLogo)
                                        <img src="{{ asset('storage/' . $siteLogo) }}" alt="{{ $editingTenant->name }} logo" class="mt-3 h-16 rounded-xl border border-gray-200 bg-white p-2 object-contain">
                                    @else
                                        <div class="mt-2 text-gray-500">Logo yuklenmemis.</div>
                                    @endif
                                </div>
                                <div>
                                    <div class="font-semibold text-gray-900">Aktif Tema</div>
                                    <div>{{ $themeOptions[$editingTenant->theme_code ?? 'classic']['name'] ?? 'Classic' }}</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif

            <section class="panel-card">
                <div class="flex items-center justify-between mb-6 gap-4">
                    <div>
                        <h3 class="text-2xl font-black text-gray-900">Tenant Listesi</h3>
                        <p class="text-sm text-gray-500 mt-2">Tum tenant kayitlari, durumlari ve hizli duzenleme aksiyonlari.</p>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-sm">
                        <thead>
                            <tr class="border-b border-gray-200 text-left text-gray-500">
                                <th class="py-4 pr-4">Tenant</th>
                                <th class="py-4 pr-4">Domain</th>
                                <th class="py-4 pr-4">Durum</th>
                                <th class="py-4 pr-4">Paket</th>
                                <th class="py-4 pr-4">Kullanici</th>
                                <th class="py-4 pr-4">Islem</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse($tenants as $tenant)
                                <tr class="border-b border-gray-100 align-middle">
                                    <td class="py-4 pr-4">
                                        <div class="font-semibold text-gray-900">{{ $tenant->name }}</div>
                                        <div class="text-xs text-gray-500 mt-1">{{ $tenant->slug }}</div>
                                    </td>
                                    <td class="py-4 pr-4">{{ $tenant->domain ?: '-' }}</td>
                                    <td class="py-4 pr-4">
                                        <span class="inline-flex rounded-full bg-green-50 px-3 py-1 text-xs font-semibold text-green-700">
                                            {{ strtoupper($tenant->status) }}
                                        </span>
                                    </td>
                                    <td class="py-4 pr-4">{{ $tenant->package_name ? strtoupper($tenant->package_name) : '-' }}</td>
                                    <td class="py-4 pr-4">{{ $tenant->users_count }}</td>
                                    <td class="py-4 pr-4">
                                        <div class="flex flex-wrap items-center gap-2">
                                            <a href="{{ route('kzcore.tenants.edit', $tenant) }}" class="inline-flex rounded-xl border border-gray-300 px-4 py-2 font-semibold text-gray-700 hover:bg-gray-50">
                                                Duzenle
                                            </a>
                                            <form method="POST" action="{{ route('kzcore.tenants.destroy', $tenant) }}" onsubmit="return confirm('Bu tenanti ve bagli tum verileri kalici olarak silmek istediginize emin misiniz?');">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex rounded-xl border border-red-200 bg-red-50 px-4 py-2 font-semibold text-red-700 hover:bg-red-100">
                                                    Sil
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="py-8 text-center text-gray-500">Henuz tenant kaydi yok.</td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </section>
        </div>
    </main>
    <script>
        const tenantUsersPreview = @json($currentSection === 'create-user' ? $tenantUsersPreview : []);
        const tenantEditForm = document.getElementById('tenant-edit-form');
        const siteThemeSelect = document.getElementById('site-theme-select');
        const currentThemeValue = document.getElementById('current-theme-value');
        const tenantUserTenantSelect = document.getElementById('tenant-user-tenant-select');
        const tenantUserList = document.getElementById('tenant-user-list');
        const tenantUserPanelTitle = document.getElementById('tenant-user-panel-title');
        const tenantUserPanelDomain = document.getElementById('tenant-user-panel-domain');
        const tenantUserCountBadge = document.getElementById('tenant-user-count-badge');

        if (tenantEditForm && siteThemeSelect && currentThemeValue) {
            tenantEditForm.addEventListener('submit', function (event) {
                if (siteThemeSelect.value !== currentThemeValue.value) {
                    const confirmed = window.confirm('Temayi degistirmek uzeresiniz. Bu islem sitenizin tasarimi uzerinde degisiklik yapacaktir. Onayliyor musunuz?');

                    if (!confirmed) {
                        event.preventDefault();
                    }
                }
            });
        }

        if (tenantUserTenantSelect && tenantUserList && tenantUserPanelTitle && tenantUserPanelDomain && tenantUserCountBadge) {
            const renderTenantUsers = function () {
                const selectedTenant = tenantUsersPreview.find(function (tenant) {
                    return String(tenant.id) === tenantUserTenantSelect.value;
                });

                if (!selectedTenant) {
                    tenantUserPanelTitle.textContent = 'Tenant secilmedi';
                    tenantUserPanelDomain.textContent = 'Lutfen soldan bir tenant secin.';
                    tenantUserCountBadge.textContent = '0 Kullanici';
                    tenantUserList.innerHTML = '<div class="rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-5 text-sm text-gray-500">Tenant secildiginde kullanici listesi burada gorunecek.</div>';
                    return;
                }

                tenantUserPanelTitle.textContent = selectedTenant.name;
                tenantUserPanelDomain.textContent = selectedTenant.domain ? selectedTenant.domain : 'Domain tanimlanmamis';
                tenantUserCountBadge.textContent = selectedTenant.users_count + ' Kullanici';

                if (!selectedTenant.users.length) {
                    tenantUserList.innerHTML = '<div class="rounded-2xl border border-dashed border-gray-300 bg-white px-4 py-5 text-sm text-gray-500">Bu tenant icin henuz kullanici yok.</div>';
                    return;
                }

                tenantUserList.innerHTML = selectedTenant.users.map(function (user) {
                    return `
                        <div class="rounded-2xl border border-gray-200 bg-white p-4">
                            <div class="flex items-start justify-between gap-3">
                                <div>
                                    <div class="text-sm font-semibold text-gray-900">${user.username}</div>
                                    <div class="mt-1 text-xs text-gray-500">${user.role}</div>
                                </div>
                            </div>
                            <div class="mt-3 space-y-1 text-xs text-gray-600">
                                <div>${user.email}</div>
                                <div>${user.phone ? user.phone : 'Telefon bilgisi yok'}</div>
                            </div>
                        </div>
                    `;
                }).join('');
            };

            tenantUserTenantSelect.addEventListener('change', renderTenantUsers);
            renderTenantUsers();
        }
    </script>
</body>
</html>
