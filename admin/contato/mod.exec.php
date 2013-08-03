<?php

foreach($_POST as $chave=>$valor) {
	$res[$chave] = $valor;
}

# include de mensagens do arquivo atual
include_once 'inc.exec.msg.php';

$sql= "UPDATE ".TABLE_PREFIX."_${var['table']} SET
		  ${var['pre']}_resposta=?,
                  ${var['pre']}_status=1
";
 $sql.=" WHERE ${var['pre']}_id=?";
 if (!$qry=$conn->prepare($sql))
	 echo divAlert($conn->error);

 else {

 	// $res['texto'] = txt_bbcode($res['texto']);
	$qry->bind_param('si',
		$res['texto'],
		$res['item']
	);
	$qry->execute();
	$qry->close();

	echo $msgSucesso;

	//notifica email
                  $assunto = nomeCategoriaContato($res['assunto']);
	include_once 'helper/exec.sendmail.php';

	//listagem
	include_once 'list.php';
 }

