<?php

	$res = $usuario->atualizaCadastro($val);

	/**
	 *Se não houve erro redireciona usuario logado ao painel dele
	 */
	if (!isset($res['error']))
		header('Location: '.ABSPATH.'participacao');
