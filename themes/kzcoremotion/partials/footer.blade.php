@php($siteSettings = $siteSettings ?? [])
    <footer class="bg-[#151821] py-16 text-white">
        <div class="motion-shell">
            <div class="grid gap-10 lg:grid-cols-[1.2fr_0.8fr_1fr]">
                <div>
                    <div class="section-label">Yerel Hizmet Gucu</div>
                    <div class="mt-4 text-3xl font-black">{{ $brandName }}</div>
                    <p class="mt-5 max-w-md text-sm leading-8 text-white/65">
                        KzCoreMotion, hizli iletisim ve donusum odakli modern kurumsal vitrinler icin tasarlandi.
                    </p>
                </div>
                <div>
                    <div class="section-label">Menu</div>
                    <div class="mt-5 flex flex-col gap-3 text-sm text-white/68">
                        <a href="{{ route('theme.home') }}" class="hover:text-white">Anasayfa</a>
                        <a href="{{ route('theme.services') }}" class="hover:text-white">Hizmetler</a>
                        <a href="{{ route('theme.gallery') }}" class="hover:text-white">Projeler</a>
                        <a href="{{ route('theme.contact') }}" class="hover:text-white">Iletisim</a>
                    </div>
                </div>
                <div>
                    <div class="section-label">Hizli Iletisim</div>
                    <div class="mt-5 space-y-3 text-sm text-white/68">
                        <div>{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                        <div>{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                        <div>{{ $siteSettings['address'] ?? 'Adres bilginizi yonetim panelinden ekleyin.' }}</div>
                    </div>
                </div>
            </div>
            <div class="mt-12 border-t border-white/10 pt-6 text-sm text-white/40">
                &copy; {{ date('Y') }} {{ $brandName }}. KzCoreMotion theme.
            </div>
        </div>
</body>
</html>
