<?php
namespace service;
use PDO;

class Connection {

    private static $conn;

    public static function getConnection() {
        if (connection::$conn == null) {
            $servername = "localhost";
            $username = "Mohammad";
            $password = "12345";
            $dbname = "servizituristici";
            connection::$conn = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
            connection::$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        }
        return connection::$conn;
    }
}
