<?php

    include_once '../../load.php';

    if (isset($_POST['enq_id']) && !empty($_POST['enq_id'])) {
        $enq_id = $hashids->decrypt($_POST['enq_id']);
        $enq_id = $enq_id[0];
    }

    if (isset($_POST['res']) && !empty($_POST['res'])) {
        $res = $hashids->decrypt($_POST['res']);
        $res = $res[0];
    }

    if (!isset($enq_id) || !isset($res) || !in_array($res, array(1, 2, 3, 4, 5)))
        echo "Ops, você fez algo de errado, senão tente mais tarde!";

    $sql = "SELECT NULL FROM ".TP."_enquete_votos WHERE enq_id=? AND ip=?"; 
    if (!$qry = $conn->prepare($sql))
        echo $conn->error();

    else {
        $qry->bind_param('is', $enq_id, $_SERVER['REMOTE_ADDR']); //$resposta,
        $qry->execute();
        $qry->store_result();
        $num = $qry->num_rows;
        $qry->close();

        if ($num==0) {

            /**
             * Após validado insere voto e mostra estatistica de resostas
             */
            $sql_enq = "INSERT INTO ".TP."_enquete_votos (enq_id, res, ip) VALUES (?, ?, ?)";
            if (!$qry_enq = $conn->prepare($sql_enq))
                echo $conn->error();

            else {
                $qry_enq->bind_param('iis', $enq_id, $res, $_SERVER['REMOTE_ADDR']);
                $qry_enq->execute();
                $qry_enq->close();

                echo "<br/><b>Voto computado!</b><p>";
            }
        } else
            echo "<br/><b>Você já votou nessa enquete!</b><p>";

        /** resgata todas as perguntas **/
        $sqlpenq = "SELECT enq_titulo, enq_res1, enq_res2, enq_res3, enq_res4, enq_res5 FROM ".TP."_enquete WHERE enq_id=?";
        if (!$qrypenq = $conn->prepare($sqlpenq))
            echo $conn->error();

        else {

            $qrypenq->bind_param('i', $enq_id);
            $qrypenq->bind_result($titulo, $res1, $res2, $res3, $res4, $res5);
            $qrypenq->execute();
            $qrypenq->fetch();
            $qrypenq->close();

            $lstResp = array();
            if (!empty($res1))
                $lstResp[1] = $res1;
             if (!empty($res2))
                $lstResp[2] = $res2;
             if (!empty($res3))
                $lstResp[3] = $res3;
             if (!empty($res4))
                $lstResp[4] = $res4;
             if (!empty($res5))
                $lstResp[5] = $res5;

            $voto = array();
            $sqlrenq = "SELECT COUNT(timestamp) num, res FROM ".TP."_enquete_votos WHERE enq_id=? GROUP BY res";
            if (!$qryrenq = $conn->prepare($sqlrenq))
                echo $conn->error();

            else {
                $qryrenq->bind_param('i', $enq_id);
                $qryrenq->bind_result($num, $resposta);
                $qryrenq->execute();

                $sum = 0;
                while($qryrenq->fetch()) {
                    $voto[$resposta]['resp'] = $lstResp[$resposta];
                    $voto[$resposta]['num'] = $num;
                    $sum += $num;
                }
                $qryrenq->close();

                foreach ($voto as $resp => $vot) {
                    $porc = ((100*$vot['num'])/$sum).'%';
                    echo ceil($porc).'% - '.$vot['resp'].' &nbsp; &nbsp;';
                }

                echo "</p>";

            }
        }
    }