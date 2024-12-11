<section class="page-content">
    <div class="cards-container">
        <?php if (!empty($tasks)) : ; ?>
            <?php foreach($tasks as $task): ?>
                <div class="card box-shadow">
                    <h3 class="mg-btm-20"><?=$task['title']?></h3>
                    <p class="mg-btm-20"><?=$task['description']?></p>
                    <p><?=formataDataHora($task['estimated_end_date_hour'])?></p>
                    <p><?=formataDataHora($task['end_date_hour'])?></p>
                </div>
            <?php endforeach; ?>
        <?php endif; ?>
    </div>
</section>