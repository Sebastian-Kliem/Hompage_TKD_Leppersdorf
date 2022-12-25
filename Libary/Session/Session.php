<?php

namespace Session;

use Model\Resource\DBQuerys\UsersDBQuery;

class Session
{
    public static function logIn(string $email, string $password): bool
    {
        $userClass = new UsersDBQuery();
        $user = $userClass->logIn($email, $password);

        if ($user) {
            $_SESSION['userId'] = $user->getId();
            $_SESSION['eMail'] = $user->getEMail();
            $_SESSION['userName'] = $user->getUsename();
            $_SESSION['isAdmin'] = $user->getIsAdmin();
            $_SESSION['isModerator'] = $user->getIsModerator();

            return true;
        } else {
            $_SESSION['massage'] = 'Benutzer nicht gefunden';
        }
        return false;
    }
}