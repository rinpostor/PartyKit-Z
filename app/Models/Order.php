<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking',
        'nama_pemesan',
        'email_pemesan',
        'telepon_pemesan',
        'tanggal_event',
        'package_id',
        'kode_unik',
        'total_bayar',
        'status_pembayaran',
        'nama_bank',
        'nomor_rekening',
        'atas_nama_rekening',
        'paid_at',
    ];

    protected $casts = [
        'tanggal_event' => 'date',
        'paid_at' => 'datetime',
    ];

    public function package(): BelongsTo
    {
        return $this->belongsTo(Package::class);
    }

    public function getGrandTotalAttribute(): int|float
    {
        return (int) $this->total_bayar + (int) $this->kode_unik;
    }
}
