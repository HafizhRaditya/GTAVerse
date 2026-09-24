<?php

namespace Tests\Feature\Admin;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

/**
 * KU-07 Kotak Masuk Pesan — pengujian State Transition.
 *
 * Status pesan: P1 Belum Dibaca, P2 Sudah Dibaca.
 */
class MessageInboxTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs($this->admin());
    }

    /** TC-PS-02 — transisi P1 ke P2 terjadi otomatis saat detail dibuka. */
    public function test_tc_ps_02_membuka_detail_menandai_pesan_sudah_dibaca(): void
    {
        $pesan = $this->message();
        $this->assertFalse((bool) $pesan->fresh()->is_read);

        $this->get(route('admin.messages.show', $pesan))->assertOk();

        $this->assertTrue($pesan->fresh()->is_read);
    }

    /** TC-PS-03 — membuka ulang tidak mengubah status. */
    public function test_tc_ps_03_membuka_ulang_pesan_tidak_mengubah_status(): void
    {
        $pesan = $this->message(['is_read' => true]);

        $this->get(route('admin.messages.show', $pesan))->assertOk();

        $this->assertTrue($pesan->fresh()->is_read);
    }

    /** TC-PS-04 — transisi P2 ke P1 dan pengarahan kembali ke daftar. */
    public function test_tc_ps_04_menandai_belum_dibaca_mengarahkan_ke_daftar(): void
    {
        $pesan = $this->message(['is_read' => true]);

        $this->patch(route('admin.messages.toggle', $pesan))
            ->assertRedirect(route('admin.messages.index'));

        $this->assertFalse($pesan->fresh()->is_read);
    }

    /** Transisi sebaliknya: menandai sudah dibaca kembali ke halaman sebelumnya. */
    public function test_menandai_sudah_dibaca_tidak_mengarahkan_ke_daftar(): void
    {
        $pesan = $this->message(['is_read' => false]);

        $this->patch(route('admin.messages.toggle', $pesan));

        $this->assertTrue($pesan->fresh()->is_read);
    }

    /** TC-PS-05 */
    public function test_tc_ps_05_penyaringan_pesan_belum_dibaca(): void
    {
        $this->message(['name' => 'Pengirim Baru', 'is_read' => false]);
        $this->message(['name' => 'Pengirim Lama', 'is_read' => true]);

        $this->get('/admin/messages?status=unread')
            ->assertOk()
            ->assertSee('Pengirim Baru')
            ->assertDontSee('Pengirim Lama');
    }

    /** TC-PS-06 */
    public function test_tc_ps_06_pencarian_pesan_berdasarkan_kata_kunci(): void
    {
        $this->message(['name' => 'Pengirim Baru', 'subject' => 'Saran fitur pencarian']);
        $this->message(['name' => 'Pengirim Lama', 'subject' => 'Laporan galat']);

        $this->get('/admin/messages?q=pencarian')
            ->assertOk()
            ->assertSee('Pengirim Baru')
            ->assertDontSee('Pengirim Lama');
    }

    /** TC-PS-07 */
    public function test_tc_ps_07_pesan_dapat_dihapus(): void
    {
        $pesan = $this->message();

        $this->delete(route('admin.messages.destroy', $pesan))
            ->assertRedirect(route('admin.messages.index'))
            ->assertSessionHas('success');

        $this->assertDatabaseMissing('messages', ['id' => $pesan->id]);
    }

    public function test_penanda_jumlah_pesan_belum_dibaca_tampil_di_navigasi(): void
    {
        $this->message(['is_read' => false]);
        $this->message(['is_read' => false]);

        $this->get(route('admin.dashboard'))
            ->assertOk()
            ->assertSee('2 unread');
    }
}
