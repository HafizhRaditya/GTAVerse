<?php

namespace Tests\Unit;

use App\Models\Article;
use App\Models\Character;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/** Pengujian unit terhadap accessor dan scope pada model. */
class ModelAttributeTest extends TestCase
{
    use RefreshDatabase;

    public function test_waktu_baca_minimal_satu_menit(): void
    {
        $artikel = new Article(['body' => '<p>Halo dunia</p>']);

        $this->assertSame(1, $artikel->reading_time);
    }

    public function test_waktu_baca_dihitung_dua_ratus_kata_per_menit(): void
    {
        $artikel = new Article(['body' => str_repeat('kata ', 400)]);

        $this->assertSame(2, $artikel->reading_time);
    }

    public function test_waktu_baca_mengabaikan_tag_html(): void
    {
        $polos = new Article(['body' => str_repeat('kata ', 200)]);
        $berhtml = new Article(['body' => '<div><p>'.str_repeat('kata ', 200).'</p></div>']);

        $this->assertSame($polos->reading_time, $berhtml->reading_time);
    }

    public function test_inisial_diambil_dari_dua_kata_pertama(): void
    {
        $this->assertSame('LC', (new Character(['name' => 'Lucia Caminos']))->initials);
    }

    public function test_inisial_nama_satu_kata(): void
    {
        $this->assertSame('C', (new Character(['name' => 'Claude']))->initials);
    }

    public function test_inisial_maksimal_dua_huruf(): void
    {
        $this->assertSame('LF', (new Character(['name' => 'Luis Fernando Lopez']))->initials);
    }

    public function test_scope_published_hanya_mengambil_artikel_yang_layak_tampil(): void
    {
        $this->admin();
        $this->article(['title' => 'Terbit kemarin', 'published_at' => now()->subDay()]);
        $this->article(['title' => 'Masih draf', 'status' => 'draft']);
        $this->article(['title' => 'Terbit tanpa tanggal', 'published_at' => null]);
        $this->article(['title' => 'Terjadwal besok', 'published_at' => now()->addDay()]);

        $hasil = Article::published()->pluck('title')->all();

        $this->assertSame(['Terbit kemarin'], $hasil);
    }

    public function test_scope_search_menyaring_judul_ringkasan_dan_isi(): void
    {
        $this->admin();
        $this->article(['title' => 'Berita GTA VI', 'body' => 'isi biasa']);
        $this->article(['title' => 'Artikel lain', 'body' => 'membahas Leonida']);
        $this->article(['title' => 'Tidak relevan', 'body' => 'isi biasa']);

        $this->assertCount(1, Article::search('Leonida')->get());
        $this->assertCount(1, Article::search('GTA VI')->get());
        $this->assertCount(3, Article::search(null)->get());
    }
}
