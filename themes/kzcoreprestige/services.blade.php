@php
    $pageTitle = 'Hizmetler | ' . $brandName;
    $pageDescription = 'Premium hizmet kartlari.';
@endphp
@include('themes.kzcoreprestige.partials.header')

<main class="prestige-shell py-16 md:py-24">
    <div class="section-eyebrow">Hizmetler</div>
    <h1 class="mt-4 max-w-3xl font-serif text-5xl font-bold text-white md:text-6xl">Kurumsal guveni destekleyen hizmet mimarisi</h1>
    <div class="mt-12 grid gap-6 lg:grid-cols-3">
        @foreach($services as $service)
            <div class="prestige-card p-8">
                <div class="section-eyebrow">Hizmet</div>
                <h2 class="mt-4 font-serif text-3xl font-bold text-slate-900">{{ $service['title'] }}</h2>
                <p class="mt-5 text-sm leading-8 text-slate-600">{{ $service['text'] }}</p>
            </div>
        @endforeach
    </div>
</main>

@include('themes.kzcoreprestige.partials.footer')
