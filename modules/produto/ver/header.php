<?php
	if ($compra->compraExiste($querystring)) {

		include_once 'modules/classes/produto.php';
		include_once 'modules/classes/usuario.php';
		$produto = new Produto();
		$usuario = new Usuario();

		$cpr = $compra->getInfoById($querystring);
		$pro = $produto->getInfoById($cpr['pro_id']);
		$vend = $usuario->getBasicInfoById($cpr['usr_id']);
	}
