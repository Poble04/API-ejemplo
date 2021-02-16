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

        if (!empty($row)) {
            $this->description = $row['description'];
            $this->done = $row['done'];
            $this->id_task = $row['id_task'];
        }else {
            unset($this->id_task);
        }

        return $stmt;
    }

    public function insert()
    {
        $query = "INSERT INTO {$this->table} (description, done)
                    VALUES (:description, :done)";

        $stmt = $this->conn->prepare($query);

        /** Formatear datos de entrada */
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->done = htmlspecialchars(strip_tags($this->done));

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

    public function update()
    {
        $query = "UPDATE {$this->table}
                    SET description = :description, done = :done
                    WHERE id_task = :id_task";

        $stmt = $this->conn->prepare($query);

        /** Formatear datos de entrada */
        $this->description = htmlspecialchars(strip_tags($this->description));
        $this->done = htmlspecialchars(strip_tags($this->done));
        $this->id_task = htmlspecialchars(strip_tags($this->id_task));

        /** Bind parámetros */
        $stmt->bindParam(':description', $this->description);
        $stmt->bindParam(':done', $this->done);
        $stmt->bindParam(':id_task', $this->id_task);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }

    public function delete()
    {
        $query = "DELETE FROM {$this->table}
                    WHERE id_task = :id_task";

        $stmt = $this->conn->prepare($query);

        /** Formatear datos de entrada */
        $this->id_task = htmlspecialchars(strip_tags($this->id_task));

        /** Bind parámetros */
        $stmt->bindParam(':id_task', $this->id_task);

        if ($stmt->execute()) {
            return true;
        } else {
            printf("Error: %s.\n", $stmt->error);
            return false;
        }
    }
}
