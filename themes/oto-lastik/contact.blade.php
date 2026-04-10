@php
    $pageTitle = 'Iletisim | ' . $brandName;
    $pageDescription = 'Iletisim bilgileri yonetim panelinden ozellestirilebilir.';
@endphp
@include('themes.oto-lastik.partials.header')

<main class="pt-36">
    <section class="section-shell">
        <div class="grid gap-6 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="theme-card page-hero rounded-[2rem] p-10 md:p-14">
                <div class="gs-reveal text-sm font-black uppercase tracking-[0.28em] text-[color:var(--color-brand-red)]">Iletisim</div>
                <h1 class="gs-reveal mt-4 text-5xl font-black tracking-tight md:text-6xl">Yola cikmadan once <span class="red-gradient">bize ulasin</span>.</h1>
                <p class="gs-reveal mt-6 max-w-2xl text-lg leading-8 text-gray-400">Adres, telefon ve e-posta bilgileri tenant ayarlarindan cekiliyor.</p>
                <div class="gs-reveal mt-10 flex flex-col gap-4">
                    <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="btn-primary w-fit">{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</a>
                    <a href="mailto:{{ $siteSettings['email'] ?? 'ornek@markaadi.com' }}" class="text-lg text-gray-300 hover:text-white">{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</a>
                </div>
            </div>
            <div class="theme-card rounded-[2rem] p-10">
                <div class="gs-reveal space-y-6">
                    <div>
                        <div class="text-xs font-black uppercase tracking-[0.25em] text-gray-500">Adres</div>
                        <div class="mt-2 text-lg leading-8 text-gray-300">{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                    </div>
                    <div>
                        <div class="text-xs font-black uppercase tracking-[0.25em] text-gray-500">Calisma Saatleri</div>
                        <div class="mt-2 text-lg leading-8 text-gray-300">Pazartesi - Cumartesi: 08:00 - 19:00</div>
                        <div class="text-lg leading-8 text-gray-300">Pazar: 10:00 - 18:00</div>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('themes.oto-lastik.partials.footer')
