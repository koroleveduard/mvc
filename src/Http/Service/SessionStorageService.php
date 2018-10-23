<?php

namespace App\Http\Service;

use App\Core\Helper\ArrayHelper;
use App\Http\Entity\User;

class SessionStorageService
{
    public function write(User $user): bool
    {
        if (!$this->isOpen()) {
            $this->openSession();
        }

        $this->writeUser($user);

        return true;
    }

    /** @return string|int|array|null|bool Return any scalar type from session*/
    public function get(string $key)
    {
        if (!$this->isOpen()) {
            $this->openSession();
        }

        return ArrayHelper::getValue($_SESSION, $key);
    }

    protected function isOpen(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE;
    }

    protected function openSession(): void
    {
        session_start();
        session_regenerate_id();
    }

    protected function writeUser(User $user): void
    {
        $session = [];
        $session['id'] = $user->getId();

        $_SESSION['user'] = $session;
    }

    public function unset(string $key): void
    {
        if (!$this->isOpen()) {
            $this->openSession();
        }

        unset($_SESSION[$key]);
    }

    public function close(): void
    {
        session_write_close();
    }

    public function destroy(): void
    {
        session_destroy();
    }
}
