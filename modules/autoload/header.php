<?php
/*
	if(isset($_POST)) {
		foreach ($_POST as $key=>$value)
			if (!is_array($value))
				$val[$key] = trim($value);
	}

	$areasRestrita = array('lista', 'lista-por-interesse', 'lista-geral-de-interesses', 'painel', 'ver', 'interesse', 'remover-produto', 'editar-produto', 'novo-produto', 'meus-dados');
	if (empty($usr['id']) && isset($basename) && in_array($basename, $areasRestrita))
		header('Location: '.ABSPATH.'?acesso-restrito');
	*/


	/**
	 * Faz login
	 */
	/*
	if (isset($val['from']) && $val['from']=='login') {
		include_once 'modules/classes/usuario.php';
		$msg = $msgTitle = $res = null;
		$usuario = new Usuario();

		include_once 'modules/usuario/login/header.php';
	}
	*/

	/*
	 *QUERY DE BANNERS
	 */
	/*
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
	 */



    /*
     *QUERY DE PRÓXIMOS promocoes
     */
    $lstEquipe = array();
    $sql =  "
        SELECT
            equ_id,
            equ_titulo

            FROM ".TP."_equipe
                WHERE equ_titulo IS NOT NULL
                    AND equ_status=1
            ORDER BY equ_titulo ASC
            ";
     if (!$qry=$conn->prepare($sql))
         $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

     else {

        $qry->bind_result($id, $titulo);
        $qry->execute();

        $i=0;
        while ($qry->fetch()) {
              $lstEquipe[$i]['id'] = $id;
              $lstEquipe[$i]['titulo'] = $titulo;
              $lstEquipe[$i]['link'] = ABSPATH.'equipe/'.urlencode($titulo);
              $i++;
        }

        $qry->close();

     }