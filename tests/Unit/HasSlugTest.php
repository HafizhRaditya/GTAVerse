<?php

namespace Tests\Unit;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * Pengujian White Box terhadap HasSlug::generateUniqueSlug().
 *
 * Cyclomatic Complexity V(G) = 3, berasal dari dua simpul keputusan:
 *   D1: operator ?: pada Str::slug($value) ?: Str::random(8)
 *   D2: perulangan while (slug sudah dipakai)
 * Sehingga terdapat tiga jalur independen yang diuji di bawah ini.
 */
class HasSlugTest extends TestCase
{
    use RefreshDatabase;

    /** TC-WB-01 — Jalur 1: nilai menghasilkan slug dan slug belum dipakai. */
    public function test_tc_wb_01_slug_dibuat_otomatis_dari_judul(): void
    {
        $game = $this->game(['title' => 'Grand Theft Auto VII']);

        $this->assertSame('grand-theft-auto-vii', $game->slug);
    }

    /** TC-WB-02 — Jalur 2: nilai tidak menghasilkan slug sehingga dipakai string acak. */
    public function test_tc_wb_02_judul_tanpa_karakter_alfanumerik_menghasilkan_slug_acak(): void
    {
        $game = $this->game(['title' => '!!!']);

        $this->assertSame(8, strlen($game->slug));
        $this->assertMatchesRegularExpression('/^[A-Za-z0-9]{8}$/', $game->slug);
    }

    /** TC-WB-03 — Jalur 3: slug sudah dipakai, perulangan berjalan satu kali. */
    public function test_tc_wb_03_slug_duplikat_memperoleh_akhiran_dua(): void
    {
        $this->game(['title' => 'Vice City']);
        $kedua = $this->game(['title' => 'Vice City']);

        $this->assertSame('vice-city-2', $kedua->slug);
    }

    /** TC-WB-04 — Jalur 3: slug dan varian -2 sudah dipakai, perulangan dua kali. */
    public function test_tc_wb_04_slug_duplikat_kedua_memperoleh_akhiran_tiga(): void
    {
        $this->game(['title' => 'Vice City']);
        $this->game(['title' => 'Vice City']);
        $ketiga = $this->game(['title' => 'Vice City']);

        $this->assertSame('vice-city-3', $ketiga->slug);
    }

    /** Slug yang diisi manual tidak boleh ditimpa oleh pembuatan otomatis. */
    public function test_slug_yang_diisi_manual_dipertahankan(): void
    {
        $game = $this->game(['title' => 'Grand Theft Auto VII', 'slug' => 'gta-7']);

        $this->assertSame('gta-7', $game->slug);
    }

    /** Karakter memakai kolom sumber "name", bukan "title". */
    public function test_slug_karakter_dibuat_dari_nama(): void
    {
        $karakter = $this->character(['name' => 'Lucia Caminos']);

        $this->assertSame('lucia-caminos', $karakter->slug);
    }
}
