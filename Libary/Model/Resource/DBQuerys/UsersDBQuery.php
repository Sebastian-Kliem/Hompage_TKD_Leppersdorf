<?php

namespace Model\Resource\DBQuerys;

use Exception;
use Model\Entitys\EventsModel;
use Model\Entitys\UserModel;
use Model\Resource\Base;

class UsersDBQuery extends Base
{

    public function logIn($email, $password)
    {
        try {
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
        } catch (exception $e) {

        }
        return false;
    }

    public function register($email, $Username, $password) {
        $passwordHash = password_hash($password, PASSWORD_DEFAULT);

        try {
            $this->connectDB();
            $query = $this->connection->prepare(
                "INSERT INTO Users (eMail, Username, Pass)
            VALUES (:eMail, :Username, :Pass)"
            );

            $query->bindParam(':eMail', $email);
            $query->bindParam(':Pass', $passwordHash);
            $query->bindParam(':Username', $Username);

            return $query->execute();
        } catch (exception $e) {
            return false;
        }
    }
}