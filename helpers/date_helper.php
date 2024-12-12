<?php

    function formataData($data) {
        return implode('/', array_reverse(explode("-",$data)));
    }

	function formataDataHora ($dataHora) {
		$dataFormatada = date("d/m/Y H:i", strtotime($dataHora));

		return $dataFormatada;
	}

	function countDays($init_date, $end_date) {
		$dataInicial = new DateTime($init_date);
		$dataFinal = new DateTime($end_date);

		$diferenca = $dataInicial->diff($dataFinal);
		
		return $diferenca->days;
	}	
    
