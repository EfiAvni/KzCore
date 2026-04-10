@php
    $pageTitle = 'Hizmetler | ' . $brandName;
    $pageDescription = 'Hizmet kartlari yonetim panelinden guncellenebilir.';
@endphp
@include('themes.oto-lastik.partials.header')

<main class="pt-36">
    <section class="section-shell">
        <div class="text-center">
            <div class="gs-reveal text-sm font-black uppercase tracking-[0.28em] text-[color:var(--color-brand-red)]">Hizmetler</div>
            <h1 class="gs-reveal mt-4 text-5xl font-black tracking-tight md:text-6xl">Atolyeden yola uzanan <span class="red-gradient">tam servis akisi</span></h1>
        </div>
        <div class="mt-14 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($services as $service)
                <div class="theme-card rounded-3xl p-8 gs-reveal">
                    <h2 class="text-2xl font-black">{{ $service['title'] }}</h2>
                    <p class="mt-4 text-sm leading-7 text-gray-400">{{ $service['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>

@include('themes.oto-lastik.partials.footer')
