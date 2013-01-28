<?php
	include_once 'modules/classes/utils.php';
	$utils = new Utils;

	if (!empty($usr['id'])) {
		if (!empty($usr['cidade']) && !empty($usr['uf']))
			$argsClima = array('cidade'=>$usr['cidade'], 'uf'=>$usr['uf']);
		elseif (empty($usr['cidade']) && !empty($usr['uf']))
			$argsClima = array('uf'=>$usr['uf']);
	}

	if (empty($usr['id']) || !isset($argsClima))
		$argsClima = array('cidade'=>'São Paulo', 'uf'=>'SP');

	$clima = $utils->climaByCityState($argsClima);
	// var_dump($clima);

	if (isset($_GET['sessao-expirada']))
		$toScript = showModal(array('title'=>'Ops', 'content'=>"Sua sessão expirou! Faça login novamente."));

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
			$destaque[$i]['imagem'] = $rph.'images/destaque/'.$imagem;
			$i++;
		}

		$qrys->close();

	 }


	/*
	 *Lista noticias de acordo com configuração
	 */
	$listNoticias = array();
	$sqlnot =  "SELECT
					not_id,
					not_titulo,
					DATE_FORMAT(not_data, '%d/%m/%Y') `data`
				FROM ".TP."_noticia
				WHERE not_status=1
				AND not_data<=DATE(NOW())
				ORDER BY not_data DESC
				LIMIT 8
			";
	 if (!$qrynot=$conn->prepare($sqlnot))
		 echo "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qrynot->bind_result($id, $titulo, $data);
		$qrynot->execute();
		$total = $qrynot->num_rows;

		$i=0;
		while ($qrynot->fetch()) {
			$hash = $hashids->encrypt($id);
			$listNoticias[$i]['titulo'] = $data.' - '.$titulo;
			$listNoticias[$i]['data'] = $data;
			$listNoticias[$i]['link']  = ABSPATH.'noticia/'.$hash.'/'.linkfySmart($titulo);
			$i++;
		}

		$qrynot->close();

	}