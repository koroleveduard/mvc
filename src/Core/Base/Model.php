<?php

namespace App\Core\Base;

use App\Core\Component\Db\Query;

/**
 * Class Model
 * @package App\Core\Base
 * @method static findOneBy(array $params):
 */
class Model
{
    protected $table;

    public function getTableName(): string
    {
        $tableName = $this->table;
        if (is_null($tableName)) {
            $className = (new \ReflectionClass($this))->getShortName();
            $tableName = mb_strtolower($className);
        }

        return $tableName;
    }

    public static function __callStatic(string $method, array $parameters)
    {
        $model = new static();
        $query = (new Query())->setModel($model);
        return $query->$method(...$parameters);
    }

    public function hydrate(array $params)
    {
        foreach ($params as $field => $value) {
            if (property_exists(static::class, $field)) {
                $this->$field = $value;
            }
        }
    }
}