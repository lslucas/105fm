<?php

    $pg_title = SITE_NAME." - Programas";
    $promocoes    = array();

    function converteSemanaParaInteiro($week)
    {
        switch ($week) {
            case 'segunda' : return 1;
          break;
            case 'terca' : return 2;
          break;
             case 'quarta' : return 3;
          break;
              case 'quinta' : return 4;
          break;
             case 'sexta' : return 5;
          break;
              case 'sabado' : return 6;
          break;
             case 'domingo' : return 7;
          break;
          default: return false;
          break;
        }
    }

    function getDiasSemana($id) {
        global $conn;

            $sql_week = "SELECT pro_diasemana FROM ".TABLE_PREFIX."_programa_semana WHERE pro_id=?";
            $qry_week = $conn->prepare($sql_week);
            $qry_week->bind_param('i', $id);
            $qry_week->bind_result($diasemana);
            $qry_week->execute();
            $weekRange = array();

            while($qry_week->fetch()) {
              $weekRange[$diasemana] = $diasemana;
            }

            return $weekRange;
    }

    function existeNoDia($id, $dia) {
        $weekRange = getDiasSemana($id);
        if (isset($weekRange[$dia]))
            return true;
        else
            return false;
    }

    /*
     *QUERY DE PRÓXIMOS promocoes
     */
    $programas = array();
    $sql =  "
        SELECT
            pro_id,
            pro_titulo,
            pro_texto,
            pro_apresentacao

            FROM ".TP."_programa
                WHERE pro_titulo IS NOT NULL
                    AND pro_status=1
            ORDER BY pro_titulo ASC
            ";
     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $id,
         $titulo,
         $texto,
         $apresentacao
        );
        $qry->execute();
        $qry->store_result();

        while ($qry->fetch()) {

            $geralProgramas[$id]['titulo'] = $titulo;
            $geralProgramas[$id]['texto'] = nl2br(stripslashes($texto));
            $geralProgramas[$id]['apresentacao'] = $apresentacao;

            for ($i = 1; $i <= 7; $i++) {
                if (existeNoDia($id, $i)) {
                    $programas[$i][$id]['titulo'] = $titulo;
                    $programas[$i][$id]['texto'] = nl2br(stripslashes($texto));
                    $programas[$i][$id]['apresentacao'] = $apresentacao;
                }
            }
        }

        $qry->close();

     }

/*
     $geralProgramas = array();
     foreach ($programas as $week=>$arr) {
        foreach ($arr as $int=>$pro) {
            $geralProgramas[] = $pro;
        }
     }
 */
     if (isset($querystring)) {
        $week = converteSemanaParaInteiro($querystring);
        if ($week)
            $geralProgramas = $programas[$week];
     }
