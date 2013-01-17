<?php

	if (!isset($usr) || empty($usr['id']))
		header('Location: '.ABSPATH.'?sessao-expirada');

	include_once 'modules/classes/cadastro.php';
	include_once 'modules/classes/compra.php';
	include_once 'modules/classes/cupons.php';

	$msg = $msgTitle = $res = null;
	$cadastro = new Cadastro();

	$val = $cadastro->getBasicInfoById($usr['id']);
	unset($val['email']);

	/**
	 * Cadastra usuário
	 */
	if(isset($_POST['from']) && $_POST['from']=='editar-dados') {
		$val = array();
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		include_once 'atualizarCadastro.php';
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
