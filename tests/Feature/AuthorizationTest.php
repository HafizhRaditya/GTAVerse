<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * KU-08 Otorisasi dan Kontrol Akses.
 *
 * Sekaligus pengujian White Box terhadap middleware EnsureUserIsAdmin,
 * yang memiliki Cyclomatic Complexity V(G) = 3 dengan tiga jalur independen.
 */
class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public static function ruteAdmin(): array
    {
        return [
            'dashboard' => ['/admin'],
            'game'      => ['/admin/games'],
            'artikel'   => ['/admin/articles'],
            'karakter'  => ['/admin/characters'],
            'kategori'  => ['/admin/categories'],
            'pesan'     => ['/admin/messages'],
        ];
    }

    /** TC-WB-09 dan TC-OT-01 — Jalur 1: pengguna belum masuk. */
    public function test_tc_wb_09_tamu_diarahkan_ke_halaman_login(): void
    {
        $this->get('/admin')->assertRedirect(route('admin.login'));
    }

    /** TC-WB-10 dan TC-OT-03 — Jalur 2: sudah masuk tetapi tanpa hak admin. */
    public function test_tc_wb_10_pengguna_tanpa_hak_admin_ditolak(): void
    {
        $this->actingAs($this->nonAdmin())
            ->get('/admin')
            ->assertForbidden();
    }

    /** TC-WB-11 dan TC-OT-04 — Jalur 3: sudah masuk dan memiliki hak admin. */
    public function test_tc_wb_11_admin_dapat_mengakses_dashboard(): void
    {
        $this->actingAs($this->admin())
            ->get('/admin')
            ->assertOk();
    }

    /** TC-OT-02 — seluruh rute admin tertutup bagi tamu. */
    #[\PHPUnit\Framework\Attributes\DataProvider('ruteAdmin')]
    public function test_tc_ot_02_seluruh_rute_admin_tertutup_bagi_tamu(string $rute): void
    {
        $this->get($rute)->assertRedirect(route('admin.login'));
    }

    /** Seluruh rute admin juga tertutup bagi pengguna biasa. */
    #[\PHPUnit\Framework\Attributes\DataProvider('ruteAdmin')]
    public function test_seluruh_rute_admin_tertutup_bagi_pengguna_biasa(string $rute): void
    {
        $this->actingAs($this->nonAdmin())->get($rute)->assertForbidden();
    }

    public function test_tamu_tidak_dapat_menghapus_data_melalui_permintaan_langsung(): void
    {
        $game = $this->game();

        $this->delete(route('admin.games.destroy', $game))
            ->assertRedirect(route('admin.login'));

        $this->assertDatabaseHas('games', ['id' => $game->id]);
    }
}
