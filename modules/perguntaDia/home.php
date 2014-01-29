<?php

    $sql_enq = "SELECT
                                    pdi_id,
                                    pdi_titulo
                                FROM ".TABLE_PREFIX."_perguntaDia
                                WHERE pdi_status=1
                                AND pdi_data<=DATE(NOW())
                                ORDER BY pdi_data DESC";
    if (!$qry_enq = $conn->prepare($sql_enq))
        echo $conn->error();

    else {
        $qry_enq->bind_result($pergunta_id, $pergunta);
        $qry_enq->execute();
        $qry_enq->fetch();
        $qry_enq->close();

        $pergunta_id = $hashids->encrypt($pergunta_id);
    }
