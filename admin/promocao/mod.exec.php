<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = trim($valor);
  }


# include de mensagens do arquivo atual
include_once 'inc.exec.msg.php';
$res['data_inicio']      = datept2en('/', $res['data_inicio']);
$res['data_termino']  = datept2en('/', $res['data_termino']);


 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_titulo retorno FROM ".TABLE_PREFIX."_${var['table']} WHERE ${var['pre']}_titulo=? AND ${var['pre']}_data_inicio=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('ss', $res['titulo'], $res['data_inicio']);
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
                            ${var['pre']}_linhafina=?,
                            ${var['pre']}_data_inicio=?,
                            ${var['pre']}_data_termino=?,
                            ${var['pre']}_ganhadores=?,
                            ${var['pre']}_enviar_texto=?,
                            ${var['pre']}_enviar_arquivo=?,
                            ${var['pre']}_descricao=?";
     $sql.=" WHERE ${var['pre']}_id=?";
	 if (!$qry=$conn->prepare($sql))
		 echo divAlert($conn->error);

	 else {

		$qry->bind_param('sssssiisi',
			$res['titulo'],
			$res['linhafina'],
			$res['data_inicio'],
			$res['data_termino'],
			$res['ganhadores'],
                                    $res['enviar_texto'],
                                    $res['enviar_arquivo'],
                                    $res['descricao'],
			$res['item']
		);
		$qry->execute();
		$qry->close();


		if ($act=='update')
			$code = $res['code'];
		else
			$code = saveTableCode($var, $res['item'], $res['titulo']);

          include_once 'helper/exec.galeria.php';
          echo $msgSucesso;

		//listagem
		include_once 'list.php';
	 }

 }

