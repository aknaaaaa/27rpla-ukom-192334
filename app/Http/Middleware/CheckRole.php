<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckRole
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        $user = $request->user();

        // Jika user tidak authenticated
        if (!$user) {
            return redirect()->route('layouts.login')->with('error', 'Silakan login terlebih dahulu.');
        }

        // Convert role parameter to role ID
        $roleMap = [
            'admin' => 1,
            'customer' => 2,
        ];
        
        $requiredRoleId = $roleMap[$role] ?? null;

        // Check if user has the required role
        if ($requiredRoleId) {
            $userRoleId = (int)($user->id_role ?? 0);
            
            if ($userRoleId !== $requiredRoleId) {
                $roleNames = [1 => 'Admin', 2 => 'Customer'];
                $requiredRole = $roleNames[$requiredRoleId] ?? 'Unknown';
                $userRole = $roleNames[$userRoleId] ?? 'Unknown';
                
                return abort(403, "Akses ditolak. Anda adalah {$userRole} tetapi halaman ini memerlukan {$requiredRole}.");
            }
        }

        return $next($request);
    }
}
