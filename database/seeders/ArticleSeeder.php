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

        // 'legacy_slug' holds the old Indonesian slug so existing rows are
        // updated in place (keeping images and view counts) instead of duplicated.
        $articles = [
            [
                'title'    => 'GTA VI Countdown: Everything You Need to Know Ahead of November 19, 2026',
                'legacy_slug' => 'hitung-mundur-gta-vi-semua-yang-perlu-kamu-tahu-menjelang-19-november-2026',
                'category' => 'news', 'game' => 'gta-vi', 'is_headline' => true,
                'published_at' => now()->subDays(2),
                'excerpt'  => 'After more than a decade of waiting, Grand Theft Auto VI is finally scheduled for release on November 19, 2026. Here is a full rundown of everything confirmed so far.',
                'body'     => '<p>The long wait is finally approaching the finish line. Rockstar Games has set <strong>November 19, 2026</strong> as the release date for Grand Theft Auto VI on PlayStation 5 and Xbox Series X|S, after a delay from the original schedule.</p><p>GTA VI brings the series back to Vice City, this time as part of the fictional, Florida-inspired state of Leonida. For the first time in mainline series history, players will control two protagonists: Jason Duval and Lucia Caminos, a criminal couple with a Bonnie-and-Clyde dynamic.</p><p>The debut trailer shattered YouTube viewing records within hours, while the second trailer offered a deeper look at Jason and Lucia\'s relationship and Leonida\'s sunny yet dangerous coastal life. Pre-orders have been open since late June 2026.</p><p>The GTAVerse editorial team will keep updating this page whenever new official information arrives from Rockstar. Stay tuned!</p>',
            ],
            [
                'title'    => '25 Years of GTA III: The Game That Changed Everything',
                'legacy_slug' => '25-tahun-gta-iii-game-yang-mengubah-segalanya',
                'category' => 'features', 'game' => 'gta-iii', 'is_headline' => false,
                'published_at' => now()->subDays(5),
                'excerpt'  => 'October 2026 marks a quarter century since GTA III redefined the open-world genre. We look back at its legacy.',
                'body'     => '<p>When Grand Theft Auto III launched on October 22, 2001, nobody was truly prepared for its impact. The shift from a top-down perspective to a fully three-dimensional world transformed Liberty City from a mere map into a city that felt alive.</p><p>The "criminal sandbox" formula it introduced — freedom to explore, non-linear missions, in-car radio stations, and a world that reacts to the player — became the blueprint for hundreds of games that followed. It is hard to imagine the modern open-world genre without the foundation this game laid.</p><p>Twenty-five years later, its fingerprints are still visible on every entry in the series, including GTA VI arriving this November. Claude may never have spoken, but the game he starred in spoke very loudly for the entire industry.</p>',
            ],
            [
                'title'    => 'Why Vice City Still Has the Best Atmosphere in GTA History',
                'legacy_slug' => 'mengapa-vice-city-tetap-menjadi-atmosfer-terbaik-dalam-sejarah-gta',
                'category' => 'features', 'game' => 'gta-vice-city', 'is_headline' => false,
                'published_at' => now()->subDays(8),
                'excerpt'  => 'Pink neon, synthwave music, and endless sunsets. Vice City proved that atmosphere can be the main character.',
                'body'     => '<p>There is a reason the internet erupts every time Rockstar teases a return to Vice City. The tropical city released in 2002 was never just a backdrop — it was a love letter to the gloriously excessive 1980s.</p><p>From neon reflections on wet asphalt to the track list of its fictional radio stations, Vice City built an atmosphere no other entry has matched. Tommy Vercetti\'s rise from errand boy to king of the city plays like a classic gangster film you can control.</p><p>With GTA VI taking us back to this city in its modern Leonida form, it will be fascinating to see whether that magic can return in a present-day setting — or whether it will forge a new identity that is just as iconic.</p>',
            ],
            [
                'title'    => 'GTA V Is Still Selling Strong: Over 215 Million Copies Shipped',
                'legacy_slug' => 'gta-v-masih-laris-manis-tembus-lebih-dari-215-juta-kopi',
                'category' => 'news', 'game' => 'gta-v', 'is_headline' => false,
                'published_at' => now()->subDays(12),
                'excerpt'  => 'Thirteen years after release, GTA V sales keep climbing, cementing it as one of the best-selling entertainment products of all time.',
                'body'     => '<p>Grand Theft Auto V simply refuses to slow down. According to Take-Two Interactive\'s latest financial report, the game first released in 2013 has now sold more than 215 million copies worldwide — a figure that makes it one of the best-selling games of all time, second only to Minecraft.</p><p>The biggest factor behind its longevity is clearly GTA Online, which has received content updates, new modes, and community events for over a decade. Re-releases across three console generations have also kept new players flowing in.</p><p>Interestingly, rather than declining ahead of GTA VI\'s arrival, enthusiasm for the Los Santos universe has risen with it. Many longtime players are returning for one more nostalgic run before moving to Leonida at the end of this year.</p>',
            ],
            [
                'title'    => 'Ranking the GTA Protagonists: From Claude to Trevor',
                'legacy_slug' => 'peringkat-protagonis-gta-versi-redaksi-dari-claude-hingga-trevor',
                'category' => 'reviews', 'game' => null, 'is_headline' => false,
                'published_at' => now()->subDays(15),
                'excerpt'  => 'Fifteen protagonists, two universes, one eternal debate. The GTAVerse editorial team ranks the series\' leading characters.',
                'body'     => '<p>Every GTA fan has a favorite, and the debate over the best protagonist never truly ends. After long discussions (and a few heated arguments), the editorial team has put together our ranking.</p><p>At the top, Niko Bellic and CJ are nearly inseparable: Niko leads with a dark immigrant story full of moral dilemmas, while CJ carries an emotional journey from Grove Street to the top of San Andreas. Tommy Vercetti follows thanks to his charisma and transformation into the king of Vice City.</p><p>The GTA V trio offers a unique dynamic — with Trevor as the most unforgettable and most controversial character of all. Meanwhile, the silent Claude remains iconic as the face of the 3D revolution. As for Jason and Lucia? We\'ll find out in November.</p><p>Agree or disagree with our order? Share your version through the GTAVerse suggestion box!</p>',
            ],
            [
                'title'    => 'GTA San Andreas Beginner\'s Guide: Tips for Surviving Grove Street',
                'legacy_slug' => 'panduan-pemula-gta-san-andreas-tips-bertahan-di-grove-street',
                'category' => 'guides', 'game' => 'gta-san-andreas', 'is_headline' => false,
                'published_at' => now()->subDays(20),
                'excerpt'  => 'Playing San Andreas for the first time in 2026? Here are the essential tips to keep CJ\'s journey from Los Santos to Las Venturas running smoothly.',
                'body'     => '<p>More than two decades after its release, San Andreas remains the favorite gateway for new players wanting a taste of the classic GTA era. Here are some tips from the editorial team to get you started.</p><p><strong>First, don\'t ignore CJ\'s stats.</strong> Unlike other entries, San Andreas has a light RPG system: stamina, muscle, and driving skill improve with use. Running, swimming, and hitting the gym early on will make later missions much easier.</p><p><strong>Second, take over territory gradually.</strong> Gang wars provide passive income, but don\'t get greedy — territory that is too large is hard to defend early in the game. <strong>Third, save your game as often as possible</strong> at a safehouse, because some legendary missions (hello, "Wrong Side of the Tracks") are famous tests of patience.</p><p>Finally, just enjoy it. San Andreas is designed to be explored without hurry — from misty countryside to the glitter of Las Venturas.</p>',
            ],
        ];

        foreach ($articles as $data) {
            $game = $data['game'] ? Game::where('slug', $data['game'])->first() : null;
            $slug = Str::slug($data['title']);

            $payload = [
                'user_id'      => $author->id,
                'category_id'  => $categories[$data['category']] ?? null,
                'game_id'      => $game?->id,
                'title'        => $data['title'],
                'slug'         => $slug,
                'excerpt'      => $data['excerpt'],
                'body'         => $data['body'],
                'status'       => 'published',
                'published_at' => $data['published_at'],
                'is_headline'  => $data['is_headline'],
            ];

            $existing = Article::whereIn('slug', [$slug, $data['legacy_slug']])->first();

            if ($existing) {
                // Update in place: keep the featured image and view count.
                $existing->update($payload);
            } else {
                Article::create($payload + ['views' => random_int(150, 4200)]);
            }
        }
    }
}
