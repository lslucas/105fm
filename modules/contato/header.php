<?php

    /**
     * Envia email
     */
    if(isset($_POST['from']) && isset($_POST['from']) && $_POST['from']=='fale-conosco') {
        if (in_array($_POST['assunto'], array('promocoes', 'programacao', 'site', 'suporte', 'comercial')))
            return enviaEmail($_POST);
        else
            include_once 'send.php';
    }


    function enviaEmail($var)
    {
        $_POST = $var;
        include_once 'modules/classes/mail.php';
        foreach ($_POST as $key=>$value)
            $val[$key] = trim($value);

        $val['toEmail'] = $val['assunto'].'@105fm.com.br';

        if (empty($val['nome']))
            $error .= "<li>Preencha seu nome</li>";
        // if (empty($val['sobrenome']))
            // $error .= "<li>Preencha seu sobrenome</li>";
        if (empty($val['email']) || !validaEmail($val['email']))
            $error .= "<li>Preencha um email válido!</li>";
        if (empty($val['assunto']))
            $error .= "<li>Selecione um assunto primeiro, se não tem certeza selecione Outro</li>";
        if (empty($val['ddd']) && empty($val['telefone']))
            $error .= "<li>Preencha o DDD+Telefone</li>";
        if (empty($val['mensagem']))
            $error .= "<li>Escreva sua mensagem!</li>";

        if (empty($error)) {
            $args = array(
                    'fromName'=>$val['nome'],
                    'fromEmail'=>$val['email'],
                    'email'=>$val['toEmail'],
                    'assunto'=>$val['assunto'],
                    'cidade'=>$val['cidade'],
                    'estado'=>$val['estado'],
                    'telefone'=>$val['ddd'].' '.$val['telefone'],
                    'mensagem'=>$val['mensagem'],
                  );
            $mail = new Mail();

            if ($mail->faleConosco($args))
                $incJS = "window.alert('Mensagem enviada com êxito! Breve responderemos.');";
        }

         #Trata mensagens de erro
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

    }
