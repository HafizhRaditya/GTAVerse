<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * KU-09 Tampilan Konten Publik.
 *
 * Mencakup pengujian White Box berupa Condition Coverage terhadap penjaga akses
 * pada ArticleController::show(), yang memiliki tiga kondisi ber-AND:
 *   K1 status bernilai published
 *   K2 kolom published_at terisi
 *   K3 published_at sudah terlewati
 * Cyclomatic Complexity V(G) = 4.
 */
class PublicPageTest extends TestCase
{
    use RefreshDatabase;

    public function test_tc_pb_01_beranda_dapat_dibuka(): void
    {
        $this->get('/')->assertOk();
    }

    public function test_halaman_daftar_dapat_dibuka(): void
    {
        foreach (['/games', '/articles', '/characters', '/suggestions'] as $rute) {
            $this->get($rute)->assertOk();
        }
    }

    public function test_tc_pb_02_detail_game_menampilkan_warna_tema(): void
    {
        $game = $this->game(['theme_color' => '#e8862e', 'accent_color' => '#2f6b39']);

        $this->get(route('games.show', $game))
            ->assertOk()
            ->assertSee('#e8862e', false)
            ->assertSee('#2f6b39', false);
    }

    public function test_tc_pb_03_slug_game_tidak_dikenal_menghasilkan_404(): void
    {
        $this->get('/games/tidak-ada')->assertNotFound();
    }

    /** TC-WB-05 dan TC-PB-04 — kondisi K1 bernilai salah. */
    public function test_tc_wb_05_artikel_berstatus_draf_menghasilkan_404(): void
    {
        $this->admin();
        $artikel = $this->article(['status' => 'draft']);

        $this->get(route('articles.show', $artikel))->assertNotFound();
    }

    /** TC-WB-06 — K1 benar, K2 salah. */
    public function test_tc_wb_06_artikel_terbit_tanpa_tanggal_menghasilkan_404(): void
    {
        $this->admin();
        $artikel = $this->article(['published_at' => null]);

        $this->get(route('articles.show', $artikel))->assertNotFound();
    }

    /** TC-WB-07 dan TC-AR-04 — K1 dan K2 benar, K3 salah. */
    public function test_tc_wb_07_artikel_dengan_tanggal_masa_depan_menghasilkan_404(): void
    {
        $this->admin();
        $artikel = $this->article(['published_at' => now()->addDay()]);

        $this->get(route('articles.show', $artikel))->assertNotFound();
    }

    /** TC-WB-08 — seluruh kondisi benar. */
    public function test_tc_wb_08_artikel_terbit_masa_lalu_dapat_dibuka(): void
    {
        $this->admin();
        $artikel = $this->article(['title' => 'Berita GTA VI']);

        $this->get(route('articles.show', $artikel))
            ->assertOk()
            ->assertSee('Berita GTA VI');
    }

    /** TC-AR-11 — penghitung pembacaan bertambah satu setiap kunjungan. */
    public function test_tc_ar_11_penghitung_views_bertambah(): void
    {
        $this->admin();
        $artikel = $this->article();
        $this->assertSame(0, $artikel->fresh()->views);

        $this->get(route('articles.show', $artikel));

        $this->assertSame(1, $artikel->fresh()->views);
    }

    /** TC-PB-05 */
    public function test_tc_pb_05_pencarian_menyaring_artikel(): void
    {
        $this->admin();
        $this->article(['title' => 'Berita GTA VI']);
        $this->article(['title' => 'Ulasan San Andreas']);

        $this->get('/articles?q=Leonida')->assertOk()->assertDontSee('Berita GTA VI');
        $this->get('/articles?q=GTA VI')->assertOk()->assertSee('Berita GTA VI');
    }

    /** TC-PB-06 */
    public function test_tc_pb_06_pencarian_tanpa_hasil_menampilkan_pesan(): void
    {
        $this->get('/articles?q=zzzzz')->assertOk()->assertSee('No Results');
    }

    /** TC-PB-07 */
    public function test_tc_pb_07_penyaringan_kategori(): void
    {
        $this->admin();
        $kategori = $this->category(['name' => 'News']);
        $this->article(['title' => 'Masuk kategori', 'category_id' => $kategori->id]);
        $this->article(['title' => 'Tanpa kategori']);

        $this->get('/articles?category=news')
            ->assertOk()
            ->assertSee('Masuk kategori')
            ->assertDontSee('Tanpa kategori');
    }

    /** TC-PB-08 — alamat lama berbahasa Indonesia dialihkan permanen. */
    public function test_tc_pb_08_url_lama_dialihkan_dengan_kode_301(): void
    {
        $this->get('/artikel')->assertRedirect('/articles')->assertStatus(301);
        $this->get('/karakter')->assertRedirect('/characters')->assertStatus(301);
        $this->get('/kotak-saran')->assertRedirect('/suggestions')->assertStatus(301);
    }

    public function test_artikel_draf_tidak_muncul_di_daftar_publik(): void
    {
        $this->admin();
        $this->article(['title' => 'Artikel Draf Rahasia', 'status' => 'draft']);

        $this->get('/articles')->assertOk()->assertDontSee('Artikel Draf Rahasia');
    }

    public function test_detail_karakter_dapat_dibuka(): void
    {
        $karakter = $this->character(['name' => 'Lucia Caminos']);

        $this->get(route('characters.show', $karakter))
            ->assertOk()
            ->assertSee('Lucia Caminos');
    }

    private function metaDescription(string $url): string
    {
        preg_match(
            '/<meta name="description" content="([^"]*)"/',
            $this->get($url)->getContent(),
            $cocok
        );

        return $cocok[1] ?? '';
    }

    /**
     * Regresi: konten tanpa ringkasan sempat kehilangan meta description miliknya
     * dan memakai teks bawaan situs, karena nilai null membuat Blade memperlakukan
     * @section bentuk singkat sebagai bentuk pembuka sehingga buffer tidak tertutup.
     */
    public function test_meta_description_artikel_tanpa_ringkasan_tidak_memakai_teks_bawaan(): void
    {
        $this->admin();
        $artikel = $this->article([
            'title'   => 'Artikel Tanpa Ringkasan',
            'excerpt' => null,
            'body'    => '<p>Isi lengkap artikel pengujian regresi.</p>',
        ]);

        $meta = $this->metaDescription(route('articles.show', $artikel));

        $this->assertStringContainsString('Isi lengkap artikel pengujian regresi', $meta);
        $this->assertStringNotContainsString('News, game catalog', $meta);
    }

    public function test_meta_description_game_tanpa_deskripsi_memakai_data_sendiri(): void
    {
        $game = $this->game(['title' => 'Game Tanpa Deskripsi', 'description' => null, 'tagline' => null]);

        $meta = $this->metaDescription(route('games.show', $game));

        $this->assertStringContainsString('Game Tanpa Deskripsi', $meta);
        $this->assertStringNotContainsString('News, game catalog', $meta);
    }

    public function test_meta_description_karakter_tanpa_biografi_memakai_namanya(): void
    {
        $karakter = $this->character(['name' => 'Karakter Tanpa Bio', 'bio' => null]);

        $meta = $this->metaDescription(route('characters.show', $karakter));

        $this->assertStringContainsString('Karakter Tanpa Bio', $meta);
        $this->assertStringNotContainsString('News, game catalog', $meta);
    }
}
