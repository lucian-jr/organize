function resetTaskInfos() {
    task_id = null;
    task.title = null;
    task.description = null,
        task.completed = null;
    task.estimated_end_date = null;
    task.end_date = null;
}

function formataData(data) {
    const partesData = data.split('-');
    const dataFormatada = partesData.reverse().join('/');

    return dataFormatada;
}

function countDays(initDate, endDate) {
    const dataInicial = new Date(initDate);
    const dataFinal = new Date(endDate);

    const diferencaEmMilissegundos = Math.abs(dataFinal - dataInicial);

    return Math.floor(diferencaEmMilissegundos / (1000 * 60 * 60 * 24));
}

function getTag(estimated_end_date) {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0'); // `getMonth` retorna 0 para janeiro
    const day = String(today.getDate()).padStart(2, '0');

    const currentData = `${year}-${month}-${day}`;
    const days = countDays(currentData, estimated_end_date);
    let cardTagColor = '';

    if (days > 5) {
        cardTagColor = 'green';
    } else if (days >= 3 && days <= 5) {
        cardTagColor = 'orange';
    } else {
        cardTagColor = 'red';
    }

    return cardTagColor;
}