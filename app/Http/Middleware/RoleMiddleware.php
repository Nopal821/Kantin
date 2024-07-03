<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    public function handle($request, Closure $next, $role)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        if ($user->role !== $role) {
            return redirect('home'); // Redirect ke halaman yang sesuai jika pengguna tidak memiliki peran yang diinginkan
        }

        return $next($request);
    }
}
