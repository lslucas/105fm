<?php
	foreach ($list as $int=>$lst) {

		$grupo = isset($lstCatIdByTitulo[$lst['grupo']]) ? $lstCatIdByTitulo[$lst['grupo']] : null;
		$fabricanteNome = trim($lst['fabricante']);
		$fabricanteMin = mb_strtolower($fabricanteNome, 'utf8');

		if (empty($grupo) || empty($fabricanteNome))
			continue;

		/**
		 * Fabricante
		 * @var string
		 */
		unset($cat_id);
		$area = 'Fabricante';
		$sqlfab = "SELECT cat_id FROM ".TP."_categoria WHERE LOWER(cat_titulo)=? AND cat_idrel=? AND cat_area=?";

		if (!$qryfab = $conn->prepare($sqlfab))
			echo $conn->error();

		else {
			$qryfab->bind_param('sis', $fabricanteMin, $grupo, $area);
			$qryfab->bind_result($cat_id);
			$qryfab->execute();
			$qryfab->fetch();
			$qryfab->close();

			// if (!empty($cat_id))
				// echo $titulo.' <b>Já</b> está cadastrado<br/>';
			// else {
			if (empty($cat_id)) {

				$sql_insf = "INSERT INTO ".TP."_categoria (cat_titulo, cat_idrel, cat_area) VALUES (?, ?, ?)";
				if (!$qry_insf = $conn->prepare($sql_insf))
					echo $conn->error();
				else {
					$qry_insf->bind_param('sis', $fabricanteNome, $grupo, $area);
					$qry_insf->execute();
					$qry_insf->close();

					echo "Fabricante ".$fabricanteNome.' do grupo '.$grupo.' cadastrado com êxito<br/>';
				}
			}
		}
	}


	foreach ($list as $int=>$lst) {

		$grupo = isset($lstCatIdByTitulo[$lst['grupo']]) ? $lstCatIdByTitulo[$lst['grupo']] : null;
		$fabricanteNome = trim($lst['fabricante']);
		$fabricante = isset($lstCatIdByTitulo[$fabricanteNome]) ? $lstCatIdByTitulo[$fabricanteNome] : null;
		$titulo = trim($lst['produto']);
		$titulo_min = mb_strtolower($titulo, 'utf8');

		if (empty($grupo) || empty($fabricante) || empty($titulo))
			continue;
		/**
		 * Produto
		 * @var string
		 */
		$sql = "SELECT pro_id FROM ".TP."_produto WHERE LOWER(pro_titulo)=? AND pro_fabricante=? AND pro_grupoquimico=?";
		if (!$qry = $conn->prepare($sql))
			echo $conn->error();

		else {
			$qry->bind_param('sii', $titulo_min, $fabricante, $grupo);
			$qry->bind_result($pro_id);
			$qry->execute();
			$qry->fetch();
			$qry->close();

			// if (!empty($pro_id)) {
				// echo $titulo.' <b>Já</b> está cadastrado<br/>';
			// else {
			if (empty($pro_id)) {

				$sql_ins = "INSERT INTO ".TP."_produto (pro_titulo, pro_tipo, pro_fabricante, pro_grupoquimico) VALUES (?, ?, ?, ?)";
				if (!$qry_ins = $conn->prepare($sql_ins))
					echo $conn->error();
				else {
					$tipo = 1;
					$qry_ins->bind_param('siii', $titulo, $tipo, $fabricante, $grupo);
					$qry_ins->execute();
					$qry_ins->close();

					echo 'Produto '.$titulo.' cadastrado com êxito<br/>';
				}
			}

		}
	}
