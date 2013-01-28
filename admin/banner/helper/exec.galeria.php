<?php
 if (isset($_FILES)) {

  include_once "_inc/class.upload.php";
   $sqlImagem = '';
   $w=$pos=0;

	//remove imagem se existir
	$res['pre'] = $var['pre'];
	$res['col'] = 'id';
	$res['prefix'] = $var['table'];
	include_once 'del.galeria.php';

	$sql= "UPDATE ".TABLE_PREFIX."_${var['table']}
				SET {$var['pre']}_imagem=?, {$var['pre']}_type=? WHERE {$var['pre']}_id=?";

	if (!$qry=$conn->prepare($sql))
		echo $conn->error;

	else {


		if (isset($_FILES['midia']['name']) && is_file($_FILES['midia']['tmp_name']) ) {

			$type = @file_extension($_FILES['midia']['name']);
			$filename = linkfySmart(str_replace($type, '', $_FILES['midia']['name']));
			$filename = $code.'-'.$filename.'_'.rand();
			$handle = new Upload($_FILES['midia']);

			if ($handle->image_src_type) {

				if ($handle->uploaded) {
					$handle->file_new_name_body  = $filename;
					$handle->Process($var['path_original']);
					if (!$handle->processed) echo 'error : ' . $handle->error;

					$handle->file_new_name_body  = $filename;
					$handle->image_resize        = true;
					#$handle->image_ratio_x        = true;
					$handle->image_ratio_crop    = true;

					if ($res['area']=='Topo') {
						$handle->image_x             = $var['topoWidth'];
						$handle->image_y             = $var['topoHeight'];
					} elseif (in_array($res['area'], array('Lateral 1', 'Lateral 2'))) {
						$handle->image_x             = $var['lateralWidth'];
						$handle->image_y             = $var['lateralHeight'];
					} else {
						$handle->image_x             = $var['homeWidth'];
						$handle->image_y             = $var['homeHeight'];
					}
					$handle->process($var['path_imagem']);
					if (!$handle->processed) echo 'error : ' . $handle->error;

				}

			} else {

				if ($handle->uploaded) {
					$handle->file_new_name_body = $filename;
					$handle->Process($var['path_imagem']);
					if (!$handle->processed) echo 'error : ' . $handle->error;
				}
			}


			$imagem = $handle->file_dst_name;

			$qry->bind_param('ssi', $imagem, $type, $res['item']);
			$qry->execute();
			$qry->close();


		}

	}

 }
