<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageOrderIntegrationTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     * TC-INT-01: Integration Test - Full flow dari membuat kategori, paket,
     * hingga booking melalui API.
     *
     * Graph Path: Category -> Package -> Booking -> Order
     */
    public function test_full_booking_flow(): void
    {
        $category = Category::factory()->create([
            'nama_kategori' => 'Paket BBQ',
            'slug' => 'bbq',
        ]);

        $package = Package::factory()->create([
            'category_id' => $category->id,
            'nama_paket' => 'BBQ Keluarga',
            'harga' => 350000,
        ]);

        $response = $this->postJson('/api/bookings', [
            'package_id'      => $package->id,
            'nama_pemesan'    => 'Ahmad Fauzi',
            'email_pemesan'   => 'ahmad@example.com',
            'telepon_pemesan' => '081298765432',
            'tanggal_event'   => '2026-09-10',
        ]);

        $response->assertStatus(201);

        $this->assertDatabaseHas('orders', [
            'package_id' => $package->id,
            'nama_pemesan' => 'Ahmad Fauzi',
            'email_pemesan' => 'ahmad@example.com',
            'total_bayar' => 350000,
            'status_pembayaran' => 'pending',
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
        ]);

        $order = Order::where('email_pemesan', 'ahmad@example.com')->first();
        $this->assertEquals($package->id, $order->package->id);
        $this->assertEquals($category->id, $order->package->category->id);
        $this->assertGreaterThan(350000, $order->grand_total);
    }
}
