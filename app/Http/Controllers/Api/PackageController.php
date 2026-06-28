<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Package;
use Illuminate\Http\Request;

class PackageController extends Controller
{
    public function categories()
{
    $categories = \App\Models\Category::all(); 
    return response()->json($categories);
}
    public function index(Request $request)
    {
        $query = Package::with('category');

        if ($request->has('category') && $request->category != 'semua-paket') {
            $slug = $request->category;
            $query->whereHas('category', function($q) use ($slug) {
                $q->where('slug', $slug);
            });
        }

        $packages = $query->get();
        $formattedData = $packages->map(function($item) {
            return [
                'id' => $item->id,
                'name' => $item->nama_paket,
                'price' => $item->harga,
                'description' => $item->deskripsi_paket ?? 'Tidak ada deskripsi',
                'category' => $item->category ? $item->category->nama_kategori : 'Umum',
                'category_slug' => $item->category ? $item->category->slug : null,
                'image_url' => $item->gambar_utama
                    ? (str_starts_with($item->gambar_utama, 'http') ? $item->gambar_utama : asset('storage/' . $item->gambar_utama))
                    : 'https://images.unsplash.com/photo-1555939594-58d7cb561ad1?w=600&q=80',
            ];
        });

        return response()->json([
            'message' => 'List paket berhasil diambil',
            'data' => $formattedData
        ]);
    }
}