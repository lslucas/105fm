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
     include_once $rp.'inc.autoinsert.php';

     $sql= "UPDATE ".TP."_${var['table']} SET
     		${var['pre']}_nome=?,
     		${var['pre']}_email=?,
     		${var['pre']}_rg=?,
     		${var['pre']}_cpf=?,
     		${var['pre']}_cnpj=?,
     		${var['pre']}_inscricao_estadual=?,
     		${var['pre']}_contato=?,
     		${var['pre']}_telefone1=?,
     		${var['pre']}_telefone2=?,
     		${var['pre']}_ref1=?,
     		${var['pre']}_ref2=?,
     		${var['pre']}_ref3=?,
     		${var['pre']}_refbancaria1=?,
     		${var['pre']}_refbancaria2=?
     		";
     $sql.=" WHERE ${var['pre']}_id=?";
	 if (!$qry=$conn->prepare($sql))
		 echo divAlert($conn->error);

	 else {

		$qry->bind_param('ssssssssssssssi',
			$res['nome'],
			$res['email'],
			$res['rg'],
			$res['cpf'],
			$res['cnpj'],
			$res['inscricao_estadual'],
			$res['contato'],
			$res['telefone1'],
			$res['telefone2'],
			$res['ref1'],
			$res['ref2'],
			$res['ref3'],
			$res['refbancaria1'],
			$res['refbancaria2'],
			$res['item']
		);
		$qry->execute();
		$qry->close();

		// include_once 'helper/exec.taxonomy.php';//taxonomy

		//list
		include_once 'list.php';
	 }

 }