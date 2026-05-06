<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class RecommendationController extends Controller
{
    public function calculate(Request $request)
    {

        $userRequest = $request->input('user_request'); 
        
        if (!$userRequest) {
            return response()->json(['message' => 'Mohon isi permintaan Anda.'], 400);
        }

        $packages = Package::all()->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->nama_paket,
                'price' => (int) $item->harga,
                'capacity' => $item->capacity ?? 0, 
                'rating' => $item->rating ?? 0,     
                'description' => $item->deskripsi_paket,
            ];
        });

        if ($packages->isEmpty()) {
            return response()->json(['message' => 'Data paket kosong.'], 404);
        }

        $prompt = "
        Bertindaklah sebagai Event Planner profesional untuk 'PartyKit'Z'.
        Berikut adalah daftar paket yang kami miliki dalam format JSON:
        " . json_encode($packages) . "
        
        Permintaan Customer: '$userRequest'
        
        Tugas Anda:
        1. Analisa permintaan customer.
        2. Pilih MAKSIMAL 3 paket yang paling relevan/cocok.
        3. Berikan 'reason' (alasan) singkat, menarik, dan persuasif kenapa paket itu cocok.
        4. JANGAN gunakan format markdown.
        5. Kembalikan HANYA data JSON valid (Array of Objects) dengan struktur persis seperti ini:
        [
            { \"id\": 1, \"reason\": \"Alasan kamu disini...\" }
        ]
        ";

        $apiKey = env('GEMINI_API_KEY');
        $url = "https://generativelanguage.googleapis.com/v1beta/models/gemini-2.5-flash:generateContent?key={$apiKey}";

        try {
            $response = Http::post($url, [
                'contents' => [
                    [
                        'parts' => [
                            ['text' => $prompt]
                        ]
                    ]
                ]
            ]);

            $result = $response->json();

            if (isset($result['error'])) {
                return response()->json(['message' => 'Gemini Error: ' . $result['error']['message']], 500);
            }

            $rawText = $result['candidates'][0]['content']['parts'][0]['text'] ?? '';
            $cleanJson = str_replace(['```json', '```', "\n"], '', $rawText);
            $recommendations = json_decode($cleanJson, true);

            if (json_last_error() !== JSON_ERROR_NONE || !is_array($recommendations)) {
                 return response()->json(['message' => 'Gagal memproses jawaban AI. Coba lagi.'], 500);
            }

            $finalResult = [];
            $allPackagesOriginal = Package::all(); 

            foreach ($recommendations as $rec) {
                $originalPackage = $allPackagesOriginal->firstWhere('id', $rec['id']);
                
                if ($originalPackage) {
                    $finalResult[] = [
                        'id' => $originalPackage->id,
                        'name' => $originalPackage->nama_paket,
                        'price' => $originalPackage->harga,
                        'capacity' => $originalPackage->capacity,
                        'rating' => $originalPackage->rating,
                        'image_url' => $originalPackage->gambar_utama ? asset('storage/' . $originalPackage->gambar_utama) : null,
                        'ai_reason' => $rec['reason']
                    ];
                }
            }

            return response()->json(['data' => $finalResult]);

        } catch (\Exception $e) {
            return response()->json(['message' => 'Server Error: ' . $e->getMessage()], 500);
        }
    }
}