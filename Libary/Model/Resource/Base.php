<?php

namespace Model\Resource;

use PDO;

class Base
{
    protected PDO $connection;

    protected function connectDB()
    {
        $dbHost = "udemy-mySql";
        $dbPort = "3306";
        $dbName = "testdatabase";
        $dbUser = "testuser";
        $dbPassword = "testpassword";

        $dsn = "mysql:host=$dbHost;dbname=$dbName";

        $this->connection = new PDO($dsn, $dbUser, $dbPassword);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}