<?php

	if (in_array($basename, array('registrar', 'login')) && (isset($usr) && !empty($usr['id'])))
		header('Location: '.ABSPATH.'painel');

	include_once 'modules/classes/compra.php';

	$msg = $msgTitle = $res = null;
	$compra = new Compra();
	$val = array();


	if(isset($_POST['from'])) {
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);
	}

	/**
	 * Cadastra usuário
	 */
	if ($basename=='novo-produto') {
		if(isset($val['from']) && $val['from']=='novo-produto')
			include_once 'novo-produto/exec.php';
	}

	/**
	 * Meus dados //edicao de usuário
	 */
	if ($basename=='editar-produto') {
		if(isset($val['from']) && $val['from']=='editar-produto')
			include_once 'editar-produto/exec.php';
		else
			$val = $compra->getInfoById($querystring);
	}

	/**
	 * Lista de produtos
	 */
	if ($basename=='lista') {
		$filtroPost = array();

		if (isset($_POST['from']) && $_POST['from']=='filtrar')
			$filtroPost = $_POST;

		foreach ($urlParams as $params) {
			list($filtroName, $valParam) = explode('-', $params);
			if (isset($catIdByTituloMin[$valParam]))
				$breadcrumb[$filtroName] = getCategoriaCol('titulo', 'id', $catIdByTituloMin[$valParam]);
		}

		$filtro = $compra->filtroCategorias($filtroPost);
		$listaGeral = $compra->listaGeral($filtroPost);
	}


	/**
	 * Lista de produtos
	 */
	if ($basename=='lista-por-interesse') {
		include_once 'modules/classes/interesse.php';
		$interesse = new Interesse();
		$filtroPost = array();

		if (isset($_POST['from']) && $_POST['from']=='filtrar')
			$filtroPost = $_POST;

		foreach ($urlParams as $params) {
			list($filtroName, $valParam) = explode('-', $params);
			if (isset($catIdByTituloMin[$valParam]))
				$breadcrumb[$filtroName] = getCategoriaCol('titulo', 'id', $catIdByTituloMin[$valParam]);
		}

		$listaGeral = $interesse->listaPessoalByInteresse($filtroPost);
		$filtro = $interesse->filtroCategorias($filtroPost);
	}


	/**
	 * Lista geral de interesses
	 */
	if ($basename=='lista-geral-de-interesses') {
		include_once 'modules/classes/interesse.php';
		$interesse = new Interesse();
		$filtroPost = array();

		if (isset($_POST['from']) && $_POST['from']=='filtrar')
			$filtroPost = $_POST;

		foreach ($urlParams as $params) {
			list($filtroName, $valParam) = explode('-', $params);
			if (isset($catIdByTituloMin[$valParam]))
				$breadcrumb[$filtroName] = getCategoriaCol('titulo', 'id', $catIdByTituloMin[$valParam]);
		}

		$listaGeral = $interesse->listaGeralByInteresse($filtroPost);
		$filtro = $interesse->filtroGeralCategorias($filtroPost);
	}

	/**
	 * Detalhes do produto
	 */
	if ($basename=='ver') {
		include_once 'ver/header.php';
		$incjQuery .= "
			$('#myTab a').click(function (e) {
			  e.preventDefault();
			  $(this).tab('show');
			});";
	}


$incjQuery .= "
	$('#datavalidade').datepicker({
		inline: true,
		nextText: '&rarr;',
		prevText: '&larr;',
		showOtherMonths: true,
		dateFormat: 'dd/mm/yy',
		dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sat'],
		monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		showOn: 'button',
		buttonImage: '".STATIC_PATH."calendar.png',
		buttonImageOnly: true,
	});
	$('#datapagamento').datepicker({
		inline: true,
		nextText: '&rarr;',
		prevText: '&larr;',
		showOtherMonths: true,
		dateFormat: 'dd/mm/yy',
		dayNamesMin: ['Dom', 'Seg', 'Ter', 'Qua', 'Qui', 'Sex', 'Sat'],
		monthNames: ['Janeiro', 'Fevereiro', 'Março', 'Abril', 'Maio', 'Junho', 'Julho', 'Agosto', 'Setembro', 'Outubro', 'Novembro', 'Dezembro'],
		showOn: 'button',
		buttonImage: '".STATIC_PATH."calendar.png',
		buttonImageOnly: true,
	});
";