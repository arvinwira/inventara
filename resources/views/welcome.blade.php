<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Inventara - Kelola Stok & Penjualan UMKM</title>
    <link rel="icon" type="image/svg+xml" href="{{ asset('logo/inventara_log.svg') }}?v=2">
    <meta name="theme-color" content="#B71C1C">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="antialiased text-neutral-800">
    <header class="border-b border-neutral-200/60">
        <div class="container flex items-center justify-between py-4">
            <div class="flex items-center gap-3" id="logo-wrap">
                <img src="{{ asset('logo/inventara_log.svg') }}" alt="Inventara" class="h-20 md:h-24 w-auto will-change-transform" id="brand-logo">
                <span class="sr-only">Inventara</span>
            </div>
            <nav class="hidden md:flex items-center gap-6 text-sm">
                <a href="#fitur" class="hover:text-brand">Fitur</a>
                <a href="#manfaat" class="hover:text-brand">Manfaat</a>
                <a href="#preview" class="hover:text-brand">Preview</a>
                @if (Route::has('login'))
                    <a href="{{ route('login') }}" class="text-neutral-600 hover:text-brand">Masuk</a>
                    <a href="{{ route('register') }}" class="inline-flex items-center gap-2 rounded-lg bg-brand px-4 py-2 text-white shadow hover:bg-brand/90">Coba Gratis</a>
                @endif
            </nav>
        </div>
    </header>

    <main>
        <!-- Hero -->
        <section class="relative overflow-hidden bg-gradient-to-b from-brand/5 to-white">
            <div class="container grid items-center gap-10 py-16 md:grid-cols-2 md:py-24">
                <div>
                    <span class="inline-flex items-center rounded-full bg-brand/10 px-3 py-1 text-xs font-medium text-brand opacity-0 translate-y-3" data-animate="chip">Inventara untuk UMKM</span>
                    <h1 class="mt-4 text-4xl font-extrabold leading-tight md:text-5xl opacity-0 translate-y-3" data-animate="title">Kelola Stok & Penjualan Lebih Mudah untuk UMKM</h1>
                    <p class="mt-4 text-neutral-600 md:text-lg opacity-0 translate-y-3" data-animate="subtitle">Catat produk, stok, supplier, transaksi, dan laporan dalam satu aplikasi yang simpel dan profesional.</p>
                    <div class="mt-6 flex flex-wrap items-center gap-3 opacity-0 translate-y-3" data-animate="cta">
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-lg bg-brand px-5 py-3 font-medium text-white shadow hover:bg-brand/90">Mulai Sekarang</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg border border-neutral-300 px-5 py-3 font-medium text-neutral-700 hover:border-brand hover:text-brand">Saya sudah punya akun</a>
                    </div>
                    <ul class="mt-6 grid gap-2 text-sm text-neutral-600">
                        <li class="flex items-center gap-2"><span class="material-icons text-brand text-base">check_circle</span> Tanpa ribet, cocok untuk warung, toko, kedai</li>
                        <li class="flex items-center gap-2"><span class="material-icons text-brand text-base">check_circle</span> Peringatan stok menipis dan laporan ringkas</li>
                    </ul>
                </div>
                <div class="relative" data-animate="hero-illust">
                    <img src="{{ asset('images/hero-warehouse-2.svg') }}" alt="Ilustrasi gudang & rak produk" class="mx-auto max-w-lg drop-shadow-xl will-change-transform opacity-0 translate-y-4">
                    <div class="pointer-events-none absolute -right-10 -top-10 h-48 w-48 rounded-full bg-brand/10 blur-3xl"></div>
                </div>
            </div>
        </section>

        <!-- Fitur Utama -->
        <section id="fitur" class="py-14 md:py-20">
            <div class="container">
                <h2 class="text-2xl font-bold md:text-3xl">Fitur Utama</h2>
                <p class="mt-2 text-neutral-600">Fokus pada hal penting untuk operasional harian UMKM.</p>

                <div class="mt-8 grid gap-5 md:grid-cols-2 lg:grid-cols-4" id="feature-grid">
                    <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card opacity-0 translate-y-4 will-change-transform">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-brand/10 text-brand">POS</div>
                        <h3 class="font-semibold">Point of Sale</h3>
                        <p class="mt-1 text-sm text-neutral-600">Input transaksi cepat dan cetak struk PDF.</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card opacity-0 translate-y-4 will-change-transform">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-brand/10 text-brand">PRO</div>
                        <h3 class="font-semibold">Produk & Stok</h3>
                        <p class="mt-1 text-sm text-neutral-600">CRUD produk, reorder point, supplier & purchase order.</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card opacity-0 translate-y-4 will-change-transform">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-brand/10 text-brand">RPT</div>
                        <h3 class="font-semibold">Dashboard & Laporan</h3>
                        <p class="mt-1 text-sm text-neutral-600">Grafik penjualan, produk terlaris, stok menipis, export PDF/CSV.</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-5 shadow-card opacity-0 translate-y-4 will-change-transform">
                        <div class="mb-3 inline-flex h-10 w-10 items-center justify-center rounded-lg bg-brand/10 text-brand">ANL</div>
                        <h3 class="font-semibold">Analytics Ringkas</h3>
                        <p class="mt-1 text-sm text-neutral-600">Total revenue, jumlah transaksi, rata-rata pembelian.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- Dashboard Preview -->
        <section id="preview" class="bg-neutral-50 py-14 md:py-20">
            <div class="container grid items-center gap-10 md:grid-cols-2">
                <div>
                    <h2 class="text-2xl font-bold md:text-3xl">Tampilan Dashboard yang Ringkas</h2>
                    <p class="mt-2 text-neutral-600">Lihat ringkasan penjualan harian, produk terlaris, dan peringatan stok menipis dalam satu layar.</p>
                    <ul class="mt-4 grid gap-2 text-sm text-neutral-700">
                        <li class="flex items-center gap-2"><span class="material-icons text-brand text-base">insights</span> Grafik penjualan</li>
                        <li class="flex items-center gap-2"><span class="material-icons text-brand text-base">trending_up</span> Produk terlaris</li>
                        <li class="flex items-center gap-2"><span class="material-icons text-brand text-base">inventory</span> Peringatan stok menipis</li>
                    </ul>
                </div>
                <div data-animate="preview">
                    <img src="{{ asset('images/dashboard-preview.svg') }}" alt="Preview Dashboard Inventara" class="mx-auto max-w-xl rounded-2xl border border-neutral-200 bg-white shadow-card will-change-transform opacity-0 translate-y-4">
                </div>
            </div>
        </section>

        <!-- Manfaat -->
        <section id="manfaat" class="py-14 md:py-20">
            <div class="container">
                <h2 class="text-2xl font-bold md:text-3xl">Manfaat untuk UMKM</h2>
                <div class="mt-6 grid gap-5 md:grid-cols-3">
                    <div class="rounded-2xl border border-neutral-200 bg-white p-6">
                        <h3 class="font-semibold">Hemat Waktu</h3>
                        <p class="mt-2 text-neutral-600">Proses pencatatan otomatis dan cepat, minim input berulang.</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-6">
                        <h3 class="font-semibold">Laporan Real-time</h3>
                        <p class="mt-2 text-neutral-600">Pantau penjualan dan stok kapan saja, di mana saja.</p>
                    </div>
                    <div class="rounded-2xl border border-neutral-200 bg-white p-6">
                        <h3 class="font-semibold">Stok Terkendali</h3>
                        <p class="mt-2 text-neutral-600">Reorder point dan notifikasi stok menipis.</p>
                    </div>
                </div>
            </div>
        </section>

        <!-- CTA Penutup -->
        <section class="relative isolate overflow-hidden bg-brand text-white">
            <div class="container py-12 md:py-16">
                <div class="grid items-center gap-6 md:grid-cols-2">
                    <div>
                        <h2 class="text-2xl font-extrabold md:text-3xl">Mulai gunakan Inventara hari ini</h2>
                        <p class="mt-2 text-brand-foreground/90">Gratis untuk memulai. Siap membantu operasional usaha Anda.</p>
                    </div>
                    <div class="flex gap-3 md:justify-end">
                        <a href="{{ route('register') }}" class="inline-flex items-center rounded-lg bg-white px-5 py-3 font-semibold text-brand shadow hover:bg-white/90">Coba Gratis</a>
                        <a href="{{ route('login') }}" class="inline-flex items-center rounded-lg border border-white/70 px-5 py-3 font-semibold text-white hover:bg-white/10">Masuk</a>
                    </div>
                </div>
            </div>
        </section>
    </main>

    <footer class="border-t border-neutral-200/60">
        <div class="container flex flex-col items-center justify-between gap-4 py-6 md:flex-row">
            <p class="text-sm text-neutral-600">&copy; {{ date('Y') }} Inventara. All rights reserved.</p>
            <div class="flex items-center gap-5 text-sm">
                <a href="#" class="hover:text-brand">Kebijakan Privasi</a>
                <a href="#" class="hover:text-brand">Syarat & Ketentuan</a>
                <a href="mailto:hello@example.com" class="hover:text-brand">Kontak</a>
            </div>
        </div>
    </footer>

    <!-- Anime.js CDN -->
    <script src="https://cdn.jsdelivr.net/npm/animejs@3.2.1/lib/anime.min.js"></script>
    <script>
      window.addEventListener('load', function () {
        if (!window.anime) return;
        // Logo pop-in with slight overshoot
        anime({ targets: '#brand-logo', scale: [{value: 1.1, duration: 300, easing: 'easeOutQuad'}, {value: 1, duration: 400, easing: 'easeOutBack'}], opacity: [0, 1] });
        // Hero text stagger
        anime.timeline({ easing: 'easeOutCubic' })
          .add({ targets: '[data-animate=chip]', opacity: [0,1], translateY: [8,0], duration: 350 })
          .add({ targets: '[data-animate=title]', opacity: [0,1], translateY: [12,0], duration: 500 }, '-=100')
          .add({ targets: '[data-animate=subtitle]', opacity: [0,1], translateY: [12,0], duration: 450 }, '-=250')
          .add({ targets: '[data-animate=cta]', opacity: [0,1], translateY: [12,0], duration: 400 }, '-=250')
          .add({ targets: '[data-animate=hero-illust] img', opacity: [0,1], translateY: [16,0], scale: [0.98, 1], duration: 650 }, '-=200');

        // Feature cards on scroll
        const grid = document.getElementById('feature-grid');
        if (grid) {
          const observer = 'IntersectionObserver' in window ? new IntersectionObserver((entries) => {
            entries.forEach((entry) => {
              if (entry.isIntersecting) {
                anime({
                  targets: '#feature-grid > div',
                  opacity: [0,1],
                  translateY: [16,0],
                  duration: 600,
                  delay: anime.stagger(120),
                  easing: 'easeOutCubic'
                });
                observer.disconnect?.();
              }
            });
          }, { threshold: 0.25 }) : null;
          observer && observer.observe(grid);
        }

        // Preview float-in
        const previewEl = document.querySelector('[data-animate=preview] img');
        if (previewEl) {
          anime({ targets: previewEl, opacity: [0,1], translateY: [18,0], scale: [0.99, 1], duration: 650, delay: 200, easing: 'easeOutCubic' });
        }
      });
    </script>
</body>
</html>
