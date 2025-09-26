<?php 
namespace App\Http\Middleware; 

use Closure; 

use Illuminate\Support\Facades\Auth;

class IsAdmin 
{
    public function handle($request, Closure $next) 
    { 
        if (Auth::check() && (str_contains(strtolower(Auth::user()->username), '@dmin') || strtolower(Auth::user()->role) === 'admin')) { 
            return $next($request); 
        } 
        return redirect()->route('dashboard'); // redirige vers dashboard user 
    } 
}