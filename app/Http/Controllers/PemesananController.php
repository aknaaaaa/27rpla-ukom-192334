<?php

namespace App\Http\Controllers;

use App\Models\Pemesanan;
use App\Models\Kamar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;

class PemesananController extends Controller
{
    /**
     * Tampilkan daftar pemesanan user di halaman pembayaran
     */
    public function index()
    {
        $user = Auth::user();

        $pemesanans = Pemesanan::with('kamar')
            ->where('id_user', $user->id_user)
            ->latest()
            ->get();

        return view('pembayaran', compact('pemesanans'));
    }

    /**
     * Simpan pemesanan baru (dipanggil dari halaman kamar)
     */
    public function store(Request $request)
    {
        $request->validate([
            'id_kamar' => 'required|exists:kamars,id_kamar',
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $id_kamar = $request->id_kamar;
        $check_in = $request->check_in;
        $check_out = $request->check_out;

        // 🔍 Cek apakah kamar sudah dipesan di tanggal bentrok
        $bentrok = Pemesanan::where('id_kamar', $id_kamar)
            ->where(function ($q) use ($check_in, $check_out) {
                $q->where('check_in', '<', $check_out)
                  ->where('check_out', '>', $check_in);
            })
            ->exists();

        if ($bentrok) {
            return back()->with('error', 'Kamar sudah dipesan di tanggal tersebut.');
        }

        // Hitung total hari
        $total_hari = (strtotime($check_out) - strtotime($check_in)) / 86400;

        Pemesanan::create([
            'id_user' => Auth::id(),
            'id_kamar' => $id_kamar,
            'booking_code' => strtoupper(Str::random(8)),
            'check_in' => $check_in,
            'check_out' => $check_out,
            'total_hari' => $total_hari,
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dibuat.');
    }

    /**
     * Update tanggal pemesanan
     */
    public function update(Request $request, $id)
    {
        $pemesanan = Pemesanan::findOrFail($id);

        $request->validate([
            'check_in' => 'required|date|after_or_equal:today',
            'check_out' => 'required|date|after:check_in',
        ]);

        $check_in = $request->check_in;
        $check_out = $request->check_out;

        // 🔍 Cek bentrok dengan pemesanan lain di kamar yang sama
        $bentrok = Pemesanan::where('id_kamar', $pemesanan->id_kamar)
            ->where('id_pemesanan', '!=', $pemesanan->id_pemesanan)
            ->where(function ($q) use ($check_in, $check_out) {
                $q->where('check_in', '<', $check_out)
                  ->where('check_out', '>', $check_in);
            })
            ->exists();

        if ($bentrok) {
            return back()->with('error', 'Tanggal yang dipilih bentrok dengan pemesanan lain.');
        }

        // Hitung ulang total hari
        $total_hari = (strtotime($check_out) - strtotime($check_in)) / 86400;

        $pemesanan->update([
            'check_in' => $check_in,
            'check_out' => $check_out,
            'total_hari' => $total_hari,
        ]);

        return redirect()->route('pemesanan.index')->with('success', 'Tanggal pemesanan berhasil diubah.');
    }

    /**
     * Hapus pemesanan
     */
    public function destroy($id)
    {
        $pemesanan = Pemesanan::findOrFail($id);
        $pemesanan->delete();

        return redirect()->route('pemesanan.index')->with('success', 'Pemesanan berhasil dihapus.');
    }
}
