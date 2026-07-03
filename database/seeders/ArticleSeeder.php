<?php

namespace Database\Seeders;

use App\Models\Article;
use App\Models\Category;
use App\Models\Game;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ArticleSeeder extends Seeder
{
    public function run(): void
    {
        $author     = User::where('is_admin', true)->first();
        $categories = Category::pluck('id', 'slug');

        $articles = [
            [
                'title'    => 'Hitung Mundur GTA VI: Semua yang Perlu Kamu Tahu Menjelang 19 November 2026',
                'category' => 'berita', 'game' => 'gta-vi', 'is_headline' => true,
                'published_at' => now()->subDays(2),
                'excerpt'  => 'Setelah penantian lebih dari satu dekade, Grand Theft Auto VI akhirnya dijadwalkan rilis 19 November 2026. Berikut rangkuman lengkap fakta yang sudah dikonfirmasi.',
                'body'     => '<p>Penantian panjang para penggemar akhirnya mendekati garis akhir. Rockstar Games menetapkan <strong>19 November 2026</strong> sebagai tanggal rilis Grand Theft Auto VI untuk PlayStation 5 dan Xbox Series X|S, setelah sempat mengalami penundaan dari jadwal awal.</p><p>GTA VI membawa seri kembali ke Vice City, kali ini sebagai bagian dari negara bagian fiksi Leonida yang terinspirasi Florida. Untuk pertama kalinya dalam sejarah seri utama, pemain akan mengendalikan dua protagonis sekaligus: Jason Duval dan Lucia Caminos, pasangan kriminal dengan dinamika ala Bonnie dan Clyde.</p><p>Trailer perdananya memecahkan berbagai rekor penayangan di YouTube hanya dalam hitungan jam, sementara trailer kedua memperlihatkan lebih dalam hubungan Jason dan Lucia serta kehidupan pesisir Leonida yang cerah namun berbahaya. Pre-order sendiri telah dibuka sejak akhir Juni 2026.</p><p>Redaksi GTAVerse akan terus memperbarui halaman ini setiap ada informasi resmi baru dari Rockstar. Pantau terus!</p>',
            ],
            [
                'title'    => '25 Tahun GTA III: Game yang Mengubah Segalanya',
                'category' => 'fitur', 'game' => 'gta-iii', 'is_headline' => false,
                'published_at' => now()->subDays(5),
                'excerpt'  => 'Oktober 2026 menandai seperempat abad sejak GTA III mendefinisikan ulang genre dunia terbuka. Kami menengok kembali warisannya.',
                'body'     => '<p>Ketika Grand Theft Auto III meluncur pada 22 Oktober 2001, tidak ada yang benar-benar siap dengan dampaknya. Perpindahan dari perspektif top-down ke dunia tiga dimensi penuh mengubah Liberty City dari sekadar peta menjadi kota yang terasa hidup.</p><p>Formula "sandbox kriminal" yang diperkenalkannya — kebebasan menjelajah, misi non-linear, radio dalam kendaraan, dan dunia yang bereaksi terhadap pemain — menjadi cetak biru bagi ratusan game sesudahnya. Sulit membayangkan genre open-world modern tanpa fondasi yang diletakkan game ini.</p><p>Dua puluh lima tahun kemudian, jejaknya masih terasa di setiap entri seri, termasuk GTA VI yang akan rilis bulan November ini. Claude mungkin tidak pernah berbicara, tetapi game yang ia bintangi berbicara sangat lantang bagi industri.</p>',
            ],
            [
                'title'    => 'Mengapa Vice City Tetap Menjadi Atmosfer Terbaik dalam Sejarah GTA',
                'category' => 'fitur', 'game' => 'gta-vice-city', 'is_headline' => false,
                'published_at' => now()->subDays(8),
                'excerpt'  => 'Neon merah muda, musik synthwave, dan matahari terbenam tanpa akhir. Vice City membuktikan bahwa atmosfer bisa menjadi karakter utama.',
                'body'     => '<p>Ada alasan mengapa setiap kali Rockstar menggoda kembalinya Vice City, internet langsung riuh. Kota tropis yang dirilis tahun 2002 itu bukan sekadar latar — ia adalah surat cinta untuk dekade 1980-an yang berlebihan dalam segala hal.</p><p>Dari pantulan lampu neon di aspal basah hingga deretan lagu di stasiun radio fiksinya, Vice City membangun suasana yang belum tertandingi entri lain. Kisah Tommy Vercetti yang menapak dari pesuruh menjadi raja kota terasa seperti film gangster klasik yang bisa dimainkan.</p><p>Dengan GTA VI yang membawa kita kembali ke kota ini dalam balutan Leonida modern, menarik untuk melihat apakah nuansa magis itu bisa hadir kembali dalam versi masa kini — atau justru melahirkan identitas baru yang sama ikoniknya.</p>',
            ],
            [
                'title'    => 'GTA V Masih Laris Manis: Tembus Lebih dari 215 Juta Kopi',
                'category' => 'berita', 'game' => 'gta-v', 'is_headline' => false,
                'published_at' => now()->subDays(12),
                'excerpt'  => 'Tiga belas tahun setelah rilis, penjualan GTA V terus bertambah dan mengukuhkannya sebagai salah satu produk hiburan terlaris sepanjang masa.',
                'body'     => '<p>Grand Theft Auto V terus menolak untuk melambat. Berdasarkan laporan keuangan terbaru Take-Two Interactive, game yang pertama kali rilis pada 2013 ini telah terjual lebih dari 215 juta kopi di seluruh dunia — angka yang menjadikannya salah satu game terlaris sepanjang masa, hanya di bawah Minecraft.</p><p>Faktor terbesar di balik umur panjangnya jelas GTA Online, yang selama lebih dari satu dekade terus menerima pembaruan konten, mode baru, dan event komunitas. Perilisan ulang di tiga generasi konsol berbeda juga menjaga arus pemain baru tetap mengalir.</p><p>Menariknya, alih-alih menurun menjelang kedatangan GTA VI, antusiasme terhadap semesta Los Santos justru ikut terkerek naik. Banyak pemain lama kembali untuk bernostalgia sebelum berpindah ke Leonida akhir tahun ini.</p>',
            ],
            [
                'title'    => 'Peringkat Protagonis GTA Versi Redaksi: Dari Claude hingga Trevor',
                'category' => 'ulasan', 'game' => null, 'is_headline' => false,
                'published_at' => now()->subDays(15),
                'excerpt'  => 'Lima belas protagonis, dua semesta, satu perdebatan abadi. Redaksi GTAVerse menyusun peringkat karakter utama favorit sepanjang seri.',
                'body'     => '<p>Setiap penggemar GTA punya jagoannya masing-masing, dan perdebatan soal protagonis terbaik tidak pernah benar-benar selesai. Setelah diskusi panjang (dan beberapa adu argumen), redaksi menyusun daftar versi kami.</p><p>Di papan atas, Niko Bellic dan CJ nyaris tidak terpisahkan: Niko unggul lewat kisah imigran yang kelam dan penuh dilema moral, sementara CJ membawa perjalanan emosional dari Grove Street hingga puncak San Andreas. Tommy Vercetti menyusul berkat karisma dan transformasinya menjadi raja Vice City.</p><p>Trio GTA V menawarkan dinamika unik — dengan Trevor sebagai karakter paling tak terlupakan sekaligus paling kontroversial. Sementara itu, Claude yang membisu tetap ikonik sebagai wajah revolusi 3D. Bagaimana dengan Jason dan Lucia? Kita tunggu pembuktiannya November nanti.</p><p>Setuju atau tidak dengan urutan kami? Sampaikan versimu di kanal komunitas GTAVerse!</p>',
            ],
            [
                'title'    => 'Panduan Pemula GTA San Andreas: Tips Bertahan di Grove Street',
                'category' => 'panduan', 'game' => 'gta-san-andreas', 'is_headline' => false,
                'published_at' => now()->subDays(20),
                'excerpt'  => 'Baru pertama kali memainkan San Andreas di 2026? Berikut tips dasar agar perjalanan CJ dari Los Santos hingga Las Venturas berjalan mulus.',
                'body'     => '<p>Lebih dari dua dekade sejak rilisnya, San Andreas tetap menjadi gerbang favorit bagi pemain baru yang ingin mencicipi era klasik GTA. Berikut beberapa tips dari redaksi untuk memulai.</p><p><strong>Pertama, jangan abaikan statistik CJ.</strong> Berbeda dari entri lain, San Andreas memiliki sistem RPG ringan: stamina, otot, dan kemampuan mengemudi meningkat seiring dipakai. Rutin berlari, berenang, dan berlatih di gym sejak awal akan sangat memudahkan misi-misi belakangan.</p><p><strong>Kedua, kuasai wilayah secara bertahap.</strong> Perang wilayah (gang war) memberi pemasukan pasif, tetapi jangan serakah — wilayah yang terlalu luas sulit dipertahankan di awal permainan. <strong>Ketiga, simpan permainan sesering mungkin</strong> di safehouse, karena beberapa misi legendaris (halo, "Wrong Side of the Tracks") terkenal menguji kesabaran.</p><p>Terakhir, nikmati saja. San Andreas dirancang untuk dijelajahi tanpa buru-buru — dari pedesaan berkabut hingga gemerlap Las Venturas.</p>',
            ],
        ];

        foreach ($articles as $data) {
            $game = $data['game'] ? Game::where('slug', $data['game'])->first() : null;

            Article::updateOrCreate(
                ['slug' => Str::slug($data['title'])],
                [
                    'user_id'        => $author->id,
                    'category_id'    => $categories[$data['category']] ?? null,
                    'game_id'        => $game?->id,
                    'title'          => $data['title'],
                    'excerpt'        => $data['excerpt'],
                    'body'           => $data['body'],
                    'status'         => 'published',
                    'published_at'   => $data['published_at'],
                    'views'          => random_int(150, 4200),
                    'is_headline'    => $data['is_headline'],
                ]
            );
        }
    }
}
