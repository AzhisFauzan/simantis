<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ApiMiddleware
{
    public function handle(Request $request, Closure $next): Response
    {
        $token = $request->bearerToken();

        $validSecret = env('SIMANTIS_SECRET_KEY');

        if ($token !== $validSecret) {
            return response()->json([
                'success' => false,
                'message' => 'Akses Ditolak! Secret Key tidak valid.'
            ], 401);
        }

        return $next($request);
    }
}
