<?php

	if (in_array($basename, array('registrar', 'login')) && (isset($usr) && !empty($usr['id'])))
		header('Location: '.ABSPATH.'painel');

	include_once 'modules/classes/interesse.php';

	$msg = $msgTitle = $res = null;
	$interesse = new Interesse();
	$val = array();


	if(isset($_POST['from'])) {
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);
	}

	/**
	 * Cadastra Interesse
	 */
	if ($basename=='interesse') {
		if(isset($val['from']) && $val['from']=='interesse')
			include_once 'interesse/exec.php';

		/**
		 * Lista de produtos
		 */
		$listaInteresses = array();
		if (isset($usr['id']))
			$listaInteresses = $interesse->getMyInsterests($usr['id']);
	}
