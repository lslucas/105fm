<?php

$rp = '../';
include_once $rp.'_inc/global.php';
include_once $rp.'_inc/db.php';
include_once $rp.'_inc/global_function.php';
include_once $rp.'_inc/Excel/reader.php';

	$excel = new Spreadsheet_Excel_Reader();
	$excel->read('cat.xls');
	$lstCatIdByTitulo = getCategoriaIdByTitulo();


	$x=1;
	$cat=$list=$grupo=$fabricante=array();
	while($x<=$excel->sheets[0]['numRows']) {
		if (isset($excel->sheets[0]['cells'][$x][1]) && !empty($excel->sheets[0]['cells'][$x][1])) {

			$col1 = isset($excel->sheets[0]['cells'][$x][1]) ? $excel->sheets[0]['cells'][$x][1] : null;
			$col1 = strip_tags(utf8_encode($col1));

			$col2 = isset($excel->sheets[0]['cells'][$x][2]) ? $excel->sheets[0]['cells'][$x][2] : null;
			$col2 = strip_tags(utf8_encode($col2));

			$col3 = isset($excel->sheets[0]['cells'][$x][3]) ? $excel->sheets[0]['cells'][$x][3] : null;
			$col3 = strip_tags(utf8_encode($col3));

			$list[$x]['produto'] = $col1;
			$list[$x]['fabricante'] = $col2;
			$list[$x]['grupo'] = $col3;

			// array_push($fabricante, $col2);
			array_push($grupo, $col3);
		}
		/*
		  while($y<=$excel->sheets[0]['numCols']) {
			$cell = isset($excel->sheets[0]['cells'][$x][$y]) ? $excel->sheets[0]['cells'][$x][$y] : '';
			$y++;
		  }
		 */
      $x++;
	}

	$grupo = array_unique($grupo);
	sort($grupo);
	$fabricante = array_unique($fabricante);
	sort($fabricante);
	unset($fabricante[100], $fabricante[129]);

	/**
	 * Categorias
	 */
	$cat['Grupo Quimico'] = $grupo;
	$cat['Fabricante'] = $fabricante;
	// echo "<h3>Categorias</h3>";
	// include 'categoria.php';

	echo "<h3>Produtos</h3>";
	include 'produto.php';
