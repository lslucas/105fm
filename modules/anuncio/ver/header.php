<?php
	$ucl = $vend = array();
	$validaclassificado = $classificado->existe($querystring);
	if ($validaclassificado) {

		include_once 'modules/classes/produto.php';
		include_once 'modules/classes/usuario.php';
		$produto = new Produto();
		$usuario = new Usuario();

		$ucl = $classificado->getInfoById($querystring);
		$classificado->plusView($ucl['id']);
		$vend = $usuario->getBasicInfoById($ucl['usr_id']);

	} else
		$toScript = showModal(array('title'=>'Produto inválido', 'content'=>'Produto inválido ou não existe mais!'));

$incjQuery .= "
$('#myTab a').click(function (e) {
  e.preventDefault();
  $(this).tab('show');
});


$('.produtoImagemThumb').click(function() {
	var image = $(this).attr('rel');

	if (image!=$('#imagemGrande').attr('src')) {
		$('#imagemGrande').hide();
		$('#imagemGrande').fadeIn('slow');
		$('#imagemGrande').attr('src', image);
	}

	return false;
});
";