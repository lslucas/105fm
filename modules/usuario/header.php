<?php
	if (in_array($basename, array('registrar', 'login', 'esqueci-senha')) && (isset($usr) && !empty($usr['id'])))
		header('Location: '.ABSPATH.'painel');
	if (!in_array($basename, array('registrar', 'login', 'esqueci-senha')) && (!isset($usr) || empty($usr['id'])))
		header('Location: '.ABSPATH.'login');

	include_once 'modules/classes/usuario.php';

	$msg = $msgTitle = $res = null;
	$usuario = new Usuario();
	$val = array();

	$var['imagemWidth'] = 500;
	$var['imagemHeight'] = 400;
	$var['pathOriginal'] = 'public/images/logo/original';
	$var['pathImagem'] = 'public/images/logo';
	$var['imagemSizeTexto'] = "{$var['imagemWidth']}px por {$var['imagemHeight']}px";
	if ($basename=='meus-dados')
		$rowContentClass = 'registro-usuario';

	if(isset($_POST['from'])) {
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);
	}

	/**
	 * Cadastra usuário
	 */
	if ($basename=='registrar') {
		if(isset($val['from']) && $val['from']=='registrar')
			include_once 'registrar/insert.php';
	}

	/**
	 * Faz login
	 */
	if ($basename=='login') {
		if(isset($val['from']) && $val['from']=='login')
			include_once 'login/header.php';
	}

	/**
	 * Meus dados //edicao de usuário
	 */
	if ($basename=='meus-dados') {
		if(isset($val['from']) && $val['from']=='meus-dados')
			include_once 'registrar/update.php';
		else {
			if (!empty($querystring) && $querystring=='endereco-localidade') {
				include_once 'modules/classes/addressbook.php';
				$address = new AddressBook();

				$id = $address->getIdByUser($usr['id']);
				if (!empty($id))
					$val = $address->getBasicInfoById($id);
			} else
				$val = $usuario->getBasicInfoById($usr['id']);
			unset($val['email']);
		}
	}

	/**
	 * Fecha sessao
	 */
	if ($basename=='sair' || $basename=='logout')
		include_once 'logout/header.php';
