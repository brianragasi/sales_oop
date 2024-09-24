<?php

class Database {
    private $host = "localhost"; // Replace with your database host
    private $username = "sales_admin"; // Replace with your database username
    private $password = "salesadmin123"; // Replace with your database password
    private $database = "sales_oop"; // Replace with your database name
    private $connection;

    public function __construct() {
        $this->connection = new mysqli($this->host, $this->username, $this->password, $this->database);

        if ($this->connection->connect_error) {
            die("Connection failed: " . $this->connection->connect_error);
        }
    }

    public function getConnection() {
        return $this->connection;
    }

    public function closeConnection() {
        $this->connection->close();
    }
}

?>