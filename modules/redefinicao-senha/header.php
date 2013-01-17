<?php

	include_once 'modules/classes/cadastro.php';

	$msg = $msgTitle = $res = null;
	$cadastro = new Cadastro();
	$val = $res = array();

	if (empty($querystring) || !$cadastro->validaToken($querystring))
		$toScript = showModal(array('title'=>'Token Expirado', 'content'=>'Desculpe-nos, seu token é inválido ou já expirou!'));

	/**
	 * Cadastra usuário
	 */
	if(isset($_POST['from']) && $_POST['from']=='redefinicao-senha') {

		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		$res['error'] = null;
		if (empty($val['senha']) || strlen($val['senha'])<6)
			$res['error'] .= '<li>Entre com uma senha válida com 6 caracteres ou mais! Sua senha possui '.strlen($args['senha']).' caracteres</li>';
		if (!empty($val['senha']) && $val['senha']<>$val['confirmaSenha'])
			$res['error'] .= '<li>Confirmação de senha Inválida</li>';

		if (!isset($res['error']))
			if ($cadastro->mudarSenha($querystring, $val['senha']))
				header('Location: '.ABSPATH.'redefinicao-senha-enviado');

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

	if (!empty($msg))
		$toScript = showModal(array('title'=>$msgTitle, 'content'=>$msg));