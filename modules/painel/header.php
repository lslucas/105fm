<?php
	if (!isset($usr) || empty($usr['id']))
		header('Location: '.ABSPATH);

	include_once 'modules/classes/compra.php';
	include_once 'modules/classes/classificado.php';

	$msg = $msgTitle = $res = null;

	$compra = new Compra();
	$myProducts = $compra->getMyProducts($usr['id']);

	$classificado = new Classificado();
	$myAnuncios = $classificado->getMyItens($usr['id']);

$incjQuery .= "
$('#myTab a').click(function (e) {
	e.preventDefault();
	$(this).tab('show');
});";