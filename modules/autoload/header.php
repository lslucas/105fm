<?php

	if(isset($_POST)) {
		foreach ($_POST as $key=>$value)
			if (!is_array($value))
				$val[$key] = trim($value);
	}

	$areasRestrita = array('lista', 'lista-por-interesse', 'lista-geral-de-interesses', 'painel', 'ver', 'interesse', 'remover-produto', 'editar-produto', 'novo-produto', 'meus-dados');
	if (empty($usr['id']) && isset($basename) && in_array($basename, $areasRestrita))
		header('Location: '.ABSPATH.'?acesso-restrito');


	/**
	 * Faz login
	 */
	if (isset($val['from']) && $val['from']=='login') {
		include_once 'modules/classes/usuario.php';
		$msg = $msgTitle = $res = null;
		$usuario = new Usuario();

		include_once 'modules/usuario/login/header.php';
	}

	/**
	 * Quantos produtos em interesse existem
	 */
	if (!empty($usr['id'])) {
		include_once 'modules/classes/interesse.php';
		$interesse = new Interesse;
		$produtosEmInteresse = $interesse->exitemProdutosEmInteresse();

		$textoProdutosEmInteresse = null;
		if ($produtosEmInteresse==1)
			$textoProdutosEmInteresse = "Existe <b>uma oferta</b> de seu <a href='".ABSPATH."lista-por-interesse' style='text-decoration:underline'>interesse</a>";
		elseif ($produtosEmInteresse>1)
			$textoProdutosEmInteresse = "Existem <b>{$produtosEmInteresse} ofertas</b> de seu <a href='".ABSPATH."lista-por-interesse' style='text-decoration:underline'>interesse</a>";
	}



	/**
	 * Retorna clima
	 */
	include_once 'modules/classes/utils.php';
	$utils = new Utils;

	if (!empty($usr['id'])) {
		if (!empty($usr['cidade']) && !empty($usr['uf']))
			$argsClima = array('cidade'=>$usr['cidade'], 'uf'=>$usr['uf']);
		elseif (empty($usr['cidade']) && !empty($usr['uf']))
			$argsClima = array('uf'=>$usr['uf']);
	}

	if (empty($usr['id']) || !isset($argsClima))
		$argsClima = array('cidade'=>'São Paulo', 'uf'=>'SP');

	$clima = $utils->climaByCityState($argsClima);



	/*
	 *Lista noticias
	 */
	$listNoticias = array();
	$sqlnot =  "SELECT
					not_id,
					not_titulo,
					DATE_FORMAT(not_data, '%d/%m/%Y') `data`
				FROM ".TP."_noticia
				WHERE not_status=1
				AND not_data<=DATE(NOW())
				ORDER BY not_data DESC
				LIMIT 4
			";
	 if (!$qrynot=$conn->prepare($sqlnot))
		 echo "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qrynot->bind_result($id, $titulo, $data);
		$qrynot->execute();
		$total = $qrynot->num_rows;

		$i=0;
		while ($qrynot->fetch()) {
			$hash = $hashids->encrypt($id);
			$listNoticias[$i]['titulo'] = $data.' - '.$titulo;
			$listNoticias[$i]['data'] = $data;
			$listNoticias[$i]['link']  = ABSPATH.'noticia/'.$hash.'/'.linkfySmart($titulo);
			$i++;
		}

		$qrynot->close();

	}


	include_once 'modules/classes/usuario.php';

	$val = array();
	if (isset($_POST['form']) && $_POST['form']=='login')
		include_once '../usuario/login/header.php';

	if (isset($_POST['form']) && $_POST['form']=='contato-vendedor')
		include_once 'modules/produto/ver/contato-vendedor.php';

	if (isset($_POST['form']) && $_POST['form']=='contato-anuncio-vendedor')
		include_once 'modules/anuncio/ver/contato-vendedor.php';

	/*
	 *QUERY DE BANNERS
	 */
	$banners = array();
	$sqlban =  "
		SELECT
			ban_id,
			ban_code,
			ban_area,
			ban_titulo,
			ban_imagem,
			ban_url,
			ban_type

			FROM ".TP."_banner
				WHERE 1
					AND ban_date_from<=DATE(NOW())
					AND (ban_date_to>=DATE(NOW()) OR ban_date_to='' OR ban_date_to IS NULL)
					AND ban_status=1
			ORDER BY ban_area, RAND()
			";
	 if (!$qryban=$conn->prepare($sqlban))
		 $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qryban->bind_result(
		 $id,
		 $code,
		 $area,
		 $titulo,
		 $imagem,
		 $url,
		 $type
		);
		$qryban->execute();

		while ($qryban->fetch()) {
			if (!isset($banners[$area]))
				$i=0;
			$banners[$area][$i]['id'] = $id;
			$banners[$area][$i]['code'] = $code;
			$banners[$area][$i]['titulo'] = $titulo;
			$banners[$area][$i]['type'] = $type;
			$banners[$area][$i]['link'] = !empty($url) ? $rph.'l/'.$code : null;
			$banners[$area][$i]['imagem'] = STATIC_PATH."banner/{$imagem}";
			$i++;
		}

		$qryban->close();

	 }

