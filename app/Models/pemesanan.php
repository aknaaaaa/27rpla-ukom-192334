<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    protected $primaryKey = 'id_pemesanan';

    protected $fillable = [
        'id_user',
        'id_kamar',
        'booking_code',
        'check_in',
        'check_out',
        'total_hari',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'id_user', 'id_user');
    }

    public function kamar(): BelongsTo
    {
        return $this->belongsTo(Kamar::class, 'id_kamar', 'id_kamar');
    }

    public function pembayaran(): HasOne
    {
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id_pemesanan');
    }

    public function getStatusLabelAttribute(): string
    {
        $paymentStatus = $this->pembayaran->status_pembayaran ?? 'Belum dibayar';
        $today = Carbon::today();

        if ($paymentStatus === 'Dibatalkan') {
            return 'Canceled';
        }

        if ($paymentStatus === 'Belum dibayar') {
            return 'Pending';
        }

        if ($paymentStatus === 'Telah dibayar') {
            if ($today->between($this->check_in, $this->check_out)) {
                return 'Occupying';
            }
            if ($today->greaterThan($this->check_out)) {
                return 'Completed';
            }
        }

        return 'Pending';
    }
}
