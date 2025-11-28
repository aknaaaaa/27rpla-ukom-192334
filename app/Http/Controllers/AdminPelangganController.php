<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class AdminPelangganController extends Controller
{
    public function index()
    {
        $roleMap = DB::table('roles')->pluck('nama_role', 'id_role');

        $customers = User::where('id_role', '!=', 1)
            ->orderBy('nama_user')
            ->paginate(10)
            ->through(function ($user) use ($roleMap) {
                $user->role_name = $roleMap[$user->id_role] ?? '-';
                return $user;
            });

        $metrics = [
            'total_users' => User::count(),
            'total_customers' => User::where('id_role', '!=', 1)->count(),
            'total_admins' => User::where('id_role', 1)->count(),
        ];

        return view('admin.pelanggan', [
            'customers' => $customers,
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
