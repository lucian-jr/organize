<?php

class TaskController {
    private $tasks_model;

    public function __construct() {
        $this->tasks_model = new Tasks();
    }
    
    public function index() {
        
    }

    public function show() {
        $id = $_GET['id'];
        
        $task = $this->tasks_model->get($id);

        if($task) {
            print_r($task);
        }

        require_once '../app/views/templates/header.php';
        require_once '../app/views/templates/menu.php';
        require_once '../app/views/form-task.php';
        require_once '../app/views/templates/footer.php';
    }

    public function insert() {
        header('Content-Type: application/json');
        $insert = false;

        if($_POST['title'] && $_POST['description'] && $_POST['estimated_end_date']) {
            $data = $_POST;

            $insert = $this->tasks_model->insert($data);
        }
    
        if($insert) {
            return print_r(json_encode([
                'status' => 200,
                'inserted_id' => $insert,
                'message' => 'Registro inserido com sucesso!'
            ]));
        } else {
            return print_r(json_encode([
                'status' => 400,
                'message' => 'Houve um problema! A requisição não foi feita de forma correta.'
            ])); 
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        
        $id = $_GET['id'];

        if($id) {
            $removedTask = $this->tasks_model->remove($id);

            if($removedTask == true) {
                return print_r(json_encode([
                    'status' => 200,
                    'message' => 'Registro excluído com sucesso!'
                ]));
            } else {
                return print_r(json_encode([
                    'status' => 500,
                    'message' => 'Ocorreu um erro desconhecido, tente novamente!'
                ]));
            }
        } else {
            return print_r(json_encode([
                'status' => 400,
                'message' => 'Houve um problema! A requisição não foi feita de forma correta.'
            ])); 
        }
    }

    public function edit() {
        
    }
}