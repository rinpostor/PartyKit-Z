<?php

namespace Tests\Feature\Filament;

use App\Filament\Resources\OrderResource;
use App\Mail\BookingPaymentConfirmed;
use App\Models\Order;
use App\Models\Package;
use App\Models\User;
use Filament\Facades\Filament;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Livewire\Livewire;
use Tests\TestCase;

class OrderPaymentConfirmationTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin_can_confirm_payment_and_customer_receives_email(): void
    {
        Mail::fake();

        $admin = User::factory()->create();
        $package = Package::factory()->create(['nama_paket' => 'Paket Grill', 'harga' => 750000]);
        $order = Order::factory()->create([
            'package_id' => $package->id,
            'email_pemesan' => 'customer@example.com',
            'status_pembayaran' => 'pending',
            'nama_bank' => 'BCA',
            'nomor_rekening' => '1234567890',
            'atas_nama_rekening' => "PartyKit'Z Official",
            'paid_at' => null,
        ]);

        Filament::setCurrentPanel(Filament::getPanel('admin'));

        $this->actingAs($admin);

        Livewire::test(OrderResource\Pages\ListOrders::class)
            ->callTableAction('confirm_payment', $order);

        $order->refresh();

        $this->assertSame('success', $order->status_pembayaran);
        $this->assertNotNull($order->paid_at);

        Mail::assertSent(BookingPaymentConfirmed::class, function (BookingPaymentConfirmed $mail) use ($order) {
            return $mail->hasTo('customer@example.com')
                && $mail->order->is($order);
        });
    }
}
