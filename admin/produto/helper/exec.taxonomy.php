<?php

/**
 * Apaga outros taxonomy já existentes
 * @var string
 */
$sqldel = "DELETE FROM ".TABLE_PREFIX."_${var['table']}_taxonomy WHERE pro_id=?";
$qrydel =$conn->prepare($sqldel);
$qrydel->bind_param('i', $res['item']);
$qrydel->execute();
$qrydel->close();

/**
 * Insere novos taxonomy
 * @var array
 */
$lstTaxonomy = array('produtosRelacionados');
foreach ($lstTaxonomy as $taxonomy) {

	if (isset($_POST[$taxonomy])) {

		$sql= "INSERT INTO ".TABLE_PREFIX."_${var['table']}_taxonomy
				(
					pro_id,
					cat_id,
					area
				)
				VALUES (?, ?, ?)";
		$qry=$conn->prepare($sql);
		$qry->store_result();

		for ($i=0; $i<=count($_POST[$taxonomy]); $i++) {

			$cat_id = isset($_POST[$taxonomy][$i]) ? $_POST[$taxonomy][$i] : null;
			if (!empty($cat_id)) {
				$qry->bind_param('iis', $res['item'], $cat_id, $taxonomy);
				$qry->execute();
			}

		}

	   $qry->close();

	 }
}