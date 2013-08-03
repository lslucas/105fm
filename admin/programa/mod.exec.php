<?php

  foreach($_POST as $chave=>$valor) {
    if (!is_array($valor))
     $res[$chave] = trim($valor);
  }


# include de mensagens do arquivo atual
include_once 'inc.exec.msg.php';

 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_titulo retorno FROM ".TABLE_PREFIX."_${var['table']} WHERE ${var['pre']}_titulo=? AND ${var['pre']}_apresentacao=? ";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('ss', $res['titulo'], $res['data']);
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

     $sql= "UPDATE ".TABLE_PREFIX."_${var['table']} SET
  		  ${var['pre']}_titulo=?,
  		  ${var['pre']}_texto=?,
  		  ${var['pre']}_apresentacao=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
	 if (!$qry=$conn->prepare($sql))
		 echo divAlert($conn->error);

	 else {

		$qry->bind_param('sssi',
			$res['titulo'],
			$res['texto'],
			$res['apresentacao'],
			$res['item']
		);
		$qry->execute();
		$qry->close();


          include_once 'helper/exec.semana.php';
          echo $msgSucesso;

		//listagem
           include_once 'list.php';
	 }

 }

