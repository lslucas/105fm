<?php

	$where = null;

	/*
	 *TOTALITENS + Paginação busca total de itens e faz variaveis de paginação
	 */
	$sql_tot = "SELECT NULL FROM ".TABLE_PREFIX."_${var['path']} $where";
	$qry_tot = $conn->query($sql_tot);
	$total_itens = $qry_tot->num_rows;
	$qry_tot->close();

	//variaveis auxiliares para paginação
	$limit_end   = 50;
	$n_paginas   = ceil($total_itens/$limit_end);
	$pg_atual    = isset($_GET['pg']) && !empty($_GET['pg'])?$_GET['pg']:1;
	$limit_start = ceil(($pg_atual-1)*$limit_end);



	/*
	 *ORDER BY da query principal
	 */
	$orderby = !isset($_GET['orderby'])?$var['pre'].'_timestamp DESC':urldecode($_GET['orderby']);


	/*
	 *QUERY PRINCIPAL, LISTAGEM DE VEICULOS
	 */
	$sql = "SELECT  ${var['pre']}_id,
			${var['pre']}_code,
			${var['pre']}_titulo,
			DATE_FORMAT(${var['pre']}_date_from, '%d/%m/%Y') dtfrom,
			DATE_FORMAT(${var['pre']}_date_to, '%d/%m/%Y') dtto,
			${var['pre']}_url,
			${var['pre']}_status,
			${var['pre']}_views,
			${var['pre']}_clicks,
			${var['pre']}_imagem

			FROM ".TABLE_PREFIX."_${var['path']}
			$where
			ORDER BY ".$orderby." LIMIT {$limit_start}, {$limit_end}";


	if (!$qry = $conn->prepare($sql)) {
	echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

	} else {

		$qry->execute();
		$qry->bind_result($id, $code, $titulo, $date_from, $date_to, $url, $status, $views, $clicks, $imagem);
		$qry->store_result();
		$num = $qry->num_rows;

		if ($total_itens==0) $total = 'Nenhum banner';
		elseif ($total_itens==1) $total = "1 banner";
		else $total = $total_itens.' banners';

	}
