<?php

namespace Database\Seeders;

use App\Models\Character;
use App\Models\Game;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class CharacterSeeder extends Seeder
{
    public function run(): void
    {
        $characters = [
            // ==================== 3D UNIVERSE ====================
            [
                'game' => 'gta-iii', 'name' => 'Claude', 'alias' => 'The Silent One',
                'voice_actor' => null, 'sort_order' => 1,
                'bio' => 'Protagonis bisu GTA III yang tidak pernah mengucapkan sepatah kata pun. Claude dikhianati dan ditembak oleh kekasihnya, Catalina, saat merampok bank. Setelah lolos dari konvoi tahanan, ia bekerja untuk berbagai fraksi kriminal Liberty City, dari mafia Leone hingga Yakuza, demi menuntut balas.',
            ],
            [
                'game' => 'gta-vice-city', 'name' => 'Tommy Vercetti', 'alias' => 'The Harwood Butcher',
                'voice_actor' => 'Ray Liotta', 'sort_order' => 2,
                'bio' => 'Mantan anggota keluarga Forelli yang menghabiskan 15 tahun di penjara. Dikirim ke Vice City untuk mengurus transaksi narkoba yang ternyata sebuah jebakan, Tommy memutuskan untuk tidak pulang dengan tangan kosong. Ia merebut kota itu blok demi blok hingga berdiri di puncak kerajaan kriminalnya sendiri.',
            ],
            [
                'game' => 'gta-san-andreas', 'name' => 'Carl Johnson', 'alias' => 'CJ',
                'voice_actor' => 'Young Maylay', 'sort_order' => 3,
                'bio' => 'Pemuda Grove Street yang kembali ke Los Santos setelah lima tahun di Liberty City karena ibunya terbunuh. Diperas oleh polisi korup C.R.A.S.H. pimpinan Frank Tenpenny, CJ berjuang membangun kembali gengnya, menyelamatkan keluarganya, dan menguak pengkhianatan yang menghancurkan Grove Street.',
            ],
            [
                'game' => 'gta-advance', 'name' => 'Mike', 'alias' => null,
                'voice_actor' => null, 'sort_order' => 4,
                'bio' => 'Kriminal kelas bawah Liberty City yang berencana meninggalkan dunia hitam bersama rekannya, Vinnie. Ketika Vinnie tewas dalam ledakan mobil, Mike menelusuri jejak pembunuhnya dan menemukan kebenaran yang lebih rumit dari dugaannya.',
            ],
            [
                'game' => 'gta-liberty-city-stories', 'name' => 'Toni Cipriani', 'alias' => null,
                'voice_actor' => 'Danny Mastrogiorgio', 'sort_order' => 5,
                'bio' => 'Anggota setia keluarga mafia Leone yang kembali ke Liberty City tahun 1998 setelah bersembunyi karena membunuh orang penting demi sang don, Salvatore Leone. Toni harus memulai lagi dari bawah dan membuktikan kesetiaannya di tengah perang tiga keluarga mafia.',
            ],
            [
                'game' => 'gta-vice-city-stories', 'name' => 'Victor Vance', 'alias' => 'Vic',
                'voice_actor' => 'Dorian Missick', 'sort_order' => 6,
                'bio' => 'Sersan angkatan darat yang dipecat secara tidak hormat karena ulah atasannya yang korup. Demi membiayai pengobatan adiknya, Vic terjun ke bisnis kriminal Vice City tahun 1984 dan membangun kerajaan bersama saudaranya, Lance, sebelum peristiwa tragis di awal Vice City.',
            ],

            // ==================== HD UNIVERSE ====================
            [
                'game' => 'gta-iv', 'name' => 'Niko Bellic', 'alias' => null,
                'voice_actor' => 'Michael Hollick', 'sort_order' => 7,
                'bio' => 'Veteran Perang Yugoslavia dari Eropa Timur yang berlayar ke Liberty City demi "American Dream" yang dijanjikan sepupunya, Roman. Kenyataannya jauh dari mimpi: Niko terseret utang, mafia, dan perburuan panjang terhadap pengkhianat yang menewaskan kawan-kawannya di masa perang.',
            ],
            [
                'game' => 'gta-the-lost-and-damned', 'name' => 'Johnny Klebitz', 'alias' => null,
                'voice_actor' => 'Scott Hill', 'sort_order' => 8,
                'bio' => 'Wakil presiden klub motor The Lost yang pragmatis dan berusaha menjaga klub tetap hidup lewat bisnis yang "lebih tenang". Kembalinya presiden klub Billy Grey yang ugal-ugalan memaksa Johnny memilih antara kesetiaan pada persaudaraan atau kelangsungan hidup klubnya.',
            ],
            [
                'game' => 'gta-chinatown-wars', 'name' => 'Huang Lee', 'alias' => null,
                'voice_actor' => null, 'sort_order' => 9,
                'bio' => 'Putra bos Triad yang manja, dikirim ke Liberty City untuk menyerahkan pedang pusaka Yu Jian kepada pamannya. Sesampainya di kota, ia dirampok, ditembak, dan dibuang ke sungai. Huang selamat dan menelusuri pengkhianatan yang ternyata bersarang di keluarganya sendiri.',
            ],
            [
                'game' => 'gta-the-ballad-of-gay-tony', 'name' => 'Luis Fernando Lopez', 'alias' => null,
                'voice_actor' => 'Mario D\'Leon', 'sort_order' => 10,
                'bio' => 'Pengawal pribadi sekaligus rekan bisnis Tony "Gay Tony" Prince, raja dunia malam Liberty City. Luis menyeimbangkan kehidupan glamor klub malam dengan tugas kotor menyelamatkan bisnis Tony dari lintah darat, mafia, dan miliarder eksentrik.',
            ],
            [
                'game' => 'gta-v', 'name' => 'Michael De Santa', 'alias' => 'Michael Townley',
                'voice_actor' => 'Ned Luke', 'sort_order' => 11,
                'bio' => 'Perampok bank legendaris yang "pensiun" lewat kesepakatan rahasia dengan FIB dan hidup mewah di Rockford Hills dengan identitas baru. Krisis paruh baya dan keluarga yang berantakan menyeretnya kembali ke dunia perampokan, tepat ketika masa lalunya menyusul.',
            ],
            [
                'game' => 'gta-v', 'name' => 'Franklin Clinton', 'alias' => null,
                'voice_actor' => 'Shawn Fonteno', 'sort_order' => 12,
                'bio' => 'Pemuda dari selatan Los Santos yang bekerja sebagai penarik mobil kredit macet dan muak dengan hidup gang yang jalan di tempat. Pertemuannya dengan Michael membuka pintu ke liga kriminal yang jauh lebih besar sekaligus lebih berbahaya.',
            ],
            [
                'game' => 'gta-v', 'name' => 'Trevor Philips', 'alias' => null,
                'voice_actor' => 'Steven Ogg', 'sort_order' => 13,
                'bio' => 'Mantan pilot militer yang gagal, kini menjalankan "Trevor Philips Industries" di gurun Blaine County: bisnis narkoba dan senjata yang dikelola dengan kekerasan tanpa filter. Sahabat lama sekaligus mimpi buruk Michael, Trevor adalah sosok paling eksplosif di Los Santos.',
            ],
            [
                'game' => 'gta-vi', 'name' => 'Lucia Caminos', 'alias' => null,
                'voice_actor' => 'Belum diumumkan resmi', 'sort_order' => 14,
                'bio' => 'Protagonis wanita pertama di era modern seri GTA. Diperkenalkan lewat trailer perdana dalam balutan seragam penjara Leonida, Lucia adalah sosok tangguh yang kehilangan segalanya dan siap melakukan apa pun demi kebebasan serta kehidupan baru bersama Jason.',
            ],
            [
                'game' => 'gta-vi', 'name' => 'Jason Duval', 'alias' => null,
                'voice_actor' => 'Belum diumumkan resmi', 'sort_order' => 15,
                'bio' => 'Pasangan Lucia dalam kisah kriminal ala Bonnie dan Clyde di negara bagian Leonida. Jason menginginkan hidup yang tenang, namun jalan pintas dan pergaulan dengan penyelundup lokal menyeretnya semakin dalam ke dunia hitam Vice City modern.',
            ],
        ];

        foreach ($characters as $data) {
            $game = Game::where('slug', $data['game'])->first();

            if (! $game) {
                continue;
            }

            Character::updateOrCreate(
                ['slug' => Str::slug($data['name'])],
                [
                    'game_id'        => $game->id,
                    'name'           => $data['name'],
                    'alias'          => $data['alias'],
                    'role'           => 'Protagonis Utama',
                    'voice_actor'    => $data['voice_actor'],
                    'bio'            => $data['bio'],
                    'is_protagonist' => true,
                    'sort_order'     => $data['sort_order'],
                ]
            );
        }
    }
}
