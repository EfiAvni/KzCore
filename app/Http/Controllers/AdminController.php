<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\ImageManager;
use Intervention\Image\Drivers\Gd\Driver;

class AdminController extends Controller
{
    public function loginForm()
    {
        if (Auth::check()) {
            return redirect()->route('admin.dashboard');
        }
        return view('admin.login');
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
            return redirect()->route('admin.dashboard');
        }

        return back()->withErrors([
            'email' => 'Girdiğiniz E-posta adresi ya da şifre hatalı.',
        ])->onlyInput('email');
    }

    public function dashboard()
    {
        return view('admin.dashboard');
    }

    public function reports()
    {
        return view('admin.reports');
    }

    public function gallery()
    {
        $images = \App\Models\GalleryItem::latest()->get();
        return view('admin.gallery', compact('images'));
    }

    public function galleryStore(Request $request)
    {
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

            \App\Models\GalleryItem::create([
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
        $item = \App\Models\GalleryItem::findOrFail($id);
        \Illuminate\Support\Facades\Storage::disk('public')->delete($item->image_path);
        $item->delete();
        
        return back()->with('success', 'Görsel silindi.');
    }

    public function settings()
    {
        $settings = \App\Models\Setting::pluck('value', 'key')->toArray();
        $users = \App\Models\User::all();
        return view('admin.settings', compact('settings', 'users'));
    }

    public function settingsUpdate(Request $request)
    {
        $data = $request->except(['_token', 'site_logo']);
        
        foreach ($data as $key => $value) {
            \App\Models\Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        if ($request->hasFile('site_logo')) {
            $path = $request->file('site_logo')->store('settings', 'public');
            \App\Models\Setting::updateOrCreate(['key' => 'site_logo'], ['value' => $path]);
        }

        return back()->with('success', 'Sistem ayarları başarıyla güncellendi.');
    }

    public function userStore(Request $request)
    {
        $request->validate([
            'username' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:6',
            'role' => 'required|in:admin,editor,viewer',
        ]);

        \App\Models\User::create([
            'business_name' => \Illuminate\Support\Facades\Auth::user()->business_name ?? 'Göksel Lastik',
            'username' => $request->username,
            'email' => $request->email,
            'password' => \Illuminate\Support\Facades\Hash::make($request->password),
            'phone' => $request->phone,
            'role' => $request->role,
        ]);

        return back()->with('success', 'Yeni kullanıcı başarıyla eklendi.');
    }

    public function userDestroy($id)
    {
        if (Auth::id() == $id) {
            return back()->withErrors('Kendi hesabınızı silemezsiniz.');
        }
        
        \App\Models\User::findOrFail($id)->delete();
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
