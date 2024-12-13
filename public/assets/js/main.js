
const task = {
    title: null,
    description: null,
    completed: null,
    estimated_end_date: null,
    end_date: null
}

let form_type = 'add';
let task_id = null;

const openTaskForm = async ({ currentTarget }) => {
    const formType = $(currentTarget).attr('data-form-type');

    form_type = formType;

    if (formType == 'add') {
        task_id = null;

        $('.shadow').fadeIn().css('display', 'flex');
        $('.toggle-title').html('Crie uma nova tarefa');
        $('#taskForm .delete-task').hide();
        $('#formTag').hide();
        $('#completed').addClass('hidden');
        $('.field').val('');
        $('.send-data').html('SALVAR').removeClass('disabled');


        resetTaskInfos();
    } else if (formType == 'edit') {
        const id = $(currentTarget).attr('data-id');

        task_id = id;

        $('.toggle-title').html('');
        $('#taskForm .delete-task').attr('data-id', id).show();
        $('#formTag').show();
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

            $("#title-task").val(data.title);
            if (data.description) $("#description").val(data.description);
            $("#completed").val(data.completed);
            if (data.estimated_end_date) $("#estimated_end_date").val(data.estimated_end_date);

            $('#formTag.tag').removeClass('green yellow red').addClass(tagColorClass);
            $('.shadow').fadeIn().css('display', 'flex');
        }

    }
}

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

            const taskCard = ` 
                <div class="card box-shadow open-task-form" data-id="${result.inserted_id}" data-form-type="edit">
                    <span class="tag ${tagColorClass} box-shadow"></span>
                    <h3 class="mg-btm-20">${task.title}</h3>
                    <div class="flex align-center">
                        <i class="fa-solid fa-hourglass-half mg-rgt-5"></i>
                        <p>${formataData(task.estimated_end_date)}</p>
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
                        <h3 class="mg-btm-20">${data.title}</h3>
                        <div class="flex align-center">
                            <i class="fa-solid fa-trash delete-task" data-id="${task_id}"></i>
                            <i class="fa-solid fa-hourglass-end mg-rgt-5"></i>
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

const toggleTypeTask = ({ currentTarget }) => {
    const typeVal = $(currentTarget).val();

    $(`.cards-container`).hide();

    if (typeVal) {
        $(`.cards-container[data-type="${typeVal}"]`).toggle('display').css({ 'display': 'flex' });
    }
}

const toggleSubmitButton = () => {
    if (form_type == 'edit') {
        $('.send-data').removeClass('disabled');
    }
}

document.addEventListener('DOMContentLoaded', () => {
    $('body').on('click', '.open-task-form', openTaskForm);

    $('body').on('click', '.close-task-form', function () {
        $('.shadow').fadeOut();
    });

    $('#taskForm').on('submit', formFieldsValidation);
    $('.field').on('change', toggleSubmitButton);
    $('body').on('click', '.delete-task', deleteTask);
    $('#cards-type').on('change', toggleTypeTask);
});