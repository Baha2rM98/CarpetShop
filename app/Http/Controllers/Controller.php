<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    /**
     * Checks if database connection is set or not
     * @return boolean|DB
     */
    protected function isDatabaseConnected()
    {
        try {
            return DB::connection()->getPdo();
        } catch (Exception $exception) {
        }
        return false;
    }
}
