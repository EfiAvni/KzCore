<?php

namespace App\Http\Controllers;

use App\Models\GalleryItem;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return $this->redirectAuthenticatedUser(Auth::user());
        }

        return view('admin.login', [
            'canRegisterSuperAdmin' => ! User::query()
                ->where('role', User::ROLE_SUPER_ADMIN)
                ->exists(),
        ]);
    }

    public function loginSubmit(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ], [
            'email.required' => 'E-posta adresi zorunludur.',
            'password.required' => 'Şifre zorunludur.',
        ]);

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return $this->redirectAuthenticatedUser(Auth::user());
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz E-posta adresi ya da şifre hatalı.',
        ])->onlyInput('email');
    }

    protected function redirectAuthenticatedUser(?User $user)
    {
        if ($user?->isSuperAdmin()) {
            return redirect()->route('kzcore.dashboard');
        }

        return redirect()->route('admin.dashboard');
    }

    protected function ensureTenantAdmin()
    {
        $user = Auth::user();

        if (! $user) {
            abort(401);
        }

        if ($user->isSuperAdmin()) {
            return redirect()->route('kzcore.dashboard');
        }

        return null;
    }

    protected function currentTenantId(): ?int
    {
        return Auth::user()?->tenant_id;
    }

    protected function tenantScopedQuery(Builder $query): Builder
    {
        if (Auth::user()?->isSuperAdmin()) {
            return $query;
        }

        return $query->where('tenant_id', $this->currentTenantId());
    }

    protected function visibleGalleryItems(): Builder
    {
        return $this->tenantScopedQuery(GalleryItem::query());
    }

    protected function visibleUsers(): Builder
    {
        return $this->tenantScopedQuery(User::query());
    }

    protected function assignableRoles(): array
    {
        if (Auth::user()?->isSuperAdmin()) {
            return User::roles();
        }

        return [User::ROLE_TENANT_ADMIN];
    }

    public function dashboard()
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        return view('admin.dashboard');
    }

    public function reports()
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        return view('admin.reports');
    }

    public function gallery()
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        $images = $this->visibleGalleryItems()->latest()->get();
        return view('admin.gallery', compact('images'));
    }

    public function galleryStore(Request $request)
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        $request->validate([
            'images' => 'required|array|max:30',
            'images.*' => 'required|image|mimes:jpeg,png,jpg,webp|max:20480',
            'title' => 'nullable|string|max:255'
        ], [
            'images.max' => 'Tek seferde maksimum 30 görsel yükleyebilirsiniz.',
            'images.*.max' => 'Yüklenen her görsel maksimum 20MB olmalıdır.'
        ]);

        if (!Storage::disk('public')->exists('gallery')) {
            Storage::disk('public')->makeDirectory('gallery');
        }

        $manager = new ImageManager(new Driver());

        foreach ($request->file('images') as $file) {
            $filename = uniqid('img_') . '.webp';
            $relativePath = 'gallery/' . $filename;
            $absolutePath = Storage::disk('public')->path($relativePath);

            $image = $manager->decodePath($file->getRealPath());
            
            // Büyük görselleri galeri için güvenli boyuta indir.
            $image->scaleDown(width: 1920, height: 1920);
            
            // WebP formatına çevir, %80 kalite ile kaydet
            $image->save($absolutePath, quality: 80);

            GalleryItem::create([
                'tenant_id' => $this->currentTenantId(),
                'image_path' => $relativePath,
                'title' => $request->title,
            ]);
        }

        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => true]);
        }

        return back()->with('success', 'Seçilen görsel(ler) başarıyla eklendi.');
    }

    public function galleryDestroy($id)
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        $item = $this->visibleGalleryItems()->findOrFail($id);
        Storage::disk('public')->delete($item->image_path);
        $item->delete();
        
        return back()->with('success', 'Görsel silindi.');
    }

    public function settings()
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        $settings = Setting::allForTenant($this->currentTenantId());
        $users = $this->visibleUsers()->get();
        return view('admin.settings', compact('settings', 'users'));
    }

    public function settingsUpdate(Request $request)
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        $data = $request->except(['_token', 'site_logo']);
        
        foreach ($data as $key => $value) {
            Setting::updateForTenant($key, $value, $this->currentTenantId());
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            Setting::updateForTenant('site_logo', $path, $this->currentTenantId());
        }

        return back()->with('success', 'Sistem ayarları başarıyla güncellendi.');
    }

    public function userStore(Request $request)
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:' . implode(',', $this->assignableRoles()),
        ]);

        User::create([
            'tenant_id' => $this->currentTenantId(),
            'business_name' => Auth::user()->business_name ?? 'Göksel Lastik',
            'username' => $request->username,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Yeni kullanıcı başarıyla eklendi.');
    }

    public function userDestroy($id)
    {
        if ($redirect = $this->ensureTenantAdmin()) {
            return $redirect;
        }

        if (Auth::id() == $id) {
            return back()->withErrors('Kendi hesabınızı silemezsiniz.');
        }
        
        $user = $this->visibleUsers()->findOrFail($id);
        $user->delete();

        return back()->with('success', 'Kullanıcı başarıyla silindi.');
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        
        return redirect()->route('admin.login');
    }
}
