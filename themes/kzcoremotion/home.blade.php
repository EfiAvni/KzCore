@php
    $pageTitle = $brandName . ' | KzCoreMotion';
    $pageDescription = 'Modern, guclu ve donusum odakli hizmet firmasi temasi.';
    $whyUsItems = [
        'Hizli geri donus ve net teklif sureci',
        'Yerel pazara uygun operasyon mantigi',
        'Mobilde guclu kullanilabilirlik',
    ];
    $reviews = [
        ['name' => 'Musteri Yorumu', 'text' => 'Hizmet sureci hizli, iletisim net ve sonuc odakliydi.'],
        ['name' => 'Kurumsal Referans', 'text' => 'Zamanlama ve operasyon kalitesi beklentimizi karsiladi.'],
    ];
    $faqs = [
        ['q' => 'Ne kadar hizli geri donus saglaniyor?', 'a' => 'Iletisim bilgileri ve teklif akisiniz panele girildiginde bu alan gercek sureclerinizle guncellenebilir.'],
        ['q' => 'Mobilde kullanimi nasil?', 'a' => 'Tema mobil aksiyonlari one cikaracak sekilde buyuk butonlar ve net bloklarla tasarlandi.'],
    ];
@endphp
@include('themes.kzcoremotion.partials.header')

<main>
    <section class="motion-shell pt-16 pb-24 lg:pt-24">
        <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
            <div>
                <div class="section-label">Daha Fazla Arama, Daha Fazla Talep</div>
                <h1 class="mt-5 max-w-4xl text-5xl font-black leading-[1.05] md:text-7xl">
                    Hizmet odakli isletmeler icin
                    <span class="text-[#ff6a3d]">guclu ve modern</span>
                    bir dijital vitrin.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-white/72">
                    KzCoreMotion; buyuk CTA alanlari, guclu kart bloklari, belirgin telefon ve WhatsApp aksiyonlariyla yerel hizmet firmalarini donusume tasir.
                </p>
                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="motion-cta">Telefonla Ulas</a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['phone_1'] ?? '') }}" class="motion-cta-blue">WhatsApp Yaz</a>
                </div>
            </div>
            <div class="motion-card overflow-hidden p-4">
                <div class="rounded-[1.4rem] bg-[linear-gradient(145deg,#232936_0%,#20242e_55%,#0c89d8_180%)] p-8">
                    <div class="grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="text-xs uppercase tracking-[0.28em] text-white/50">Hizli Arama</div>
                            <div class="mt-3 text-xl font-black">{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="text-xs uppercase tracking-[0.28em] text-white/50">Iletisim</div>
                            <div class="mt-3 text-xl font-black break-words">{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                        </div>
                    </div>
                    <div class="mt-6 rounded-2xl border border-white/10 bg-black/20 p-6">
                        <div class="section-label">Hizmet Mesaji</div>
                        <div class="mt-3 text-2xl font-black text-white">Hizli aksiyon, net anlatim, guclu gorunuruluk.</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#f7f7f8] py-24 text-slate-900">
        <div class="motion-shell">
            <div class="section-label">Hizmetler</div>
            <h2 class="mt-4 max-w-3xl text-4xl font-black md:text-5xl">Hizmet odakli bloklar ile net anlati</h2>
            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach($featuredServices as $service)
                    <div class="motion-light-card p-8">
                        <div class="text-sm font-black uppercase tracking-[0.3em] text-[#ff6a3d]">0{{ $loop->iteration }}</div>
                        <h3 class="mt-4 text-2xl font-black text-slate-900">{{ $service['title'] }}</h3>
                        <p class="mt-4 text-sm leading-8 text-slate-600">{{ $service['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-24 text-slate-900">
        <div class="motion-shell grid gap-10 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="motion-light-card p-10">
                <div class="section-label">Neden Biz</div>
                <h2 class="mt-4 text-4xl font-black">Yerel guc, hizli iletisim, net sonuc</h2>
                <p class="mt-6 text-sm leading-8 text-slate-600">{{ $aboutText }}</p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach($whyUsItems as $item)
                    <div class="motion-light-card p-8">
                        <div class="text-lg font-black text-slate-900">{{ $item }}</div>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-[#eef3f8] py-24 text-slate-900">
        <div class="motion-shell">
            <div class="flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <div>
                    <div class="section-label">Galeri / Projeler</div>
                    <h2 class="mt-4 text-4xl font-black md:text-5xl">Islerinizden guclu kareler</h2>
                </div>
                <a href="{{ route('theme.gallery') }}" class="motion-cta">Tum Projeleri Gor</a>
            </div>
            <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
                @forelse($galleryPreview as $image)
                    <div class="motion-light-card overflow-hidden p-3">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="h-72 w-full rounded-[1.3rem] object-cover">
                    </div>
                @empty
                    <div class="motion-light-card p-10 md:col-span-2 xl:col-span-3">Henuz proje veya galeri gorseli eklenmedi.</div>
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white py-24 text-slate-900">
        <div class="motion-shell grid gap-10 lg:grid-cols-2">
            <div>
                <div class="section-label">Yorumlar</div>
                <div class="mt-8 space-y-6">
                    @foreach($reviews as $review)
                        <div class="motion-light-card p-8">
                            <div class="text-lg font-black">{{ $review['name'] }}</div>
                            <p class="mt-4 text-sm leading-8 text-slate-600">{{ $review['text'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
            <div>
                <div class="section-label">Sik Sorulan Sorular</div>
                <div class="mt-8 space-y-4">
                    @foreach($faqs as $faq)
                        <div class="motion-light-card p-8">
                            <div class="text-lg font-black">{{ $faq['q'] }}</div>
                            <p class="mt-4 text-sm leading-8 text-slate-600">{{ $faq['a'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#1b1d24] py-24">
        <div class="motion-shell grid gap-6 lg:grid-cols-[1fr_0.95fr]">
            <div class="motion-card p-10">
                <div class="section-label">Iletisim</div>
                <h2 class="mt-4 text-4xl font-black text-white">Hizli iletisim alanlari ile donusumu guclendir</h2>
                <div class="mt-8 space-y-4 text-white/78">
                    <div>{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                    <div>{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                    <div>{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                </div>
                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="motion-cta">Telefon</a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['phone_1'] ?? '') }}" class="motion-cta-blue">WhatsApp</a>
                </div>
            </div>
            <div class="motion-card overflow-hidden p-4">
                <div class="flex h-full min-h-80 items-center justify-center rounded-[1.4rem] border border-dashed border-white/10 bg-white/5 text-center text-sm leading-8 text-white/58">
                    Harita alani placeholder olarak hazir. Google Maps veya embed kodu ile sonradan baglanabilir.
                </div>
            </div>
        </div>
    </section>
</main>

@include('themes.kzcoremotion.partials.footer')
