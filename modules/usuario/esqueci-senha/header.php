<?php
	$usuario = new Usuario();
	$res = $usuario->zerarSenha($val['email']);

	if ($res===false)
		$toScript = showModal(array('title'=>'Esqueci a Senha', 'content'=>'Email inválido ou não cadastrado!'));
	else
		$toScript = showModal(array('title'=>'Esqueci a Senha', 'content'=>'Sua nova senha foi enviada ao email <b>'.$val['email'].'</b>!'));
