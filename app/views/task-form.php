<div class="shadow">
    <section class="pop-up-content">
        <span id="formTag" class="tag box-shadow"></span>

        <form id="taskForm">
            <i class="fa-solid fa-x close-task-form"></i>
            <i class="fa-solid fa-trash delete-task" data-id=""></i>

            <hgroup class="flex align-center mg-btm-30">
                <h2 class="toggle-title"></h2>
            </hgroup>

            <div class="header flex align-center mg-btm-30">
                <input type="text" name="title" id="title-task" class="width-100 fs-18 field" placeholder="TÍTULO DA TAREFA">
                <select class="field mg-lft-10" name="completed" id="completed">
                    <option value="0">Em andamento</option>
                    <option value="1">Concluído</option>
                </select>
            </div>

            <div class="body mg-btm-30">
                <div class="flex align-center mg-btm-10">
                    <div>
                        <i class="fa-solid fa-list-ul"></i>
                    </div>

                    <hgroup class="mg-lft-10">
                        <h3>Descrição</h3>
                    </hgroup>
                </div>
             
                <div class="flex mg-lft-25">
                    <textarea name="description" id="description" class="width-100 field" rows="10"></textarea>
                </div>
            </div>

            <div class="footer mg-btm-30">
                <div class="flex align-center mg-btm-10">
                    <div>
                        <i class="fa-solid fa-hourglass-end"></i>
                    </div>

                    <hgroup class="mg-lft-10">
                        <h3>Data de finalização</h3>
                    </hgroup>
                </div>

                <div class="flex mg-lft-25">
                    <input id="estimated_end_date" name="estimated_end_date" type="date" class="field">
                </div>
            </div>

            <div class="mg-lft-25">
                <button type="submit" class="send-data"></button>
            </div>
        </form>
    </section>
</div>