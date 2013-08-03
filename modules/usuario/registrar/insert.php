<?php

	$res = $usuario->novoCadastro($val);

	/**
	 *Se não houve erro redireciona usuario logado ao painel dele
	 */
	if (!isset($res['error'])) {
		if ($usuario->login($val['email'], $val['senha']))
			header('Location: '.ABSPATH.'participacao');
	}
