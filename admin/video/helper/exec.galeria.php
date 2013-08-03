<?php
if (isset($res['youtube']) && !empty($res['youtube'])) {

	include_once "_inc/class.upload.php";
	$sqlImagem = '';
	$w=$pos=0;

	/*
	 *REMOVE ANTIGAS
	 */
	$sql_dmod = "DELETE FROM ".TABLE_PREFIX."_{$var['path']}_galeria WHERE rvg_vid_id=?";
	$qry_dmod = $conn->prepare($sql_dmod);
	$qry_dmod->bind_param('i', $res['item']);
	$qry_dmod->execute();
	$qry_dmod->close();

	/*
	     $folder = explode(',',$var['imagem_folderlist']);
	     for($j=0;$j<count($folder);$j++) {
			$arquivo = $folder[$j].'/'.$imgold;

			if (!empty($folder[$j]) && is_file($arquivo))
				unlink($arquivo);
		 }
		  */

	// QUERY PARA INSERIR
	$sql= "INSERT INTO ".TABLE_PREFIX."_${var['table']}_galeria

			    (rvg_${var['pre']}_id,
			     rvg_imagem,
			     rvg_pos
			     )
			    VALUES
			    (?,
			     ?,
			     ?)";
	$qry=$conn->prepare($sql);
	$qry->store_result();

	$videoid = getYoutubeVideoId($res['youtube']);
	$filename=$code.'-'.$videoid;
	$file= "http://img.youtube.com/vi/{$videoid}/hqdefault.jpg";

	list($width, $height) = getimagesize($file);
	$image_p = imagecreatetruecolor($width, $height);
	$image = imagecreatefromjpeg($file);
	imagecopyresampled($image_p, $image, 0, 0, 0, 0, $width, $height, $width, $height);
	imagejpeg($image_p, $var['path_original'].'/'.$filename.'.jpg', 100);
	imagedestroy($image_p);

	$handle = new Upload($var['path_original'].'/'.$filename.'.jpg');

	// then we check if the file has been uploaded properly
	// in its *temporary* location in the server (often, it is /tmp)
	if ($handle->uploaded) {
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

		$imagem = $handle->file_dst_name;

		$qry->bind_param('isi', $res['item'], $imagem, $pos);
		$qry->execute();
		$qry->close();
	} else
		echo "problems";




}