<?php

namespace Database\Factories;

use App\Models\Order;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;

class OrderFactory extends Factory
{
    protected $model = Order::class;

    public function definition(): array
    {
        $package = Package::factory()->create();
        return [
            'kode_booking'      => 'BKG-' . strtoupper(fake()->bothify('??####')),
            'package_id'        => $package->id,
            'nama_pemesan'      => fake()->name(),
            'email_pemesan'     => fake()->safeEmail(),
            'telepon_pemesan'   => fake()->phoneNumber(),
            'tanggal_event'     => fake()->dateTimeBetween('+1 week', '+6 months')->format('Y-m-d'),
            'total_bayar'       => $package->harga + rand(100, 999),
            'kode_unik'         => rand(100, 999),
            'status_pembayaran' => 'pending',
        ];
    }
}
