<?php
	$listaUrl = null;
	if (isset($_POST['q_grupoquimico']) && !empty($_POST['q_grupoquimico']))
		$listaUrl .= '/grupoquimico-'.linkfySmart(getCategoriaCol('titulo', 'id', $_POST['q_grupoquimico']));
	if (isset($_POST['filtroGrupoQuimico']) && !empty($_POST['filtroGrupoQuimico']))
		$listaUrl .= '/grupoquimico-'.linkfySmart(getCategoriaCol('titulo', 'id', $_POST['filtroGrupoQuimico']));
	if (isset($_POST['filtroFabricante']) && !empty($_POST['filtroFabricante']))
		$listaUrl .= '/fabricante-'.mb_strtolower(urlencode(getCategoriaCol('titulo', 'id', $_POST['filtroFabricante'])), 'utf8');
	if (isset($_POST['filtroProduto']) && !empty($_POST['filtroProduto']))
		$listaUrl .= '/produto-'.trim($_POST['filtroProduto']);
	if (isset($_POST['filtroLocalizacao']) && !empty($_POST['filtroLocalizacao']))
		$listaUrl .= '/uf-'.trim($_POST['filtroLocalizacao']);
	if (isset($_POST['filtroUsuario']) && !empty($_POST['filtroUsuario'])) {
		$usuario = linkfySmart(getUsuarioEmpresaById($_POST['filtroUsuario']));
		$listaUrl .= '/revenda-'.$usuario;
	} if (isset($_POST['q']) && !empty($_POST['q']))
		$listaUrl .= '/q-'.linkfySmart(trim($_POST['q']));

	header('Location: '.ABSPATH.'lista'.$listaUrl);
