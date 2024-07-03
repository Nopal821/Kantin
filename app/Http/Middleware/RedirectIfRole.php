<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfRole
{
    public function handle(Request $request, Closure $next)
    {
        $user = Auth::user();

        if ($user->hasRole('admin')) {
            return redirect()->route('home');
        } elseif ($user->hasRole('pengguna')) {
            return redirect()->route('orders.index');
        } elseif ($user->hasRole('pembeli')) {
            return redirect()->route('index');
        }

        return $next($request);
    }
}
