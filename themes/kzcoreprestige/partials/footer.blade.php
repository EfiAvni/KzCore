@php($siteSettings = $siteSettings ?? [])
    <footer class="mt-24 bg-[#0c1529] py-16 text-white">
        <div class="prestige-shell">
            <div class="grid gap-12 lg:grid-cols-[1.2fr_0.8fr_1fr]">
                <div>
                    <div class="section-eyebrow">Kurumsal Durus</div>
                    <div class="mt-4 font-serif text-3xl font-bold">{{ $brandName }}</div>
                    <p class="mt-5 max-w-md text-sm leading-8 text-white/68">
                        Premium kurumsal sunum icin tasarlanmis bu tema, veritabanindaki marka icerikleriyle otomatik sekilde zenginlesir.
                    </p>
                </div>
                <div>
                    <div class="section-eyebrow">Hizli Erisim</div>
                    <div class="mt-5 flex flex-col gap-3 text-sm text-white/68">
                        <a href="{{ route('theme.home') }}" class="hover:text-white">Anasayfa</a>
                        <a href="{{ route('theme.services') }}" class="hover:text-white">Hizmetler</a>
                        <a href="{{ route('theme.about') }}" class="hover:text-white">Hakkimizda</a>
                        <a href="{{ route('theme.gallery') }}" class="hover:text-white">Galeri</a>
                        <a href="{{ route('theme.contact') }}" class="hover:text-white">Iletisim</a>
                    </div>
                </div>
                <div>
                    <div class="section-eyebrow">Iletisim</div>
                    <div class="mt-5 space-y-3 text-sm text-white/68">
                        <div>{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                        <div>{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                        <div>{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-14 border-t border-white/10 pt-6 text-sm text-white/45">
                &copy; {{ date('Y') }} {{ $brandName }}. KzCorePrestige theme.
            </div>
        </div>
    </footer>
</body>
</html>
