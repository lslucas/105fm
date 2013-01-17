<?php

	if (!isset($usr) || empty($usr['id'])) {
		header('Location: '.ABSPATH.'?sessao-expirada');

	} else {

	include_once 'modules/classes/compra.php';
	include_once 'modules/classes/cupons.php';
	include_once 'modules/classes/mail.php';

	$cupom = new GeraCupons();

	$res = null;
	$error = null;
	$alert = null;

	/**
	 * Cadastra usuário
	 */
	if(isset($_POST['from']) && $_POST['from']=='meus-numeros') {

		$val = array();
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);


		/**
		 * Cadastra compra
		 */
		$val['cad_id'] = $hashids->decrypt($usr['id']);
		$val['cad_id'] = $val['cad_id'][0];

		$compra = new Compra();
		$res = $compra->novaCompra($val);

		/**
		 * Se cadastrou compra com sucesso, gera cupom
		 */
		if (isset($res['success'])) {
			$val['cpr_id'] = $res['cols']['id'];

			$res = $cupom->novoCupom($val['cad_id'], $val['cpr_id']);

			$args = array(
		              'nome'=>$usr['nome'],
		              'email'=>$usr['email'],
		              'coo'=>$val['coo'],
		              'cupom'=>$res,
	              );
			$mail = new Mail();
			$mail->novoCupom($args);
		}

		/**
		 * Se cupom foi gerado entra
		 */
		if (!isset($res['error']) && !isset($res['alert'])) {
			header('Location: '.ABSPATH.'cadastro-cupom-enviado');
		} /*else
			$toScript = showModal(array('title'=>'', 'content'=>"Houve um problema na tentativa de cadastrar o cupom {$val['notafiscal']}"));*/
	}

	/**
	 * Trata mensagens de erro
	 */
	if (isset($res['error'])) {
		$error .= '<p>Você deve corrigir os seguintes erros antes de continuar:';
		$error .= "<div class='alert alert-error'>";
		$error .= "<ul class='error'>";
		$error .= $res['error'];
		$error .= '</ul>';
		$error .= '</div>';
		$error .= '</p>';
	}

	/**
	 * Trata mensagens de alerta
	 */
	if (isset($res['alert'])) {
		$error .= "<div class='alert'>";
		$error .= $res['alert'];
		$error .= '</div>';
	}

	if (!empty($error))
		$toScript = showModal(array('title'=>'Erro', 'content'=>$error));

	$incjQuery .= "
		$('.produtoList').slideUp();
		$('select[name=\"produto_cat\"]').change(function(){
			var catid = $(this).val();

			$('.produtoList').slideUp();
			$('select#'+catid).removeAttr('disabled').slideDown();
		});

		var catid = $('select[name=\"produto_cat\"]').val();
		if (catid!='')
			$('select#'+catid).removeAttr('disabled').slideDown();
	";
}