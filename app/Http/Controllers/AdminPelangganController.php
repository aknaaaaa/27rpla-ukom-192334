<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPelangganController extends Controller
{
    public function index()
    {
        // Ambil seluruh user beserta nama role-nya
        $roleMap = DB::table('roles')->pluck('nama_role', 'id_role');

        $customers = User::orderBy('nama_user')->get()->map(function ($user) use ($roleMap) {
            $user->role_name = $roleMap[$user->id_role] ?? '-';
            return $user;
        });

        $metrics = [
            'total_users' => $customers->count(),
            'total_customers' => $customers->where('id_role', '!=', 1)->count(),
            'total_admins' => $customers->where('id_role', 1)->count(),
        ];

        return view('admin.pelanggan', [
            'customers' => $customers->filter(fn ($user) => strcasecmp($user->role_name ?? '', 'Admin') !== 0)->values(),
            'metrics' => $metrics,
        ]);
    }

    public function show($id)
    {
        $roleMap = DB::table('roles')->pluck('nama_role', 'id_role');

        $customer = User::findOrFail($id);
        $customer->role_name = $roleMap[$customer->id_role] ?? '-';

        return view('admin.pelanggan_detail', [
            'customer' => $customer,
        ]);
    }
}
