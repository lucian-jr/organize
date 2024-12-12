const task = {
    title: null,
    description: null,
    estimated_end_date: null
}

const openTaskForm = ({ currentTarget }) => {
    const formType = $(currentTarget).data('form-type');

    $('.shadow').fadeIn().css('display', 'flex');

    if (formType == 'add') {
        $('.toggle-title').html('Crie uma nova tarefa');
    }
}

const formFieldsValidation = (form) => {
    form.preventDefault();

    let validated = true;

    $('.field').each(function () {
        if (!$(this).val()) {
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
        const taskCard = ` 
            <div class="card">
                <i class="fa-solid fa-trash delete-task" data-id="${result.inserted_id}"></i>
                <h3 class="mg-btm-20">${task.title}</h3>
                <p class="mg-btm-20">${task.description}</p>
                <div class="flex align-center">
                    <i class="fa-solid fa-hourglass-half mg-rgt-5"></i>
                    <p>${formataData(task.estimated_end_date)}</p>
                </div>
            </div>
        `;
      
        $('.shadow').fadeOut();
        $('.cards-container[data-type="uncompleted"]').prepend(taskCard);
        $('.field').val('');
        alert(result.message);
    }

}

const removeTask = async ({ currentTarget }) => {
    const taskCard = $(currentTarget);
    const id = taskCard.data('id');

    var continuar = confirm("Você deseja realmente exluir esta tarefa?");

    if (!continuar) return;

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
                alert(result.message);
            }
        } catch (error) {
            console.error('Erro na requisição AJAX:', error);
        } finally {

        }
    } else {
        alert('Ocorreu algum problema ao tentar excluir esta tarefa! Por favor, tenta novamente.');
    }

}

const toggleTypeTask = ({ currentTarget }) => {
    const typeVal = $(currentTarget).val();

    $(`.cards-container`).hide();

    if(typeVal) {
        $(`.cards-container[data-type="${typeVal}"]`).toggle('display').css({'display' : 'flex'});
    } 
}

const resetTaskInfos = () => {
    task.title = null;
    task.description = null,
    task.estimated_end_date = null;
}

document.addEventListener('DOMContentLoaded', () => {
    $('.open-task-form').on('click', openTaskForm);

    $('.close-task-form').on('click', function () {
        $('.shadow').fadeOut();
    });

    $('#taskForm').on('submit', formFieldsValidation);
    $('.delete-task').on('click', removeTask);
    $('#cards-type').on('change', toggleTypeTask);
    
});

function formataData(data) {
    const partesData = data.split('-');
    const dataFormatada = partesData.reverse().join('/');

    return dataFormatada;
}