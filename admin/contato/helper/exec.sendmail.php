<?php
$msg = $administrador_email_header;
    $email_subject = SITE_NAME.": Resposta de seu contato feito a ".$assunto;
    $msg .= "
         Olá ".$res['nome'].", segue sua resposta ao contato enviado em {$assunto}:
         <hr/>".$res['texto']."";
$msg .= $administrador_email_footer;


        /*
         *vars to send a email
         */
        $htmlMensage= $msg;
        // $htmlMensage= utf8_decode($msg);
        $subject    = $email_subject;
        $fromEmail  = EMAIL;
        $fromName   = utf8_decode(SITE_NAME);
        $toName     = utf8_decode($res['nome']);
        $toEmail    = $res['email'];

        include_once 'inc.sendmail.header.php';

        if (!$sended)
            echo '<div class="alert alert-warning">Houve um <b>erro</b> ao enviar o email para '.$toEmail.', envie manualmente, depois entre em contato com o <a href="mailto:'.ADM_EMAIL.'">desenvolvedor</a>.</div>';
