<?php

class HomeController {
    public function index() {

        $tasks_model = new Tasks();
        $tasks = $tasks_model->getAllTasks();

    
        require_once '../app/views/templates/header.php';
        require_once '../app/views/templates/menu.php';
        require_once '../app/views/home.php';
        require_once '../app/views/templates/footer.php';
    }
}