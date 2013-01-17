<?php
	include_once 'modules/classes/mail.php';

	$msg = $msgTitle = $res = $error = null;
	$val = array();

	/**
	 * Envia email
	 */
	if(isset($_POST['from']) && $_POST['from']=='fale-conosco') {

		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		if (empty($val['nome']))
			$error .= "<li>Preencha seu nome</li>";
		if (empty($val['email']) || !validaEmail($val['email']))
			$error .= "<li>Preencha um email válido!</li>";
		if (empty($val['assunto']))
			$error .= "<li>Selecione um assunto primeiro, se não tem certeza selecione Outro</li>";
		if (empty($val['mensagem']))
			$error .= "<li>Escreva sua mensagem!</li>";

		if (empty($error)) {
			$args = array(
		            'fromName'=>$val['nome'],
		            'fromEmail'=>$val['email'],
		            'assunto'=>$val['assunto'],
		            'mensagem'=>$val['mensagem'],
		          );
			$mail = new Mail();

			if ($mail->faleConosco($args))
				header('Location: '.ABSPATH.'fale-conosco-enviado');
		}
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