<?php

    include_once '../../load.php';

    if (isset($_POST['id_pergunta']) && !empty($_POST['id_pergunta'])) {
        $id_pergunta = $hashids->decrypt($_POST['id_pergunta']);
        $id_pergunta = $id_pergunta[0];
    }

    if (isset($_POST['resposta']) && !empty($_POST['resposta']))
        $resposta = $_POST['resposta'];

    if (empty($id_pergunta) || empty($resposta))
        echo "Ops, você fez algo de errado, senão, tente mais tarde!";

    $sql = "SELECT NULL FROM ".TP."_perguntaDia_votos WHERE pdi_id=? AND usr_id=? OR pdi_id=? AND ip=?"; //AND resposta=? 
    if (!$qry = $conn->prepare($sql))
        echo $conn->error();

    else {
        $qry->bind_param('iiis', $id_pergunta, $usr['id'], $id_pergunta, $_SERVER['REMOTE_ADDR']); //$resposta,
        $qry->execute();
        $qry->store_result();
        $num = $qry->num_rows;
        $qry->close();

        if ($num>0)
            exit('<b>Você já respondeu essa pergunta!');

        /**
         * Após validado insere voto e mostra estatistica de resostas
         */
        $sql_enq = "INSERT INTO ".TP."_perguntaDia_votos (pdi_id, usr_id, resposta, ip) VALUES (?, ?, ?, ?)";
        if (!$qry_enq = $conn->prepare($sql_enq))
            echo $conn->error();

        else {
            $qry_enq->bind_param('iiss', $id_pergunta, $usr['id'], $resposta, $_SERVER['REMOTE_ADDR']);
            $qry_enq->execute();
            $qry_enq->close();

            echo "<b>Resposta enviada!</b>";
        }
    }
