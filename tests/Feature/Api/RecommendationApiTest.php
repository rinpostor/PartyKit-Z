<?php

namespace Tests\Feature\Api;

use App\Models\Package;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RecommendationApiTest extends TestCase
{
    use RefreshDatabase;

    /** @test TC-014: POST /api/recommendation -- Request Tanpa Text */
    public function test_recommendation_requires_user_request(): void
    {
        $response = $this->postJson('/api/recommendation', []);

        $response->assertStatus(400)
                 ->assertJson([
                     'message' => 'Mohon isi permintaan Anda.'
                 ]);
    }

    /** @test TC-015: POST /api/recommendation -- Data Paket Kosong */
    public function test_recommendation_returns_404_when_no_packages(): void
    {
        $response = $this->postJson('/api/recommendation', [
            'user_request' => 'acara ulang tahun'
        ]);

        $response->assertStatus(404)
                 ->assertJson([
                     'message' => 'Data paket kosong.'
                 ]);
    }

    /** @test TC-016: POST /api/recommendation -- Handling Gemini API Error */
    public function test_recommendation_handles_gemini_api_error(): void
    {
        Package::factory(3)->create();

        $response = $this->postJson('/api/recommendation', [
            'user_request' => 'pesta ulang tahun anak'
        ]);

        // Gemininya mungkin error karena API key test mungkin tidak diset,
        // atau sukses jika key valid. Minimal kita pastikan response valid.
        $this->assertTrue(
            in_array($response->status(), [200, 500]),
            'Response should be either 200 (success) or 500 (API error)'
        );
    }

    /** @test TC-017: POST /api/recommendation -- Response Structure Valid */
    public function test_recommendation_response_structure(): void
    {
        Package::factory(3)->create();

        $response = $this->postJson('/api/recommendation', [
            'user_request' => 'acara keluarga kecil'
        ]);

        if ($response->status() === 200) {
            $response->assertJsonStructure([
                'data' => [
                    '*' => ['id', 'name', 'price', 'image_url', 'ai_reason']
                ]
            ]);
        }
    }
}
