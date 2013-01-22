<?php
$msg = $administrador_email_header;
  if ($act=='insert') {
    $email_subject = SITE_NAME.": Seus dados de acesso";
    $msg .= "
	     <!--<center><img src='".URL_ADMLOGO."'></center><p />-->
	     Olá ".$res['nome'].", abaixo seus dados de acesso ao ".SITE_NAME.":

	     <p><b>Login:</b> ".$res['email']."
	     <br><b>Senha:</b> ".$res['senha']."
	     <br><b>Painel:</b> <a href='".PAINEL_URL."' target='_blank'>".PAINEL_URL."</a>

	     <p>Você pode alterar sua senha a qualquer hora!</p>";

   } elseif ($act=='update') {
    $email_subject = SITE_NAME.": Informações de conta alterada";
    $msg .= "
	     <!--<center><img src='".URL_ADMLOGO."'></center><p />-->
	     Olá ".$res['nome'].", seus dados de acesso foram alterados:

	     <p><b>Login:</b> ".$res['email']."
	     <br><b>Senha:</b> ainda a mesma!
	     <br><b>Panel:</b> <a href='".PAINEL_URL."' target='_blank'>".PAINEL_URL."</a>
	    ";

   } else {
    $email_subject = SITE_NAME.": Senha alterada";
    $msg .= "
	     <!--<center><img src='".URL_ADMLOGO."'></center><p />-->
	     Olá ".$res['nome'].", sua senha foi alterada!

	     <p><b>Login:</b> ".$res['email']."
	     <br><b>Senha:</b> ".$res['senha']."
	     <br><b>Painel:</b> <a href='".PAINEL_URL."' target='_blank'>".PAINEL_URL."</a>
	    ";
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
