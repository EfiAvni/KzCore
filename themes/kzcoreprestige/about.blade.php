@php
    $pageTitle = 'Hakkimizda | ' . $brandName;
    $pageDescription = 'Kurumsal hakkimizda sayfasi.';
@endphp
@include('themes.kzcoreprestige.partials.header')

<main class="prestige-shell py-16 md:py-24">
    <section class="prestige-card overflow-hidden">
        <div class="grid lg:grid-cols-[0.95fr_1.05fr]">
            <div class="bg-[linear-gradient(160deg,#0f1c35_0%,#223252_100%)] p-10 text-white md:p-14">
                <div class="section-eyebrow">Hakkimizda</div>
                <h1 class="mt-4 font-serif text-5xl font-bold leading-tight">Guvenin arkasindaki kurumsal durus</h1>
            </div>
            <div class="p-10 md:p-14">
                <p class="text-lg leading-9 text-slate-700">{{ $aboutText }}</p>
            </div>
        </div>
    </section>
</main>

@include('themes.kzcoreprestige.partials.footer')
