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
        $dbPassword = "TKD_Leppe";

        if (file_exists($_SERVER['DOCUMENT_ROOT']."/.config.php")) {
            $configs = include($_SERVER['DOCUMENT_ROOT']."/.config.php");

            $dbHost = $configs['dbHost'];
            $dbPort = $configs['dbPort'];
            $dbName = $configs['dbName'];
            $dbUser = $configs['dbUser'];
            $dbPassword = $configs['dbPassword'];
        }

        $dsn = "mysql:host=$dbHost;dbname=$dbName";

        $this->connection = new PDO($dsn, $dbUser, $dbPassword);
        $this->connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    }
}