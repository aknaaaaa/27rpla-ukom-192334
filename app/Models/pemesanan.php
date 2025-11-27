<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Carbon;

class Pemesanan extends Model
{
    protected $table = 'pemesanans';
    protected $primaryKey = 'id';

    protected $fillable = [
        'id_user',
        'id_kamar',
        'booking_code',
        'check_in',
        'check_out',
        'total_hari',
        'kode_pesanan',
        'tanggal_pemesanan',
        'tanggal_checkin',
        'tanggal_checkout',
        'status',
        'nama_penginap',
        'email_penginap',
        'telepon_penginap',
        'total_harga',
    ];

    protected $casts = [
        'check_in' => 'date',
        'check_out' => 'date',
        'tanggal_checkin' => 'date',
        'tanggal_checkout' => 'date',
        'tanggal_pemesanan' => 'date',
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
        return $this->hasOne(Pembayaran::class, 'id_pemesanan', 'id');
    }

    public function getStatusLabelAttribute(): string
    {
        $paymentStatus = $this->pembayaran?->status_pembayaran ?? 'Belum dibayar';
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
