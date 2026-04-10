<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Duzenle</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-900">
    <div class="min-h-screen max-w-3xl mx-auto px-6 py-10">
        <div class="mb-8">
            <a href="{{ route('kzcore.dashboard') }}" class="text-sm font-semibold text-indigo-600">KzCore paneline don</a>
            <h1 class="mt-3 text-3xl font-bold">Tenant Duzenle</h1>
            <p class="mt-2 text-sm text-gray-500">Paket durumu ve domain yonetimini bu ekrandan guncelleyebilirsin.</p>
        </div>

        <div class="rounded-2xl bg-white p-6 shadow-sm border border-gray-200">
            <form method="POST" action="{{ route('kzcore.tenants.update', $tenant) }}" class="space-y-5">
                @csrf
                @method('PUT')
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Tenant Adi</label>
                    <input type="text" name="name" value="{{ old('name', $tenant->name) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Slug</label>
                    <input type="text" name="slug" value="{{ old('slug', $tenant->slug) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Domain</label>
                    <input type="text" name="domain" value="{{ old('domain', $tenant->domain) }}" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Panel Path</label>
                    <input type="text" name="panel_path" value="{{ old('panel_path', $tenant->panel_path) }}" required class="w-full rounded-lg border border-gray-300 px-3 py-2">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Durum</label>
                    <select name="status" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                        @foreach($statusOptions as $option)
                        <option value="{{ $option }}" @selected(old('status', $tenant->status) === $option)>{{ strtoupper($option) }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-600 mb-1">Paket</label>
                    <select name="package_name" class="w-full rounded-lg border border-gray-300 px-3 py-2">
                        <option value="">Paket secin</option>
                        @foreach($packageNameOptions as $option)
                        <option value="{{ $option }}" @selected(old('package_name', $tenant->package_name) === $option)>{{ strtoupper($option) }}</option>
                        @endforeach
                    </select>
                </div>
                <button type="submit" class="rounded-lg bg-indigo-600 px-4 py-2 font-semibold text-white">Tenant Bilgilerini Guncelle</button>
            </form>
        </div>
    </div>
</body>
</html>
