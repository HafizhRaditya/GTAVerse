<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * KU-02 Autentikasi Admin — pengujian Decision Table.
 *
 * Kondisi: K1 isian terisi, K2 format email valid,
 *          K3 kredensial terdaftar, K4 akun memiliki hak admin.
 */
class AdminAuthTest extends TestCase
{
    use RefreshDatabase;

    /** TC-LG-01 — Aturan A5: seluruh kondisi benar. */
    public function test_tc_lg_01_kredensial_admin_benar_masuk_ke_dashboard(): void
    {
        $admin = $this->admin();

        $response = $this->post(route('admin.login.attempt'), [
            'email'    => 'admin@gtaverse.test',
            'password' => self::SANDI,
        ]);

        $response->assertRedirect(route('admin.dashboard'));
        $this->assertAuthenticatedAs($admin);
    }

    /** TC-LG-02 — Aturan A3: kredensial tidak cocok. */
    public function test_tc_lg_02_kata_sandi_salah_ditolak(): void
    {
        $this->admin();

        $response = $this->post(route('admin.login.attempt'), [
            'email'    => 'admin@gtaverse.test',
            'password' => 'salah123',
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** TC-LG-03 — Aturan A3: email tidak terdaftar. */
    public function test_tc_lg_03_email_tidak_terdaftar_ditolak(): void
    {
        $response = $this->post(route('admin.login.attempt'), [
            'email'    => 'tidakada@contoh.com',
            'password' => self::SANDI,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** TC-LG-04 — Aturan A4: kredensial benar tetapi tanpa hak admin. */
    public function test_tc_lg_04_akun_tanpa_hak_admin_dikeluarkan_kembali(): void
    {
        $this->nonAdmin();

        $response = $this->post(route('admin.login.attempt'), [
            'email'    => 'pembaca@gtaverse.test',
            'password' => self::SANDI,
        ]);

        $response->assertSessionHasErrors('email');
        $this->assertGuest();
    }

    /** TC-LG-05 — Aturan A1: email dikosongkan. */
    public function test_tc_lg_05_email_wajib_diisi(): void
    {
        $this->post(route('admin.login.attempt'), ['email' => '', 'password' => self::SANDI])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /** TC-LG-06 — Aturan A1: kata sandi dikosongkan. */
    public function test_tc_lg_06_kata_sandi_wajib_diisi(): void
    {
        $this->post(route('admin.login.attempt'), ['email' => 'admin@gtaverse.test', 'password' => ''])
            ->assertSessionHasErrors('password');

        $this->assertGuest();
    }

    /** TC-LG-07 — Aturan A2: format email tidak valid. */
    public function test_tc_lg_07_format_email_tidak_valid_ditolak(): void
    {
        $this->post(route('admin.login.attempt'), ['email' => 'admin', 'password' => self::SANDI])
            ->assertSessionHasErrors('email');

        $this->assertGuest();
    }

    /** TC-LG-08 */
    public function test_tc_lg_08_keluar_mengakhiri_sesi(): void
    {
        $admin = $this->admin();

        $this->actingAs($admin)
            ->post(route('admin.logout'))
            ->assertRedirect(route('home'));

        $this->assertGuest();
    }

    /** TC-LG-09 */
    public function test_tc_lg_09_dashboard_dapat_diakses_dalam_sesi_aktif(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.dashboard'))
            ->assertOk();
    }

    public function test_admin_yang_sudah_masuk_dialihkan_dari_halaman_login(): void
    {
        $this->actingAs($this->admin())
            ->get(route('admin.login'))
            ->assertRedirect(route('admin.dashboard'));
    }
}
