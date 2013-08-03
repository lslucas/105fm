<?php

    $pg_title = SITE_NAME." - Equipe";
    $equipe    = array();

    $sql_team= "SELECT equ_id, equ_titulo FROM ".TABLE_PREFIX."_equipe WHERE equ_titulo IS NOT NULL AND equ_status=1 ORDER BY equ_titulo ASC";
    $qry_team = $conn->prepare($sql_team);
    $qry_team->bind_result($eq_id, $eq_titulo);
    $qry_team->execute();

    $i=0;
    while($qry_team->fetch()) {
      $eqentitulo = urlencode($eq_titulo);
      $listaEquipe[$eq_id] = $eq_titulo;
      $listaIntEquipe[$eqentitulo] = $i;
      $i++;
    }

    /*
     *QUERY DE PRÓXIMOS promocoes
     */
    $equipeArr = array();
    $sql =  "
        SELECT
            equ_id,
            equ_titulo,
            equ_texto,
            equ_imagem,
            equ_programa

            FROM ".TP."_equipe
                WHERE equ_titulo IS NOT NULL
                    AND equ_status=1
            ORDER BY equ_titulo ASC
            ";
     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $id,
         $titulo,
         $texto,
         $imagem,
         $programa
        );
        $qry->execute();

        $i=0;
        while ($qry->fetch()) {
              $equipeArr[$i]['id'] = $id;
              $equipeArr[$i]['titulo'] = $titulo;
              $equipeArr[$i]['texto'] = stripslashes($texto);
              $equipeArr[$i]['imagem'] = ABSPATH.'images/equipe/'.$imagem;
              $equipeArr[$i]['link'] = ABSPATH.'equipe/'.urlencode($titulo);
              $equipeArr[$i]['programa'] = $programa;
              $i++;
        }

        $qry->close();

     }


    if (!empty($querystring) && isset($listaIntEquipe[$querystring]))
      $intItem = $listaIntEquipe[$querystring];
    else
      $intItem = 0;

    $equipe = $equipeArr[$intItem];
    if (isset($equipeArr[$intItem+1]))
      $equipeNext = $equipeArr[$intItem+1];
    elseif (isset($equipeArr[$intItem-1]))
      $equipeNext = $equipeArr[$intItem-1];
    else
      $equipeNext = $equipe;

     if (($intItem-1)>=0)
      $equipePrev = isset($equipeArr[$intItem-1]) ? $equipeArr[$intItem-1] : $equipe;
    else
      $equipePrev = isset($equipeArr[count($equipe)]) ? $equipeArr[count($equipe)] : $equipe;

