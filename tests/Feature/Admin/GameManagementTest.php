<?php

namespace Tests\Feature\Admin;

use App\Models\Game;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

/** KU-03 Manajemen Game — Black Box (Equivalence Partitioning dan Boundary Value Analysis). */
class GameManagementTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->admin());
    }

    private function dataGame(array $ubah = []): array
    {
        return array_merge([
            'title'    => 'Grand Theft Auto VII',
            'universe' => 'HD',
            'status'   => 'upcoming',
        ], $ubah);
    }

    /** TC-GM-01 */
    public function test_tc_gm_01_menambah_game_dengan_data_valid(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame())
            ->assertRedirect(route('admin.games.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('games', ['title' => 'Grand Theft Auto VII', 'universe' => 'HD']);
    }

    /** TC-GM-02 */
    public function test_tc_gm_02_slug_dibuat_otomatis_bila_dikosongkan(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame(['slug' => '']));

        $this->assertSame('grand-theft-auto-vii', Game::first()->slug);
    }

    /** TC-GM-03 */
    public function test_tc_gm_03_slug_duplikat_ditolak(): void
    {
        $this->game(['title' => 'Grand Theft Auto V', 'slug' => 'gta-v']);

        $this->post(route('admin.games.store'), $this->dataGame(['slug' => 'gta-v']))
            ->assertSessionHasErrors('slug');

        $this->assertDatabaseCount('games', 1);
    }

    /** TC-GM-04 */
    public function test_tc_gm_04_judul_wajib_diisi(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame(['title' => '']))
            ->assertSessionHasErrors('title');
    }

    /** TC-GM-05 — batas atas judul. */
    public function test_tc_gm_05_judul_255_karakter_diterima(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame(['title' => str_repeat('j', 255)]))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('games', 1);
    }

    /** TC-GM-06 — di atas batas atas judul. */
    public function test_tc_gm_06_judul_256_karakter_ditolak(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame(['title' => str_repeat('j', 256)]))
            ->assertSessionHasErrors('title');

        $this->assertDatabaseCount('games', 0);
    }

    /** TC-GM-07 */
    public function test_tc_gm_07_universe_di_luar_daftar_pilihan_ditolak(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame(['universe' => '2D']))
            ->assertSessionHasErrors('universe');
    }

    /** TC-GM-08 */
    public function test_tc_gm_08_status_di_luar_daftar_pilihan_ditolak(): void
    {
        $this->post(route('admin.games.store'), $this->dataGame(['status' => 'cancelled']))
            ->assertSessionHasErrors('status');
    }

    /** TC-GM-09 — batas atas ukuran unggahan. */
    public function test_tc_gm_09_sampul_4096_kb_diterima(): void
    {
        Storage::fake('public');

        $this->post(route('admin.games.store'), $this->dataGame([
            'cover_image' => UploadedFile::fake()->image('sampul.jpg')->size(4096),
        ]))->assertSessionHasNoErrors();

        $this->assertNotNull(Game::first()->cover_image);
    }

    /** TC-GM-10 — di atas batas atas ukuran unggahan. */
    public function test_tc_gm_10_sampul_4097_kb_ditolak(): void
    {
        Storage::fake('public');

        $this->post(route('admin.games.store'), $this->dataGame([
            'cover_image' => UploadedFile::fake()->image('sampul.jpg')->size(4097),
        ]))->assertSessionHasErrors('cover_image');

        $this->assertDatabaseCount('games', 0);
    }

    /** TC-GM-11 */
    public function test_tc_gm_11_berkas_bukan_gambar_ditolak(): void
    {
        Storage::fake('public');

        $this->post(route('admin.games.store'), $this->dataGame([
            'cover_image' => UploadedFile::fake()->create('dokumen.pdf', 100, 'application/pdf'),
        ]))->assertSessionHasErrors('cover_image');
    }

    /** TC-GM-12 — menyunting tanpa mengganti gambar mempertahankan gambar lama. */
    public function test_tc_gm_12_menyunting_tanpa_gambar_baru_mempertahankan_gambar_lama(): void
    {
        $game = $this->game(['cover_image' => 'games/lama.jpg']);

        $this->put(route('admin.games.update', $game), $this->dataGame(['title' => 'Judul Diperbarui']));

        $this->assertSame('games/lama.jpg', $game->fresh()->cover_image);
        $this->assertSame('Judul Diperbarui', $game->fresh()->title);
    }

    /** TC-GM-13 — slug milik sendiri tidak dianggap duplikat saat menyunting. */
    public function test_tc_gm_13_menyunting_dengan_slug_sendiri_diterima(): void
    {
        $game = $this->game(['title' => 'Vice City']);

        $this->put(route('admin.games.update', $game), $this->dataGame([
            'title' => 'Vice City',
            'slug'  => $game->slug,
        ]))->assertSessionHasNoErrors();
    }

    /** TC-GM-14 — menghapus game ikut menghapus karakternya (cascade). */
    public function test_tc_gm_14_menghapus_game_menghapus_karakternya(): void
    {
        $game = $this->game();
        $karakter = $this->character(['game_id' => $game->id]);

        $this->delete(route('admin.games.destroy', $game))
            ->assertRedirect(route('admin.games.index'));

        $this->assertDatabaseMissing('games', ['id' => $game->id]);
        $this->assertDatabaseMissing('characters', ['id' => $karakter->id]);
    }

    /** TC-GM-15 */
    public function test_tc_gm_15_pencarian_judul_game(): void
    {
        $this->game(['title' => 'Vice City']);
        $this->game(['title' => 'San Andreas']);

        $this->get('/admin/games?q=Vice')
            ->assertOk()
            ->assertSee('Vice City')
            ->assertDontSee('San Andreas');
    }

    /** TC-GM-16 */
    public function test_tc_gm_16_penyaringan_berdasarkan_universe(): void
    {
        $this->game(['title' => 'Vice City', 'universe' => '3D']);
        $this->game(['title' => 'Grand Theft Auto V', 'universe' => 'HD']);

        $this->get('/admin/games?universe=3D')
            ->assertOk()
            ->assertSee('Vice City')
            ->assertDontSee('Grand Theft Auto V');
    }
}
