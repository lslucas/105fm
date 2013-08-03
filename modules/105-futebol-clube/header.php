<?php

    $pg_title = SITE_NAME." - 105 Futebol Club";
    $list    = array();


    /*
     *QUERY DE PRÓXIMOS promocoes
     */
    $gfuipeArr = array();
    $sql =  "
        SELECT
            gfu_id,
            gfu_times,
            gfu_horario,
            gfu_apresentador,
            DATE_FORMAT(gfu_data, '%d/%m/%Y')

            FROM ".TP."_gradefutebol
                WHERE gfu_times IS NOT NULL
                    AND gfu_status=1
                    AND gfu_data>=DATE(NOW())
            ORDER BY gfu_data ASC
            ";
     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $id,
         $times,
         $horario,
         $apresentador,
         $data
        );
        $qry->execute();

        $i=0;
        while ($qry->fetch()) {
              $list[$i]['id'] = $id;
              $list[$i]['times'] = $times;
              $list[$i]['horario'] = $horario;
              $list[$i]['apresentador'] = $apresentador;
              $list[$i]['data'] = $data;
              $i++;
        }

        $qry->close();

     }


