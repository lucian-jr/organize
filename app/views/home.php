<?php 
    require_once '../app/views/task-form.php';
?>

<section class="page-content">

    <!-- Legenda de cores -->
    <div class="tags-orientation mg-btm-20">
        <hgroup class="flex align-center mg-btm-10">
            <i class="fa-solid fa-circle-info mg-rgt-5"></i>
            <h3>Legenda de cores</h3>
        </hgroup>

        <div class="flex mg-btm-10">
            <div class="tag green">
                +5 dias p/ data final
            </div>

            <div class="tag orange">
                3-5 dias p/ data final
            </div>

            <div class="tag red">
                Próximo da data final
            </div>

            <div class="tag lemon-green">
                Data de finalização
            </div>
        </div>
    </div>

    <!-- Filtrar -->
    <div class="filter-area mg-btm-20">
        <hgroup class="flex align-center mg-btm-10">
            <i class="fa-solid fa-filter mg-rgt-5"></i>
            <h3>Filtrar</h3>
        </hgroup>

        <div class="flex">
            <div class="flex flex-column flex-content-tiny">
                <label class="defautl-label" for="cards-type">Status</label>
                <select name="cards-type" id="cards-type">
                    <option value="uncompleted">Tarefas em andamento</option>
                    <option value="completed">Tarefas finalizadas</option>
                </select>
            </div>
        </div>
    </div>

    <hr class="mg-btm-30 width-100">

    <!-- Conteúdo das tarefas incompletas -->
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
                <div class="card box-shadow open-task-form" data-id="<?=$task->id?>" data-form-type="edit">
                    <span class="tag <?=$cardTagColor?> box-shadow"></span>
                    <h3 class="mg-btm-20"><?=$task->title?></h3>
                    <div class="flex align-center">
                        <i class="fa-regular fa-clock mg-rgt-5"></i>
                        <p><?=formataData($task->estimated_end_date)?> - <?=$days?> dias</p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>

        <div class="card add-task box-shadow open-task-form" data-form-type="add">
            <i class="fa-solid fa-plus fs-32"></i>
        </div>
    </div>

    <!-- Conteúdo das tarefas completas -->
    <div class="cards-container display-none" data-type="completed">
        <?php if (!empty($completed_tasks)) : ?>
            <?php foreach($completed_tasks as $task): ?>
                <div class="card box-shadow" data-id="<?=$task->id?>">
                    <i class="fa-solid fa-trash delete-task" data-id="<?=$task->id?>"></i>
                    <h3 class="mg-btm-20"><?=$task->title?></h3>
                    <div class="flex align-center finished-date">
                        <i class="fa-regular fa-clock mg-rgt-5"></i>
                        <p><?=formataData($task->end_date)?></p>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>

