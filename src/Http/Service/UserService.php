<?php

namespace App\Http\Service;

use App\Core\Application;
use App\Http\Entity\User;

class UserService
{
    public function writeOff(User $user, $sum)
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
            'id' => $user->id
        ]);

        $user->balance = $newBalance;

        $connection->commit();
    }

    protected function getAndLockCurrentBalance(User $user, $connection)
    {
        $sqlBalance = "SELECT balance FROM users WHERE id = :id FOR UPDATE";
        $sth = $connection->prepare($sqlBalance);
        $sth->execute([
            'id' => $user->id
        ]);

        $result = $sth->fetchAll(\PDO::FETCH_ASSOC);
        $result = array_shift($result);
        $currentBalance = $result['balance'];

        return $currentBalance;
    }
}