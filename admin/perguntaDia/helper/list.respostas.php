<?php

/*
*busca total de itens e faz variaveis de paginação
*/
$where = $join = null;
$total_itens = 0;
$sql_tot = "SELECT NULL FROM ".TABLE_PREFIX."_${var['table']}_votos {$join} $where";
$qry_tot = $conn->query($sql_tot);
$total_itens = $qry_tot->num_rows;
$limit_end   = 30;
$n_paginas   = ceil($total_itens/$limit_end);
$pg_atual    = isset($_GET['pg']) && !empty($_GET['pg'])?$_GET['pg']:1;
$limit_start = ceil(($pg_atual-1)*$limit_end);

$qry_tot->close();


$orderby = !isset($_GET['orderby'])?$var['pre'].'_titulo ASC':urldecode($_GET['orderby']);


$sql = "SELECT  pdi_id,
                         resposta,
              		ip,
              		DATE_FORMAT(timestamp, '%d/%m/%Y %H:%i')

		FROM ".TABLE_PREFIX."_${var['table']}_votos
		{$join}
		$where
    ORDER BY timestamp DESC

    LIMIT $limit_start,$limit_end
    ";
 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    $qry->execute();
    $qry->bind_result($id, $resposta, $ip, $timestamp);

    if($total_itens==0) $total = 'Nenhuma resposta';
    elseif ($total_itens==1) $total = "1 resposta";
    else $total = $total_itens.' respostas';

  }