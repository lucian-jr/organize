const togglePopUp = (type) => {
    if(type == 'open') $('.shadow').fadeIn().css('display', 'flex');
    else $('.shadow').fadeOut();
}

const submitTaskForm = ( form ) => {
    form.preventDefault();

    console.log(form);
}

document.addEventListener('DOMContentLoaded', () => {
    $('.open-task-form').on('click', function() {
        togglePopUp('open');
    });

    $('.close-task-form').on('click', function() {
        togglePopUp('close');
    });

    $('#taskForm').on('submit', submitTaskForm);
});