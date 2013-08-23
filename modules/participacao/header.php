<?php

    if (!isset($usr) || empty($usr['id']))
        header('Location: '.ABSPATH.'login');

    foreach ($_POST as $key=>$value)
        $val[$key] = trim($value);

    /**
     * Registra promocao
     */
    // var_dump($_POST);
    if (isset($_POST['submited']) && $basename=='participacao')
        include_once 'enviar.php';


    $pg_title = SITE_NAME." - Agenda";
    $promocoes    = array();

    /*
     *QUERY DE PRÓXIMOS promocoes
     */
    $sql =  "
        SELECT
            pro_id,
            pro_titulo,
            pro_enviar_arquivo,
            pro_enviar_texto,
            pro_regulamento,
            pro_linhafina,
            DATE_FORMAT(pro_data_inicio, '%d/%m/%Y'),
            DATE_FORMAT(pro_data_termino, '%d/%m/%Y')

            FROM ".TP."_promocao
                WHERE pro_titulo IS NOT NULL
                    AND (pro_data_termino IS NULL OR pro_data_termino>=DATE(NOW()))
                    AND pro_ganhadores IS NOT NULL
            ORDER BY pro_data_inicio DESC
            ";

     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $id,
         $titulo,
         $enviar_arquivo,
         $enviar_texto,
         $regulamento,
         $linhafina,
         $data_inicio,
         $data_termino
        );
        $qry->execute();
        $qry->store_result();

        $i=0;
        while ($qry->fetch()) {
            $promocoes[$i]['id'] = $hashids->encrypt($id);
            $promocoes[$i]['titulo'] = $titulo;
            $promocoes[$i]['enviar_arquivo'] = $enviar_arquivo;
            $promocoes[$i]['enviar_texto'] = $enviar_texto;
            $promocoes[$i]['linhafina'] = $linhafina. ' ';
            $promocoes[$i]['regulamento'] = stripslashes($regulamento);
            $promocoes[$i]['data_inicio'] = $data_inicio;
            $promocoes[$i]['data_termino'] = $data_termino;
            $i++;
        }

        $qry->close();

     }
