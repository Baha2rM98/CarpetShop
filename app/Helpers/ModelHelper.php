<?php

namespace App\Helpers;

use Illuminate\Support\Str;

trait ModelHelper
{
    /**
     * Returns absolute path of uploaded files on server
     *
     * @param  string  $path
     * @param  string  $dir
     *
     * @return string
     */
    public static function getFileAbsolutePath($dir, $path)
    {
        return Str::replaceArray('/storage/'.$dir.'/', [''], $path);
    }
}
