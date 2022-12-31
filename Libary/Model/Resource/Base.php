<?php

namespace Model\Resource;

use PDO;

class Base
{
    protected PDO $connection;

    protected function connectDB()
    {
        $dbHost = "db";
        $dbPort = "33306";
        $dbName = "TKD_Leppe";
        $dbUser = "TKD_Leppe";
        $dbPassword = "TKD_Lepp";

        if (file_exists('.config.php')) {
            require_once('.config.php');
        }

        $dsn = "mysql:host=$dbHost;dbname=$dbName";

        $this->connection = new PDO($dsn, $dbUser, $dbPassword);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}