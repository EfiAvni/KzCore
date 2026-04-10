<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\Tenant;
use Illuminate\Contracts\View\View;

class ThemeController extends Controller
{
    protected function currentTenant(): ?Tenant
    {
        if (app()->bound('currentTenant')) {
            return app('currentTenant');
        }

        return null;
    }

    protected function currentTheme(): string
    {
        $theme = $this->currentTenant()?->theme_code ?? 'classic';

        // Geriye donuk uyumluluk: DB default classic olsa da mevcut tasarim oto-lastik klasorunde.
        return $theme === 'classic' ? 'oto-lastik' : $theme;
    }

    protected function themedView(string $page): string
    {
        return 'themes.' . $this->currentTheme() . '.' . $page;
    }

    protected function contentSettings(): array
    {
        return Setting::allForTenant($this->currentTenant()?->id);
    }

    protected function serviceItems(array $settings): array
    {
        $defaultServices = [
            ['title' => 'Lastik Degisimi', 'text' => 'Yazlik-kislik gecisleri ve yeni alimlar icin hizli montaj.'],
            ['title' => 'Lastik Tamiri', 'text' => 'Patlak ve yuzey hasarlarinda profesyonel onarim kontrolu.'],
            ['title' => 'Rot Balans', 'text' => 'Surus konforunu artiran hassas olcum ve ayarlama.'],
        ];

        $decoded = json_decode($settings['services_json'] ?? '', true);

        if (! is_array($decoded) || empty($decoded)) {
            return $defaultServices;
        }

        return collect($decoded)
            ->filter(fn ($item) => is_array($item) && filled($item['title'] ?? null) && filled($item['text'] ?? null))
            ->map(fn ($item) => [
                'title' => (string) $item['title'],
                'text' => (string) $item['text'],
            ])
            ->values()
            ->all() ?: $defaultServices;
    }

    protected function sharedContent(): array
    {
        $settings = $this->contentSettings();
        $services = $this->serviceItems($settings);
        $galleryPreview = GalleryItem::query()
            ->when($this->currentTenant()?->id, fn ($query, $tenantId) => $query->where('tenant_id', $tenantId))
            ->latest()
            ->take(3)
            ->get();

        return [
            'brandName' => $this->currentTenant()?->name ?: 'Marka Adi',
            'aboutText' => $settings['about_text'] ?? 'Isletmeniz hakkindaki tanitim yazisini sistem ayarlarindan guncelleyebilirsiniz.',
            'services' => $services,
            'featuredServices' => array_slice($services, 0, 3),
            'galleryPreview' => $galleryPreview,
        ];
    }

    public function home(): View
    {
        return view($this->themedView('home'), $this->sharedContent());
    }

    public function about(): View
    {
        return view($this->themedView('about'), $this->sharedContent());
    }

    public function services(): View
    {
        return view($this->themedView('services'), $this->sharedContent());
    }

    public function contact(): View
    {
        return view($this->themedView('contact'), $this->sharedContent());
    }

    public function gallery(): View
    {
        $images = GalleryItem::query()
            ->when($this->currentTenant()?->id, fn ($query, $tenantId) => $query->where('tenant_id', $tenantId))
            ->latest()
            ->get();

        return view($this->themedView('gallery'), array_merge($this->sharedContent(), compact('images')));
    }
}
