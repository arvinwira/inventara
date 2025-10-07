<p align="center">
  <img src="public/logo/inventara_logo.svg" alt="Inventara" height="80" />
</p>

# Inventara — Aplikasi Inventaris & Penjualan untuk UMKM

> Kelola produk, stok, supplier, transaksi, dan laporan harian dengan cepat dan sederhana.

## Fitur Utama

- Manajemen Produk & Stok: CRUD produk, satuan, harga beli/jual, reorder point.
- Supplier & Pembelian: relasi supplier dan purchase order (roadmap).
- Point of Sale (POS): input transaksi penjualan, cetak struk PDF (roadmap).
- Dashboard & Laporan: ringkasan penjualan, produk terlaris, stok menipis, export PDF/CSV (roadmap/parsial).
- Analytics Ringkas: total pendapatan, jumlah transaksi, rata-rata pembelian (roadmap).
- Inventaris: pencatatan pergerakan stok (PURCHASE, SALE, ADJUST, RETURN).
- Autentikasi modern: toast notifikasi, pemeriksaan kekuatan kata sandi, anti-email enumeration.

## Teknologi

- Laravel 12, PHP 8.3
- Blade + TailwindCSS + Vite
- Notyf (toast JS)
- Material Icons (untuk toggle tampil/sembunyikan kata sandi)

## Prasyarat

- PHP 8.2+
- Composer
- Node.js 18+
- MySQL/MariaDB/PostgreSQL (sesuaikan `.env`)

## Instalasi

- Clone repo ini.
- Install dependency PHP: `composer install`
- Install dependency JS: `npm install`
- Duplikat file env: `cp .env.example .env` lalu set koneksi database dan `APP_URL` (contoh: `http://inventara.test`).
- Generate key: `php artisan key:generate`

## Jalankan Migrasi & Seed

- Migrasi database: `php artisan migrate`
- Seed data dasar: `php artisan db:seed`
  - Seeder akan membuat akun:
    - Admin: `admin@example.com` / `admin123`
    - 3 kasir dummy: password `admin123`
  - Produk awal dari `ProductSeeder`
  - Pergerakan stok awal (ADJUST) + contoh `SALE` kecil per produk

Jika ingin reset bersih:
- `php artisan migrate:fresh --seed`

## Menjalankan Aplikasi

- Development assets: `npm run dev`
- Production build: `npm run build`
- Jalankan server: `php artisan serve` (atau gunakan Valet/Laragon sesuai preferensi)

Akses:
- Landing: `/`
- Login/Daftar: `/login`, `/register`
- Dashboard: `/dashboard` (setelah login)

## Branding UI

- Warna brand: `#B71C1C` (Tailwind key: `brand`), telah dikonfigurasi di `tailwind.config.js`.
- Font: Montserrat (heading) + Poppins (teks), diimport pada `resources/css/app.css`.
- Logo: `public/logo/inventara_logo.svg`
- Favicon: `public/logo/inventara_favicon.svg` (square, jelas di 16×16).
- Ilustrasi landing: `public/images/hero-warehouse.svg`, `public/images/dashboard-preview.svg`.

## UX & Keamanan Autentikasi

- Notifikasi toast (Notyf) untuk status sukses/error (bukan alert browser).
- Toggle tampil/sembunyikan kata sandi dengan Material Icons pada semua form auth.
- Password checker (Register/Reset):
  - Wajib: minimal 8 karakter, mengandung huruf dan angka.
  - Rekomendasi: huruf besar dan simbol (skor meter 0–5).
- Anti email enumeration pada lupa kata sandi: selalu mengirim respons sukses generik.
- Rate limiting login dengan pesan berbahasa Indonesia.

## Struktur Data (ringkas)

- `products`: sku, name, category, unit, cost_price, sell_price, reorder_point.
- `inventory_movements`: product_id, type (PURCHASE|SALE|ADJUST|RETURN), qty, note.
- Relasi: `Product hasMany InventoryMovement`.
- Akses stok saat ini: accessor `Product::$current_stock` dihitung dari pergerakan.

## Perintah Berguna

- Hapus cache/kompilasi: `php artisan optimize:clear`
- Cek route: `php artisan route:list`
- Tinker: `php artisan tinker`

## Troubleshooting

- Favicon tidak berubah: lakukan hard refresh (Ctrl/Cmd + Shift + R) atau buka jendela private. Kami menambahkan query `?v=1` untuk cache busting.
- Error “Namespace declaration has to be the very first statement”: pastikan file PHP disimpan sebagai UTF‑8 tanpa BOM. Jalankan `php artisan optimize:clear` setelah mengedit file.
- CSS tidak terupdate: pastikan `npm run dev` aktif atau `npm run build` telah dijalankan.

## Lisensi

- Aplikasi ini dibangun di atas Laravel (MIT). Konten kode aplikasi Inventara hak cipta pemilik proyek.
