<?php

	include_once 'modules/classes/usuario.php';

	$val = array();
	if (isset($_POST)) {
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);
	}


	if (isset($_POST['form']) && $_POST['form']=='login')
		include_once '../usuario/login/header.php';

	if (isset($_POST['form']) && $_POST['form']=='contato-vendedor')
		include_once 'modules/produto/ver/contato-vendedor.php';


	/*
	 *QUERY DE BANNERS
	 */
	$banners = array();
	$sqlban =  "
		SELECT
			ban_id,
			ban_code,
			ban_area,
			ban_titulo,
			ban_imagem,
			ban_url,
			ban_type

			FROM ".TP."_banner
				WHERE 1
					AND ban_date_from<=DATE(NOW())
					AND (ban_date_to>=DATE(NOW()) OR ban_date_to='' OR ban_date_to IS NULL)
					AND ban_status=1
			ORDER BY ban_area, RAND()
			";
	 if (!$qryban=$conn->prepare($sqlban))
		 $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qryban->bind_result(
		 $id,
		 $code,
		 $area,
		 $titulo,
		 $imagem,
		 $url,
		 $type
		);
		$qryban->execute();

		while ($qryban->fetch()) {
			if (!isset($banners[$area]))
				$i=0;
			$banners[$area][$i]['id'] = $id;
			$banners[$area][$i]['code'] = $code;
			$banners[$area][$i]['titulo'] = $titulo;
			$banners[$area][$i]['type'] = $type;
			$banners[$area][$i]['link'] = !empty($url) ? $rph.'l/'.$code : null;
			$banners[$area][$i]['imagem'] = STATIC_PATH."banner/{$imagem}";
			$i++;
		}

		$qryban->close();

	 }

