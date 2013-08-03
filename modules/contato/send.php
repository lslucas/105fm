<?php

    // include_once '../../load.php';
    $msg = null;
    if (empty($_POST['nome']))
        $msg .= "Preencha seu nome!\n";
    if (empty($_POST['email']))
        $msg .= "Preencha seu email!\n";
    if (empty($_POST['cidade']))
        $msg .= "Preencha sua cidade!\n";
    // if (empty($_POST['estado']))
        // $msg .= "Preencha seu estado!\n";
    if (empty($_POST['assunto']))
        $msg .= "Selecione um assunto!\n";
    // if (empty($_POST['telefone']))
        // $msg .= "Entre com seu telefone!\n";
    if (empty($_POST['mensagem']))
        $msg .= "Escreva sua mensagem!\n";

    if (!empty($msg))
        $toJS .= "alert('{$msg}');";

    else {

        foreach ($_POST as $key=>$val) {
            $$key = trim($val);
        }

        /**
         * Após validado insere voto e mostra estatistica de resostas
         */
        $sql= "INSERT INTO ".TP."_contato (con_assunto, con_nome, con_email, con_cidade, con_estado, con_telefone, con_mensagem, con_ip) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        if (!$qry= $conn->prepare($sql))
            echo $conn->error();

        else {
            $qry->bind_param('ssssssss',
                                                    $assunto,
                                                    $nome,
                                                    $email,
                                                    $cidade,
                                                    $estado,
                                                    $telefone,
                                                    $mensagem,
                                                    $_SERVER['REMOTE_ADDR']);
            $qry->execute();
            $qry->close();

            $toJS .= "alert('Mensagem enviada! Breve será respondida!');";

        }
    }
