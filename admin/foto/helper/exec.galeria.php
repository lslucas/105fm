<?php

if (isset($_FILES)) {

  include_once "_inc/class.upload.php";
   $sqlImagem = '';
   $w=$pos=0;


   $sql_smod = "SELECT rfg_pos FROM ".TABLE_PREFIX."_${var['table']}_galeria WHERE rfg_${var['pre']}_id=? ORDER BY rfg_pos DESC LIMIT 1";
   $qry_smod = $conn->prepare($sql_smod);
   $qry_smod->bind_param('i',$res['item']);
   $qry_smod->execute();
   $qry_smod->bind_result($pos);
   $qry_smod->fetch();
   $qry_smod->close();
   $pos = ($pos!==0)?$pos=$pos+1:$pos;



       $sql= "INSERT INTO ".TABLE_PREFIX."_${var['table']}_galeria

		    (rfg_${var['pre']}_id,
		     rfg_imagem,
		     rfg_legenda,
		     rfg_pos
		     )
		    VALUES
		    (?, ?, ?, ?)";
       $qry=$conn->prepare($sql);
       $qry->store_result();



	for ($i=0;$i<=count($_FILES);$i++) {

		if (isset($_FILES['galeria'.$i]['name']) && is_file($_FILES['galeria'.$i]['tmp_name']) ) {


			$legenda = trim($_POST['legenda'.$i]);
			$filename = $res['item'].'_'.rand();
			$handle = new Upload($_FILES['galeria'.$i]);

			if ($handle->uploaded) {
				$handle->file_new_name_body  = $filename;
				$handle->Process($var['path_original']);
				#$handle->jpeg_quality        = 90;
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
				$handle->jpeg_quality        = 70;
				$handle->process($var['path_thumb']);
				if (!$handle->processed) echo 'error : ' . $handle->error;

				$imagem = $handle->file_dst_name;


			 $qry->bind_param('issi', $res['item'], $imagem, $legenda, $pos);
			 $qry->execute();
			}
		}

		$pos++;
	}



   $qry->close();


 }