@php
    $pageTitle = 'Projeler | ' . $brandName;
    $pageDescription = 'Proje ve galeri sunumu.';
@endphp
@include('themes.kzcoremotion.partials.header')

<main class="motion-shell py-16 md:py-24">
    <div class="section-label">Galeri / Projeler</div>
    <h1 class="mt-4 max-w-3xl text-5xl font-black text-white md:text-6xl">Gorsel referans alanlariyla guven olusturun</h1>
    @if(isset($images) && count($images) > 0)
        <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($images as $image)
                <div class="motion-card overflow-hidden p-3">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="h-72 w-full rounded-[1.3rem] object-cover">
                </div>
            @endforeach
        </div>
    @else
        <div class="motion-card mt-12 p-12 text-white/72">Henuz galeri gorseli eklenmedi.</div>
    @endif
</main>

@include('themes.kzcoremotion.partials.footer')
