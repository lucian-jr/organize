<?php 
    require_once '../app/views/task-form.php';
?>

<section class="page-content">

    <div class="filter-area mg-btm-20">
        <hgroup class="flex align-center mg-btm-15">
            <i class="fa-solid fa-filter mg-rgt-5"></i>
            <h3>Filtros</h3>
        </hgroup>

        <div class="flex">
            <div class="flex flex-column flex-content-tiny mg-rgt-20">
                <label class="defautl-label" for="cards-type">Tipo das tarefas</label>

                <div class="search-content">
                    <i class="fa-solid fa-magnifying-glass search-icon"></i>
                    <input type="text" id="search">
                </div>
            </div>

            <div class="flex flex-column flex-content-tiny">
                <label class="defautl-label" for="cards-type">Pesquisar tarefas</label>
                <select name="cards-type" id="cards-type">
                    <option value="uncompleted">Em andamento</option>
                    <option value="completed">Finalizados</option>
                </select>
            </div>
        </div>
    </div>

    <hr class="mg-btm-30 width-100">

    <div class="cards-container" data-type="uncompleted">
        <?php if (!empty($uncompleted_tasks)) : ?>
            <?php foreach($uncompleted_tasks as $task): 
                $cardTagColor = '';
                $currentDate = date('Y-m-d');
                $days = countDays($currentDate, $task->estimated_end_date); 
            
                if($days > 5){
                    $cardTagColor = 'green';
                } else if($days >= 3 && $days <= 5) {
                    $cardTagColor = 'orange';
                } else {
                    $cardTagColor = 'red';
                }
            ?>
                <div class="card box-shadow" data-id="<?=$task->id?>">
                    <span class="tag <?=$cardTagColor?> box-shadow"></span>
                    <i class="fa-solid fa-trash delete-task" data-id="<?=$task->id?>"></i>
                    <h3 class="mg-btm-20"><?=$task->title?></h3>
                    <div class="flex align-center">
                        <i class="fa-solid fa-hourglass-half mg-rgt-5"></i>
                        <p><?=formataData($task->estimated_end_date)?></p>
                    </div>
                
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="card box-shadow open-task-form" data-form-type="add">
            <i class="fa-solid fa-plus fs-32"></i>
        </div>
    </div>

    <div class="cards-container display-none" data-type="completed">
        <?php if (!empty($completed_tasks)) : ?>
            <?php foreach($completed_tasks as $task): ?>
                <div class="card box-shadow" data-id="<?=$task->id?>">
                    <i class="fa-solid fa-trash delete-task" data-id="<?=$task->id?>"></i>
                    <h3 class="mg-btm-20"><?=$task->title?></h3>
                    <div class="flex align-center">
                        <i class="fa-solid fa-hourglass-end mg-rgt-5"></i>
                        <p><?=formataData($task->end_date)?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

