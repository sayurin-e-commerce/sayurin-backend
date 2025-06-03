<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        $user = $request->user();

        if (!$user || $user->role !== 'admin') {
            return response()->json([
                'meta' => [
                    'status_code' => 403,
                    'success' => false,
                    'message' => 'Akses ditolak. Hanya admin yang boleh.'
                ]
            ], 403);
        }

        return $next($request);
    }
}
