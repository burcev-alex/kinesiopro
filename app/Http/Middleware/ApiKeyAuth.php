<?php


namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Log;

class ApiKeyAuth
{
    public function handle($request, Closure $next)
    {
        $apiKey = $request->header('x-apikey');

        if (strlen($apiKey) == 0) {
            return response()->json([
                'error' => 'Token is required',
                'code' => 401
            ], 401);
        } elseif ($apiKey != config('ekoj.internal_api_key')) {
            return response()->json([
                'error' => 'Token_invalid',
                'code' => 401
            ], 401);
        }

        return $next($request);
    }
}
