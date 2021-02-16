<?php

class Task
{
    private $conn;
    private $table = 'tasks';

    public $id;
    public $description;
    public $status;

    /** Constructor */
    public function __construct($db)
    {
        $this->conn = $db;
    }

    public function getTask()
    {
        $query = "SELECT *
                    FROM {$this->table}";

        $stmt = $this->conn->prepare($query);
        $stmt->execute();

        return $stmt;
    }
}
