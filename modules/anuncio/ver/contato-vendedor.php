<?php
	include_once 'modules/classes/mail.php';

	$msg = $msgTitle = $res = $error = null;
	$val = array();

	/**
	 * Envia email
	 */
	foreach ($_POST as $key=>$value)
		$val[$key] = trim($value);

	if (empty($val['email']) || !validaEmail($val['email']))
		$error .= "<li>Preencha um email válido!</li>";
	if (empty($val['mensagem']))
		$error .= "<li>Escreva sua mensagem!</li>";

	if (empty($error)) {
		$args = array(
	            'fromName'=>$usr['nome_fantasia'].' - '.$usr['nome'],
	            'fromEmail'=>$val['email'],
	            'toName'=>$val['contatoVendedor'],
	            'toEmail'=>$val['emailVendedor'],
	            'assunto'=>'Contato sobre '.$val['produto'],
	            'produto'=>$val['produto'],
	            'mensagem'=>$val['mensagem'],
	          );
		$mail = new Mail();

		if ($mail->contatoVendedor($args))
			$toScript = showModal(array('title'=>null, 'content'=>'Mensagem enviada!'));
	}

	/**
	 * Trata mensagens de erro
	 */
	if (!empty($error)) {
		$msgTitle = 'Erro';
		// $msg = '<p>Você deve corrigir os seguintes erros antes de continuar:';
		$msg .= "<div class='alert alert-error'>";
		$msg .= "<ul class='erro'>";
		$msg .= $error;
		$msg .= '</ul>';
		$msg .= '</div>';
		// $msg .= '</p>';
	}

	if (!empty($msg))
		$toScript = showModal(array('title'=>$msgTitle, 'content'=>$msg));