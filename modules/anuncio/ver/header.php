<?php
	$cpr = $pro = $vend = array();
	$validaclassificado = $classificado->classificadoExiste($querystring);
	if ($validaclassificado) {

		include_once 'modules/classes/produto.php';
		include_once 'modules/classes/usuario.php';
		$produto = new Produto();
		$usuario = new Usuario();

		$cpr = $classificado->getInfoById($querystring);
		$classificado->plusView($cpr['id']);
		$pro = $produto->getInfoById($cpr['pro_id']);
		$vend = $usuario->getBasicInfoById($cpr['usr_id']);

	} else
		$toScript = showModal(array('title'=>'Produto inválido', 'content'=>'Produto inválido ou não existe mais!'));

$incjQuery .= "
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});";