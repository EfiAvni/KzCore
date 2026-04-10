@php
    $pageTitle = 'Hakkimizda | ' . $brandName;
    $pageDescription = 'Hakkimizda icerigi yonetim panelinden ozellestirilebilir.';
@endphp
@include('themes.oto-lastik.partials.header')

<main class="pt-36">
    <section class="section-shell">
        <div class="page-hero theme-card rounded-[2rem] px-8 py-16 md:px-14">
            <div class="max-w-4xl">
                <div class="gs-reveal text-sm font-black uppercase tracking-[0.28em] text-[color:var(--color-brand-red)]">Hakkimizda</div>
                <h1 class="gs-reveal mt-4 text-5xl font-black tracking-tight md:text-6xl">Guven veren servis kulturunu <span class="red-gradient">sahada kurduk</span>.</h1>
                <p class="gs-reveal mt-6 max-w-3xl text-lg leading-8 text-gray-400">
                    {{ $aboutText }}
                </p>
            </div>
        </div>
    </section>
</main>

@include('themes.oto-lastik.partials.footer')
