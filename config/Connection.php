<?php

class Connection
{
    private $host = 'localhost';
    private $db_name = 'to_do_list';
    private $username = 'root';
    private $password = '';
    private $conn;

    public function connect()
    {
        try {
            $this->conn = null;
            $this->conn = new PDO('mysql:host=' . $this->host . ';dbname=' . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            echo 'Connection Error: ' . $e->getMessage();
        }

        return $this->conn;
    }
}
