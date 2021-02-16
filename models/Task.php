<?php

class Task
{
    private $conn;
    private $table = 'tasks';

    public $id_task;
    public $description;
    public $done;

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

    public function getSingleTask()
    {
        $query = "SELECT *
                    FROM {$this->table}
                    WHERE id_task = ?";

        $stmt = $this->conn->prepare($query);

        /** Bind id_task */
        $stmt->bindParam(1, $this->id_task);
        $stmt->execute();

        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        $this->description = $row['description'];
        $this->done = $row['done'];

        return $stmt;
    }

    public function insert()
    {
        $query = "INSERT INTO {$this->table} (description, done)
                    VALUES (:description, :done)";

        $stmt = $this->conn->prepare($query);

        /** Formatear datos de entrada */
        $this->description = htmlspecialchars(strip_tags($this->description));

        /** Bind parámetros */
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':done', $this->done);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
