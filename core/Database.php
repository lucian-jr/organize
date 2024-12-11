<?php

require_once '../app/models/Tasks.php';

class Database {
    private $pdo;

    public function __construct() 
    {
        try {
            $this->pdo = new PDO(
                'mysql:host=localhost;dbname=task_manager', 
                'root', 
                '',
                [PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION]
            );
        } catch (PDOException $e) {
            die("Data base conection error: " . $e->getMessage());
        }
    }

    public function getConnection() {
        return $this->pdo;
    }

    // public function query($sql) {
    //     $stmt = $this->pdo->prepare($sql);
    //     $stmt->execute();
    //     return $stmt->fetchAll(PDO::FETCH_ASSOC);
    // }
}