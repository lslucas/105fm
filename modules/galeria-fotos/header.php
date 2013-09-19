<?php

    $pg_title = SITE_NAME." - Fotos";
    $fotos = array();
    $galeria = array();

    /*
     *QUERY DE PRÓXIMOS SHOWS
     */
    $sql =  "
        SELECT
            fot_id,
            fot_code,
            fot_titulo,
            DATE_FORMAT(fot_data, '%d/%m/%Y'),
            (SELECT rfg_imagem FROM ".TP."_foto_galeria WHERE rfg_fot_id=fot_id ORDER BY rfg_pos ASC LIMIT 1),
            (SELECT rfg_legenda FROM ".TP."_foto_galeria WHERE rfg_fot_id=fot_id ORDER BY rfg_pos ASC LIMIT 1)

            FROM ".TP."_foto
                WHERE fot_titulo IS NOT NULL
                    AND fot_status=1
                    AND fot_data<=DATE(NOW())
            ORDER BY fot_data DESC
            ";
     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        if ($querystring=='detail')
            $qry->bind_param('s', $queryaction);

        $qry->bind_result(
         $id,
         $code,
         $titulo,
         $data,
         $capa,
         $legenda
        );
        $qry->execute();

        $lstGalerias = $lstCapas = array();
        $i=$j=$page=0;
        while ($qry->fetch()) {
            array_push($lstCapas, $capa);
            array_push($lstGalerias, $id);
            if ($j==4) {
                $j=0;
                $i=0;
                $page++;
            }
            $fotos[$page][$i]['code']  = $code;
            $fotos[$page][$i]['foto_id']= $id;
            $fotos[$page][$i]['titulo']= $titulo;
            $fotos[$page][$i]['data']  = $data;
            $fotos[$page][$i]['capa']  = STATIC_PATH.'foto/thumb/'.$capa;
            $fotos[$page][$i]['capa_grande']   = STATIC_PATH.'foto/'.$capa;
            $fotos[$page][$i]['legenda']= !empty($legenda) ? stripslashes($legenda) : null;
            // $fotos[$page][$i]['link']   = "artistas/detail/{$code}";
            $j++;
            $i++;
        }

        $qry->close();

     }


    /*
     * GALERIA DE FOTOS
     */
    $whrGalerias = " AND rfg_fot_id IN (".join(', ', $lstGalerias).")";
    $sqlgal =  "
        SELECT
            rfg_fot_id,
            rfg_imagem,
            rfg_legenda
            FROM ".TP."_foto_galeria
            INNER JOIN ".TP."_foto
                ON rfg_fot_id=fot_id
                AND fot_status=1
                AND fot_data<=DATE(NOW())
                WHERE rfg_imagem IS NOT NULL
                {$whrGalerias}
            ORDER BY rfg_fot_id, rfg_pos ASC
            ";
     if (!$qrygal=$conn->prepare($sqlgal))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qrygal->bind_result(
         $fot_id,
         $imagem,
         $legenda
        );
        $qrygal->execute();

        while ($qrygal->fetch()) {

            // if (in_array($imagem, $lstCapas))
                // continue;

            if (!isset($galeria[$fot_id])) {
                $i=0;
                $galeria[$fot_id][$i] = array();
            }

            $galeria[$fot_id][$i]['imagem'] = STATIC_PATH.'foto/'.$imagem;
            $galeria[$fot_id][$i]['thumb']  = STATIC_PATH.'foto/thumb/'.$imagem;
            $galeria[$fot_id][$i]['legenda']= !empty($legenda) ? $legenda : null;

            $i++;
        }

        $qrygal->close();

     }