<?php

namespace Tests\Feature\Admin;

use App\Models\Article;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * KU-04 Manajemen Artikel — Black Box (EP, BVA) dan State Transition.
 *
 * Status artikel: S1 Draf, S2 Terbit, S3 Terjadwal.
 */
class ArticleManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->admin());
    }

    private function artikel(array $ubah = []): array
    {
        return array_merge([
            'title'  => 'Berita GTA VI Terbaru',
            'body'   => '<p>Isi artikel uji.</p>',
            'status' => 'draft',
        ], $ubah);
    }

    /** TC-AR-01 — S1: draf tidak memperoleh tanggal terbit. */
    public function test_tc_ar_01_artikel_draf_tersimpan_tanpa_tanggal_terbit(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel())
            ->assertRedirect(route('admin.articles.index'));

        $artikel = Article::first();
        $this->assertSame('draft', $artikel->status);
        $this->assertNull($artikel->published_at);
    }

    /** TC-AR-02 — transisi S1 ke S2: tanggal terbit terisi otomatis. */
    public function test_tc_ar_02_status_terbit_mengisi_tanggal_secara_otomatis(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel([
            'status'       => 'published',
            'published_at' => '',
        ]));

        $this->assertNotNull(Article::first()->published_at);
    }

    /** TC-AR-03 — tanggal yang diisi manual tidak ditimpa. */
    public function test_tc_ar_03_tanggal_terbit_manual_dipertahankan(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel([
            'status'       => 'published',
            'published_at' => '2026-01-01 08:00',
        ]));

        $this->assertSame('2026-01-01 08:00', Article::first()->published_at->format('Y-m-d H:i'));
    }

    /** TC-AR-05 — transisi S2 ke S1: artikel hilang dari daftar publik. */
    public function test_tc_ar_05_mengubah_terbit_menjadi_draf_menghilangkan_dari_publik(): void
    {
        $artikel = $this->article(['title' => 'Artikel Publik']);
        $this->get('/articles')->assertSee('Artikel Publik');

        $this->put(route('admin.articles.update', $artikel), $this->artikel([
            'title'  => 'Artikel Publik',
            'status' => 'draft',
        ]));

        $this->assertSame('draft', $artikel->fresh()->status);
        $this->get('/articles')->assertDontSee('Artikel Publik');
    }

    /** TC-AR-06 */
    public function test_tc_ar_06_judul_wajib_diisi(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['title' => '']))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('articles', 0);
    }

    /** TC-AR-07 */
    public function test_tc_ar_07_isi_artikel_wajib_diisi(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['body' => '']))
            ->assertSessionHasErrors('body');

        $this->assertDatabaseCount('articles', 0);
    }

    /** TC-AR-08 — batas atas ringkasan. */
    public function test_tc_ar_08_ringkasan_500_karakter_diterima(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['excerpt' => str_repeat('r', 500)]))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('articles', 1);
    }

    /** TC-AR-09 — di atas batas atas ringkasan. */
    public function test_tc_ar_09_ringkasan_501_karakter_ditolak(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['excerpt' => str_repeat('r', 501)]))
            ->assertSessionHasErrors('excerpt');

        $this->assertDatabaseCount('articles', 0);
    }

    /** TC-AR-10 */
    public function test_tc_ar_10_kategori_tidak_terdaftar_ditolak(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['category_id' => 9999]))
            ->assertSessionHasErrors('category_id');

        $this->assertDatabaseCount('articles', 0);
    }

    public function test_status_di_luar_daftar_pilihan_ditolak(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['status' => 'archived']))
            ->assertSessionHasErrors('status');
    }

    /** TC-AR-12 — slug dibuat otomatis bila dikosongkan. */
    public function test_tc_ar_12_slug_dibuat_otomatis_dari_judul(): void
    {
        $this->post(route('admin.articles.store'), $this->artikel(['title' => 'Berita GTA VI Terbaru']));

        $this->assertSame('berita-gta-vi-terbaru', Article::first()->slug);
    }

    public function test_slug_duplikat_ditolak(): void
    {
        $this->article(['title' => 'Artikel Pertama']);

        $this->post(route('admin.articles.store'), $this->artikel(['slug' => 'artikel-pertama']))
            ->assertSessionHasErrors('slug');
    }

    /** TC-AR-13 */
    public function test_tc_ar_13_artikel_dapat_dihapus(): void
    {
        $artikel = $this->article();

        $this->delete(route('admin.articles.destroy', $artikel))
            ->assertRedirect(route('admin.articles.index'));

        $this->assertDatabaseMissing('articles', ['id' => $artikel->id]);
    }
}
