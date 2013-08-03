<?php
    if (isset($_GET['sessao-expirada']))
        $toScript = showModal(array('title'=>'Ops', 'content'=>"Sua sessão expirou! Faça login novamente."));
    if (isset($_GET['acesso-restrito']))
        $toScript = showModal(array('title'=>'Acesso Restrito', 'content'=>"Para acessar essa area você precisa estar registrado e logado! <br/>Faça o <a href='".ABSPATH."login'>login</a> ou <a href='".ABSPATH."registrar'>registre-se</a>.<br/><br/>Dúvidas? Entre em contato com <a href='mailto:".EMAIL_CONTACT."'>".EMAIL_CONTACT."</a>"));

    $incReady = '$("#popup").fancybox().trigger("click");';

    /*
     *QUERY DESTAQUE
     */
    $destaque = array();
    $sqls =  "
        SELECT
            des_id,
            des_descricao,
            des_link,
            (SELECT rdg_imagem FROM ".TP."_r_destaque_galeria WHERE rdg_des_id=des_id LIMIT 1) imagem

            FROM ".TP."_destaque
                WHERE
                    des_status=1
                    AND des_data<=DATE(NOW())
            ORDER BY des_data DESC
            ";
     if (!$qrys=$conn->prepare($sqls))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qrys->bind_result(
         $id,
         $descricao,
         $link,
         $imagem
        );
        $qrys->execute();
        $qrys->store_result();

        $i=0;
        while ($qrys->fetch()) {
            $destaque[$i]['id'] = $id;
            $destaque[$i]['descricao'] = $descricao;
            $destaque[$i]['link'] = $link;
            $destaque[$i]['imagem'] = 'images/destaque/'.$imagem;
            $i++;
        }

        $qrys->close();

     }


    /*
     *Lista ultimas noticias
     */
    $noticias  = array();
    $sqlnot =  "SELECT
                not_id,
                not_cat,
                not_titulo,
                not_resumo,
                DATE_FORMAT(not_data, '%d.%m.%y') `data`,
                (SELECT rng_imagem FROM ".TP."_r_noticia_galeria WHERE rng_not_id=not_id ORDER BY rng_pos LIMIT 1)
                FROM ".TP."_noticia
                WHERE not_status=1
                AND not_destaque=1
                ORDER BY not_data DESC
                LIMIT 4
            ";
     if (!$qrynot=$conn->prepare($sqlnot))
         echo "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qrynot->bind_result($id, $cat, $titulo, $resumo, $data, $imagem);
        $qrynot->execute();

        $i=0;
        while ($qrynot->fetch()) {
            $noticias[$id]['id'] = $id;
            $noticias[$id]['titulo'] = mb_strtoupper($titulo, 'utf8');
            $noticias[$id]['resumo'] = strlen($resumo)>60 ? substr(mb_strtoupper($resumo, 'utf8'), 0, 62).'...' : $resumo;
            $noticias[$id]['data'] = $data;
            $noticias[$id]['imagem'] =  !empty($imagem) ? 'images/noticia/home/' . $imagem : null;
            $noticias[$id]['link'] =  ABSPATH.'noticia/' . $hashids->encrypt($id) . '/' .linkfySmart($titulo);
            $i++;
        }

        $qrynot->close();

    }

    /*
     *QUERY DA AGENDA
     */
    $agenda    = array();
    $sql =  "
        SELECT
            sho_code,
            sho_titulo,
            DATE_FORMAT(sho_data, '%d/%m/%Y'),
            DATE_FORMAT(sho_hora_inicio, '%H:%i'),
            sho_local

            FROM ".TP."_show
                WHERE sho_titulo IS NOT NULL
                    AND sho_data>=DATE(NOW())
            ORDER BY sho_data ASC, sho_hora_inicio ASC
            ";

     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result(
         $code,
         $titulo,
         $data,
         $hora_inicio,
         $local
        );
        $qry->execute();
        $qry->store_result();

        $i=0;
        while ($qry->fetch()) {
            $agenda[$i]['code'] = $code;
            $agenda[$i]['titulo'] = $titulo;
            $agenda[$i]['data'] = $data.(!empty($hora_inicio) && $hora_inicio!='00:00' ? ' - '.$hora_inicio : null);
            $agenda[$i]['hora_inicio'] = $hora_inicio;
            $agenda[$i]['local'] = $local;
            $i++;
        }

        $qry->close();

     }


    include_once 'modules/perguntaDia/home.php';
    include_once 'modules/galeria-fotos/home.php';
    include_once 'modules/mais-pedidas/home.php';
    include_once 'modules/galeria-videos/default.php';
    include_once 'modules/enquete/home.php';
