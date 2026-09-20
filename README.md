# GTAVerse CMS

**Content Management System berita Grand Theft Auto** — portal publik dinamis (hero slider + animasi berbasis scroll ala situs Rockstar Games) dengan panel admin kustom berbasis Blade.

Situs produksi: http://gtaverse.free.nf

| Komponen    | Teknologi                                        |
|-------------|--------------------------------------------------|
| Bahasa      | PHP ≥ 8.2                                        |
| Framework   | Laravel 12                                       |
| Panel Admin | Kustom (Blade + controller sendiri, tanpa paket) |
| Database    | SQLite (lokal) / MySQL (produksi)                |
| CSS         | Tailwind CSS 4 (via Vite 7)                      |
| Animasi     | GSAP 3 + ScrollTrigger (CDN)                     |
| Crop gambar | Cropper.js 1.6 (CDN)                             |

Antarmuka situs menggunakan **bahasa Inggris**.

## Fitur

**Frontend publik:**

1. **Hero slider** — berganti otomatis dan manual antar game unggulan, dengan animasi konten GSAP.
2. **Scroll Journey** — bagian *sticky scrollytelling*: panel game berubah mengikuti gulir, menampilkan perjalanan dari 3D Universe (2001) hingga HD Universe (2026).
3. **Katalog game** per universe (3D / HD) + halaman detail dengan parallax dan **tema warna dinamis** — warna halaman mengikuti `theme_color` dan `accent_color` game yang dibuka.
4. **Artikel** — daftar, pencarian, filter kategori, pagination, dan detail dengan penghitung views.
5. **Profil karakter** — daftar dengan filter per game + halaman detail biografi.
6. **Kotak Saran** (`/suggestions`) — pengunjung mengirim masukan yang langsung masuk ke panel admin.
7. Countdown rilis GTA VI, desain responsif, tema gelap.

**Panel admin (`/admin`):**

- Autentikasi mandiri; hanya user dengan `is_admin = true` yang dapat masuk (middleware `EnsureUserIsAdmin`).
- CRUD Game, Artikel (draf/terbit, headline), Karakter, dan Kategori.
- **Editor gambar** dengan zoom, geser, dan pilihan rasio (Disarankan / Bebas / 1:1 / 16:9 / 3:4), berlaku untuk gambar baru maupun gambar yang sudah tersimpan.
- **Kotak masuk saran** dengan penanda jumlah pesan belum dibaca.
- Dashboard statistik (game, artikel, karakter, kategori, total views, saran masuk).

## Instalasi (pengembangan lokal)

Prasyarat: PHP ≥ 8.2, Composer, dan Node.js. Semuanya sudah tersedia bila memakai Laragon.

```bash
git clone https://github.com/HafizhRaditya/GTAVerse.git
cd GTAVerse

composer install
cp .env.example .env          # Windows (CMD): copy .env.example .env
php artisan key:generate

php artisan migrate --seed    # jawab "yes" saat ditanya membuat file database SQLite
php artisan storage:link

npm install
npm run build                 # gunakan `npm run dev` selama pengembangan

php artisan serve
```

Buka `http://localhost:8000` untuk situs publik dan `http://localhost:8000/admin` untuk panel admin.

**Akun admin bawaan seeder (khusus lokal):**

| Email                 | Password   |
|-----------------------|------------|
| `admin@gtaverse.test` | `password` |

> Password ini hanya dibuat saat akun belum ada, sehingga menjalankan ulang seeder tidak akan menimpa password yang sudah diganti. Gunakan password berbeda di lingkungan produksi.

Data awal dari seeder: 13 game, 15 karakter, 6 kategori, dan 6 artikel.

## Pengujian

```bash
php artisan test                 # menjalankan seluruh test
php artisan test --coverage      # butuh ekstensi Xdebug atau PCOV
```

Pengujian memakai SQLite in-memory (lihat `phpunit.xml`), jadi tidak menyentuh database pengembangan.

Bila `--coverage` gagal dengan pesan *code coverage driver not available*, pasang Xdebug: unduh DLL yang sesuai versi PHP kamu dari [xdebug.org/download](https://xdebug.org/download), letakkan di folder `ext`, lalu tambahkan pada `php.ini`:

```ini
zend_extension=xdebug
xdebug.mode=coverage
```

### Aturan validasi (acuan penyusunan kasus uji)

| Isian                            | Aturan                                        |
|----------------------------------|-----------------------------------------------|
| Kotak Saran — `name`             | wajib, maks. 255 karakter                     |
| Kotak Saran — `email`            | opsional, format email, maks. 255 karakter    |
| Kotak Saran — `subject`          | opsional, maks. 255 karakter                  |
| Kotak Saran — `body`             | wajib, maks. 5000 karakter                    |
| Kotak Saran — laju pengiriman    | maks. 5 permintaan per menit (HTTP 429)       |
| Game — `universe`                | `3D` atau `HD`                                |
| Game — `status`                  | `released` atau `upcoming`                    |
| Artikel — `status`               | `draft` atau `published`                      |
| Artikel — `excerpt`              | opsional, maks. 500 karakter                  |
| Unggahan gambar                  | harus gambar, maks. 4096 KB                   |
| `slug` seluruh entitas           | opsional (dibuat otomatis), unik              |

## Daftar Rute

| Metode | URL                        | Keterangan                              |
|--------|----------------------------|-----------------------------------------|
| GET    | `/`                        | Beranda                                 |
| GET    | `/games`                   | Katalog game (filter `?universe=`)      |
| GET    | `/games/{slug}`            | Detail game                             |
| GET    | `/articles`                | Daftar artikel (`?q=`, `?category=`)    |
| GET    | `/articles/{slug}`         | Detail artikel                          |
| GET    | `/characters`              | Daftar karakter (`?game=`)              |
| GET    | `/characters/{slug}`       | Detail karakter                         |
| GET    | `/suggestions`             | Form kotak saran                        |
| POST   | `/suggestions`             | Kirim saran (dibatasi 5 per menit)      |
| GET    | `/admin/login`             | Halaman masuk admin                     |
| GET    | `/admin`                   | Dashboard admin                         |
| —      | `/admin/{games,articles,characters,categories}` | CRUD konten        |
| GET    | `/admin/messages`          | Kotak masuk saran                       |

URL lama berbahasa Indonesia (`/artikel`, `/karakter`, `/kotak-saran`) dialihkan permanen (301) ke alamat baru.

## Struktur Proyek

```
app/
├── Http/
│   ├── Controllers/          # Home, Game, Article, Character, Message (publik)
│   │   └── Admin/            # Auth, Dashboard, Game, Article, Character, Category, Message
│   └── Middleware/EnsureUserIsAdmin.php
├── Models/                   # Game, Article, Character, Category, Message, User
│   └── Concerns/HasSlug.php  # pembuatan slug otomatis & unik
database/
├── migrations/               # categories, games, characters, articles, messages, is_admin
└── seeders/                  # data GTA 3D & HD Universe
resources/
├── css/app.css               # Tailwind 4 + kelas animasi kustom
└── views/
    ├── admin/                # layout, dashboard, CRUD, modal crop gambar
    ├── games/ articles/ characters/ messages/
    └── layouts/app.blade.php
routes/web.php
```

## Catatan Deployment

Produksi berjalan di shared hosting (InfinityFree) yang tidak mendukung symlink dan hanya menyajikan folder `htdocs`. Karena itu:

- Seluruh folder aplikasi diletakkan **di dalam** `htdocs`, dan `htdocs/index.php` menunjuk ke sana.
- Variabel `PUBLIC_STORAGE_PATH` pada `.env` mengarahkan gambar unggahan langsung ke dalam web root sebagai pengganti `storage:link`.
- Deployment dilakukan manual via FTP, dan `composer install --no-dev` dijalankan di lokal karena hosting tidak menyediakan SSH.

## Catatan Lain

- **Gambar:** demi hak cipta, repositori ini tidak menyertakan aset resmi Rockstar. Gambar yang diunggah melalui panel admin juga tidak ikut ke repositori, sehingga salinan hasil clone akan menampilkan gambar cadangan di `public/images` atau gradien warna tema.
- **Slug** dibuat otomatis dari judul/nama bila dikosongkan dan dijamin unik.
- **Artikel draf** tidak pernah tampil di frontend. Kolom `published_at` terisi otomatis saat status diubah menjadi terbit, dan artikel dengan tanggal terbit di masa depan belum ditampilkan.
- Animasi menghormati preferensi `prefers-reduced-motion`.
