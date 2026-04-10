@php($pageTitle = 'Endustriyel Theme About')
@include('themes.endustriyel.partials.header')
<main class="shell py-16">
    <section class="panel p-10">
        <h1 class="text-4xl font-black">About</h1>
        <p class="mt-4 text-slate-300">{{ $aboutText }}</p>
    </section>
</main>
@include('themes.endustriyel.partials.footer')
