<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Package;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        // Admin user
        User::firstOrCreate(
            ['email' => 'test@example.com'],
            ['name' => 'Test User', 'password' => bcrypt('password')]
        );

        // Categories
        $grill = Category::firstOrCreate(
            ['slug' => 'grill'],
            ['nama_kategori' => 'Paket Grill', 'slug' => 'grill', 'gambar' => 'categories/grill.jpg']
        );

        $steak = Category::firstOrCreate(
            ['slug' => 'steak'],
            ['nama_kategori' => 'Paket Steak', 'slug' => 'steak', 'gambar' => 'categories/steak.jpg']
        );

        // Packages
        $grillImages = [
            'https://images.unsplash.com/photo-1529193591184-b1d58069ecdd?w=600&q=80',
            'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&q=80',
            'https://images.unsplash.com/photo-1527515637462-cff94eecc1ac?w=600&q=80',
        ];
        $steakImages = [
            'https://images.unsplash.com/photo-1546833998-877b37c2e5c6?w=600&q=80',
            'https://images.unsplash.com/photo-1504973960431-1c467e159aa4?w=600&q=80',
            'https://images.unsplash.com/photo-1558030006-450675393462?w=600&q=80',
        ];

        $packages = [
            [
                'category_id'    => $grill->id,
                'nama_paket'     => 'Paket Grill Santai',
                'slug'           => 'paket-grill-santai',
                'harga'          => 299000,
                'deskripsi_paket'=> 'Paket lengkap untuk BBQ santai bersama keluarga. Termasuk kompor portable, grill pan anti lengket, dan bahan daging ayam serta sosis untuk 6 orang.',
                'gambar_utama'   => $grillImages[0],
            ],
            [
                'category_id'    => $grill->id,
                'nama_paket'     => 'Paket Grill Premium',
                'slug'           => 'paket-grill-premium',
                'harga'          => 499000,
                'deskripsi_paket'=> 'BBQ level premium dengan daging wagyu lokal, bumbu spesial, dan alat grill stainless steel profesional untuk 10 orang.',
                'gambar_utama'   => $grillImages[1],
            ],
            [
                'category_id'    => $grill->id,
                'nama_paket'     => 'Paket BBQ Party Besar',
                'slug'           => 'paket-bbq-party-besar',
                'harga'          => 750000,
                'deskripsi_paket'=> 'Paket terlengkap untuk acara besar! Grill station, 2 kompor, daging pilihan, sayuran, saus, dan alat makan untuk 20 orang.',
                'gambar_utama'   => $grillImages[2],
            ],
            [
                'category_id'    => $steak->id,
                'nama_paket'     => 'Paket Steak Rumahan',
                'slug'           => 'paket-steak-rumahan',
                'harga'          => 349000,
                'deskripsi_paket'=> 'Nikmati steak restoran di rumah! Termasuk daging sirloin premium, bumbu marinasi, wajan cast iron, dan saus mushroom untuk 4 orang.',
                'gambar_utama'   => $steakImages[0],
            ],
            [
                'category_id'    => $steak->id,
                'nama_paket'     => 'Paket Steak Mewah',
                'slug'           => 'paket-steak-mewah',
                'harga'          => 599000,
                'deskripsi_paket'=> 'Pengalaman steakhouse bintang 5 di rumah. Daging ribeye pilihan, alat memasak premium, saus béarnaise homemade untuk 6 orang.',
                'gambar_utama'   => $steakImages[1],
            ],
            [
                'category_id'    => $steak->id,
                'nama_paket'     => 'Paket Date Night Steak',
                'slug'           => 'paket-date-night-steak',
                'harga'          => 279000,
                'deskripsi_paket'=> 'Romantis dan spesial! Paket steak untuk 2 orang dengan daging tenderloin, dekorasi meja makan, lilin aromaterapi, dan saus spesial.',
                'gambar_utama'   => $steakImages[2],
            ],
        ];

        foreach ($packages as $pkg) {
            Package::firstOrCreate(
                ['slug' => $pkg['slug']],
                $pkg
            );
        }
    }
}
