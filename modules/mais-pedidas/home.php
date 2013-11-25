<?php

    /*
     *QUERY DE MÚSICAS RECENTES
     */
    $sqlmusic =  "
        SELECT
            mus_code,
            mus_titulo,
            DATE_FORMAT(mus_data, '%d/%m/%Y'),
            (SELECT art_titulo FROM ".TP."_artista WHERE art_code=mus_art_code),
            (SELECT rmm_media FROM ".TP."_musica_media WHERE rmm_mus_id=mus_id),
            (SELECT rag_imagem FROM ".TP."_artista_galeria WHERE rag_art_id=(SELECT art_id FROM ".TP."_artista WHERE art_code=mus_art_code))

            FROM ".TP."_musica
                WHERE 1
                    AND mus_data<=DATE(NOW())
                    AND mus_status=1
            ORDER BY mus_data DESC
            LIMIT 7
            ";

     #AND mus_mp3 IS NOT NULL
     if (!$qrymusic=$conn->prepare($sqlmusic))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qrymusic->bind_result(
         $code,
         $titulo,
         $data,
         $artista,
         $mp3,
         $imagem
        );
        $qrymusic->execute();

        $ip = apenasNumeros($_SERVER['REMOTE_ADDR']);
        $i=0;
        while ($qrymusic->fetch()) {
            if (empty($mp3))
                continue;

            $musicas[$i]['titulo'] = $titulo;
            $musicas[$i]['data'] = $data;
            $musicas[$i]['artista'] = $artista;
            $musicas[$i]['artista_imagem'] = ABSPATH.'images/artista/thumb/'.$imagem;
            $musicas[$i]['mp3'] = $mp3;
            $musicas[$i]['download'] = ABSPATH."createlink/{$code}-{$ip}";
            $musicas[$i]['ouvir'] = ABSPATH."ouvir?code=".$code;
            $i++;
        }

        $qrymusic->close();

     }

