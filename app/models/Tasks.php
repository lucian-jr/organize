<?php

require_once '../core/Database.php';

class Tasks
{
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllTasks($completed)
    {
        $sql = "SELECT * FROM tasks WHERE completed = $completed ORDER BY id DESC";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_OBJ);
    }

    public function get($id)
    {
        $sql = "SELECT * FROM tasks WHERE id = :id";
        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindParam(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return $stmt->fetch(PDO::FETCH_OBJ);
        } else {
            return false;
        }
    }

    public function remove()
    {
        $id = $_GET['id'];

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

    public function insert($data)
    {
        $sql = "INSERT INTO tasks (`title`, `description`, `estimated_end_date`) VALUES (?, ?, ?)";

        $stmt = $this->db->getConnection()->prepare($sql);
        $stmt->bindValue(1, $data['title']);
        $stmt->bindValue(2, $data['description']);
        $stmt->bindValue(3, $data['estimated_end_date']);

        if ($stmt->execute()) {
            $lastId = $this->db->getConnection()->lastInsertId();

            return $lastId;
        } else {
            return false;
        }
    }

    public function update($data, $id)
    {
        // print_r($data);
        $sql = "UPDATE tasks 
            SET 
                `title` = :title, 
                `description` = :description, 
                `completed` = :completed, 
                `estimated_end_date` = :estimated_end_date, 
                `end_date` = :end_date 
            WHERE id = :id";

        $stmt = $this->db->getConnection()->prepare($sql);

        $stmt->bindValue(':title', $data['title'] ?? null);
        $stmt->bindValue(':description', $data['description'] ?? null);
        $stmt->bindValue(':completed', $data['completed'] !== '' ? intval($data['completed']) : 0);
        $stmt->bindValue(':estimated_end_date', $data['estimated_end_date'] ?? null);
        $stmt->bindValue(':end_date', $data['end_date'] !== '' ? $data['end_date'] : null);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);

        if ($stmt->execute()) {
            return true;
        } else {
            return false;
        }
    }
}
