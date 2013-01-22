<?php

if (isset($_FILES)) {

	include_once "_inc/class.upload.php";
	$sqlImagem = '';
	$w=$pos=0;


   	$sql_rmod = "DELETE FROM ".TP."_taxonomy WHERE tax_idrel=?";
	if (!$qry_rmod = $conn->prepare($sql_rmod))
		echo $conn->error;
	else {
		$qry_rmod->bind_param('i',$res['item']);
		$qry_rmod->execute();
		$qry_rmod->close();
	}


	/*
	$sql_smod = "SELECT tax_pos FROM ".TABLE_PREFIX."_taxonomy WHERE tax_idrel=? ORDER BY tax_pos DESC LIMIT 1";
	if (!$qry_smod = $conn->prepare($sql_smod))
		echo $conn->error;
	else {
		$qry_smod->bind_param('i',$res['item']);
		$qry_smod->execute();
		$qry_smod->bind_result($pos);
		$qry_smod->fetch();
		$qry_smod->close();
		$pos = ($pos!==0)?$pos=$pos+1:$pos;
	}
	 */


       $sql= "INSERT INTO ".TP."_taxonomy
			    (tax_idrel,
			     tax_area,
			     tax_tipo,
			     tax_file,
			     tax_pos
			     ) VALUES (?, ?, ?, ?, ?)";
       $qry=$conn->prepare($sql);
       $qry->store_result();

	for ($i=0; $i<=count($_FILES); $i++) {

		if (isset($_FILES['galeria'.$i]['name']) && is_file($_FILES['galeria'.$i]['tmp_name']) ) {

			$name = (string)$_FILES['galeria'.$i]['name'];
			$ext = file_extension($name);
			$name = str_replace('.'.$ext, null, $name);

			$filename = linkfy($res['item'].'-'.$name);
			$handle = new Upload($_FILES['galeria'.$i]);

			if ($handle->uploaded) {
				$handle->file_new_name_body  = $filename;
				if (isset($var['path_original']) || isset($var['imagemHeight'])) {
					$handle->Process($var['path_original']);
					if (!$handle->processed) echo 'error : ' . $handle->error;
				}

				if (isset($var['imagemWidth']) || isset($var['imagemHeight'])) {
					// if ($handle->image_x>$var['imagemWidth'] || $handle->image_y>$var['imagemHeight']) {}
					$handle->image_resize            = true;
					$handle->image_ratio          = true;
					// $handle->image_ratio_crop     = true;
					$handle->image_ratio_no_zoom_out = true;
					if (isset($var['imagemWidth']))
						$handle->image_x                 = $var['imagemWidth'];
					if (isset($var['imagemHeight']))
					$handle->image_y                 = $var['imagemHeight'];
					$handle->jpeg_quality            = 90;
					$handle->process($var['path_imagem']);
					if (!$handle->processed) echo 'error : ' . $handle->error;
				}

				if (isset($var['thumbWidth']) || isset($var['thumbHeight'])) {
					$handle->file_new_name_body  = $filename;
					$handle->image_resize        = true;
					$handle->image_ratio_crop    = true;
					$handle->image_ratio_fill = true;
					if (isset($var['thumbWidth']))
						$handle->image_x             = $var['thumbWidth'];
					if (isset($var['thumbHeight']))
						$handle->image_y             = $var['thumbHeight'];
					$handle->jpeg_quality        = 70;
					$handle->process($var['path_thumb']);
					if (!$handle->processed) echo 'error : ' . $handle->error;
				}

				if (isset($var['listWidth']) || isset($var['listHeight'])) {
					$handle->file_new_name_body  = $filename;
					$handle->image_resize        = true;
					$handle->image_ratio_crop    = true;
					$handle->image_ratio_fill = true;
					if (isset($var['listWidth']))
						$handle->image_x = $var['listWidth'];
					if (isset($var['listWidth']))
						$handle->image_y = $var['listHeight'];
					$handle->jpeg_quality        = 90;
					$handle->process($var['path_list']);
					if (!$handle->processed) echo 'error : ' . $handle->error;
				}

				$imagem = $handle->file_dst_name;

				$area = $var['path'];
				$tipo = 'Imagem';
				$qry->bind_param('isssi', $res['item'], $area, $tipo, $imagem, $pos);
				$qry->execute();
			}
		}

		$pos++;
	}

	$qry->close();

}