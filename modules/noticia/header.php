<?php

	$list  = array();

	/*
	 *Lista posts de acordo com configuração
	 */
	$sqlpos =  "SELECT
					not_id,
					not_titulo,
					not_texto,
					DATE_FORMAT(not_data, '%d/%m/%Y') `data`,
					(SELECT rng_imagem FROM ".TP."_r_noticia_galeria WHERE rng_not_id=not_id ORDER BY rng_pos LIMIT 1)
				FROM ".TP."_noticia
				WHERE not_status=1
				AND not_id=?
			";
	 if (!$qrypos=$conn->prepare($sqlpos))
		 echo "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

	 	$item = $hashids->decrypt($querystring);
	 	$item = isset($item[0]) ? $item[0] : null;
		$qrypos->bind_param('i', $item);
		$qrypos->bind_result($id, $titulo, $texto, $data, $imagem);
		$qrypos->execute();
		$qrypos->store_result();
		$qrypos->fetch();
		$total = $qrypos->num_rows;
		$qrypos->close();

		$imagem = !empty($imagem) ? ABSPATH.'images/noticia/'.$imagem : null;
	}
