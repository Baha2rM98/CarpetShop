<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class Controller extends BaseController
{
    use AuthorizesRequests;
    use DispatchesJobs;
    use ValidatesRequests;

    /**
     * Checks if database connection is set or not
     * @return bool|DB
     */
    protected function isDatabaseConnected()
    {
        try {
            return DB::connection()->getPdo();
        } catch (Exception $exception) {
        }

        return false;
    }

    /** Returns absolute path of uploaded files on server
     *
     * @param  string  $path
     * @param  string  $dir
     *
     * @return string
     */
    protected function getFileAbsolutePath($dir, $path)
    {
        return Str::replaceArray('/storage/'.$dir.'/', [''], $path);
    }
}
