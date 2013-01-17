<?php

	foreach($_POST as $chave=>$valor)
		$res[$chave] = $valor;

	//include de mensagens do arquivo atual
	include_once 'inc.exec.msg.php';
	//autoinsert
	include_once $rp.'inc.autoinsert.php';

	$qry=false;
	$sql= "UPDATE ".TABLE_PREFIX."_${var['path']} SET
		  ${var['pre']}_area=?,
		  ${var['pre']}_titulo=?,
		  ${var['pre']}_date_from=?,
		  ${var['pre']}_date_to=?,
		  ${var['pre']}_url=?
	";
	$sql.=" WHERE ${var['pre']}_id=?";

	if (!$qry=$conn->prepare($sql))
		 echo $conn->error;

	else {

		$res['date_from']  = datept2en('/', $res['date_from']);
		$res['date_to']  = datept2en('/', $res['date_to']);
		$qry->bind_param('sssssi',
			 $res['area'],
			 $res['titulo'],
			 $res['date_from'],
			 $res['date_to'],
			 $res['url'],
			 $res['item']);

		$qry->execute();
		$qry->close();

		if ($act=='update')
			$code = $res['code'];
		else
			$code = saveTableCode($var, $res['item'], $res['titulo']);

		//insere as fotos/galeria do artigo e opcionais
		include_once 'helper/exec.galeria.php';
		echo $msgSucesso;

	}


	//mostra listagem de carros
	include_once 'list.php';