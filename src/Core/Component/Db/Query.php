<?php

namespace App\Core\Component\Db;

use App\Core\Application;

class Query
{
    protected $model;

    public function setModel($model)
    {
        $this->model = $model;

        return $this;
    }

    public function findOneBy(array $params)
    {
        $columns = ['*'];
        $sql = $this->getSelectQuery($columns, $params);

        $connection = Application::$app->getDb()->getConnection();
        $sth = $connection->prepare($sql);
        $pdoParams = $this->prepareParams($params);
        $sth->execute($pdoParams);
        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);

        if (empty($result)) {
            return null;
        }

        $data = array_shift($result);
        $this->model->hydrate($data);

        return $this->model;
    }

    protected function getSelectQuery(array $columns, array $params): string
    {
        $tableName = $this->model->getTableName();
        $columns = implode(', ', $columns);

        $conditions = [];
        foreach ($params as $key => $value) {
            $conditions[] = $key . ' = :' . $key;
        }

        $conditionsStr = implode(' AND ', $conditions);

        $sql = "SELECT $columns FROM $tableName WHERE $conditionsStr";

        return $sql;
    }

    protected function prepareParams(array $params): array
    {
        $result = [];

        foreach ($params as $key => $value) {
            $param = ':' . $key;
            $result[$param] = $value;
        }

        return $result;
    }
}