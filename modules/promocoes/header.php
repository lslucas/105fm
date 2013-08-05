<?php

    $pg_title = SITE_NAME." - Agenda";
    $promocoes    = array();

    /*
     *QUERY DE PRÓXIMOS promocoes
     */
    $sql =  "
        SELECT
            pro_id,
            pro_titulo,
            pro_linhafina,
            DATE_FORMAT(pro_data_inicio, '%d/%m/%Y'),
            DATE_FORMAT(pro_data_termino, '%d/%m/%Y'),
            pro_descricao,
            pro_ganhadores,
            pro_enviar_texto,
            pro_enviar_arquivo,
            (SELECT rpg_imagem FROM ".TP."_r_promocao_galeria WHERE rpg_pro_id=pro_id ORDER BY rpg_pos LIMIT 1),
            (SELECT rpg_legenda FROM ".TP."_r_promocao_galeria WHERE rpg_pro_id=pro_id ORDER BY rpg_pos LIMIT 1)

            FROM ".TP."_promocao
                WHERE pro_titulo IS NOT NULL
                    AND pro_status=1
                    #AND (pro_data_termino IS NULL OR pro_data_termino>=DATE(NOW()))
            ORDER BY pro_data_inicio DESC
            ";
     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $id,
         $titulo,
         $linhafina,
         $data_inicio,
         $data_termino,
         $descricao,
         $ganhadores,
         $enviar_texto,
         $enviar_arquivo,
         $imagem,
         $legenda
        );
        $qry->execute();
        $qry->store_result();

        $i=0;
        while ($qry->fetch()) {
            $enviar_arquivo = empty($enviar_arquivo) ? 0 : $enviar_arquivo;
            $enviar_texto = empty($enviar_texto) ? 0 : $enviar_texto;

            $promocoes[$i]['id'] = $hashids->encrypt($id);
            $promocoes[$i]['titulo'] = $titulo;
            $promocoes[$i]['linhafina'] = $linhafina. ' ';
            $promocoes[$i]['data_inicio'] = $data_inicio;
            $promocoes[$i]['data_termino'] = $data_termino;
            $promocoes[$i]['data'] = !empty($data_termino) && $data_termino!='0000-00-00' ? 'de '.$data_inicio.' até '.$data_termino : $data_inicio;
            $promocoes[$i]['descricao'] = nl2br(stripslashes($descricao));
            $promocoes[$i]['ganhadores'] = nl2br(stripslashes($ganhadores));
            $promocoes[$i]['enviar_texto'] = $enviar_texto;
            $promocoes[$i]['enviar_arquivo'] = $enviar_arquivo;
            $promocoes[$i]['participar'] = ($enviar_arquivo+$enviar_texto)>0 ? 1 : 0;

            $promocoes[$i]['thumb'] = 'images/promocao/thumb/'.$imagem;
            $promocoes[$i]['imagem'] = 'images/promocao/'.$imagem;
            $promocoes[$i]['legenda'] = $legenda;
            $i++;
        }

        $qry->close();

     }
