<?php

    $sql_enq = "SELECT
                                    enq_id,
                                    enq_titulo,
                                    enq_res1,
                                    enq_res2,
                                    enq_res3,
                                    enq_res4,
                                    enq_res5
                                FROM ".TABLE_PREFIX."_enquete
                                WHERE enq_status=1
                                AND enq_data<=DATE(NOW())
                                ORDER BY enq_data DESC, enq_id DESC";
    if (!$qry_enq = $conn->prepare($sql_enq))
        echo $conn->error();

    else {
        $qry_enq->bind_result($enq_id, $enq_titulo, $enq_res1, $enq_res2, $enq_res3, $enq_res4, $enq_res5);
        $qry_enq->execute();
        $qry_enq->fetch();
        $qry_enq->close();
    }
