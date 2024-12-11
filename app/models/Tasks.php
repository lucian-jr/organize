<?php

require_once '../core/Database.php'; 

class Tasks {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function get($id) {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function getAllTasks() {
        $sql = "SELECT * FROM tasks";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function removeTask($id) {
        try {
            $sql = "DELETE FROM tasks WHERE id = :id";
        
            $stmt = $this->db->getConnection()->prepare($sql);
            $stmt->bindParam(':id', $id, PDO::PARAM_INT);

            if ($stmt->execute()) {
                return true;
            } else {
                return false;
            }
        } catch (PDOException $e) {
            echo "Erro: " . $e->getMessage();

            return false;
        }
    }
}