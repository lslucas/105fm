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
                                ORDER BY enq_data DESC";
    if (!$qry_enq = $conn->prepare($sql_enq))
        echo $conn->error();

    else {
        $qry_enq->bind_result($enq_id, $enq_titulo, $enq_res1, $enq_res2, $enq_res3, $enq_res4, $enq_res5);
        $qry_team->execute();
        $qry_team->fetch();
        $qry_team->close();
    }
