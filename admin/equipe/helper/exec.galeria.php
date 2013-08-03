<?php
 if (isset($_FILES) && isset($_FILES['midia']['name']) && is_file($_FILES['midia']['tmp_name'])) {

  include_once "_inc/class.upload.php";
   $sqlImagem = '';
   $w=$pos=0;

	//remove imagem se existir
	$res['pre'] = $var['pre'];
	$res['col'] = 'id';
	$res['prefix'] = $var['table'];
	include_once 'del.galeria.php';

	$sql= "UPDATE ".TABLE_PREFIX."_${var['table']} SET {$var['pre']}_imagem=? WHERE {$var['pre']}_id=?";

	if (!$qry=$conn->prepare($sql))
		echo $conn->error;

	else {


		if (isset($_FILES['midia']['name']) && is_file($_FILES['midia']['tmp_name']) ) {

			$type = @file_extension($_FILES['midia']['name']);
			$filename = linkfySmart(str_replace($type, '', $_FILES['midia']['name']));
			$filename = $res['item'].'-'.$filename.'_'.rand();
			$handle = new Upload($_FILES['midia']);

			if ($handle->uploaded) {
				$handle->file_new_name_body  = $filename;
				$handle->Process($var['path_original']);
				if (!$handle->processed) echo 'error : ' . $handle->error;

				$handle->file_new_name_body  = $filename;
				$handle->image_resize        = true;
				#$handle->image_ratio_x        = true;
				$handle->image_ratio_crop    = true;
				$handle->image_x             = $var['imagemWidth'];
				$handle->image_y             = $var['imagemHeight'];
				$handle->jpeg_quality        = 90;
				$handle->process($var['path_imagem']);
				if (!$handle->processed) echo 'error : ' . $handle->error;

				$handle->file_new_name_body  = $filename;
				$handle->image_resize        = true;
				#$handle->image_ratio_x        = true;
				$handle->image_ratio_crop    = true;
				$handle->image_x             = $var['thumbWidth'];
				$handle->image_y             = $var['thumbHeight'];
				$handle->jpeg_quality        = 90;
				$handle->process($var['path_thumb']);
				if (!$handle->processed) echo 'error : ' . $handle->error;
			}

			$imagem = $handle->file_dst_name;

			$qry->bind_param('si', $imagem, $res['item']);
			$qry->execute();
			$qry->close();

		}

	}

 }