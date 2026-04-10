<!DOCTYPE html>
<html lang="tr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Galeri Yönetimi | Küçükzade Dijital</title>
    
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=outfit:300,400,500,600,700,800&display=swap" rel="stylesheet" />
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js"></script>

    <style type="text/tailwindcss">
        @theme {
            --font-sans: 'Outfit', sans-serif;
            --color-kz-gold: #c6a71e;
            --color-kz-gold-light: #e6c834;
            --color-kz-black: #111111;
            --color-kz-bg: #f5f6fa;
        }
        
        body { background-color: var(--color-kz-bg); }

        .sidebar { background-color: var(--color-kz-black); color: #ffffff; }

        .nav-item {
            display: flex; align-items: center; gap: 0.875rem; padding: 0.875rem 1.25rem;
            border-radius: 0.75rem; color: #9ca3af; font-weight: 500; transition: all 0.3s ease;
            position: relative; overflow: hidden;
        }
        .nav-item:hover { color: #ffffff; background-color: rgba(255, 255, 255, 0.05); }
        .nav-item.active { color: var(--color-kz-gold); background-color: rgba(198, 167, 30, 0.08); }
        .nav-item.active::before {
            content: ''; position: absolute; left: 0; top: 0; bottom: 0; width: 4px;
            background-color: var(--color-kz-gold); border-top-right-radius: 4px; border-bottom-right-radius: 4px;
        }

        .upload-card {
            background-color: #ffffff; border-radius: 1.25rem; padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.02); border: 1px dashed rgba(198, 167, 30, 0.5);
            transition: all 0.3s ease; text-align: center;
        }

        .image-card {
            background-color: #ffffff; border-radius: 1rem; overflow: hidden;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05); border: 1px solid rgba(0,0,0,0.05);
            position: relative; transition: all 0.3s;
        }
        .image-card:hover { transform: translateY(-4px); box-shadow: 0 12px 20px -8px rgba(0,0,0,0.1); border-color: rgba(198,167,30,0.3); }
        
        .input-field {
            width: 100%; border: 1px solid #e5e7eb; padding: 0.75rem 1rem; border-radius: 0.75rem;
            outline: none; transition: all 0.2s ease;
        }
        .input-field:focus { border-color: var(--color-kz-gold); box-shadow: 0 0 0 3px rgba(198, 167, 30, 0.1); }
    </style>
</head>
<body class="antialiased text-gray-800 flex h-screen overflow-hidden">

    <!-- Left Sidebar -->
    <aside class="sidebar w-72 flex-shrink-0 flex flex-col justify-between border-r border-[#222]">
        <div>
            <!-- Logo Area -->
            <div class="h-24 flex items-center px-8 border-b border-[#222] mb-6">
                <img src="/images/kucukzade-logo.png" alt="Küçükzade Dijital" class="h-auto w-auto mr-3 brightness-0 invert">
            </div>

            <!-- Navigation Links -->
            <div class="px-4 space-y-2">
                <a href="{{ route('admin.dashboard') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="7" height="9" x="3" y="3" rx="1"/><rect width="7" height="5" x="14" y="3" rx="1"/><rect width="7" height="9" x="14" y="12" rx="1"/><rect width="7" height="5" x="3" y="16" rx="1"/></svg>
                    Genel Bakış
                </a>
                <a href="{{ route('admin.gallery') }}" class="nav-item active">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2" ry="2"/><circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/></svg>
                    Galeri Yönetimi
                </a>
                <a href="{{ route('admin.reports') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M2 3h6a4 4 0 0 1 4 4v14a3 3 0 0 0-3-3H2z"/><path d="M22 3h-6a4 4 0 0 0-4 4v14a3 3 0 0 1 3-3h7z"/></svg>
                    Raporlar
                </a>
                <a href="{{ route('admin.settings') }}" class="nav-item">
                    <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="3"/><path d="M19.4 15a1.65 1.65 0 0 0 .33 1.82l.06.06a2 2 0 0 1 0 2.83 2 2 0 0 1-2.83 0l-.06-.06a1.65 1.65 0 0 0-1.82-.33 1.65 1.65 0 0 0-1 1.51V21a2 2 0 0 1-2 2 2 2 0 0 1-2-2v-.09A1.65 1.65 0 0 0 9 19.4a1.65 1.65 0 0 0-1.82.33l-.06.06a2 2 0 0 1-2.83 0 2 2 0 0 1 0-2.83l.06-.06a1.65 1.65 0 0 0 .33-1.82 1.65 1.65 0 0 0-1.51-1H3a2 2 0 0 1-2-2 2 2 0 0 1 2-2h.09A1.65 1.65 0 0 0 4.6 9a1.65 1.65 0 0 0-.33-1.82l-.06-.06a2 2 0 0 1 0-2.83 2 2 0 0 1 2.83 0l.06.06a1.65 1.65 0 0 0 1.82.33H9a1.65 1.65 0 0 0 1-1.51V3a2 2 0 0 1 2-2 2 2 0 0 1 2 2v.09a1.65 1.65 0 0 0 1 1.51 1.65 1.65 0 0 0 1.82-.33l.06-.06a2 2 0 0 1 2.83 0 2 2 0 0 1 0 2.83l-.06.06a1.65 1.65 0 0 0-.33 1.82V9a1.65 1.65 0 0 0 1.51 1H21a2 2 0 0 1 2 2 2 2 0 0 1-2 2h-.09a1.65 1.65 0 0 0-1.51 1z"/></svg>
                    Sistem Ayarları
                </a>
            </div>
        </div>

        <div class="p-6 border-t border-[#222]">
            <form method="POST" action="{{ route('admin.logout') }}" class="mb-5">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center gap-2 bg-[#1a1a1a] hover:bg-[#222] text-gray-400 hover:text-white py-3 rounded-xl transition-colors font-medium border border-[#333]">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/><line x1="21" x2="9" y1="12" y2="12"/></svg>
                    Güvenli Çıkış
                </button>
            </form>
            <div class="text-center text-[0.65rem] text-[#666] font-semibold tracking-wider uppercase">
                Küçükzade Dijital Yönetim Paneli <span class="text-[#888]">v1.0</span>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 flex flex-col h-screen w-full relative">
        <!-- Top Navbar in content -->
        <header class="h-24 bg-[rgba(245,246,250,0.8)] backdrop-blur-md sticky top-0 z-10 flex items-center justify-between px-10 border-b border-gray-200/50 flex-shrink-0">
            <div>
                <h2 class="text-xl font-bold text-gray-800">Galeri Yönetimi</h2>
            </div>
            <div class="flex items-center gap-3 pl-6 border-l border-gray-200">
                <div class="w-10 h-10 flex-shrink-0 rounded-full bg-white flex items-center justify-center p-1 shadow-sm overflow-hidden border border-gray-200">
                    <img src="{{ !empty($siteSettings['site_logo']) ? asset('storage/' . $siteSettings['site_logo']) : '/images/logo.webp' }}" alt="Logo" class="w-full h-full object-contain">
                </div>
                <div>
                    <div class="text-sm font-bold text-gray-800">{{ Auth::user()->username }}</div>
                    <div class="text-xs text-gray-500 font-medium">{{ Auth::user()->getRoleLabel() }}</div>
                </div>
            </div>
        </header>

        <!-- Scrollable content area -->
        <div class="flex-1 overflow-y-auto p-10 max-w-7xl w-full mx-auto pb-20">
            
            @if(session('success'))
            <div class="mb-6 p-4 bg-green-50 border-l-4 border-green-500 text-green-700 rounded-lg">
                {{ session('success') }}
            </div>
            @endif

            @if($errors->any())
            <div class="mb-6 p-4 bg-red-50 border-l-4 border-red-500 text-red-700 rounded-lg">
                <ul class="list-disc pl-4 space-y-1">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
            @endif

            <!-- Upload Area -->
            <div class="upload-card mb-10 gs-reveal relative overflow-hidden" id="uploadCard">
                <h3 class="text-lg font-bold mb-6 text-gray-800 text-left">Yeni Fotoğraf Yükle</h3>
                
                <form id="galleryUploadForm" action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data" class="max-w-2xl text-left space-y-4 relative z-10">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Görsel(ler) Seç (*)</label>
                        <input type="file" id="imageInput" name="images[]" multiple accept="image/jpeg,image/png,image/jpg,image/webp" class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-yellow-50 file:text-kz-gold-dark hover:file:bg-yellow-100 cursor-pointer" required>
                        <p class="text-xs text-gray-400 mt-1">Tek seferde maksimum 30 görsel seçebilirsiniz. Büyük görseller otomatik küçültülüp WebP formatında optimize edilir.</p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-1">Açıklama / Başlık (Tümüne Uygulanır | İsteğe Bağlı)</label>
                        <input type="text" id="titleInput" name="title" class="input-field" placeholder="Örn: Kışlık Lastik Değişimi">
                    </div>
                    <div class="pt-2">
                        <button type="submit" id="uploadBtn" class="bg-kz-gold hover:bg-kz-gold-dark text-white px-6 py-2.5 rounded-xl font-bold uppercase tracking-wider text-sm transition-colors shadow-md flex items-center justify-center gap-2">
                            <span>Sırayla Yüklemeyi Başlat</span>
                            <svg id="uploadSpinner" class="animate-spin h-4 w-4 text-white hidden" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
                        </button>
                    </div>
                </form>

                <!-- Progress Overlay -->
                <div id="progressOverlay" class="absolute inset-0 bg-white/95 backdrop-blur-sm z-20 flex flex-col items-center justify-center hidden opacity-0 transition-opacity duration-300">
                    <div class="relative w-28 h-28 mb-6">
                        <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                            <!-- Background Circle -->
                            <circle class="text-gray-100" stroke-width="8" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50" />
                            <!-- Progress Circle -->
                            <circle id="progressCircle" class="text-kz-gold transition-all duration-300 ease-out" stroke-width="8" stroke-dasharray="264" stroke-dashoffset="264" stroke-linecap="round" stroke="currentColor" fill="transparent" r="42" cx="50" cy="50" />
                        </svg>
                        <div class="absolute inset-0 flex items-center justify-center flex-col">
                            <span id="progressPercent" class="text-2xl font-black text-gray-800">0%</span>
                        </div>
                    </div>
                    
                    <h3 class="text-xl font-bold text-gray-800 mb-2 tracking-tight">Görseller İşleniyor</h3>
                    <p id="progressText" class="text-sm text-gray-600 font-medium bg-gray-100/80 border border-gray-200 px-5 py-2 rounded-full shadow-inner tracking-wide">Analiz ediliyor...</p>
                </div>
            </div>

            <!-- Existing Gallery Grid -->
            <div>
                <h3 class="text-lg font-bold mb-6 text-gray-800 border-b border-gray-200 pb-2">Mevcut Görseller ({{ $images->count() }})</h3>
                
                @if($images->isEmpty())
                    <div class="text-center py-16 bg-white rounded-2xl border border-gray-100 gs-reveal">
                        <div class="text-gray-300 mb-4 inline-flex">
                            <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"><path d="M21 15v4a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2v-4"/><polyline points="17 8 12 3 7 8"/><line x1="12" x2="12" y1="3" y2="15"/></svg>
                        </div>
                        <h4 class="text-lg font-medium text-gray-600">Henüz Görsel Yüklenmedi</h4>
                        <p class="text-sm text-gray-400 mt-1">Sitede görünecek ilk fotoğrafı yukarıdan yükleyebilirsiniz.</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 md:grid-cols-3 lg:grid-cols-4 gap-6">
                        @foreach($images as $image)
                            <div class="image-card gs-reveal">
                                <div class="aspect-video w-full bg-gray-100 relative">
                                    <img src="{{ asset('storage/' . $image->image_path) }}" class="w-full h-full object-cover" alt="{{ $image->title }}">
                                </div>
                                <div class="p-4">
                                    <h4 class="font-bold text-gray-800 text-sm truncate" title="{{ $image->title }}">{{ $image->title ?: 'İsimsiz Görsel' }}</h4>
                                    <p class="text-xs text-gray-400 mt-1">{{ $image->created_at->format('d/m/Y H:i') }}</p>
                                    
                                    <div class="mt-4 pt-4 border-t border-gray-100">
                                        <form method="POST" action="{{ route('admin.gallery.destroy', $image->id) }}" onsubmit="return confirm('Bu görseli silmek istediğinize emin misiniz? Siteden tamamen kalkacaktır.');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="w-full text-xs text-red-600 hover:text-white border border-red-200 hover:bg-red-500 hover:border-red-500 py-1.5 rounded transition-colors font-medium flex justify-center items-center gap-1">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M3 6h18"/><path d="M19 6v14c0 1-1 2-2 2H7c-1 0-2-1-2-2V6"/><path d="M8 6V4c0-1 1-2 2-2h4c1 0 2 1 2 2v2"/><line x1="10" x2="10" y1="11" y2="17"/><line x1="14" x2="14" y1="11" y2="17"/></svg>
                                                Sil
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </div>

        </div>
    </main>

    <script>
        gsap.utils.toArray('.gs-reveal').forEach(function(elem, i) {
            gsap.fromTo(elem, { y: 20, opacity: 0 }, { y: 0, opacity: 1, duration: 0.6, delay: i * 0.1, ease: "power3.out" });
        });

        // AJAX Multi-Upload Script
        document.addEventListener('DOMContentLoaded', function() {
            const form = document.getElementById('galleryUploadForm');
            if(!form) return;
            
            const imageInput = document.getElementById('imageInput');
            const titleInput = document.getElementById('titleInput');
            const progressOverlay = document.getElementById('progressOverlay');
            const progressCircle = document.getElementById('progressCircle');
            const progressPercent = document.getElementById('progressPercent');
            const progressText = document.getElementById('progressText');
            
            // Circumference for r=42 is exactly 2 * pi * 42 = 263.89 ~ 264
            const circleLength = 264;

            form.addEventListener('submit', async function(e) {
                e.preventDefault();
                
                const files = imageInput.files;
                if (files.length === 0) {
                    alert('Lütfen en az 1 görsel seçin.');
                    return;
                }
                
                // Enforcer: Max 30 files
                if (files.length > 30) {
                    alert(`Maksimum 30 görsel kısıtlaması mevcuttur.\nSiz tam ${files.length} görsel seçtiniz, lütfen gereksiz olanları çıkarıp tekrar deneyin.`);
                    return;
                }

                // UI Aktifleştir
                progressOverlay.classList.remove('hidden');
                setTimeout(() => progressOverlay.classList.remove('opacity-0'), 10);
                
                let successCount = 0;
                let errorCount = 0;
                let errorMessages = [];
                let total = files.length;
                
                for (let i = 0; i < total; i++) {
                    let file = files[i];
                    
                    progressText.innerText = `Optimize ediliyor: ${i + 1} / ${total}`;
                    
                    const formData = new FormData();
                    
                    try {
                        file = await optimizeImageFile(file);

                        progressText.innerText = `Yükleniyor: ${i + 1} / ${total}`;

                        formData.append('images[]', file);
                        formData.append('title', titleInput.value);
                        formData.append('_token', '{{ csrf_token() }}');

                        const response = await fetch(form.action, {
                            method: 'POST',
                            headers: { 'Accept': 'application/json' },
                            body: formData
                        });
                        
                        if (response.ok) {
                            successCount++;
                        } else {
                            errorCount++;
                            errorMessages.push(await getUploadErrorMessage(response, file.name));
                        }
                    } catch (error) {
                        errorCount++;
                        errorMessages.push(`${file.name}: Görsel optimize edilemedi veya yüklenemedi.`);
                    }
                    
                    // Update progress UI dynamically
                    const percent = Math.round(((i + 1) / total) * 100);
                    progressPercent.innerText = `${percent}%`;
                    const offset = circleLength - (percent / 100) * circleLength;
                    progressCircle.style.strokeDashoffset = offset;
                }
                
                // Tamamlandığında
                if (errorCount > 0) {
                    const details = errorMessages.slice(0, 3).join('\n');
                    alert(`${successCount} görsel yüklendi, ${errorCount} görsel hata verdi.${details ? `\n\n${details}` : ''}`);
                } else {
                    progressText.innerText = `Tümü tamamlandı. Yönlendiriliyor...`;
                    progressText.className = "text-sm font-semibold bg-green-100 border border-green-200 text-green-700 px-5 py-2 rounded-full shadow-inner tracking-wide";
                }
                
                setTimeout(() => {
                    window.location.reload();
                }, 1000);
            });

            function canvasToBlob(canvas, type, quality) {
                return new Promise((resolve) => canvas.toBlob(resolve, type, quality));
            }

            async function optimizeImageFile(file) {
                const maxDimension = 1920;
                const targetSize = 1800 * 1024;
                const minQuality = 0.58;
                const image = await loadImage(file);
                const largestSide = Math.max(image.width, image.height);

                if (largestSide <= maxDimension && file.size <= targetSize) {
                    URL.revokeObjectURL(image.src);
                    return file;
                }

                const scale = Math.min(1, maxDimension / largestSide);
                let canvas = document.createElement('canvas');
                canvas.width = Math.max(1, Math.round(image.width * scale));
                canvas.height = Math.max(1, Math.round(image.height * scale));

                let context = canvas.getContext('2d');
                context.imageSmoothingQuality = 'high';
                context.drawImage(image, 0, 0, canvas.width, canvas.height);
                URL.revokeObjectURL(image.src);

                let blob = await compressCanvas(canvas, targetSize, minQuality);

                while (blob && blob.size > targetSize && Math.max(canvas.width, canvas.height) > 1280) {
                    const smallerCanvas = document.createElement('canvas');
                    smallerCanvas.width = Math.max(1, Math.round(canvas.width * 0.85));
                    smallerCanvas.height = Math.max(1, Math.round(canvas.height * 0.85));

                    context = smallerCanvas.getContext('2d');
                    context.imageSmoothingQuality = 'high';
                    context.drawImage(canvas, 0, 0, smallerCanvas.width, smallerCanvas.height);

                    canvas = smallerCanvas;
                    blob = await compressCanvas(canvas, targetSize, minQuality);
                }

                if (!blob) {
                    return file;
                }

                const optimizedName = file.name.replace(/\.[^/.]+$/, '') + '.webp';
                return new File([blob], optimizedName, { type: 'image/webp', lastModified: Date.now() });
            }

            async function compressCanvas(canvas, targetSize, minQuality) {
                let quality = 0.82;
                let blob = await canvasToBlob(canvas, 'image/webp', quality);

                while (blob && blob.size > targetSize && quality > minQuality) {
                    quality = Math.max(minQuality, quality - 0.08);
                    blob = await canvasToBlob(canvas, 'image/webp', quality);
                }

                return blob;
            }

            function loadImage(file) {
                return new Promise((resolve, reject) => {
                    const image = new Image();
                    image.onload = () => resolve(image);
                    image.onerror = () => {
                        URL.revokeObjectURL(image.src);
                        reject(new Error('Görsel okunamadı.'));
                    };
                    image.src = URL.createObjectURL(file);
                });
            }

            async function getUploadErrorMessage(response, fileName) {
                try {
                    const data = await response.json();
                    const message = data.message || Object.values(data.errors || {}).flat().join(' ');
                    return `${fileName}: ${message || 'Sunucu görseli kabul etmedi.'}`;
                } catch (error) {
                    return `${fileName}: Sunucu görseli kabul etmedi.`;
                }
            }
        });
    </script>
</body>
</html>
