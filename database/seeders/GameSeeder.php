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
                'tagline' => 'The dawn of the 3D open-world era.',
                'description' => 'The game that revolutionized the industry by bringing the Grand Theft Auto series into a fully three-dimensional open world. Players take on the role of Claude, a mute criminal betrayed by his lover during a bank robbery, who climbs the ranks of Liberty City\'s criminal underworld in pursuit of revenge.',
                'theme_color' => '#28425f', 'accent_color' => '#9db6cc',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 1,
            ],
            [
                'title' => 'Grand Theft Auto: Vice City', 'slug' => 'gta-vice-city', 'universe' => '3D',
                'release_date' => '2002-10-29',
                'platforms' => 'PlayStation 2, Xbox, PC, Mobile',
                'setting' => 'Vice City, 1986',
                'tagline' => 'Neon, the eighties, and limitless ambition.',
                'description' => 'Set in a tropical, Miami-inspired city in 1986, Vice City follows Tommy Vercetti, fresh out of prison and sent south by the Forelli family. After a drug deal turns into an ambush, Tommy builds a criminal empire of his own in this neon-soaked city.',
                'theme_color' => '#ff2e88', 'accent_color' => '#00e5ff',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 2,
            ],
            [
                'title' => 'Grand Theft Auto Advance', 'slug' => 'gta-advance', 'universe' => '3D',
                'release_date' => '2004-10-26',
                'platforms' => 'Game Boy Advance',
                'setting' => 'Liberty City, 2000',
                'tagline' => 'Liberty City from a top-down view.',
                'description' => 'A portable entry with the classic top-down perspective, set in Liberty City one year before the events of GTA III. Players follow Mike, a low-level criminal investigating the death of his partner, Vinnie, amid the city\'s gang wars.',
                'theme_color' => '#4b5563', 'accent_color' => '#d1d5db',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 3,
            ],
            [
                'title' => 'Grand Theft Auto: San Andreas', 'slug' => 'gta-san-andreas', 'universe' => '3D',
                'release_date' => '2004-10-26',
                'platforms' => 'PlayStation 2, Xbox, PC, Mobile',
                'setting' => 'State of San Andreas, 1992',
                'tagline' => 'Back to Grove Street.',
                'description' => 'The biggest adventure of the 3D Universe, spanning three cities: Los Santos, San Fierro, and Las Venturas. Carl "CJ" Johnson returns to Grove Street after his mother is murdered, only to be dragged back into a world of gangs, corrupt cops, and a conspiracy that threatens his family.',
                'theme_color' => '#e8862e', 'accent_color' => '#2f6b39',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 4,
            ],
            [
                'title' => 'Grand Theft Auto: Liberty City Stories', 'slug' => 'gta-liberty-city-stories', 'universe' => '3D',
                'release_date' => '2005-10-24',
                'platforms' => 'PSP, PlayStation 2, Mobile',
                'setting' => 'Liberty City, 1998',
                'tagline' => 'Loyalty to the Leone family.',
                'description' => 'A prequel to GTA III following Toni Cipriani, a loyal member of the Leone crime family who returns to Liberty City after time in hiding. Toni must reclaim his standing while protecting the Leone family through a war between the mafia families.',
                'theme_color' => '#1e3a8a', 'accent_color' => '#93c5fd',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 5,
            ],
            [
                'title' => 'Grand Theft Auto: Vice City Stories', 'slug' => 'gta-vice-city-stories', 'universe' => '3D',
                'release_date' => '2006-10-31',
                'platforms' => 'PSP, PlayStation 2',
                'setting' => 'Vice City, 1984',
                'tagline' => 'Before the Vercetti empire rose.',
                'description' => 'A Vice City prequel set in 1984, telling the story of Victor "Vic" Vance, an army sergeant unfairly discharged and forced into the criminal world to support his family, including his sick brother.',
                'theme_color' => '#f472b6', 'accent_color' => '#fb923c',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 6,
            ],

            // ==================== HD UNIVERSE ====================
            [
                'title' => 'Grand Theft Auto IV', 'slug' => 'gta-iv', 'universe' => 'HD',
                'release_date' => '2008-04-29',
                'platforms' => 'PlayStation 3, Xbox 360, PC',
                'setting' => 'Liberty City, 2008',
                'tagline' => 'Chasing the American Dream.',
                'description' => 'The start of the HD Universe era, with a realistically rebuilt Liberty City. Niko Bellic, a war veteran from Eastern Europe, arrives in America to start a new life with his cousin Roman — and to hunt down a traitor from his past.',
                'theme_color' => '#374151', 'accent_color' => '#fbbf24',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 7,
            ],
            [
                'title' => 'GTA IV: The Lost and Damned', 'slug' => 'gta-the-lost-and-damned', 'universe' => 'HD',
                'release_date' => '2009-02-17',
                'platforms' => 'Xbox 360, PlayStation 3, PC',
                'setting' => 'Liberty City, 2008',
                'tagline' => 'Brotherhood on two wheels.',
                'description' => 'A GTA IV expansion episode following Johnny Klebitz, vice president of The Lost motorcycle club. The return of club president Billy Grey from rehab sparks an internal conflict that tears the brotherhood apart.',
                'theme_color' => '#1c1917', 'accent_color' => '#a8a29e',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 8,
            ],
            [
                'title' => 'Grand Theft Auto: Chinatown Wars', 'slug' => 'gta-chinatown-wars', 'universe' => 'HD',
                'release_date' => '2009-03-17',
                'platforms' => 'Nintendo DS, PSP, Mobile',
                'setting' => 'Liberty City, 2009',
                'tagline' => 'Triad intrigue in the heart of Liberty City.',
                'description' => 'A portable top-down adventure in the HD Universe. Huang Lee, a spoiled Triad heir, arrives in Liberty City to deliver a family heirloom sword, but is robbed and left for dead. He sets out to unravel a betrayal rooted inside his own organization.',
                'theme_color' => '#b91c1c', 'accent_color' => '#facc15',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 9,
            ],
            [
                'title' => 'GTA: The Ballad of Gay Tony', 'slug' => 'gta-the-ballad-of-gay-tony', 'universe' => 'HD',
                'release_date' => '2009-10-29',
                'platforms' => 'Xbox 360, PlayStation 3, PC',
                'setting' => 'Liberty City, 2008',
                'tagline' => 'The glitter of Liberty City\'s nightlife.',
                'description' => 'The second GTA IV episode, spotlighting the city\'s glamorous side through Luis Lopez, bodyguard and business partner of nightlife king Tony "Gay Tony" Prince. Luis must save Tony\'s business from debt, the mob, and the chaos of the club scene.',
                'theme_color' => '#7c3aed', 'accent_color' => '#f0abfc',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 10,
            ],
            [
                'title' => 'Grand Theft Auto V', 'slug' => 'gta-v', 'universe' => 'HD',
                'release_date' => '2013-09-17',
                'platforms' => 'PS3, PS4, PS5, Xbox 360, Xbox One, Xbox Series X|S, PC',
                'setting' => 'Los Santos & Blaine County, 2013',
                'tagline' => 'Three criminals, one city, no way out.',
                'description' => 'One of the best-selling games of all time, with three playable protagonists: Michael, a retired bank robber; Franklin, an ambitious young man from South Los Santos; and Trevor, an unstable former pilot. The three are drawn into a string of major heists across Los Santos.',
                'theme_color' => '#38bdf8', 'accent_color' => '#f0abfc',
                'is_featured' => true, 'status' => 'released', 'sort_order' => 11,
            ],
            [
                'title' => 'Grand Theft Auto Online', 'slug' => 'gta-online', 'universe' => 'HD',
                'release_date' => '2013-10-01',
                'platforms' => 'PS4, PS5, Xbox One, Xbox Series X|S, PC',
                'setting' => 'Los Santos & Blaine County',
                'tagline' => 'Build your own criminal empire.',
                'description' => 'The ever-evolving online multiplayer world of the GTA V universe. Players create their own character, pull off heists with friends, build businesses, and follow the content updates Rockstar has released regularly for more than a decade.',
                'theme_color' => '#10b981', 'accent_color' => '#a7f3d0',
                'is_featured' => false, 'status' => 'released', 'sort_order' => 12,
            ],
            [
                'title' => 'Grand Theft Auto VI', 'slug' => 'gta-vi', 'universe' => 'HD',
                'release_date' => '2026-11-19',
                'platforms' => 'PlayStation 5, Xbox Series X|S',
                'setting' => 'State of Leonida (Vice City), present day',
                'tagline' => 'The king returns to Leonida.',
                'description' => 'The next mainline entry, bringing the series back to Vice City within the Florida-inspired state of Leonida. For the first time in the main series, players control two protagonists: Jason Duval and Lucia Caminos, a criminal couple caught in a conspiracy in America\'s sunniest — and most dangerous — state.',
                'theme_color' => '#ff2ea6', 'accent_color' => '#7c3aed',
                'is_featured' => true, 'status' => 'upcoming', 'sort_order' => 13,
            ],
        ];

        foreach ($games as $game) {
            Game::updateOrCreate(['slug' => $game['slug']], $game);
        }
    }
}
