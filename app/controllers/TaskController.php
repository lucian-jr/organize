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
        $id = $_GET['id'];
        
        $task = $this->tasks_model->get($id);

        if($task) {
            print_r($task);
        }
    }

    public function delete() {
        header('Content-Type: application/json');
        
        $id = $_GET['id'];

        if($id) {
            $removedTask = $this->tasks_model->removeTask($id);

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