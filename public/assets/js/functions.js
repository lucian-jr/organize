// Funções de ajuda

// Formata Data para o padrão BR
function formataData(data) {
    const partesData = data.split('-');
    const dataFormatada = partesData.reverse().join('/');

    return dataFormatada;
}


// Formata Data e Hora para o padrão BR
function formataDataHora(dataHora) {
    const data = new Date(dataHora);

    const dia = String(data.getDate()).padStart(2, '0');
    const mes = String(data.getMonth() + 1).padStart(2, '0');
    const ano = data.getFullYear();

    const horas = String(data.getHours()).padStart(2, '0');
    const minutos = String(data.getMinutes()).padStart(2, '0');

    return `${dia}/${mes}/${ano} ${horas}:${minutos}`;
}

// Pega data atual
function getCurrentDate() {
    const today = new Date();
    const year = today.getFullYear();
    const month = String(today.getMonth() + 1).padStart(2, '0');
    const day = String(today.getDate()).padStart(2, '0');
    const currentDate = `${year}-${month}-${day}`;

    return currentDate;
}

// Conta dias entre duas datas
function countDays(initDate, endDate) {
    const dataInicial = new Date(initDate);
    const dataFinal = new Date(endDate);

    const diferencaEmMilissegundos = Math.abs(dataFinal - dataInicial);

    return Math.floor(diferencaEmMilissegundos / (1000 * 60 * 60 * 24));
}

// Define a cor da tag da tarefa
function getTag(estimated_end_date) {
    const days = countDays(getCurrentDate(), estimated_end_date);
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