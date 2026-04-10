@php
    $pageTitle = 'Iletisim | ' . $brandName;
    $pageDescription = 'Premium iletisim sayfasi.';
@endphp
@include('themes.kzcoreprestige.partials.header')

<main class="prestige-shell py-16 md:py-24">
    <section class="prestige-card overflow-hidden">
        <div class="grid lg:grid-cols-[1fr_0.9fr]">
            <div class="p-10 md:p-14">
                <div class="section-eyebrow">Iletisim</div>
                <h1 class="mt-4 font-serif text-5xl font-bold text-slate-900">Markanizla iletisime gecmenin premium yolu</h1>
                <div class="mt-8 space-y-5 text-base text-slate-700">
                    <div>{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                    <div>{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                    <div>{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                </div>
            </div>
            <div class="bg-[linear-gradient(160deg,#10203c_0%,#1e3157_100%)] p-10 text-white md:p-14">
                <div class="section-eyebrow">CTA</div>
                <p class="mt-4 text-lg leading-9 text-white/76">
                    Bu alan, kurumsal guven ve hizli iletisim hissini yuksek bosluk kullanimi ve premium tonlarla destekler.
                </p>
            </div>
        </div>
    </section>
</main>

@include('themes.kzcoreprestige.partials.footer')
