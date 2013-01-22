<?php
$msg = $administrador_email_header;
if ($act=='insert') {
    $email_subject = SITE_NAME.": Seus dados de acesso";
    $msg .= "
	     Olá ".$res['nome'].", abaixo seus dados de acesso ao ".SITE_NAME.":
	     <p><b>Login:</b> ".$res['email']."
	     <br><b>Senha:</b> <code>".$res['senha']."</code>
	     <br><b>Painel:</b> <a href='".SITE_URL."login' target='_blank'>".SITE_URL."login</a>

	     <p>Você pode alterar sua senha a qualquer hora!</p>";

} elseif ($act=='update') {
    $email_subject = utf8_encode(SITE_NAME.": Informações de conta alterada");
    $msg .= "
	     Olá ".$res['nome'].", abaixo seus dados de acesso ao ".SITE_NAME.":
	     <p><b>Login:</b> ".$res['email']."
	     <br><b>Senha:</b> ".(empty($res['senha']) ? 'continua a mesma!' : '<code>'.$res['senha'].'</code>')."
	     <br><b>Painel:</b> <a href='".SITE_URL."login' target='_blank'>".SITE_URL."login</a>

	     <p>Você pode alterar sua senha a qualquer hora!</p>";

}
$msg .= $administrador_email_footer;


		/*
		 *vars to send a email
		 */
		$htmlMensage= utf8_decode($msg);
		$subject	= utf8_decode($email_subject);
		$fromEmail	= EMAIL;
		$fromName	= utf8_decode(SITE_NAME);
		$toName		= utf8_decode($res['nome']);
		$toEmail	= $res['email'];

		include_once 'inc.sendmail.header.php';

		if (!$sended)
			echo '<div class="alert alert-warning">Houve um <b>erro</b> ao enviar o email para '.$toEmail.', envie manualmente, depois entre em contato com o <a href="mailto:'.ADM_EMAIL.'">desenvolvedor</a>.</div>';
