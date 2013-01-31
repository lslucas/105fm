<?php
		$filtroPost = array();

		if (isset($_POST['from']) && $_POST['from']=='filtrar')
			$filtroPost = $_POST;

		foreach ($urlParams as $params) {
			list($filtroName, $valParam) = explode('-', $params);
			if (isset($catIdByTituloMin[$valParam]))
				$breadcrumb[$filtroName] = getCategoriaCol('titulo', 'id', $catIdByTituloMin[$valParam]);
		}

		$filtro = $classificado->filtroCategorias($filtroPost);
		$listaGeral = $classificado->listaGeral($filtroPost);