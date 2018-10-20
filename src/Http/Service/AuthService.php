<?php

namespace App\Http\Service;

use App\Http\Entity\User;

class AuthService
{
    protected $session;

    protected $user;

    public function __construct()
    {
        $this->session = new SessionStorageService();
    }

    public function login($identity, $credentials): void
    {
        $user = User::findOneBy([
            'username' => $identity
        ]);

        if (is_null($user)) {
            throw new \DomainException('User is not found!');
        }

        if ($user->password !== md5($credentials)) {
            throw new \DomainException('Password is wrong!');
        }

        $this->session->write($user);
        $this->session->close();
    }

    public function logout()
    {
        $this->session->unset('user');
        $this->session->close();
        $this->user = null;
    }

    public function getIdentity() : ?User
    {
        $user = $this->user;

        if (!is_null($user)) {
            return $user;
        }

        $sessionUser = $this->session->get('user');
        $this->session->close();

        if (is_null($sessionUser)) {
            return null;
        }

        $user = User::findOneBy([
            'id' => $sessionUser['id']
        ]);

        return $user;
    }
}
