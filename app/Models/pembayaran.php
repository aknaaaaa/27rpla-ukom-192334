<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Pembayaran extends Model
{
    protected $table = 'pembayarans';
    protected $primaryKey = 'id_pembayaran';

    protected $fillable = [
        'id_pembayaran',
        'id_pemesanan',
        'payment_method',
        'payment_date',
        'amount_paid',
        'status_pembayaran',
    ];

    protected $casts = [
        'payment_date' => 'date',
        'amount_paid' => 'float',
    ];

    public function pemesanan(): BelongsTo
    {
        return $this->belongsTo(Pemesanan::class, 'id_pemesanan', 'id_pemesanan');
    }
}
