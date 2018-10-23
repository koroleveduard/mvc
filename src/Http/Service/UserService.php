<?php

namespace App\Http\Service;

use App\Core\Application;
use App\Http\Entity\User;

class UserService
{
    public function writeOff(User $user, int $sum): void
    {
        $connection = Application::$app->getDb()->getConnection();

        $connection->beginTransaction();

        $currentBalance = $this->getAndLockCurrentBalance($user, $connection);
        if ($currentBalance < $sum) {
            $connection->rollBack();
            throw new \DomainException(' У вас недостаточно средств на счету');
        }

        $sqlUpdate = "UPDATE users SET balance = :balance WHERE id = :id";
        $newBalance = $currentBalance - $sum;

        $sth = $connection->prepare($sqlUpdate);
        $sth->execute([
            'balance' => $newBalance,
            'id' => $user->getId()
        ]);

        $user->setBalance($newBalance);

        $connection->commit();
    }

    protected function getAndLockCurrentBalance(User $user, \PDO $connection): int
    {
        $sqlBalance = "SELECT balance FROM users WHERE id = :id FOR UPDATE";
        $sth = $connection->prepare($sqlBalance);
        $sth->execute([
            'id' => $user->getId()
        ]);

        $result = $sth->fetch(\PDO::FETCH_ASSOC);
        if (!$result) {
            throw new \DomainException('С юзером что-то случилось');
        }

        $currentBalance = $result['balance'];

        return $currentBalance;
    }
}