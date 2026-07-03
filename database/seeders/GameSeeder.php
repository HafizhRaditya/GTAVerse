<?php

namespace Database\Seeders;

use App\Models\Game;
use Illuminate\Database\Seeder;

class GameSeeder extends Seeder
{
    public function run(): void
    {
        $games = [
            // ==================== 3D UNIVERSE ====================
            [
                'title' => 'Grand Theft Auto III', 'slug' => 'gta-iii', 'universe' => '3D',
                'release_date' => '2001-10-22',
                'platforms' => 'PlayStation 2, Xbox, PC, Mobile',
                'setting' => 'Liberty City, 2001',
                'tagline' => 'Awal era dunia terbuka 3D.',
                'description' => 'Game yang merevolusi industri dengan membawa seri Grand Theft Auto ke dunia terbuka tiga dimensi penuh. Pemain berperan sebagai Claude, kriminal bisu yang dikhianati kekasihnya saat perampokan bank, lalu menapaki tangga dunia kriminal Liberty City demi balas dendam.',
                'theme_color' => '#28425f', 'accent_color' => '#9db6cc',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 1,
            ],
            [
                'title' => 'Grand Theft Auto: Vice City', 'slug' => 'gta-vice-city', 'universe' => '3D',
                'release_date' => '2002-10-29',
                'platforms' => 'PlayStation 2, Xbox, PC, Mobile',
                'setting' => 'Vice City, 1986',
                'tagline' => 'Neon, dekade 80-an, dan ambisi tanpa batas.',
                'description' => 'Berlatar kota tropis bergaya Miami tahun 1986, Vice City mengikuti Tommy Vercetti yang baru bebas dari penjara dan dikirim ke selatan oleh keluarga Forelli. Setelah transaksi narkoba yang berujung penyergapan, Tommy membangun kerajaan kriminalnya sendiri di kota penuh neon ini.',
                'theme_color' => '#ff2e88', 'accent_color' => '#00e5ff',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 2,
            ],
            [
                'title' => 'Grand Theft Auto Advance', 'slug' => 'gta-advance', 'universe' => '3D',
                'release_date' => '2004-10-26',
                'platforms' => 'Game Boy Advance',
                'setting' => 'Liberty City, 2000',
                'tagline' => 'Liberty City dari sudut pandang atas.',
                'description' => 'Entri portabel dengan perspektif top-down klasik yang berlatar Liberty City setahun sebelum peristiwa GTA III. Pemain mengikuti Mike, kriminal kelas bawah yang menyelidiki kematian rekannya, Vinnie, di tengah perang kelompok kriminal kota.',
                'theme_color' => '#4b5563', 'accent_color' => '#d1d5db',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 3,
            ],
            [
                'title' => 'Grand Theft Auto: San Andreas', 'slug' => 'gta-san-andreas', 'universe' => '3D',
                'release_date' => '2004-10-26',
                'platforms' => 'PlayStation 2, Xbox, PC, Mobile',
                'setting' => 'Negara Bagian San Andreas, 1992',
                'tagline' => 'Kembali ke Grove Street.',
                'description' => 'Petualangan terbesar di 3D Universe yang mencakup tiga kota: Los Santos, San Fierro, dan Las Venturas. Carl "CJ" Johnson pulang ke Grove Street setelah ibunya terbunuh, lalu terseret kembali ke dunia geng, polisi korup, dan konspirasi yang mengancam keluarganya.',
                'theme_color' => '#e8862e', 'accent_color' => '#2f6b39',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 4,
            ],
            [
                'title' => 'Grand Theft Auto: Liberty City Stories', 'slug' => 'gta-liberty-city-stories', 'universe' => '3D',
                'release_date' => '2005-10-24',
                'platforms' => 'PSP, PlayStation 2, Mobile',
                'setting' => 'Liberty City, 1998',
                'tagline' => 'Kesetiaan pada keluarga Leone.',
                'description' => 'Prekuel GTA III yang mengikuti Toni Cipriani, anggota setia keluarga mafia Leone yang kembali ke Liberty City setelah bersembunyi. Toni harus merebut kembali posisinya sambil menjaga keluarga Leone dari perang antar-mafia.',
                'theme_color' => '#1e3a8a', 'accent_color' => '#93c5fd',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 5,
            ],
            [
                'title' => 'Grand Theft Auto: Vice City Stories', 'slug' => 'gta-vice-city-stories', 'universe' => '3D',
                'release_date' => '2006-10-31',
                'platforms' => 'PSP, PlayStation 2',
                'setting' => 'Vice City, 1984',
                'tagline' => 'Sebelum kerajaan Vercetti berdiri.',
                'description' => 'Prekuel Vice City berlatar tahun 1984 yang mengisahkan Victor "Vic" Vance, sersan angkatan darat yang dipecat secara tidak adil dan terpaksa masuk dunia kriminal demi menghidupi keluarganya, termasuk adiknya yang sakit.',
                'theme_color' => '#f472b6', 'accent_color' => '#fb923c',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 6,
            ],

            // ==================== HD UNIVERSE ====================
            [
                'title' => 'Grand Theft Auto IV', 'slug' => 'gta-iv', 'universe' => 'HD',
                'release_date' => '2008-04-29',
                'platforms' => 'PlayStation 3, Xbox 360, PC',
                'setting' => 'Liberty City, 2008',
                'tagline' => 'Mengejar American Dream.',
                'description' => 'Awal era HD Universe dengan Liberty City yang dibangun ulang secara realistis. Niko Bellic, veteran perang dari Eropa Timur, tiba di Amerika untuk memulai hidup baru bersama sepupunya Roman, sekaligus memburu pengkhianat dari masa lalunya.',
                'theme_color' => '#374151', 'accent_color' => '#fbbf24',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 7,
            ],
            [
                'title' => 'GTA IV: The Lost and Damned', 'slug' => 'gta-the-lost-and-damned', 'universe' => 'HD',
                'release_date' => '2009-02-17',
                'platforms' => 'Xbox 360, PlayStation 3, PC',
                'setting' => 'Liberty City, 2008',
                'tagline' => 'Persaudaraan di atas dua roda.',
                'description' => 'Episode ekspansi GTA IV yang mengikuti Johnny Klebitz, wakil presiden klub motor The Lost. Kembalinya sang presiden Billy Grey dari rehabilitasi memicu konflik internal yang mengoyak persaudaraan klub.',
                'theme_color' => '#1c1917', 'accent_color' => '#a8a29e',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 8,
            ],
            [
                'title' => 'Grand Theft Auto: Chinatown Wars', 'slug' => 'gta-chinatown-wars', 'universe' => 'HD',
                'release_date' => '2009-03-17',
                'platforms' => 'Nintendo DS, PSP, Mobile',
                'setting' => 'Liberty City, 2009',
                'tagline' => 'Intrik Triad di jantung Liberty City.',
                'description' => 'Petualangan portabel bergaya top-down di HD Universe. Huang Lee, pemuda Triad yang manja, tiba di Liberty City untuk menyerahkan pedang pusaka keluarga, namun dirampok dan ditinggalkan mati. Ia pun menelusuri pengkhianatan di dalam organisasinya sendiri.',
                'theme_color' => '#b91c1c', 'accent_color' => '#facc15',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 9,
            ],
            [
                'title' => 'GTA: The Ballad of Gay Tony', 'slug' => 'gta-the-ballad-of-gay-tony', 'universe' => 'HD',
                'release_date' => '2009-10-29',
                'platforms' => 'Xbox 360, PlayStation 3, PC',
                'setting' => 'Liberty City, 2008',
                'tagline' => 'Gemerlap dunia malam Liberty City.',
                'description' => 'Episode kedua GTA IV yang menyorot sisi glamor kota lewat Luis Lopez, pengawal sekaligus rekan bisnis raja klub malam Tony "Gay Tony" Prince. Luis harus menyelamatkan bisnis Tony dari utang, mafia, dan kekacauan dunia malam.',
                'theme_color' => '#7c3aed', 'accent_color' => '#f0abfc',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 10,
            ],
            [
                'title' => 'Grand Theft Auto V', 'slug' => 'gta-v', 'universe' => 'HD',
                'release_date' => '2013-09-17',
                'platforms' => 'PS3, PS4, PS5, Xbox 360, Xbox One, Xbox Series X|S, PC',
                'setting' => 'Los Santos & Blaine County, 2013',
                'tagline' => 'Tiga kriminal, satu kota, tanpa jalan keluar.',
                'description' => 'Salah satu game terlaris sepanjang masa dengan tiga protagonis yang bisa dimainkan bergantian: Michael, perampok bank pensiunan; Franklin, pemuda ambisius dari selatan Los Santos; dan Trevor, mantan pilot yang tidak stabil. Ketiganya terseret ke rangkaian perampokan besar di Los Santos.',
                'theme_color' => '#38bdf8', 'accent_color' => '#f0abfc',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 11,
            ],
            [
                'title' => 'Grand Theft Auto Online', 'slug' => 'gta-online', 'universe' => 'HD',
                'release_date' => '2013-10-01',
                'platforms' => 'PS4, PS5, Xbox One, Xbox Series X|S, PC',
                'setting' => 'Los Santos & Blaine County',
                'tagline' => 'Bangun kerajaan kriminalmu sendiri.',
                'description' => 'Dunia multipemain daring yang terus berkembang di semesta GTA V. Pemain menciptakan karakter sendiri, merampok bersama teman, membangun bisnis, dan mengikuti pembaruan konten yang dirilis Rockstar secara berkala selama lebih dari satu dekade.',
                'theme_color' => '#10b981', 'accent_color' => '#a7f3d0',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 12,
            ],
            [
                'title' => 'Grand Theft Auto VI', 'slug' => 'gta-vi', 'universe' => 'HD',
                'release_date' => '2026-11-19',
                'platforms' => 'PlayStation 5, Xbox Series X|S',
                'setting' => 'Negara Bagian Leonida (Vice City), masa kini',
                'tagline' => 'Kembalinya sang raja ke Leonida.',
                'description' => 'Entri utama berikutnya yang membawa seri kembali ke Vice City dalam negara bagian Leonida yang terinspirasi Florida. Untuk pertama kalinya seri utama menghadirkan duo protagonis Jason Duval dan Lucia Caminos, pasangan kriminal yang terjebak dalam konspirasi di negeri paling cerah sekaligus paling berbahaya di Amerika.',
                'theme_color' => '#ff2ea6', 'accent_color' => '#7c3aed',
                'is_featured' => true, 'status' => 'upcoming', 'sort_order' => 13,
            ],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(['slug' => $game['slug']], $game);
        }
    }
}
