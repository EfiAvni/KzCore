<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use App\Models\Tenant;
use App\Models\TenantDomain;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class SuperAdminController extends Controller
{
    protected function ensureSuperAdmin()
    {
        $user = Auth::user();

        if (! $user) {
            abort(401);
        }

        if (! $user->isSuperAdmin()) {
            return redirect()->route('admin.dashboard');
        }

        return null;
    }

    public function dashboard(Request $request)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        $tenants = Tenant::with([
            'settings',
            'domains',
            'users' => fn ($query) => $query->select('id', 'tenant_id', 'username', 'email', 'phone', 'role')->latest(),
        ])->withCount('users')->latest()->get();
        $editingTenant = null;

        if ($request->filled('tenant')) {
            $editingTenant = $tenants->firstWhere('id', (int) $request->integer('tenant'));
        }

        return view('kzcore.dashboard', [
            'tenants' => $tenants,
            'editingTenant' => $editingTenant,
            'activeSection' => $editingTenant ? 'edit-tenant' : $request->string('section', 'overview')->value(),
            'tenantCount' => $tenants->count(),
            'activeTenantCount' => $tenants->where('status', 'active')->count(),
            'configuredDomainCount' => $tenants->whereNotNull('domain')->count(),
            'tenantUserCount' => User::query()->where('role', User::ROLE_TENANT_ADMIN)->count(),
            'superAdminCount' => User::query()->where('role', User::ROLE_SUPER_ADMIN)->count(),
            'statusOptions' => $this->statusOptions(),
            'packageNameOptions' => $this->packageNameOptions(),
            'themeOptions' => $this->themeOptions(),
        ]);
    }

    public function tenantStore(Request $request)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:tenants,slug'],
            'domain' => ['nullable', 'string', 'max:255', 'unique:tenants,domain'],
            'panel_path' => ['nullable', 'string', 'max:100'],
            'status' => ['required', Rule::in($this->statusOptions())],
            'package_name' => ['nullable', Rule::in($this->packageNameOptions())],
            'admin_username' => ['required', 'string', 'max:255'],
            'admin_email' => ['required', 'email', 'unique:users,email'],
            'admin_password' => ['required', 'string', 'min:6'],
            'admin_phone' => ['nullable', 'string', 'max:20'],
            'theme_code' => ['nullable', Rule::in(array_keys($this->themeOptions()))],
            'theme_color' => ['nullable', 'string', 'max:20'],
            'settings_email' => ['nullable', 'email'],
            'address' => ['nullable', 'string', 'max:1000'],
            'phone_1' => ['nullable', 'string', 'max:20'],
            'site_logo' => ['nullable', 'image', 'max:2048'],
        ]);

        DB::transaction(function () use ($data, $request) {
            $tenant = Tenant::create([
                'name' => $data['name'],
                'slug' => $data['slug'] ?? null,
                'domain' => $data['domain'] ?: null,
                'panel_path' => $data['panel_path'] ?: '/admin',
                'status' => $data['status'],
                'package_name' => $data['package_name'] ?: null,
                'theme_code' => $data['theme_code'] ?? 'classic',
            ]);

            if (! empty($data['domain'])) {
                TenantDomain::create([
                    'tenant_id' => $tenant->id,
                    'domain' => $data['domain'],
                    'is_primary' => true,
                ]);
            }

            User::create([
                'tenant_id' => $tenant->id,
                'business_name' => $tenant->name,
                'username' => $data['admin_username'],
                'email' => $data['admin_email'],
                'password' => Hash::make($data['admin_password']),
                'phone' => $data['admin_phone'] ?: null,
                'role' => User::ROLE_TENANT_ADMIN,
            ]);

            foreach ($this->defaultSettingsPayload($data['admin_email'], $data) as $key => $value) {
                Setting::updateForTenant($key, $value, $tenant->id);
            }

            if ($request->hasFile('site_logo')) {
                $path = $request->file('site_logo')->store('settings', 'public');
                Setting::updateForTenant('site_logo', $path, $tenant->id);
            }
        });

        return back()->with('success', 'Tenant, tenant admin ve varsayilan ayarlar basariyla olusturuldu.');
    }

    public function tenantEdit(Tenant $tenant)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        return redirect()->route('kzcore.dashboard', [
            'section' => 'edit-tenant',
            'tenant' => $tenant->id,
        ]);
    }

    public function tenantUpdate(Request $request, Tenant $tenant)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'slug' => ['required', 'string', 'max:255', Rule::unique('tenants', 'slug')->ignore($tenant->id)],
            'domain' => ['nullable', 'string', 'max:255', Rule::unique('tenants', 'domain')->ignore($tenant->id)],
            'panel_path' => ['required', 'string', 'max:100'],
            'status' => ['required', Rule::in($this->statusOptions())],
            'package_name' => ['nullable', Rule::in($this->packageNameOptions())],
            'theme_code' => ['nullable', Rule::in(array_keys($this->themeOptions()))],
        ]);

        DB::transaction(function () use ($tenant, $data) {
            $tenant->update($data);

            if (! empty($data['domain'])) {
                TenantDomain::query()->updateOrCreate(
                    ['domain' => $data['domain']],
                    [
                        'tenant_id' => $tenant->id,
                        'is_primary' => true,
                    ],
                );
            }
        });

        return redirect()->route('kzcore.dashboard', [
            'section' => 'edit-tenant',
            'tenant' => $tenant->id,
        ])->with('success', 'Tenant bilgileri guncellendi.');
    }

    public function tenantUserStore(Request $request)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        $data = $request->validate([
            'tenant_id' => ['required', 'exists:tenants,id'],
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $tenant = Tenant::findOrFail($data['tenant_id']);

        User::create([
            'tenant_id' => $tenant->id,
            'business_name' => $tenant->name,
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?? null,
            'role' => User::ROLE_TENANT_ADMIN,
        ]);

        return back()->with('success', 'Tenant kullanicisi basariyla olusturuldu.');
    }

    public function tenantDestroy(Tenant $tenant)
    {
        if ($redirect = $this->ensureSuperAdmin()) {
            return $redirect;
        }

        DB::transaction(function () use ($tenant) {
            $galleryPaths = $tenant->galleries()->pluck('image_path')->filter()->all();

            foreach ($galleryPaths as $path) {
                Storage::disk('public')->delete($path);
            }

            $tenant->galleries()->delete();
            $tenant->settings()->delete();
            $tenant->users()->delete();
            $tenant->domains()->delete();
            $tenant->delete();
        });

        return redirect()->route('kzcore.dashboard', [
            'section' => 'overview',
        ])->with('success', 'Tenant ve bagli tum veriler kalici olarak silindi.');
    }

    public function superAdminStore(Request $request)
    {
        $authenticatedUser = Auth::user();

        if ($authenticatedUser) {
            if ($redirect = $this->ensureSuperAdmin()) {
                return $redirect;
            }
        } elseif (User::query()->where('role', User::ROLE_SUPER_ADMIN)->exists()) {
            return redirect()->route('admin.login')->withErrors([
                'register' => 'Kayit olma islemi devre disi. Mevcut bir super admin bulunuyor.',
            ]);
        }

        $data = $request->validate([
            'username' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'string', 'min:6'],
            'phone' => ['nullable', 'string', 'max:20'],
        ]);

        $user = User::create([
            'tenant_id' => null,
            'business_name' => 'KzCore',
            'username' => $data['username'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
            'phone' => $data['phone'] ?: null,
            'role' => User::ROLE_SUPER_ADMIN,
        ]);

        if (! $authenticatedUser) {
            Auth::login($user);
            $request->session()->regenerate();

            return redirect()->route('kzcore.dashboard')->with('success', 'Super admin hesabi olusturuldu.');
        }

        return back()->with('success', 'Super admin kullanicisi basariyla olusturuldu.');
    }

    protected function statusOptions(): array
    {
        return [
            'active',
            'passive',
        ];
    }

    protected function packageNameOptions(): array
    {
        return [
            'basic',
            'premium',
            'enterprise',
        ];
    }

    protected function themeOptions(): array
    {
        return [
            'classic' => [
                'name' => 'Classic',
                'accent' => '#D20000',
                'description' => 'Mevcut oto lastik tasarimini kullanan klasik ana tema.',
                'preview' => [
                    'hero' => 'Ustalikla yola hazir lastik hizmeti',
                    'surface' => 'linear-gradient(135deg, #0a0a0a 0%, #1f1f1f 60%, #3b0b0b 100%)',
                ],
            ],
            'endustriyel' => [
                'name' => 'Endustriyel',
                'accent' => '#f97316',
                'description' => 'Kurumsal ve daha teknik gorunumlu endustriyel sunum temasi.',
                'preview' => [
                    'hero' => 'Saha operasyonlari icin guclu kurumsal yapi',
                    'surface' => 'linear-gradient(135deg, #0f172a 0%, #1e293b 55%, #7c2d12 100%)',
                ],
            ],
            'kzcoreprestige' => [
                'name' => 'KzCorePrestige',
                'accent' => '#b78d52',
                'description' => 'Premium, guven veren ve lux hissi tasiyan kurumsal hizmet firmasi temasi.',
                'preview' => [
                    'hero' => 'Premium kurumsal sunum ve guven odakli modern vitrin',
                    'surface' => 'linear-gradient(135deg, #0b1630 0%, #14213d 55%, #5c4a33 100%)',
                ],
            ],
            'kzcoremotion' => [
                'name' => 'KzCoreMotion',
                'accent' => '#ff6a3d',
                'description' => 'Modern, guclu ve donusum odakli yerel hizmet firmasi temasi.',
                'preview' => [
                    'hero' => 'Buyuk CTA, hizli iletisim ve hizmet odakli modern vitrin',
                    'surface' => 'linear-gradient(135deg, #1b1d24 0%, #232936 50%, #0c89d8 140%)',
                ],
            ],
        ];
    }

    protected function defaultSettingsPayload(string $adminEmail, array $data): array
    {
        return [
            'theme_color' => $data['theme_color'] ?: '#D20000',
            'email' => $data['settings_email'] ?: '',
            'address' => $data['address'] ?: '',
            'phone_1' => $data['phone_1'] ?: '',
            'about_text' => 'Buraya markanizin hikayesini, uzmanlik alanlarini ve musteriye sundugu degeri yazabilirsiniz.',
            'services_json' => json_encode([
                ['title' => 'Hizmet Basligi 1', 'text' => 'Bu alana ilk hizmet aciklamanizi yazabilirsiniz.'],
                ['title' => 'Hizmet Basligi 2', 'text' => 'Bu alana ikinci hizmet aciklamanizi yazabilirsiniz.'],
                ['title' => 'Hizmet Basligi 3', 'text' => 'Bu alana ucuncu hizmet aciklamanizi yazabilirsiniz.'],
            ], JSON_UNESCAPED_UNICODE),
            'site_logo' => '',
        ];
    }
}
