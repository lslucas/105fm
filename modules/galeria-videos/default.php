<?php

	/*
	 *QUERY DE VIDEOS RECENTES
	 */
	$videos = array();
	$sqlvideo =  "
		SELECT
			vid_code,
			vid_titulo,
			DATE_FORMAT(vid_data, '%d/%m'),
			(SELECT art_titulo FROM ".TP."_artista WHERE art_code=vid_art_code),
			vid_youtube,
			(SELECT rvg_imagem FROM ".TP."_video_galeria WHERE rvg_vid_id=vid_id ORDER BY rvg_pos ASC LIMIT 1) imagem

			FROM ".TP."_video
				WHERE 1
					AND vid_data<=DATE(NOW())
					AND vid_status=1
			ORDER BY vid_data DESC
			LIMIT 4
			";
	 #AND mus_mp3 IS NOT NULL
	 if (!$qryvideo=$conn->prepare($sqlvideo))
		 $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qryvideo->bind_result(
		 $code,
		 $titulo,
		 $data,
		 $artista,
		 $youtube,
		 $imagem
		);
		$qryvideo->execute();

		$i=0;
		while ($qryvideo->fetch()) {
			$videos[$i]['code'] = $code;
			$videos[$i]['titulo'] = $artista.' - '.$titulo;
			$videos[$i]['data'] = $data;
			$videos[$i]['artista'] = $artista;
			$videos[$i]['youtube'] = $youtube;
			$videos[$i]['youtube_embed'] = preg_replace('/watch\?v\=/', 'embed/', $youtube);
			$videos[$i]['link']	= "videos/detail/{$code}";
			$videos[$i]['imagem'] = STATIC_PATH.'video/thumb/'.$imagem;
			$i++;
		}


		$qryvideo->close();

	 }
