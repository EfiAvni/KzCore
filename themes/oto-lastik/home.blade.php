@php
    $pageTitle = $brandName . ' | Ana Sayfa';
    $pageDescription = 'Tema gorunumu hazir. Icerikleri yonetim panelinden ozellestirebilirsiniz.';
@endphp
@include('themes.oto-lastik.partials.header')

<main>
    <section class="page-hero min-h-screen pt-40 pb-24">
        <div class="section-shell">
            <div class="grid items-center gap-14 lg:grid-cols-[1.15fr_0.85fr]">
                <div class="relative z-10">
                    <div class="gs-reveal inline-flex items-center gap-2 rounded-full border border-white/10 bg-white/5 px-4 py-2 text-xs uppercase tracking-[0.28em] text-gray-300">
                        Tema onizleme alani
                    </div>
                    <h1 class="gs-reveal mt-8 text-5xl font-black leading-tight tracking-tight md:text-7xl">
                        Ustalikla
                        <span class="red-gradient">yola hazir</span>
                        kurumsal gorunume.
                    </h1>
                    <p class="gs-reveal mt-6 max-w-2xl text-lg leading-8 text-gray-400">
                        Bu alanlar varsayilan tema metinleridir. Marka bilgileri, iletisim icerikleri ve hizmet detaylari yonetim panelinden girildikce site otomatik olarak guncellenir.
                    </p>
                    <div class="gs-reveal mt-10 flex flex-col gap-4 sm:flex-row">
                        <a href="{{ route('theme.services') }}" class="btn-primary">Hizmetleri Incele</a>
                        <a href="{{ route('theme.contact') }}" class="btn-secondary">Iletisime Gec</a>
                    </div>
                </div>
                <div class="gs-reveal theme-card rounded-[2rem] p-6">
                    <img src="/images/tire.png" alt="Tema Gorseli" class="mx-auto w-full max-w-md object-contain drop-shadow-[0_30px_40px_rgba(0,0,0,0.6)]">
                </div>
            </div>
        </div>
    </section>

    <section class="pb-8">
        <div class="section-shell grid gap-6 md:grid-cols-3">
            @foreach($featuredServices as $service)
                <div class="theme-card rounded-3xl p-8 gs-reveal">
                    <div class="text-4xl font-black text-[color:var(--color-brand-red)]">{{ str_pad((string) ($loop->iteration), 2, '0', STR_PAD_LEFT) }}</div>
                    <div class="mt-3 text-lg font-bold">{{ $service['title'] }}</div>
                    <p class="mt-3 text-sm leading-7 text-gray-400">{{ $service['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>

@include('themes.oto-lastik.partials.footer')
