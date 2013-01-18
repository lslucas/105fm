<?php
	$listaUrl = null;
	if (isset($_POST['q_grupoquimico']) && !empty($_POST['q_grupoquimico']))
		$listaUrl .= '/grupoquimico-'.linkfySmart(getCategoriaCol('titulo', 'id', $_POST['q_grupoquimico']));
	if (isset($_POST['filtroGrupoQuimico']) && !empty($_POST['filtroGrupoQuimico']))
		$listaUrl .= '/grupoquimico-'.linkfySmart(getCategoriaCol('titulo', 'id', $_POST['filtroGrupoQuimico']));
	if (isset($_POST['filtroFabricante']) && !empty($_POST['filtroFabricante']))
		$listaUrl .= '/fabricante-'.linkfySmart(getCategoriaCol('titulo', 'id', $_POST['filtroFabricante']));
	if (isset($_POST['filtroProduto']) && !empty($_POST['filtroProduto']))
		$listaUrl .= '/produto-'.linkfySmart(getProdutoCol('titulo', 'id', $_POST['filtroProduto']));
	if (isset($_POST['q']) && !empty($_POST['q']))
		$listaUrl .= '/q-'.linkfySmart(trim($_POST['q']));

	header('Location: '.ABSPATH.'lista'.$listaUrl);
