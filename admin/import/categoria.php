<?php

	foreach ($cat as $tipo=>$c) {
		foreach ($c as $titulo) {
			$titulo_min = mb_strtolower($titulo, 'utf8');

			$sql = "SELECT cat_id FROM ".TP."_categoria WHERE LOWER(cat_titulo)=? AND cat_area=?";
			if (!$qry = $conn->prepare($sql))
				echo $conn->error();

			else {
				$qry->bind_param('ss', $titulo_min, $tipo);
				$qry->bind_result($cat_id);
				$qry->execute();
				$qry->fetch();
				$qry->close();

				// if (!empty($cat_id))
					// echo $titulo.' <b>Já</b> está cadastrado<br/>';
				// else {
				if (empty($cat_id)) {

					$sql_ins = "INSERT INTO ".TP."_categoria (cat_titulo, cat_area) VALUES (?, ?)";
					if (!$qry_ins = $conn->prepare($sql_ins))
						echo $conn->error();
					else {
						$qry_ins->bind_param('ss', $titulo, $tipo);
						$qry_ins->execute();
						$qry_ins->close();

						echo $tipo.' com nome '.$titulo.' cadastrado com êxito<br/>';
					}
				}
			}
		}
	}
