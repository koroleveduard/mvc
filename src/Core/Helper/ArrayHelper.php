<?php

namespace App\Core\Helper;

class ArrayHelper
{
    /**
     * @param array $search
     * @param string $key
     * @param mixed $default
     * @return mixed|null
     */
    public static function getValue(array $search, string $key, $default = null)
    {
        if (isset($search[$key])) {
            return $search[$key];
        }

        return $default;
    }
}
