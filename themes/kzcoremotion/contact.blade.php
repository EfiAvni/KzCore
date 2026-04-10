@php
    $pageTitle = 'Iletisim | ' . $brandName;
    $pageDescription = 'Hizli iletisim odakli sayfa.';
@endphp
@include('themes.kzcoremotion.partials.header')

<main class="motion-shell py-16 md:py-24">
    <section class="motion-light-card overflow-hidden text-slate-900">
        <div class="grid lg:grid-cols-[1fr_0.9fr]">
            <div class="p-10 md:p-14">
                <div class="section-label">Iletisim</div>
                <h1 class="mt-4 text-5xl font-black">Bize hizli ulasin</h1>
                <div class="mt-8 space-y-4 text-base text-slate-700">
                    <div>{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                    <div>{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                    <div>{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                </div>
                <div class="mt-8 flex flex-col gap-4 sm:flex-row">
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="motion-cta">Telefon</a>
                    <a href="https://wa.me/{{ preg_replace('/[^0-9]/', '', $siteSettings['phone_1'] ?? '') }}" class="motion-cta-blue">WhatsApp</a>
                </div>
            </div>
            <div class="bg-[linear-gradient(145deg,#232936_0%,#1b1d24_70%,#0c89d8_170%)] p-10 text-white md:p-14">
                <div class="section-label">Harita</div>
                <p class="mt-4 text-lg leading-9 text-white/72">Harita alani bu temada da hizli ulasim hissini destekleyen gorunumsel bir blok olarak hazir.</p>
            </div>
        </div>
    </section>
</main>

@include('themes.kzcoremotion.partials.footer')
