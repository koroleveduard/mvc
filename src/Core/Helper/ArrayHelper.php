<?php

namespace App\Core\Helper;

class ArrayHelper
{
    public static function getValue(array $search, string $key, $default = null)
    {
        if (isset($search[$key])) {
            return $search[$key];
        }

        return $default;
    }
}
