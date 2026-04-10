@php($pageTitle = 'Endustriyel Theme Services')
@include('themes.endustriyel.partials.header')
<main class="shell py-16">
    <section class="panel p-10">
        <h1 class="text-4xl font-black">Services</h1>
        <div class="mt-8 grid gap-4 md:grid-cols-2">
            @foreach($services as $service)
                <div class="rounded-3xl border border-white/10 bg-white/5 p-6">
                    <div class="text-xl font-bold">{{ $service['title'] }}</div>
                    <p class="mt-3 text-slate-300">{{ $service['text'] }}</p>
                </div>
            @endforeach
        </div>
    </section>
</main>
@include('themes.endustriyel.partials.footer')
