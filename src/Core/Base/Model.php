<?php

namespace App\Core\Base;

use App\Core\Component\Db\Query;

class Model
{
    protected $table;

    public function getTableName()
    {
        return $this->table;
    }

    public static function __callStatic($method, $parameters)
    {
        $model = new static();
        $query = (new Query())->setModel($model);
        return $query->$method(...$parameters);
    }

    public function hydrate($params)
    {
        foreach ($params as $field => $value) {
            if (property_exists(static::class, $field)) {
                $this->$field = $value;
            }
        }
    }


}