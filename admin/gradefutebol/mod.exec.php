<?php

foreach($_POST as $chave=>$valor) {
	$res[$chave] = $valor;
}

$res['data'] = datept2en('/', $res['data']);

# include de mensagens do arquivo atual
include_once 'inc.exec.msg.php';

     #autoinsert
     include_once $rp.'inc.autoinsert.php';

     $sql= "UPDATE ".TABLE_PREFIX."_${var['table']} SET
  		  ${var['pre']}_times=?,
                        ${var['pre']}_horario=?,
  		  ${var['pre']}_data=?,
                        ${var['pre']}_apresentador=?
	";
     $sql.=" WHERE ${var['pre']}_id=?";
	 if (!$qry=$conn->prepare($sql))
		 echo divAlert($conn->error);

	 else {

	 	// $res['texto'] = txt_bbcode($res['texto']);
		$qry->bind_param('ssssi',
                                 $res['times'],
			$res['horario'],
			$res['data'],
                                 $res['apresentador'],
			$res['item']
		);
		$qry->execute();
		$qry->close();

		echo $msgSucesso;

		//insere fotos
		// include_once 'helper/exec.galeria.php';

		//listagem
		include_once 'list.php';
	 }
