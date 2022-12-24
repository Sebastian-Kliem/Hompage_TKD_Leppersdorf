<?php

namespace Model\Resource\DBQuerys;

use Model\Entitys\EventsModel;
use Model\Entitys\UserModel;
use Model\Resource\Base;

class User extends Base
{

    public function logIn($email, $password)
    {
        $this->connectDB();
        $query = $this->connection->prepare(
            "Select * from Users where eMail = ?");

        $query->execute([$email]);

        while ($row = $query->fetch(\PDO::FETCH_ASSOC)) {
            if (password_verify($password, $row['Pass'])) {
                $user = new UserModel(
                    $row['id_Users'],
                    $row['Username'],
                    $row['eMail'],
                    $row['isAdmin'],
                    $row['isModerator']
                );
                return $user;
            }
        }
        return false;
    }

    public function register($email, $Username, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        $this->connectDB();
        $query = $this->connection->prepare(
            "INSERT INTO Users (eMail, Username, Pass)
            VALUES (:eMail, :Pass, :Username)"
        );

        $query->bindParam(':eMail', $email);
        $query->bindParam(':Pass', $passwordHash);
        $query->bindParam(':Username', $Username);

        $query->execute();
    }

}