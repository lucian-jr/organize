<?php

require_once '../core/Database.php'; 

class Tasks {
    private $db;

    public function __construct()
    {
        $this->db = new Database();
    }

    public function getAllTasks() {
        $stmt = $this->db->getConnection()->prepare("SELECT * FROM tasks");
        $stmt->execute();

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}