@php
    $pageTitle = 'Hizmetler | ' . $brandName;
    $pageDescription = 'Hizmet odakli modern hizmet listesi.';
@endphp
@include('themes.kzcoremotion.partials.header')

<main class="motion-shell py-16 md:py-24">
    <div class="section-label">Hizmetler</div>
    <h1 class="mt-4 max-w-3xl text-5xl font-black text-white md:text-6xl">Her hizmet alanini net CTA ile one cikar</h1>
    <div class="mt-12 grid gap-6 lg:grid-cols-3">
        @foreach($services as $service)
            <div class="motion-card p-8">
                <div class="text-sm font-black uppercase tracking-[0.28em] text-[#ff6a3d]">Hizmet</div>
                <h2 class="mt-4 text-3xl font-black text-white">{{ $service['title'] }}</h2>
                <p class="mt-5 text-sm leading-8 text-white/72">{{ $service['text'] }}</p>
            </div>
        @endforeach
    </div>
</main>

@include('themes.kzcoremotion.partials.footer')
