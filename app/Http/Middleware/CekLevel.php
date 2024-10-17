<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CekLevel
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $level)
    {

        if (auth()->user()&& $level == auth()->user()->level) {
            return $next($request);
        }
        return redirect()->route('dashboard');
    }   
}
//Fungsi handle ini dirancang untuk melakukan kontrol akses. Ini memastikan bahwa hanya pengguna dengan level tertentu yang dapat mengakses rute atau kontrol 
//yang dilindungi oleh middleware ini. Jika tidak memenuhi syarat, pengguna akan diarahkan kembali ke dashboard.

//Dalam contoh di atas, jika pengguna yang terautentikasi memiliki level 'admin', mereka akan dapat mengakses halaman admin. Jika tidak, mereka akan diarahkan ke halaman dashboard.