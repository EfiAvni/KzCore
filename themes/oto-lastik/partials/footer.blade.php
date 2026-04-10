    @php($siteSettings = $siteSettings ?? [])
    <footer class="border-t border-white/8 bg-black/60 pt-16 pb-10 mt-24">
        <div class="section-shell">
            <div class="grid gap-10 md:grid-cols-3">
                <div>
                    @if(!empty($siteSettings['site_logo']))
                        <img src="{{ asset('storage/' . $siteSettings['site_logo']) }}" alt="Logo" class="h-16 w-auto object-contain rounded-xl bg-white/5 p-2 border border-white/10">
                    @else
                        <div class="flex h-16 w-16 items-center justify-center rounded-xl border border-white/10 bg-white/5 text-[0.65rem] font-bold uppercase tracking-[0.25em] text-gray-300">Logo</div>
                    @endif
                    <p class="mt-5 max-w-sm text-sm leading-7 text-gray-400">Bu alandaki aciklama, logo ve iletisim bilgileri yonetim panelinden ozellestirilebilir.</p>
                </div>
                <div>
                    <h3 class="text-sm font-black uppercase tracking-[0.24em] text-white">Hizli Menu</h3>
                    <div class="mt-5 flex flex-col gap-3 text-sm text-gray-400">
                        <a href="{{ route('theme.home') }}" class="hover:text-white">Anasayfa</a>
                        <a href="{{ route('theme.about') }}" class="hover:text-white">Hakkimizda</a>
                        <a href="{{ route('theme.services') }}" class="hover:text-white">Hizmetler</a>
                        <a href="{{ route('theme.gallery') }}" class="hover:text-white">Galeri</a>
                        <a href="{{ route('theme.contact') }}" class="hover:text-white">Iletisim</a>
                    </div>
                </div>
                <div>
                    <h3 class="text-sm font-black uppercase tracking-[0.24em] text-white">Iletisim</h3>
                    <div class="mt-5 space-y-3 text-sm text-gray-400">
                        <div>{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                        <div><a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="hover:text-white">{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</a></div>
                        <div><a href="mailto:{{ $siteSettings['email'] ?? 'ornek@markaadi.com' }}" class="hover:text-white">{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</a></div>
                    </div>
                </div>
            </div>
            <div class="mt-12 flex flex-col gap-2 border-t border-white/8 pt-6 text-sm text-gray-500 md:flex-row md:items-center md:justify-between">
                <div>&copy; {{ date('Y') }} {{ $brandName }}</div>
                <div>Theme: <span class="text-[color:var(--color-brand-red)]">oto-lastik</span></div>
            </div>
        </div>
    </footer>
    <script>
        if (window.gsap && window.ScrollTrigger) {
            gsap.registerPlugin(ScrollTrigger);
            gsap.utils.toArray('.gs-reveal').forEach(function (elem, index) {
                gsap.fromTo(elem, { y: 40, opacity: 0 }, {
                    y: 0,
                    opacity: 1,
                    duration: 0.8,
                    delay: index * 0.06,
                    ease: 'power3.out',
                    scrollTrigger: {
                        trigger: elem,
                        start: 'top 88%',
                    }
                });
            });
        }
    </script>
</body>
</html>
