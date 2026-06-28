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

        if (! $package) {
            return response()->json(['message' => 'Paket tidak ditemukan'], 404);
        }

        $order = new Order();
        $order->kode_booking = 'BKG-' . strtoupper(Str::random(6));
        $order->package_id = $package->id;
        $order->nama_pemesan = $validated['nama_pemesan'];
        $order->email_pemesan = $validated['email_pemesan'];
        $order->telepon_pemesan = $validated['telepon_pemesan'];
        $order->tanggal_event = $validated['tanggal_event'];
        $order->total_bayar = $package->harga;
        $order->status_pembayaran = 'pending';
        $order->kode_unik = rand(100, 999);
        $order->nama_bank = config('services.bank_name');
        $order->nomor_rekening = config('services.account_number');
        $order->atas_nama_rekening = config('services.account_holder');
        $order->save();

        return response()->json([
            'message' => 'Booking berhasil disimpan',
            'data' => [
                'id' => $order->id,
                'kode_booking' => $order->kode_booking,
                'nama_pemesan' => $order->nama_pemesan,
                'email_pemesan' => $order->email_pemesan,
                'telepon_pemesan' => $order->telepon_pemesan,
                'tanggal_event' => $order->tanggal_event,
                'total_bayar' => $order->total_bayar,
                'status_pembayaran' => $order->status_pembayaran,
                'kode_unik' => $order->kode_unik,
                'nama_bank' => $order->nama_bank,
                'nomor_rekening' => $order->nomor_rekening,
                'atas_nama_rekening' => $order->atas_nama_rekening,
                'grand_total' => $order->grand_total,
            ],
        ], 201);
    }
}
