@php
    $pageTitle = 'Galeri | ' . $brandName;
    $pageDescription = 'Kurumsal galeri sunumu.';
@endphp
@include('themes.kzcoreprestige.partials.header')

<main class="prestige-shell py-16 md:py-24">
    <div class="section-eyebrow">Galeri</div>
    <h1 class="mt-4 max-w-3xl font-serif text-5xl font-bold text-white md:text-6xl">Referans niteligindeki gorsel sunum alani</h1>

    @if(isset($images) && count($images) > 0)
        <div class="mt-12 grid gap-6 md:grid-cols-2 xl:grid-cols-3">
            @foreach($images as $image)
                <div class="prestige-card overflow-hidden p-3">
                    <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="h-72 w-full rounded-[1.4rem] object-cover">
                </div>
            @endforeach
        </div>
    @else
        <div class="prestige-card mt-12 p-12 text-center text-slate-600">
            Henuz galeri gorseli eklenmedi.
        </div>
    @endif
</main>

@include('themes.kzcoreprestige.partials.footer')
