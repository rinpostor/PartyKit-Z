<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'kode_booking', 'nama_pemesan', 'email_pemesan', 
        'telepon_pemesan', 'tanggal_event', 'package_id', 
        'kode_unik', 'total_bayar', 'status_pembayaran'
    ];

    public function package()
    {
        return $this->belongsTo(Package::class);
    }
}