<?php
	if (!isset($usr) || empty($usr['id']))
		header('Location: '.ABSPATH);

	include_once 'modules/classes/compra.php';

	$msg = $msgTitle = $res = null;
	$compra = new Compra();
	$myProducts = $compra->getMyProducts($usr['id']);
