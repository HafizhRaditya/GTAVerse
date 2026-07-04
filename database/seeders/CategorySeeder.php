<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        // 'legacy' holds the old Indonesian slug so existing rows are
        // updated in place (keeping their article relations) instead of duplicated.
        $categories = [
            ['name' => 'News',      'slug' => 'news',      'legacy' => 'berita'],
            ['name' => 'Rumors',    'slug' => 'rumors',    'legacy' => 'rumor'],
            ['name' => 'Reviews',   'slug' => 'reviews',   'legacy' => 'ulasan'],
            ['name' => 'Guides',    'slug' => 'guides',    'legacy' => 'panduan'],
            ['name' => 'Features',  'slug' => 'features',  'legacy' => 'fitur'],
            ['name' => 'Community', 'slug' => 'community', 'legacy' => 'komunitas'],
        ];

        foreach ($categories as $data) {
            $category = Category::whereIn('slug', [$data['slug'], $data['legacy']])->first();

            if ($category) {
                $category->update(['name' => $data['name'], 'slug' => $data['slug']]);
            } else {
                Category::create(['name' => $data['name'], 'slug' => $data['slug']]);
            }
        }
    }
}
