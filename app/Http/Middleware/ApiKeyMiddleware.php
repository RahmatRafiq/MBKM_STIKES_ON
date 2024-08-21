<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $providedApiKey = $request->header('X-API-KEY');
        $hashedApiKey = config('app.api_key_hash');

        // Validasi apakah API key yang diberikan cocok dengan hash di konfigurasi
        if (!$providedApiKey || !Hash::check($providedApiKey, $hashedApiKey)) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
