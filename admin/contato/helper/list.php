<?php

  /*
   *busca total de itens e faz variaveis de paginação
   */
  $sql_letras = "SELECT UPPER(LEFT({$var['pre']}_assunto, 1)) FROM ".TABLE_PREFIX."_{$var['table']} WHERE 1 GROUP BY LEFT({$var['pre']}_assunto, 1) ORDER BY {$var['pre']}_assunto";

  if($qry_letras = $conn->prepare($sql_letras)) {

    $qry_letras->execute();
    $qry_letras->bind_result($letra);

	$letras = "<div class='btn-group'>";
    if(!isset($_GET['letra']) || empty($_GET['letra'])) {
    $letras .= '<button class="btn btn-mini">Todos</button>';
    $countLetra = '';

    } else {
      $letras .= "<a class='btn btn-mini' href='?p={$var['path']}'>Todos</a>";
      $countLetra = ' com a letra '.$_GET['letra'];
    }


      while($qry_letras->fetch()) {
        if(!isset($_GET['letra']) || $letra<>$_GET['letra'])
	        $letras .= "<a class='btn btn-mini' href='?p={$var['path']}&letra=${letra}'>";
		else
	        $letras .= "<a class='btn btn-mini' href='javascript:void(0);'>";

        $letras .= $letra;
        $letras .= "</a>  ";
      }

    $letras = substr($letras, 0, -2);
    $qry_letras->close();

  }
  $letras .= "</div>";


  $where = ' WHERE 1';
  $join = null;
  if( isset($_GET['letra']) && !empty($_GET['letra']) ) {
    $where.= " AND ${var['pre']}_assunto LIKE '".$_GET['letra']."%' ";
  }

  if( isset($_GET['q']) && !empty($_GET['q']) ) {
	$where.= " AND ( ";
	$where.= " ${var['pre']}_mensagem LIKE '%".$_GET['q']."%' ";
      $where.= " OR ${var['pre']}_nome LIKE '%".$_GET['q']."%' ";
      $where.= " OR ${var['pre']}_email LIKE '%".$_GET['q']."%' ";
	$where.= ")";
  }

/*
*busca total de itens e faz variaveis de paginação
*/
$total_itens = 0;
$sql_tot = "SELECT NULL FROM ".TABLE_PREFIX."_${var['table']} {$join} $where";
$qry_tot = $conn->query($sql_tot);
$total_itens = $qry_tot->num_rows;
$limit_end   = 30;
$n_paginas   = ceil($total_itens/$limit_end);
$pg_atual    = isset($_GET['pg']) && !empty($_GET['pg'])?$_GET['pg']:1;
$limit_start = ceil(($pg_atual-1)*$limit_end);

$qry_tot->close();


$orderby = !isset($_GET['orderby'])?$var['pre'].'_timestamp DESC':urldecode($_GET['orderby']);


$sql = "SELECT  ${var['pre']}_id,
           ${var['pre']}_assunto,
           ${var['pre']}_nome,
           ${var['pre']}_email,
           ${var['pre']}_cidade,
           ${var['pre']}_estado,
           ${var['pre']}_mensagem,
		${var['pre']}_status,
            DATE_FORMAT(${var['pre']}_timestamp, '%d/%m/%y %H:%i')

		FROM ".TABLE_PREFIX."_${var['table']}
		{$join}
		$where
    ORDER BY ${var['pre']}_status ASC, $orderby

    LIMIT $limit_start,$limit_end
    ";
 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    $qry->execute();
    $qry->bind_result($id, $assunto, $nome, $email, $cidade, $estado, $mensagem, $status, $datahora);

    if($total_itens==0) $total = 'Nenhuma mensagem'.$countLetra;
    elseif ($total_itens==1) $total = "1 mensagem".$countLetra;
    else $total = $total_itens.' mensagens'.$countLetra;

  }