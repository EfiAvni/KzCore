@php
    $pageTitle = 'Neden Biz | ' . $brandName;
    $pageDescription = 'Neden bizi tercih etmelisiniz sayfasi.';
@endphp
@include('themes.kzcoremotion.partials.header')

<main class="motion-shell py-16 md:py-24">
    <section class="motion-light-card p-10 md:p-14 text-slate-900">
        <div class="section-label">Neden Biz</div>
        <h1 class="mt-4 text-5xl font-black">Yerel guc ve net hizmet durusu</h1>
        <p class="mt-6 text-lg leading-9 text-slate-600">{{ $aboutText }}</p>
    </section>
</main>

@include('themes.kzcoremotion.partials.footer')
