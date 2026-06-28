<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class PackageFactory extends Factory
{
    protected $model = Package::class;

    public function definition(): array
    {
        $name = fake()->unique()->words(3, true);
        return [
            'category_id'     => Category::factory(),
            'nama_paket'      => $name,
            'slug'            => Str::slug($name),
            'harga'           => fake()->numberBetween(100000, 1000000),
            'deskripsi_paket' => fake()->paragraph(),
            'gambar_utama'    => fake()->imageUrl(600, 400, 'food'),
        ];
    }
}
