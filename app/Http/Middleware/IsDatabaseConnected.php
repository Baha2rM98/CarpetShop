<?php

namespace App\Http\Middleware;

use Closure;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class IsDatabaseConnected
{
    /**
     * Handle an incoming request.
     *
     * @param  Request  $request
     * @param  Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->isConnectionStable()) {
            if ($this->isAPIRequest($request)) {
                return response()->json(['error' => 'Database Connection Error'], 500);
            }
            abort(500, 'Database Connection Error');
        }
        return $next($request);
    }

    /**
     * Checks if database connection is set
     * @return bool|DB
     */
    private function isConnectionStable()
    {
        try {
            return DB::connection()->getPdo();
        } catch (Exception $exception) {
        }

        return false;
    }

    /**
     * Determines if request type is API
     * @param  Request  $request
     * @return bool
     */
    private function isAPIRequest(Request $request)
    {
        return Str::contains($request->fullUrl(), 'api');
    }
}
