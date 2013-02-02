<?php

	include_once 'modules/classes/classificado.php';

	$msg = $msgTitle = $res = null;
	$classificado = new Classificado();
	$val = array();


	if(isset($_POST['from'])) {
		foreach ($_POST as $key=>$value)
			if (!is_array($value))
				$val[$key] = trim($value);
	}

	/**
	 * Cadastra anuncio
	 */
	if ($basename=='anuncio' && empty($querystring))
		include_once 'novo/exec.php';

	/**
	 * edicao
	*/
	if ($basename=='anuncio' && !empty($querystring))
		include_once 'editar/exec.php';

	/**
	 * Lista de anuncios
	 */
	if ($basename=='lista-ofertas')
		include_once 'ver/lista.php';


	/**
	 * Detalhes do anuncio
	 */
	if ($basename=='ver-oferta')
		include_once 'ver/header.php';

