<?php

namespace App\Core\Component\Db;

interface DBAdapter
{
    public function getConnection();
}