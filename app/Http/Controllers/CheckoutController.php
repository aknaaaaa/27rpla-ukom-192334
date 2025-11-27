<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use Illuminate\Http\Request;

class CheckoutController extends Controller
{
    /**
     * Show complete page after successful payment
     */
    public function complete(Request $request)
    {
        $pemesanan = session()->pull('last_pemesanan');
        abort_if(!$pemesanan, 403);

        // Load fresh from database to get latest data
        $pemesanan = Pemesanan::with(['kamar', 'pembayaran', 'user'])->findOrFail($pemesanan['id']);

        return view('kamar.checkout-complete', compact('pemesanan'));
    }

    /**
     * Show invoice for a booking
     */
    public function invoice($id)
    {
        $pemesanan = Pemesanan::with(['kamar', 'pembayaran', 'user'])
            ->findOrFail($id);

        // Check authorization - user can only see their own invoices
        if (auth()->id() !== $pemesanan->id_user && !auth()->user()->isAdmin()) {
            abort(403);
        }

        return view('kamar.invoice', compact('pemesanan'));
    }
}
