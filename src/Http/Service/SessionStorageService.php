<?php

namespace App\Http\Service;

use App\Core\Helper\ArrayHelper;
use App\Http\Entity\User;

class SessionStorageService
{
    public function write(User $user)
    {
        if (!$this->isOpen()) {
            $this->openSession();
        }

        $this->writeUser($user);

        return true;
    }

    public function get($key)
    {
        if (!$this->isOpen()) {
            $this->openSession();
        }

        return ArrayHelper::getValue($_SESSION, $key);
    }

    protected function isOpen()
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    protected function openSession()
    {
        session_start();
    }

    protected function writeUser(User $user)
    {
        $session = [];
        $session['id'] = $user->id;

        $_SESSION['user'] = $session;
    }

    public function close()
    {
        session_write_close();
    }
}
