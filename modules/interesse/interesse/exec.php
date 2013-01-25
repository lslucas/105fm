<?php

	$res = $interesse->novoInteresse($val);

	/**
	 *Se não houve erro redireciona usuario logado ao painel dele
	 */
	if (isset($res['success']))
		header('Location: '.ABSPATH.'interesse');
