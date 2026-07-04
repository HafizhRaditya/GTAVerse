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
                'bio' => 'The mute protagonist of GTA III who never speaks a single word. Claude is betrayed and shot by his lover, Catalina, during a bank robbery. After escaping a prison convoy, he works for Liberty City\'s criminal factions — from the Leone mafia to the Yakuza — in pursuit of revenge.',
            ],
            [
                'game' => 'gta-vice-city', 'name' => 'Tommy Vercetti', 'alias' => 'The Harwood Butcher',
                'voice_actor' => 'Ray Liotta', 'sort_order' => 2,
                'bio' => 'A former Forelli family member who spent 15 years in prison. Sent to Vice City to handle a drug deal that turns out to be a setup, Tommy decides he is not going home empty-handed. He takes the city block by block until he stands at the top of his own criminal empire.',
            ],
            [
                'game' => 'gta-san-andreas', 'name' => 'Carl Johnson', 'alias' => 'CJ',
                'voice_actor' => 'Young Maylay', 'sort_order' => 3,
                'bio' => 'A Grove Street native who returns to Los Santos after five years in Liberty City when his mother is murdered. Blackmailed by the corrupt C.R.A.S.H. cops led by Frank Tenpenny, CJ fights to rebuild his gang, protect his family, and expose the betrayal that destroyed Grove Street.',
            ],
            [
                'game' => 'gta-advance', 'name' => 'Mike', 'alias' => null,
                'voice_actor' => null, 'sort_order' => 4,
                'bio' => 'A low-level Liberty City criminal planning to leave the underworld with his partner, Vinnie. When Vinnie dies in a car bombing, Mike traces the killer\'s trail and uncovers a truth far more complicated than he expected.',
            ],
            [
                'game' => 'gta-liberty-city-stories', 'name' => 'Toni Cipriani', 'alias' => null,
                'voice_actor' => 'Danny Mastrogiorgio', 'sort_order' => 5,
                'bio' => 'A loyal member of the Leone crime family who returns to Liberty City in 1998 after hiding out for killing a made man on behalf of his don, Salvatore Leone. Toni must start again from the bottom and prove his loyalty amid a war between three mafia families.',
            ],
            [
                'game' => 'gta-vice-city-stories', 'name' => 'Victor Vance', 'alias' => 'Vic',
                'voice_actor' => 'Dorian Missick', 'sort_order' => 6,
                'bio' => 'An army sergeant dishonorably discharged because of his corrupt superior. To pay for his brother\'s medical treatment, Vic dives into Vice City\'s criminal business in 1984 and builds an empire with his brother Lance — before the tragic events at the start of Vice City.',
            ],

            // ==================== HD UNIVERSE ====================
            [
                'game' => 'gta-iv', 'name' => 'Niko Bellic', 'alias' => null,
                'voice_actor' => 'Michael Hollick', 'sort_order' => 7,
                'bio' => 'A Yugoslav Wars veteran from Eastern Europe who sails to Liberty City for the "American Dream" promised by his cousin Roman. The reality is far from the dream: Niko is dragged into debt, the mafia, and a long hunt for the traitor who got his wartime friends killed.',
            ],
            [
                'game' => 'gta-the-lost-and-damned', 'name' => 'Johnny Klebitz', 'alias' => null,
                'voice_actor' => 'Scott Hill', 'sort_order' => 8,
                'bio' => 'The pragmatic vice president of The Lost motorcycle club, trying to keep the club alive through "quieter" business. The return of reckless club president Billy Grey forces Johnny to choose between loyalty to the brotherhood and the survival of his club.',
            ],
            [
                'game' => 'gta-chinatown-wars', 'name' => 'Huang Lee', 'alias' => null,
                'voice_actor' => null, 'sort_order' => 9,
                'bio' => 'The spoiled son of a Triad boss, sent to Liberty City to deliver the heirloom sword Yu Jian to his uncle. On arrival he is robbed, shot, and dumped in a river. Huang survives and follows the trail of a betrayal that turns out to be rooted in his own family.',
            ],
            [
                'game' => 'gta-the-ballad-of-gay-tony', 'name' => 'Luis Fernando Lopez', 'alias' => null,
                'voice_actor' => 'Mario D\'Leon', 'sort_order' => 10,
                'bio' => 'Personal bodyguard and business partner of Tony "Gay Tony" Prince, the king of Liberty City nightlife. Luis balances the glamour of the club scene with the dirty work of saving Tony\'s business from loan sharks, the mob, and eccentric billionaires.',
            ],
            [
                'game' => 'gta-v', 'name' => 'Michael De Santa', 'alias' => 'Michael Townley',
                'voice_actor' => 'Ned Luke', 'sort_order' => 11,
                'bio' => 'A legendary bank robber who "retired" through a secret deal with the FIB and lives in luxury in Rockford Hills under a new identity. A midlife crisis and a dysfunctional family drag him back into the heist business — just as his past catches up with him.',
            ],
            [
                'game' => 'gta-v', 'name' => 'Franklin Clinton', 'alias' => null,
                'voice_actor' => 'Shawn Fonteno', 'sort_order' => 12,
                'bio' => 'A young man from South Los Santos working as a repo man, fed up with a gang life that is going nowhere. Meeting Michael opens the door to a criminal league that is far bigger — and far more dangerous.',
            ],
            [
                'game' => 'gta-v', 'name' => 'Trevor Philips', 'alias' => null,
                'voice_actor' => 'Steven Ogg', 'sort_order' => 13,
                'bio' => 'A washed-out former military pilot who now runs "Trevor Philips Industries" in the Blaine County desert: a drugs-and-guns business managed with unfiltered violence. Michael\'s old friend and worst nightmare, Trevor is the most explosive figure in Los Santos.',
            ],
            [
                'game' => 'gta-vi', 'name' => 'Lucia Caminos', 'alias' => null,
                'voice_actor' => 'Not yet officially announced', 'sort_order' => 14,
                'bio' => 'The first female protagonist of the series\' modern era. Introduced in the debut trailer wearing a Leonida prison uniform, Lucia is a tough woman who has lost everything and is ready to do whatever it takes for freedom and a new life with Jason.',
            ],
            [
                'game' => 'gta-vi', 'name' => 'Jason Duval', 'alias' => null,
                'voice_actor' => 'Not yet officially announced', 'sort_order' => 15,
                'bio' => 'Lucia\'s partner in a Bonnie-and-Clyde-style crime story set in the state of Leonida. Jason wants a quiet life, but shortcuts and the company of local smugglers pull him ever deeper into the underworld of modern Vice City.',
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
                    'role'           => 'Main Protagonist',
                    'voice_actor'    => $data['voice_actor'],
                    'bio'            => $data['bio'],
                    'is_protagonist' => true,
                    'sort_order'     => $data['sort_order'],
                ]
            );
        }
    }
}
