<?php

	foreach($_POST as $chave=>$valor) {
	 $res[$chave] = $valor;
	}

	# include de mensagens do arquivo atual
	include_once 'inc.exec.msg.php';

	## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
	$sql_valida = "SELECT ${var['pre']}_email retorno FROM ".TABLE_PREFIX."_${var['table']} WHERE ${var['pre']}_email=?";
	$qry_valida = $conn->prepare($sql_valida);
	$qry_valida->bind_param('s', $res['email']);
	$qry_valida->execute();
	$qry_valida->store_result();

	#se existe um titulo/nome/email assim nao passa
	if ($qry_valida->num_rows<>0 && $act=='insert') {
	 echo $msgDuplicado;
	 $qry_valida->close();


	#se nao existe faz a inserção
	} else {

	#autoinsert
	include $rp.'inc.autoinsert.php';

	$sql= "UPDATE ".TP."_${var['table']} SET
				${var['pre']}_nome=?,
				${var['pre']}_email=?,
				${var['pre']}_cpf=?,
				${var['pre']}_cnpj=?,
				${var['pre']}_nome_fantasia=?,
				${var['pre']}_inscricao_estadual=?,
				${var['pre']}_contato=?,
				${var['pre']}_telefone1=?,
				${var['pre']}_telefone2=?";
	$sql.=" WHERE ${var['pre']}_id=?";
	if (!$qry=$conn->prepare($sql))
		 echo divAlert($conn->error);

	else {

		$qry->bind_param('sssssssssi',
			$res['nome'],
			$res['email'],
			$res['cpf'],
			$res['cnpj'],
			$res['nome_fantasia'],
			$res['inscricao_estadual'],
			$res['contato'],
			$res['telefone1'],
			$res['telefone2'],
			$res['item']
		);
		$qry->execute();
		$qry->close();

		/**
		 * Se foi preenchido a senha
		 */
		if (!empty($res['senha'])) {
			$senhaEncrypted = $aes->encrypt($res['senha']);
			$sqlpass = "UPDATE `".TP."_usuario` SET `usr_senha`=? WHERE `usr_id`=?";
			if (!$qrypass = $conn->prepare($sqlpass))
				return false;
			else {
				$qrypass->bind_param('si', $senhaEncrypted, $res['item']);
				$qrypass->execute();
				$qrypass->close();
			}

		}


		include_once 'helper/exec.galeria.php';//taxonomy
		/**
		 * Addressbook
		 */
		$var['_path'] = $var['_table'] = $var['path'];
		$var['_pre'] = $var['pre'];
		$var['path'] = $var['table'] = 'address_book';
		$var['pre'] = 'adb';
		$usr_id = $res['item'];

		if (isset($res['adb_id']) && !empty($res['adb_id']))
			$item = $res['adb_id'];
		else {
			unset($res['item'], $_POST['item']);
			$res['force_insert'] = true;
		}

		include $rp.'inc.autoinsert.php';

		if (!isset($item))
			$item = $res['item'];

		$sql= "UPDATE ".TP."_${var['table']} SET
					${var['pre']}_usr_id=?,
					${var['pre']}_tipo=?,
					${var['pre']}_endereco=?,
					${var['pre']}_complemento=?,
					${var['pre']}_cep=?,
					${var['pre']}_cidade=?,
					${var['pre']}_uf=?
					";
		$sql.=" WHERE ${var['pre']}_id=?";
		if (!$qry=$conn->prepare($sql))
			 echo divAlert($conn->error);

		else {

			$qry->bind_param('issssssi',
				$usr_id,
				$res['tipo'],
				$res['endereco'],
				$res['complemento'],
				$res['cep'],
				$res['cidade'],
				$res['uf'],
				$item
			);
			$qry->execute();
			$qry->close();
		}

		$var['path'] = $var['table'] = $var['_path'];
		$var['pre'] = $var['_pre'];

		include_once 'helper/exec.email.php';

		//list
		include_once 'list.php';
	 }

 }