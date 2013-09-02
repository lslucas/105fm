<?php

    $sql_team= "SELECT not_id FROM ".TABLE_PREFIX."_noticia WHERE not_status=1 ORDER BY not_titulo ASC";
    $qry_team = $conn->prepare($sql_team);
    $qry_team->bind_result($eq_id);
    $qry_team->execute();

    $i=0;
    while($qry_team->fetch()) {
      $hash = $aes->encrypt($eq_id);
      $listaInt[$hash] = $i;
      $i++;
    }



        /**
         * Resgata ID da última noticia cadastrada para caso não seja informado um  id de noticia
         * @var string
         */
            $sql_not = "SELECT not_id FROM ".TABLE_PREFIX."_noticia WHERE not_status=1 ORDER BY not_data DESC LIMIT 1";
            if ($qry_not = $conn->prepare($sql_not)) {
                $qry_not->bind_result($item);
                $qry_not->execute();
                $qry_not->fetch();
                $qry_not->close();
    }

    $list  = array();

    /*
     *Lista posts de acordo com configuração
     */
    $sqlpos =  "SELECT
                    not_id,
                    not_titulo,
                    not_texto,
                    not_resumo,
                    DATE_FORMAT(not_data, '%d/%m/%Y') `data`,
                    (SELECT rng_imagem FROM ".TP."_r_noticia_galeria WHERE rng_not_id=not_id ORDER BY rng_pos LIMIT 1)
                FROM ".TP."_noticia
                WHERE not_status=1
                AND not_id=?
            ";
     if (!$qrypos=$conn->prepare($sqlpos))
         echo "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        if (!empty($querystring)) {
            $item = $hashids->decrypt($querystring);
            $item = isset($item[0]) ? $item[0] : null;
        }

        $qrypos->bind_param('i', $item);
        $qrypos->bind_result($id, $titulo, $texto, $resumo, $data, $imagem);
        $qrypos->execute();
        $qrypos->store_result();
        $qrypos->fetch();
        $total = $qrypos->num_rows;
        $qrypos->close();

        $texto = stripslashes($texto);
        $imagem = !empty($imagem) ? ABSPATH.'images/noticia/'.$imagem : null;
        $imagemUrl = !empty($imagem) ? SITE_URL.'images/noticia/'.$imagem : null;
        $url = SITE_URL.'noticia/' . $hashids->encrypt($id) . '/' .linkfySmart($titulo);
    }

