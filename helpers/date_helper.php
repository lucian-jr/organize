<?php

    function formataData($data) {
        return implode('/', array_reverse(explode("-",$data)));
    }

	function formataDataHora ($dataHora)	{
		$dataFormatada = date("d/m/Y H:i", strtotime($dataHora));

		return $dataFormatada;
	}
    
