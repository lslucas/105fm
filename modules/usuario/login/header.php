<?php
	$usuario = new Usuario();
	$res = $usuario->login($val['email'], $val['senha']);

	if ($res===true)
		header('Location: '.ABSPATH.'participacao');
	else
		$toScript = showModal(array('title'=>'Login', 'content'=>'Email ou senha inválidos!'));