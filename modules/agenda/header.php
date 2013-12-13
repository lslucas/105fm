<?php

    $pg_title = SITE_NAME." - Agenda";
    $shows    = array();

    /*
     *QUERY DE PRÓXIMOS SHOWS
     */
    $sql =  "
        SELECT
            sho_code,
            sho_titulo,
            DATE_FORMAT(sho_data, '%d/%m/%Y'),
            DATE_FORMAT(sho_data, '%d'),
            DATE_FORMAT(sho_data, '%m'),
            DATE_FORMAT(sho_data, '%Y'),
            DATE_FORMAT(sho_hora_inicio, '%H:%i'),
            DATE_FORMAT(sho_hora_fim, '%H:%i'),
            sho_local,
            sho_url,
            sho_artista,
            sho_descricao,
            (SELECT rsg_imagem FROM ".TP."_r_show_galeria WHERE rsg_sho_id=sho_id ORDER BY rsg_pos LIMIT 1),
            (SELECT rsg_legenda FROM ".TP."_r_show_galeria WHERE rsg_sho_id=sho_id ORDER BY rsg_pos LIMIT 1)

            FROM ".TP."_show
                WHERE sho_titulo IS NOT NULL
                    AND sho_data>=DATE(NOW())
                    AND sho_data_exibir<=DATE(NOW())
            ORDER BY sho_data ASC, sho_hora_inicio ASC
            ";

     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $code,
         $titulo,
         $data,
         $dia,
         $mes,
         $ano,
         $hora_inicio,
         $hora_fim,
         $local,
         $url,
         $artista,
         $descricao,
         $imagem,
         $legenda
        );
        $qry->execute();
        $qry->store_result();

        $i=0;
        while ($qry->fetch()) {
            $shows[$i]['code'] = $code;
            $shows[$i]['titulo'] = $titulo;
            $shows[$i]['data'] = $data;
            $shows[$i]['dia'] = $dia;
            $shows[$i]['mes'] = mesExtenso($mes);
            $shows[$i]['ano'] = $ano;
            $shows[$i]['hora_inicio'] = $hora_inicio;
            $shows[$i]['hora_fim'] = $hora_fim;
            $shows[$i]['local'] = $local;
            $shows[$i]['url'] = $url;
            $shows[$i]['artista'] = $artista;
            $shows[$i]['descricao'] = nl2br(stripslashes($descricao));
            $shows[$i]['legenda'] = nl2br(stripslashes($legenda));
            $shows[$i]['thumb'] = 'images/show/thumb/'.$imagem;
            $shows[$i]['imagem'] = 'images/show/'.$imagem;
            $i++;
        }

        $qry->close();

     }
