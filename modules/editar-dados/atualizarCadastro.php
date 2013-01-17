<?php

	include_once 'modules/classes/mail.php';

	$res = $cadastro->atualizaCadastro($val);

	/**
	 * Se cupom foi gerado entra
	 */
	if (!isset($res['error']) && !isset($res['alert']))
		header('Location: '.ABSPATH.'meus-numeros');
		// $toScript = showModal(array('title'=>'Sucesso!', 'content'=>'Dados atualizados com êxito!'));
