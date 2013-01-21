<?php
	$cpr = $pro = $vend = array();
	$validaCompra = $compra->compraExiste($querystring);
	if ($validaCompra) {

		include_once 'modules/classes/produto.php';
		include_once 'modules/classes/usuario.php';
		$produto = new Produto();
		$usuario = new Usuario();

		$cpr = $compra->getInfoById($querystring);
		$pro = $produto->getInfoById($cpr['pro_id']);
		$vend = $usuario->getBasicInfoById($cpr['usr_id']);

	} else
		$toScript = showModal(array('title'=>'Produto inválido', 'content'=>'Produto inválido ou não existe mais!'));
