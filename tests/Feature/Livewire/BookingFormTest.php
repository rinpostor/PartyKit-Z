<?php

namespace Tests\Feature\Livewire;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class BookingFormTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_booking_form_loads_with_valid_package_id(): void
    {
        $package = Package::factory()->create();

        Livewire::test('booking-form')
            ->set('packageId', $package->id)
            ->call('loadPackage')
            ->assertSet('packageLoaded', true)
            ->assertSet('packageError', false)
            ->assertSet('package.name', $package->nama_paket);
    }

    #[Test]
    public function test_booking_form_shows_error_with_invalid_package_id(): void
    {
        Livewire::test('booking-form')
            ->set('packageId', 99999)
            ->call('loadPackage')
            ->assertSet('packageLoaded', false)
            ->assertSet('packageError', true);
    }

    #[Test]
    public function test_booking_form_submit_valid_data(): void
    {
        $package = Package::factory()->create(['harga' => 500000]);

        Livewire::test('booking-form')
            ->set('packageId', $package->id)
            ->call('loadPackage')
            ->set('nama_pemesan', 'Test User')
            ->set('email_pemesan', 'test@example.com')
            ->set('telepon_pemesan', '081234567890')
            ->set('tanggal_event', now()->addMonth()->format('Y-m-d'))
            ->call('submitBooking')
            ->assertSet('showPaymentModal', true)
            ->assertSet('orderData.id', fn ($id) => is_numeric($id))
            ->assertSet('orderData.nama_bank', 'BCA')
            ->assertSet('orderData.nomor_rekening', '1234567890')
            ->assertSet('orderData.grand_total', fn ($value) => $value >= 500100 && $value <= 500999);

        $this->assertDatabaseHas('orders', [
            'email_pemesan' => 'test@example.com',
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
        ]);
    }

    #[Test]
    public function test_booking_form_validates_required_name(): void
    {
        $package = Package::factory()->create();

        Livewire::test('booking-form')
            ->set('packageId', $package->id)
            ->call('loadPackage')
            ->set('nama_pemesan', '')
            ->set('email_pemesan', 'test@example.com')
            ->set('telepon_pemesan', '081234567890')
            ->set('tanggal_event', now()->addMonth()->format('Y-m-d'))
            ->call('submitBooking')
            ->assertHasErrors(['nama_pemesan' => 'required']);
    }

    #[Test]
    public function test_booking_form_validates_phone_number(): void
    {
        $package = Package::factory()->create();

        Livewire::test('booking-form')
            ->set('packageId', $package->id)
            ->call('loadPackage')
            ->set('nama_pemesan', 'Test User')
            ->set('email_pemesan', 'test@example.com')
            ->set('telepon_pemesan', 'abc')
            ->set('tanggal_event', now()->addMonth()->format('Y-m-d'))
            ->call('submitBooking')
            ->assertHasErrors(['telepon_pemesan']);
    }

    #[Test]
    public function test_booking_form_validates_event_date(): void
    {
        $package = Package::factory()->create();

        Livewire::test('booking-form')
            ->set('packageId', $package->id)
            ->call('loadPackage')
            ->set('nama_pemesan', 'Test User')
            ->set('email_pemesan', 'test@example.com')
            ->set('telepon_pemesan', '081234567890')
            ->set('tanggal_event', now()->subDay()->format('Y-m-d'))
            ->call('submitBooking')
            ->assertHasErrors(['tanggal_event']);
    }
}
