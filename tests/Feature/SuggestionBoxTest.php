<?php

namespace Tests\Feature;

use App\Models\Message;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Cache;
use Tests\TestCase;

/**
 * KU-01 Kotak Saran — pengujian Black Box pada lapisan server.
 *
 * Catatan: kasus uji manual (TC-KS-03, 04, 05, 08, 10) tertahan lebih dulu oleh
 * validasi HTML5 di browser. Pengujian otomatis ini menembus lapisan tersebut
 * sehingga yang diverifikasi adalah validasi sisi server sebagai lapisan kedua.
 */
class SuggestionBoxTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        // Menghapus penghitung pembatasan laju agar setiap kasus uji berdiri sendiri.
        Cache::flush();
    }

    private function saran(array $ubah = []): array
    {
        return array_merge([
            'name'    => 'Budi',
            'email'   => 'budi@mail.com',
            'subject' => 'Saran',
            'body'    => 'Tambah fitur cari',
        ], $ubah);
    }

    /** TC-KS-01 */
    public function test_tc_ks_01_saran_dengan_seluruh_isian_valid_tersimpan(): void
    {
        $response = $this->post(route('messages.store'), $this->saran());

        $response->assertRedirect(route('messages.create'));
        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', [
            'name'    => 'Budi',
            'email'   => 'budi@mail.com',
            'subject' => 'Saran',
            'body'    => 'Tambah fitur cari',
        ]);
    }

    /** TC-KS-02 — email dan subjek bersifat opsional. */
    public function test_tc_ks_02_email_dan_subjek_boleh_dikosongkan(): void
    {
        $response = $this->post(route('messages.store'), [
            'name' => 'Budi',
            'body' => 'Situs sudah bagus.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('messages', ['name' => 'Budi', 'email' => null, 'subject' => null]);
    }

    /** TC-KS-03 */
    public function test_tc_ks_03_nama_wajib_diisi(): void
    {
        $response = $this->post(route('messages.store'), $this->saran(['name' => '']));

        $response->assertSessionHasErrors('name');
        $this->assertDatabaseCount('messages', 0);
    }

    /** TC-KS-04 */
    public function test_tc_ks_04_isi_pesan_wajib_diisi(): void
    {
        $response = $this->post(route('messages.store'), $this->saran(['body' => '']));

        $response->assertSessionHasErrors('body');
        $this->assertDatabaseCount('messages', 0);
    }

    /** TC-KS-05 */
    public function test_tc_ks_05_email_harus_berformat_valid(): void
    {
        $response = $this->post(route('messages.store'), $this->saran(['email' => 'budimail.com']));

        $response->assertSessionHasErrors('email');
        $this->assertDatabaseCount('messages', 0);
    }

    /** TC-KS-06 — batas bawah nama. */
    public function test_tc_ks_06_nama_satu_karakter_diterima(): void
    {
        $this->post(route('messages.store'), $this->saran(['name' => 'A']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('messages', 1);
    }

    /** TC-KS-07 — batas atas nama. */
    public function test_tc_ks_07_nama_255_karakter_diterima(): void
    {
        $this->post(route('messages.store'), $this->saran(['name' => str_repeat('a', 255)]))
            ->assertSessionHasNoErrors();

        $this->assertSame(255, mb_strlen(Message::first()->name));
    }

    /** TC-KS-08 — di atas batas atas nama. */
    public function test_tc_ks_08_nama_256_karakter_ditolak(): void
    {
        $this->post(route('messages.store'), $this->saran(['name' => str_repeat('a', 256)]))
            ->assertSessionHasErrors('name');

        $this->assertDatabaseCount('messages', 0);
    }

    /** TC-KS-09 — batas bawah isi pesan. */
    public function test_tc_ks_09_pesan_satu_karakter_diterima(): void
    {
        $this->post(route('messages.store'), $this->saran(['body' => 'A']))
            ->assertSessionHasNoErrors();

        $this->assertDatabaseCount('messages', 1);
    }

    /** TC-KS-10 — batas atas isi pesan. */
    public function test_tc_ks_10_pesan_5000_karakter_diterima(): void
    {
        $this->post(route('messages.store'), $this->saran(['body' => str_repeat('c', 5000)]))
            ->assertSessionHasNoErrors();

        $this->assertSame(5000, mb_strlen(Message::first()->body));
    }

    /** TC-KS-11 — di atas batas atas isi pesan. */
    public function test_tc_ks_11_pesan_5001_karakter_ditolak(): void
    {
        $this->post(route('messages.store'), $this->saran(['body' => str_repeat('c', 5001)]))
            ->assertSessionHasErrors('body');

        $this->assertDatabaseCount('messages', 0);
    }

    /** TC-KS-12 — batas atas subjek. */
    public function test_tc_ks_12_subjek_256_karakter_ditolak(): void
    {
        $this->post(route('messages.store'), $this->saran(['subject' => str_repeat('s', 256)]))
            ->assertSessionHasErrors('subject');

        $this->assertDatabaseCount('messages', 0);
    }

    /** TC-KS-13 dan TC-KS-14 — batas pembatasan laju lima permintaan per menit. */
    public function test_tc_ks_13_dan_14_batas_lima_kiriman_per_menit(): void
    {
        for ($ke = 1; $ke <= 5; $ke++) {
            $this->post(route('messages.store'), $this->saran(['body' => "Kiriman ke-{$ke}"]))
                ->assertRedirect(route('messages.create'));
        }

        $this->post(route('messages.store'), $this->saran(['body' => 'Kiriman ke-6']))
            ->assertStatus(429);

        $this->assertDatabaseCount('messages', 5);
        $this->assertDatabaseMissing('messages', ['body' => 'Kiriman ke-6']);
    }

    /** TC-PS-01 — pesan yang baru masuk berstatus belum dibaca. */
    public function test_tc_ps_01_pesan_baru_berstatus_belum_dibaca(): void
    {
        $this->post(route('messages.store'), $this->saran());

        $this->assertFalse(Message::first()->is_read);
    }

    public function test_halaman_kotak_saran_dapat_dibuka(): void
    {
        $this->get(route('messages.create'))->assertOk();
    }
}
