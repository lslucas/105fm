<?php

foreach($_POST as $chave=>$valor) {
	$res[$chave] = $valor;
}

$res['data'] = datept2en('/', $res['data']);

# include de mensagens do arquivo atual
include_once 'inc.exec.msg.php';

## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
$sql_valida = "SELECT ${var['pre']}_titulo retorno FROM ".TABLE_PREFIX."_${var['table']} WHERE ${var['pre']}_titulo=? AND ${var['pre']}_data=?";
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
  		  ${var['pre']}_data=?,
                        ${var['pre']}_res1=?,
                        ${var['pre']}_res2=?,
                        ${var['pre']}_res3=?,
                        ${var['pre']}_res4=?,
                        ${var['pre']}_res5=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
	 if (!$qry=$conn->prepare($sql))
		 echo divAlert($conn->error);

	 else {

	 	// $res['texto'] = txt_bbcode($res['texto']);
		$qry->bind_param('sssssssi',
                                 $res['titulo'],
			$res['data'],
			$res['res1'],
                                 $res['res2'],
                                 $res['res3'],
                                 $res['res4'],
                                 $res['res5'],
			$res['item']
		);
		$qry->execute();
		$qry->close();

		echo $msgSucesso;

		//listagem
		include_once 'list.php';
	 }

 }

