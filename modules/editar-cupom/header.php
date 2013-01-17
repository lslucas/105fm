<?php

	if (!isset($usr) || empty($usr['id']))
		header('Location: '.ABSPATH.'?sessao-expirada');

	include_once 'modules/classes/compra.php';

	$msg = $msgTitle = $res = null;
	$compra = new Compra();
	$val = array();

	$val = $compra->getInfoById($querystring); //resgata id criptografado da compra

	/**
	 * Atualiza Compra
	 */
	if(isset($_POST['from']) && $_POST['from']=='editar-cupom') {
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		$val['cad_id'] = $hashids->decrypt($usr['id']);
		$val['cad_id'] = $val['cad_id'][0];
		include_once 'atualizarCompra.php';
	}


	/**
	 * Trata mensagens de erro
	 */
	if (isset($res['error'])) {
		$msgTitle = 'Erro';
		// $msg = '<p>Você deve corrigir os seguintes erros antes de continuar:';
		$msg .= "<div class='alert alert-error'>";
		$msg .= "<ul class='erro'>";
		$msg .= $res['error'];
		$msg .= '</ul>';
		$msg .= '</div>';
		// $msg .= '</p>';
	}

	/**
	 * Trata mensagens de alerta
	 */
	if (isset($res['alert'])) {
		$msg = "<div class='alert'>";
		$msg .= $res['alert'];
		$msg .= '</div>';
	}

	if (!empty($msg))
		$toScript = showModal(array('title'=>$msgTitle, 'content'=>$msg));

	$incjQuery .= "
		$('.produtosList').slideUp();
		$('select[name=\"produto_cat\"]').change(function(){
			var catid = $(this).val();

			$('.produtosList').attr('disabled', 'disabled').slideUp();
			$('select#'+catid).removeAttr('disabled').show().slideDown();
		});

		$('.produtosList').attr('disabled', 'disabled').removeClass('hide').slideUp();
		var catid = $('select[name=\"produto_cat\"]').val();
		if (catid!='') {
			$('select#'+catid).removeAttr('disabled').removeClass('hide').slideDown();
		}

	";
