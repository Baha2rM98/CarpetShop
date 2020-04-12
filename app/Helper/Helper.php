<?php

namespace App\Helper;

use Illuminate\Support\Str;

trait Helper
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

    /**
     * Returns application sub domain url
     *
     * @return string
     */
    public static function getApplicationSubDomain()
    {
        return 'admin.'.parse_url(env('app_url'), PHP_URL_HOST);
    }

    /**
     * Checks if all values of array is ['null']
     *
     * @param  array  $array
     * @return bool
     */
    public function isAllValuesNull(array $array)
    {
        return array_unique(array_values($array)) === ['null'];
    }

    /**
     * Filters null strings from an array
     *
     * @param  array  $array
     * @return array
     */
    public function filter(array $array)
    {
        return array_values(array_filter($array, function ($k) use ($array) {
            return $array[$k] !== 'null';
        }, ARRAY_FILTER_USE_KEY));
    }
}
