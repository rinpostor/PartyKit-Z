<?php

namespace Tests\Unit;

use App\Models\Category;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ModelRelationshipTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC-024: Category -> packages() */
    public function test_category_has_many_packages(): void
    {
        $category = Category::factory()->create();
        Package::factory(3)->create(['category_id' => $category->id]);

        $this->assertInstanceOf(Package::class, $category->packages->first());
        $this->assertCount(3, $category->packages);
    }

    /** @test TC-025: Package -> category() dan orders() */
    public function test_package_belongs_to_category_and_has_many_orders(): void
    {
        $category = Category::factory()->create();
        $package  = Package::factory()->create(['category_id' => $category->id]);
        Order::factory(2)->create(['package_id' => $package->id]);

        $this->assertInstanceOf(Category::class, $package->category);
        $this->assertEquals($category->id, $package->category->id);

        $this->assertCount(2, $package->orders);
        $this->assertInstanceOf(Order::class, $package->orders->first());
    }

    /** @test TC-026: Order -> package() */
    public function test_order_belongs_to_package(): void
    {
        $package = Package::factory()->create();
        $order   = Order::factory()->create(['package_id' => $package->id]);

        $this->assertInstanceOf(Package::class, $order->package);
        $this->assertEquals($package->id, $order->package->id);
    }
}
