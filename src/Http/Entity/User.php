<?php

namespace App\Http\Entity;

use App\Core\Base\Model;

class User extends Model
{
    protected $table = 'users';

    public $id;

    public $username;

    public $password;

    public $balance;

}