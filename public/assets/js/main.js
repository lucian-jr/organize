
const task = {
    title: null,
    description: null,
    completed: null,
    estimated_end_date: null,
    end_date: null
}

let form_type = 'add';
let task_id = null;

// Manipula as ações após clicar em uma tarefa
const openTaskForm = async ({ currentTarget }) => {
    const formType = $(currentTarget).attr('data-form-type');

    form_type = formType;

    if (formType == 'add') {
        task_id = null;

        $('.shadow').fadeIn().css('display', 'flex');
        $('.toggle-title').html('Crie uma nova tarefa');
        $('.edit-content').hide();
        $('#completed').addClass('hidden');
        $('.field').val('');
        $('.send-data').html('SALVAR').removeClass('disabled');


        resetTaskInfos();
    } else if (formType == 'edit') {
        const id = $(currentTarget).attr('data-id');

        task_id = id;

        $('.toggle-title').html('');
        $('#taskForm .delete-task').attr('data-id', id).show();
        $('.edit-content').show();
        $('#completed').removeClass('hidden');
        $('.send-data').html('SALVAR').addClass('disabled');

        const result = await new Promise((resolve, reject) => {
            $.ajax({
                url: `/organize/public/?controller=task&action=get&id=${id}`,
                type: 'GET',
                success: resolve,
                error: reject,
            });
        });

        if (result.status == 200) {
            const data = result.data;
            const tagColorClass = getTag(data.estimated_end_date);

            $(".registered_date").html(formataDataHora(data.registered_date_hour));
            $("#title-task").val(data.title);
            if (data.description) $("#description").val(data.description);
            $("#completed").val(data.completed);
            if (data.estimated_end_date) $("#estimated_end_date").val(data.estimated_end_date);

            $('#formTag.tag').removeClass('green orange red').addClass(tagColorClass);
            $('.shadow').fadeIn().css('display', 'flex');
        }

    }
}

// Validação dos campos do form
const formFieldsValidation = (form) => {
    form.preventDefault();

    let validated = true;

    $('.field').each(function () {
        if (!$(this).val() && !$(this).hasClass('hidden')) {
            $(this).css({ 'outline': '2px solid #b91c1c' });
            validated = false;
        } else {
            let name = $(this).prop('name');
            let val = $(this).val();

            task[name] = val;
        }
    });

    if (validated == true) {
        submitTaskForm();
    } else {
        resetTaskInfos();
    }
}

// Aplica as regras para submissão do form em modo "adicionar" e "edição"
const submitTaskForm = async () => {

    if (form_type == 'add') {
        const result = await new Promise((resolve, reject) => {
            $.ajax({
                url: '/organize/public/?controller=task&action=insert',
                type: 'POST',
                data: {
                    'title': task.title,
                    'description': task.description,
                    'estimated_end_date': task.estimated_end_date
                },
                success: resolve,
                error: reject,
            });
        });

        if (result.status == 200) {
            const tagColorClass = getTag(task.estimated_end_date);
            const daysRemaining = countDays(getCurrentDate(), task.estimated_end_date);

            const taskCard = ` 
                <div class="card box-shadow open-task-form" data-id="${result.inserted_id}" data-form-type="edit">
                    <span class="tag ${tagColorClass} box-shadow"></span>
                    <h3 class="mg-btm-20">${task.title}</h3>
                    <div class="flex align-center">
                        <i class="fa-solid fa-hourglass-half mg-rgt-5"></i>
                        <p>${formataData(task.estimated_end_date)} - ${daysRemaining} dias</p>
                    </div>
                </div>
            `;

            $('.shadow').fadeOut();
            $('.cards-container[data-type="uncompleted"]').prepend(taskCard);
            $('.field').val('');

            Swal.fire({
                title: "Sucesso!",
                text: result.message,
                icon: "success"
            });
        }
    } else {
        const result = await new Promise((resolve, reject) => {
            $.ajax({
                url: `/organize/public/?controller=task&action=update&id=${task_id}`,
                type: 'POST',
                data: {
                    'title': task.title,
                    'description': task.description,
                    'completed': task.completed,
                    'estimated_end_date': task.estimated_end_date,
                    'end_date': task.end_date
                },
                success: resolve,
                error: reject,
            });
        });

        if (result.status == 200) {
            const data = result.data;

            if (data.completed == 1) {
                const taskCard = ` 
                    <div class="card box-shadow" data-id="${task_id}">
                        <i class="fa-solid fa-trash delete-task" data-id="${task_id}"></i>
                        <h3 class="mg-btm-20">${data.title}</h3>
                        <div class="flex align-center finished-date">
                            <i class="fa-solid fa-regular fa-clock mg-rgt-5"></i>
                            <p>${formataData(data.end_date)}</p>
                        </div>
                    </div>
                `;

                $('.shadow').fadeOut();
                $(`.card[data-id="${task_id}"]`).remove();
                $(`.cards-container[data-type="completed"]`).prepend(taskCard);
            } else {
                $(`.card[data-id="${task_id}"] h3`).html(data.title);
                $(`.card[data-id="${task_id}"] p`).html(formataData(data.estimated_end_date));
            }

            Swal.fire({
                title: "Sucesso!",
                text: result.message,
                icon: "success"
            });
            resetTaskInfos();
        } else {
            Swal.fire({
                title: "Erro :(",
                text: result.message,
                icon: "error"
            });
        }
    }
}

// Remoção de uma "tarefa"
const deleteTask = async ({ currentTarget }) => {
    const taskCard = $(currentTarget);
    const id = taskCard.attr('data-id');

    Swal.fire({
        title: "Você tem certeza?",
        text: "Excluir uma tarefa é uma ação irreversível!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#dc2626",
        confirmButtonText: "Sim, excluir!",
        cancelButtonText: "Cancelar"
    }).then(async (result) => {
        if (result.isConfirmed) {
            if (id) {
                try {
                    const result = await new Promise((resolve, reject) => {
                        $.ajax({
                            url: `/organize/public/?controller=task&action=delete&id=${id}`,
                            type: 'GET',
                            dataType: 'json',
                            success: resolve,
                            error: reject,
                        });
                    });

                    if (result.status == 200) {
                        $(`.card[data-id="${id}"]`).remove();
                        $('.field').val('');
                        $('.shadow').fadeOut();

                        Swal.fire({
                            title: "Sucesso!",
                            text: result.message,
                            icon: "success"
                        });
                    } else {
                        Swal.fire({
                            title: "Erro!",
                            text: result.message,
                            icon: "error"
                        });
                    }
                } catch (error) {
                    console.error('Erro na requisição AJAX:', error);
                }
            } else {
                Swal.fire({
                    title: "Erro!",
                    text: 'Ocorreu algum problema ao tentar excluir esta tarefa! Por favor, tente novamente.',
                    icon: "error"
                });
            }
        }
    });
}

// Troca os tipos de "tarefas" de acordo com o selecionado
const toggleTypeTask = ({ currentTarget }) => {
    const typeVal = $(currentTarget).val();

    $(`.cards-container`).hide();

    if (typeVal) {
        $(`.cards-container[data-type="${typeVal}"]`).toggle('display').css({ 'display': 'flex' });
    }
}

// Desabilita o botão de submit no form de edição de "tarefa"
const toggleSubmitButton = () => {
    if (form_type == 'edit') {
        $('.send-data').removeClass('disabled');
    }
}

// Remove o outline dos inputs com alerta de "vazios"
const removeRedOutline = ({currentTarget}) => {
    $(currentTarget).css({'outline' : 'none'})
}

// Carrega o conteudo da DOM
document.addEventListener('DOMContentLoaded', () => {
    // Chamando as funções acima de acordo com cada ação
    $('body').on('click', '.close-task-form', function () {
        $('.shadow').fadeOut();
    });
    $('body').on('click', '.open-task-form', openTaskForm);
    $('body').on('click', '.delete-task', deleteTask);
    $('#taskForm').on('submit', formFieldsValidation);
    $('#cards-type').on('change', toggleTypeTask);
    $('.field').on('change', toggleSubmitButton);
    $('.field').on('click', removeRedOutline);
});

// Reseta as informações da "tarefa"
function resetTaskInfos() {
    task_id = null;
    task.title = null;
    task.description = null,
    task.completed = null;
    task.estimated_end_date = null;
    task.end_date = null;
}