<?php

namespace Tests\Feature\Api;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class BookingApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC-009: POST /api/bookings -- Booking Sukses */
    public function test_can_create_booking_successfully(): void
    {
        $package = Package::factory()->create(['harga' => 500000]);

        $response = $this->postJson('/api/bookings', [
            'package_id'      => $package->id,
            'nama_pemesan'    => 'Budi Santoso',
            'email_pemesan'   => 'budi@example.com',
            'telepon_pemesan' => '081234567890',
            'tanggal_event'   => '2026-08-15',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'data' => [
                    'id',
                    'kode_booking',
                    'nama_pemesan',
                    'email_pemesan',
                    'telepon_pemesan',
                    'tanggal_event',
                    'total_bayar',
                    'status_pembayaran',
                    'kode_unik',
                    'nama_bank',
                    'nomor_rekening',
                    'atas_nama_rekening',
                    'grand_total',
                ],
            ]);

        $this->assertEquals('pending', $response->json('data')['status_pembayaran']);
        $this->assertEquals(500000, (int) $response->json('data')['total_bayar']);
        $this->assertEquals('BCA', $response->json('data')['nama_bank']);
        $this->assertEquals('1234567890', $response->json('data')['nomor_rekening']);
        $this->assertGreaterThan(500000, (int) $response->json('data')['grand_total']);

        $this->assertDatabaseHas('orders', [
            'email_pemesan' => 'budi@example.com',
            'status_pembayaran' => 'pending',
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
        ]);
    }

    /** @test TC-010: POST /api/bookings -- Package ID Tidak Valid */
    public function test_cannot_book_with_invalid_package_id(): void
    {
        $response = $this->postJson('/api/bookings', [
            'package_id'      => 99999,
            'nama_pemesan'    => 'Budi',
            'email_pemesan'   => 'budi@test.com',
            'telepon_pemesan' => '08123456789',
            'tanggal_event'   => '2026-08-15',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['package_id']);
    }

    /** @test TC-011: POST /api/bookings -- Validasi Email Tidak Valid */
    public function test_validation_fails_for_invalid_email(): void
    {
        $package = Package::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'package_id'      => $package->id,
            'nama_pemesan'    => 'Budi',
            'email_pemesan'   => 'not-an-email',
            'telepon_pemesan' => '08123456789',
            'tanggal_event'   => '2026-08-15',
        ]);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors(['email_pemesan']);
    }

    /** @test TC-012: POST /api/bookings -- Field Wajib Kosong */
    public function test_validation_fails_when_required_fields_missing(): void
    {
        $response = $this->postJson('/api/bookings', []);

        $response->assertStatus(422);
        $response->assertJsonValidationErrors([
            'package_id', 'nama_pemesan', 'email_pemesan',
            'telepon_pemesan', 'tanggal_event'
        ]);
    }

    /** @test TC-013: POST /api/bookings -- Tanggal Event Format Valid */
    public function test_booking_with_valid_date_format(): void
    {
        $package = Package::factory()->create();

        $response = $this->postJson('/api/bookings', [
            'package_id'      => $package->id,
            'nama_pemesan'    => 'Siti',
            'email_pemesan'   => 'siti@test.com',
            'telepon_pemesan' => '08123456789',
            'tanggal_event'   => '2026-12-25',
        ]);

        $response->assertStatus(201);
        $this->assertStringStartsWith('2026-12-25', $response->json('data')['tanggal_event']);
    }
}
