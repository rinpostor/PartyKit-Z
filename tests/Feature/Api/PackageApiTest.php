<?php

namespace Tests\Feature\Api;

use App\Models\Category;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class PackageApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC-005: GET /api/packages -- Semua Paket */
    public function test_can_list_all_packages(): void
    {
        Package::factory(3)->create();

        $response = $this->getJson('/api/packages');

        $response->assertStatus(200)
                 ->assertJsonStructure([
                     'message',
                     'data' => [
                         '*' => ['id', 'name', 'price', 'description', 'category', 'category_slug', 'image_url']
                     ]
                 ]);
    }

    /** @test TC-006: GET /api/packages?category=grill -- Filter by category */
    public function test_can_filter_packages_by_category_slug(): void
    {
        $grill = Category::factory()->create(['slug' => 'grill', 'nama_kategori' => 'Paket Grill']);
        $steak = Category::factory()->create(['slug' => 'steak', 'nama_kategori' => 'Paket Steak']);

        Package::factory(3)->create(['category_id' => $grill->id]);
        Package::factory(2)->create(['category_id' => $steak->id]);

        $response = $this->getJson('/api/packages?category=grill');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json('data'));

        foreach ($response->json('data') as $package) {
            $this->assertEquals('grill', $package['category_slug']);
        }
    }

    /** @test TC-007: GET /api/packages?category=semua-paket -- Kembalikan Semua */
    public function test_semua_paket_filter_returns_all(): void
    {
        Package::factory(5)->create();

        $response = $this->getJson('/api/packages?category=semua-paket');

        $response->assertStatus(200);
        $this->assertCount(5, $response->json('data'));
    }

    /** @test TC-008: GET /api/categories -- List Kategori */
    public function test_can_list_categories(): void
    {
        Category::factory(3)->create();

        $response = $this->getJson('/api/categories');

        $response->assertStatus(200);
        $this->assertCount(3, $response->json());
    }
}
