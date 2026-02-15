<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class redirek
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::user()){
            $user = Auth::user();

            if($user->role === 'admin'){
                return redirect()->route('admin.dashboard');
            } elseif($user->role === 'petugas'){
                return redirect()->route('petugas.dashboard');
            } 
        }
        return $next($request);
    }
}
