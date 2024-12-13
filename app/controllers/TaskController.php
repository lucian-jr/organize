<?php

class TaskController {
    private $tasks_model;

    public function __construct() {
        $this->tasks_model = new Tasks();
    }
    
    public function index() {
        
    }

    public function get() {
        header('Content-Type: application/json');
        $id = $_GET['id'];

        if(!$id) {
            return print_r(json_encode([
                'status' => 400,
                'message' => 'O registro não foi encontrado, tente novamente!'
            ])); 
        } 
        
        $task = $this->tasks_model->get($id);

        if($task) {
            return print_r(json_encode([
                'status' => 200,
                'data' => $task,
                'message' => 'Registro encontrado com sucesso!'
            ]));
        } else {
            return print_r(json_encode([
                'status' => 400,
                'message' => 'O registro não foi encontrado, tente novamente!'
            ])); 
        }
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

    public function update() {
        header('Content-Type: application/json');
        $id = $_GET['id'];
        $insert = false;
        $data = $_POST;

        if($id) {

            if($data['completed'] && !$data['end_date']) {
                $data['end_date'] = date('Y-m-d');
            }

            $update = $this->tasks_model->update($data, $id);
        }
    
        if($update) {
            return print_r(json_encode([
                'status' => 200,
                'data' => $data,
                'message' => 'Registro alterado com sucesso!'
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