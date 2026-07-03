# GTAVerse CMS

**Content Management System berita Grand Theft Auto** — portal publik dinamis (hero slider + animasi berbasis scroll ala situs Rockstar Games) dengan panel admin berbasis Filament.

| Komponen   | Teknologi                          |
|------------|------------------------------------|
| Bahasa     | PHP ≥ 8.3                          |
| Framework  | Laravel 13                         |
| Panel Admin| Filament 4 (`filament/filament`)   |
| Database   | MySQL 8                            |
| CSS        | Tailwind CSS 4 (via Vite)          |
| Animasi    | GSAP 3 + ScrollTrigger (CDN)       |

## Fitur

**Frontend publik (dinamis):**
1. **Hero slider** — berganti otomatis & manual antar game unggulan, dengan animasi konten GSAP.
2. **Scroll Journey** — bagian *sticky scrollytelling* ala situs Rockstar: panel/gambar game berubah menjadi animasi mengikuti gulir, menampilkan perjalanan dari 3D Universe (2001) hingga HD Universe (2026).
3. **Katalog game** per universe (3D / HD) + halaman detail dengan parallax.
4. **Artikel** — daftar, pencarian, filter kategori, pagination, detail dengan penghitung views.
5. **Profil karakter** — daftar dengan filter per game + halaman detail biografi.
6. Countdown rilis GTA VI, desain responsif, tema gelap, gradien warna per game (fallback otomatis bila gambar belum diunggah).

**Panel admin (`/admin`, Filament):**
- Autentikasi (hanya user dengan `is_admin = true`).
- CRUD Game, Artikel (rich editor, draf/terbit, headline), Karakter, dan Kategori.
- Unggah gambar ke `storage/app/public`.
- Dashboard statistik (jumlah game, artikel terbit, karakter, total views).

## Cara Instalasi

Paket ini berisi **file sumber kustom** yang ditimpakan ke proyek Laravel baru.

```bash
# 1. Buat proyek Laravel 13 baru
composer create-project laravel/laravel:^13.0 gtaverse
cd gtaverse

# 2. Pasang Filament 4
composer require filament/filament:"^4.0"
php artisan filament:install --panels
#    -> saat ditanya ID panel, isi: admin

# 3. Salin seluruh isi paket ini ke dalam proyek (timpa file yang sama):
#    app/, database/, resources/, routes/, vite.config.js, README.md
#    (Pastikan App\Providers\Filament\AdminPanelProvider yang dipakai
#     adalah versi dari paket ini.)

# 4. Konfigurasi database di .env
#    DB_CONNECTION=mysql
#    DB_DATABASE=gtaverse
#    DB_USERNAME=root
#    DB_PASSWORD=
#    Lalu buat database `gtaverse` di MySQL.

# 5. Migrasi + isi data awal (13 game, 15 karakter, 6 kategori, 6 artikel)
php artisan migrate --seed

# 6. Symlink storage untuk gambar unggahan
php artisan storage:link

# 7. Aset frontend
npm install
npm install -D @tailwindcss/typography
npm run build      # atau `npm run dev` saat pengembangan

# 8. Jalankan
php artisan serve
```

Buka `http://localhost:8000` (publik) dan `http://localhost:8000/admin` (panel admin).

**Akun admin bawaan (dari seeder):**

| Email                 | Password   |
|-----------------------|------------|
| `admin@gtaverse.test` | `password` |

> Ganti password ini segera pada lingkungan produksi.

## Struktur Paket

```
app/
├── Filament/
│   ├── Resources/            # GameResource, ArticleResource, CharacterResource, CategoryResource (+Pages)
│   └── Widgets/StatsOverview.php
├── Http/Controllers/         # Home, Game, Article, Character (publik)
├── Models/                   # Game, Article, Character, Category, User (+ Concerns/HasSlug)
└── Providers/Filament/AdminPanelProvider.php
database/
├── migrations/               # categories, games, characters, articles, is_admin
└── seeders/                  # data lengkap GTA 3D & HD Universe
resources/
├── css/app.css               # Tailwind 4 + kelas animasi kustom
├── js/app.js
└── views/                    # layout, home, games, articles, characters
routes/web.php
vite.config.js
```

## Catatan

- **Gambar:** demi hak cipta, paket ini tidak menyertakan aset resmi Rockstar. Semua tampilan memakai gradien warna tema per game sebagai *fallback*; admin dapat mengunggah gambar sampul/hero sendiri melalui panel.
- **Slug** dibuat otomatis dari judul/nama bila dikosongkan (trait `HasSlug`), dan dijamin unik.
- **Artikel draf** tidak pernah tampil di frontend; `published_at` terisi otomatis saat status diubah menjadi *Terbit*.
- Animasi menghormati preferensi `prefers-reduced-motion`.
- Dokumen pendamping: **SRS (SKPL)**, **SDD (DPPL)**, dan **Dokumen Black Box Testing** disertakan terpisah dalam format .docx.
