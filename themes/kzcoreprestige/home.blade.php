@php
    $pageTitle = $brandName . ' | KzCorePrestige';
    $pageDescription = 'Premium kurumsal hizmet firmalari icin sade ama luks hisli tema.';
    $referenceItems = [
        'Uzun soluklu is ortakliklari',
        'Surec odakli proje yonetimi',
        'Guven veren operasyon standardi',
    ];
@endphp
@include('themes.kzcoreprestige.partials.header')

<main>
    <section class="prestige-shell pt-16 pb-24 lg:pt-24">
        <div class="grid items-center gap-10 lg:grid-cols-[1.05fr_0.95fr]">
            <div class="text-white">
                <div class="section-eyebrow">Premium Kurumsal Sunum</div>
                <h1 class="mt-6 max-w-4xl font-serif text-5xl font-bold leading-tight md:text-7xl">
                    Guven veren, sade ve luks hisli bir
                    <span class="text-[#d6b07a]">kurumsal vitrin</span>.
                </h1>
                <p class="mt-6 max-w-2xl text-lg leading-8 text-white/72">
                    KzCorePrestige temasi; hizmet firmalari icin premium algi, genis bosluklar, kontrollu vurgu renkleri ve guclu tipografi ile kurumsal guveni one cikarir.
                </p>
                <div class="mt-10 flex flex-col gap-4 sm:flex-row">
                    <a href="{{ route('theme.services') }}" class="prestige-button">Hizmetleri Incele</a>
                    <a href="{{ route('theme.contact') }}" class="prestige-outline">Iletisime Gec</a>
                </div>
            </div>
            <div class="prestige-card overflow-hidden bg-white/90 p-4">
                <div class="rounded-[1.6rem] bg-[linear-gradient(135deg,#12213d_0%,#1b2d50_60%,#e9dcc7_160%)] p-8 text-white">
                    <div class="section-eyebrow">Kurumsal Bakis</div>
                    <div class="mt-4 font-serif text-3xl font-bold">Guvenilir hizmet, olgun gorunum, net mesaj.</div>
                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="text-xs uppercase tracking-[0.28em] text-white/55">Iletisim</div>
                            <div class="mt-3 text-lg font-semibold">{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</div>
                        </div>
                        <div class="rounded-2xl border border-white/10 bg-white/5 p-5">
                            <div class="text-xs uppercase tracking-[0.28em] text-white/55">E-Posta</div>
                            <div class="mt-3 text-lg font-semibold break-words">{{ $siteSettings['email'] ?? 'E-posta bilginizi ekleyin' }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#f5f1e8] py-24">
        <div class="prestige-shell">
            <div class="section-eyebrow">Hizmetler</div>
            <div class="mt-4 flex flex-col gap-4 lg:flex-row lg:items-end lg:justify-between">
                <h2 class="max-w-3xl font-serif text-4xl font-bold text-slate-900 md:text-5xl">Kurumsal guveni destekleyen temel hizmet basliklari</h2>
                <p class="max-w-xl text-sm leading-8 text-slate-600">Hizmet kartlari veritabanindan gelir; tema sadece premium sunum katmanini saglar.</p>
            </div>
            <div class="mt-12 grid gap-6 lg:grid-cols-3">
                @foreach($featuredServices as $service)
                    <div class="prestige-card p-8">
                        <div class="text-xs font-bold uppercase tracking-[0.32em] text-[#b78d52]">0{{ $loop->iteration }}</div>
                        <h3 class="mt-5 font-serif text-2xl font-bold text-slate-900">{{ $service['title'] }}</h3>
                        <p class="mt-4 text-sm leading-8 text-slate-600">{{ $service['text'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white py-24">
        <div class="prestige-shell grid gap-10 lg:grid-cols-[0.95fr_1.05fr]">
            <div class="prestige-card overflow-hidden">
                <div class="h-full rounded-[2rem] bg-[linear-gradient(160deg,#0f1c35_0%,#243657_100%)] p-10 text-white">
                    <div class="section-eyebrow">Hakkimizda</div>
                    <h2 class="mt-4 font-serif text-4xl font-bold">Sade ama iddiali kurumsal anlatim</h2>
                    <p class="mt-6 text-sm leading-8 text-white/72">{{ $aboutText }}</p>
                </div>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                <div class="prestige-card p-8">
                    <div class="text-4xl font-bold text-[#b78d52]">12+</div>
                    <div class="mt-3 text-sm uppercase tracking-[0.24em] text-slate-500">Basari Gostergesi</div>
                    <p class="mt-4 text-sm leading-8 text-slate-600">Bu bloklar premium kurumsal anlatimi destekleyen istatistik alanlari olarak kullanilir.</p>
                </div>
                <div class="prestige-card p-8">
                    <div class="text-4xl font-bold text-[#b78d52]">%98</div>
                    <div class="mt-3 text-sm uppercase tracking-[0.24em] text-slate-500">Guven Hissi</div>
                    <p class="mt-4 text-sm leading-8 text-slate-600">Sektorel guven, uzun vadeli iliski ve sureklilik algisini guclendiren premium blok.</p>
                </div>
                <div class="prestige-card p-8 md:col-span-2">
                    <div class="section-eyebrow">Referanslar</div>
                    <div class="mt-5 grid gap-4 md:grid-cols-3">
                        @foreach($referenceItems as $referenceItem)
                            <div class="rounded-2xl border border-slate-200 bg-slate-50 px-5 py-6 text-sm font-semibold text-slate-700">
                                {{ $referenceItem }}
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-[#eef1f5] py-24">
        <div class="prestige-shell">
            <div class="prestige-card overflow-hidden bg-[linear-gradient(135deg,#0f1b34_0%,#1d2c4d_58%,#63513a_180%)] p-10 text-white md:p-14">
                <div class="section-eyebrow">Iletisim CTA</div>
                <div class="mt-4 grid gap-8 lg:grid-cols-[1fr_auto] lg:items-center">
                    <div>
                        <h2 class="font-serif text-4xl font-bold md:text-5xl">Kurumsal iletisimi premium bir ilk izlenime donusturun.</h2>
                        <p class="mt-5 max-w-2xl text-sm leading-8 text-white/74">
                            Telefon, e-posta ve adres bilgileri veritabanindan gelir; bu alanlar panelden guncellendikce tema ayni premium tasarim diliyle sunmaya devam eder.
                        </p>
                    </div>
                    <div class="flex flex-col gap-4">
                        <a href="tel:{{ $siteSettings['phone_1'] ?? '#' }}" class="prestige-button">{{ $siteSettings['phone_1'] ?? 'Telefon bilginizi ekleyin' }}</a>
                        <a href="{{ route('theme.contact') }}" class="prestige-outline">Iletisim Sayfasi</a>
                    </div>
                </div>
            </div>
        </div>
    </section>
</main>

@include('themes.kzcoreprestige.partials.footer')
