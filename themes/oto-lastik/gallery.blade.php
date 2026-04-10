@php
    $pageTitle = 'Galeri | ' . $brandName;
    $pageDescription = 'Galeri gorselleri veritabanindan listelenir.';
@endphp
@include('themes.oto-lastik.partials.header')

<main class="pt-36">
    <section class="section-shell">
        <div class="text-center">
            <div class="gs-reveal text-sm font-black uppercase tracking-[0.28em] text-[color:var(--color-brand-red)]">Galeri</div>
            <h1 class="gs-reveal mt-4 text-5xl font-black tracking-tight md:text-6xl">Sahadan ve atolyeden <span class="red-gradient">gercek kareler</span></h1>
        </div>

        @if(isset($images) && count($images) > 0)
            <div class="mt-14 columns-1 gap-6 space-y-6 md:columns-2 lg:columns-3">
                @foreach($images as $image)
                    <div class="theme-card gs-reveal break-inside-avoid overflow-hidden rounded-[1.75rem] p-3">
                        <img src="{{ asset('storage/' . $image->image_path) }}" alt="{{ $image->title }}" class="h-auto w-full rounded-[1.2rem] object-cover">
                    </div>
                @endforeach
            </div>
        @else
            <div class="theme-card gs-reveal mx-auto mt-14 max-w-3xl rounded-[2rem] p-14 text-center">
                <div class="text-2xl font-black">Henuz galeri gorseli eklenmedi</div>
            </div>
        @endif
    </section>
</main>

@include('themes.oto-lastik.partials.footer')
