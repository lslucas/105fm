<?php

	if ($querystring=='endereco-localidade') {
		include_once 'modules/classes/addressbook.php';
		$address = new AddressBook();

		if ($address->addressExists($val['cep']))
			$res = $address->atualizaCadastro($val);
		else
			$res = $address->novoCadastro($val);

	} else {
		$res = $usuario->atualizaCadastro($val);
	}

	/**
	 *Se não houve erro redireciona usuario logado ao painel dele
	 */
	if (!isset($res['error']))
		header('Location: '.ABSPATH.'painel');
