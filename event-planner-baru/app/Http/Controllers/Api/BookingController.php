<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Package;
use Illuminate\Http\Request;
use Illuminate\Support\Str; 

class BookingController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'package_id'      => 'required|exists:packages,id',
            'nama_pemesan'    => 'required|string',
            'email_pemesan'   => 'required|email',
            'telepon_pemesan' => 'required|string',
            'tanggal_event'   => 'required|date',
        ]);

        $package = Package::find($validated['package_id']);

        if (!$package) {
            return response()->json(['message' => 'Paket tidak ditemukan'], 404);
        }

        $order = new Order();
        $order->kode_booking = 'BKG-' . strtoupper(Str::random(6));
        $order->package_id      = $package->id;
        $order->nama_pemesan    = $validated['nama_pemesan'];
        $order->email_pemesan   = $validated['email_pemesan'];
        $order->telepon_pemesan = $validated['telepon_pemesan'];
        $order->tanggal_event   = $validated['tanggal_event'];
        $order->total_bayar     = $package->harga; 
        $order->status_pembayaran = 'pending'; 
        $order->kode_unik       = rand(1, 999); 
        $order->save();

        return response()->json([
            'message' => 'Booking berhasil disimpan', 
            'data' => $order
        ], 201);
    }
}