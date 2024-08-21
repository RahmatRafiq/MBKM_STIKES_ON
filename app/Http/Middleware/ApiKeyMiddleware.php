<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;

class ApiKeyMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        $providedApiKey = $request->header('X-API-KEY');
        $hashedApiKey = config('app.api_key_hash');

        // Logging untuk debug
        Log::info('Received API Key: ' . $providedApiKey);
        Log::info('Expected API Key hash: ' . $hashedApiKey);

        // Validasi apakah API key yang diberikan cocok dengan hash di konfigurasi
        if (!$providedApiKey || !Hash::check($providedApiKey, $hashedApiKey)) {
            Log::warning('Unauthorized: API Key did not match.');
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
