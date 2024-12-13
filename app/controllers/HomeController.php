<?php

class HomeController {
    public function index() {

        // Chamando a model Tasks()
        $tasks_model = new Tasks();

        // Utilizando funções da model para receber os registros das tasks
        $uncompleted_tasks= $tasks_model->getAllTasks(0);
        $completed_tasks = $tasks_model->getAllTasks(1);
    
        require_once '../app/views/templates/header.php';
        require_once '../app/views/templates/menu.php';
        require_once '../app/views/home.php';
        require_once '../app/views/templates/footer.php';
    }
}