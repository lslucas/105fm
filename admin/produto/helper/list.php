<?php

  /*
   *busca total de itens e faz variaveis de paginação
   */
  $sql_letras = "SELECT UPPER(LEFT({$var['pre']}_titulo, 1)) FROM ".TABLE_PREFIX."_{$var['table']} WHERE 1 GROUP BY LEFT({$var['pre']}_titulo, 1) ORDER BY {$var['pre']}_titulo";

  if($qry_letras = $conn->prepare($sql_letras)) {

    $qry_letras->execute();
    $qry_letras->bind_result($letra);

	$letras = "<div class='btn-group'>";
    if(!isset($_GET['letra']) || empty($_GET['letra'])) {
    $letras .= '<button class="btn btn-mini">All</button>';
    $countLetra = '';

    } else {
      $letras .= "<a class='btn btn-mini' href='?p={$var['path']}'>All</a>";
      $countLetra = ' with '.$_GET['letra'];
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
    $where.= " AND ${var['pre']}_titulo LIKE '".$_GET['letra']."%' ";
  }

  if( isset($_GET['q']) && !empty($_GET['q']) ) {
	$where.= " AND ( ";
	$where.= " ${var['pre']}_titulo LIKE '%".$_GET['q']."%' OR ";
  $where.= " ${var['pre']}_descricao LIKE '%".$_GET['q']."%' ";
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
$pag = null;
$n_paginas   = ceil($total_itens/$limit_end);
$pg_atual    = isset($_GET['pg']) && !empty($_GET['pg'])?$_GET['pg']:1;
$limit_stvid = ceil(($pg_atual-1)*$limit_end);

$qry_tot->close();


$orderby = !isset($_GET['orderby'])?$var['pre'].'_titulo ASC':urldecode($_GET['orderby']);


$sql = "SELECT pro.${var['pre']}_id,
		pro.${var['pre']}_code,
		fab.cat_titulo `fabricante`,
            gru.cat_titulo `grupoquimico`,
		pro.${var['pre']}_codigo,
		pro.${var['pre']}_titulo,
		DATE_FORMAT(pro.${var['pre']}_data, '%m/%d/%y'),
		pro.${var['pre']}_descricao,
            (SELECT usr_nome FROM ".TP."_usuario WHERE usr_id=pro.${var['pre']}_usr_id) `nome`,
            pro.${var['pre']}_valor,
            pro.${var['pre']}_valor_unidade,
            pro.${var['pre']}_qtd,
            pro.${var['pre']}_peso_unidade,
            pro.${var['pre']}_unidade_medida,
		pro.${var['pre']}_status
		FROM ".TABLE_PREFIX."_${var['table']} pro
		INNER JOIN ".TP."_categoria fab
			ON pro.{$var['pre']}_fabricante=fab.cat_id
			AND fab.cat_area='Fabricante'
            INNER JOIN ".TP."_categoria gru
                ON pro.{$var['pre']}_grupoquimico=gru.cat_id
                AND gru.cat_area='Grupo Quimico'
		{$join}
		$where
    ORDER BY $orderby

    LIMIT $limit_stvid,$limit_end
    ";

 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    $qry->execute();
    $qry->bind_result($id, $code, $fabricante, $grupoquimico, $codigo, $titulo, $date, $descricao, $nome, $valor, $valor_unidade, $qtd, $peso_unidade, $unidade_medida, $status);


    if($total_itens==0) $total = 'nenhum produto'.$countLetra;
    elseif ($total_itens==1) $total = "1 produto".$countLetra;
	else $total = $total_itens.' produtos'.$countLetra;

  }
