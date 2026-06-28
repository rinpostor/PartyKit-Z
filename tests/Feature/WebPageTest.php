<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use PHPUnit\Framework\Attributes\Test;
use Tests\TestCase;

class WebPageTest extends TestCase
{
    use RefreshDatabase;

    #[Test]
    public function test_home_page_returns_successful_response(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    #[Test]
    public function test_packages_page_returns_successful_response(): void
    {
        $response = $this->get('/packages');
        $response->assertStatus(200);
    }

    #[Test]
    public function test_about_page_returns_successful_response(): void
    {
        $response = $this->get('/about');
        $response->assertStatus(200);
    }

    #[Test]
    public function test_consultation_page_returns_successful_response(): void
    {
        $response = $this->get('/consultation');
        $response->assertStatus(200);
    }
}
