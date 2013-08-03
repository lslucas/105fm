<?php

if (isset($_FILES)) {

	include_once "_inc/class.upload.php";
	$sqlImagem = '';
	$w=$pos=0;

	if (isset($_FILES['mp3']['name']) && is_file($_FILES['mp3']['tmp_name']) ) {

		if (isset($res['item'])) {

			/*
			 *REMOVE ANTIGAS
			 */
			$sql_imod = "SELECT rmm_media FROM ".TABLE_PREFIX."_{$var['path']}_media WHERE rmm_mus_id=?";
			$qry_imod = $conn->prepare($sql_imod);
			$qry_imod->bind_param('i', $res['item']);
			$qry_imod->bind_result($imgold);
			$qry_imod->execute();
			$qry_imod->close();

			/*
			 *REMOVE ANTIGAS
			 */
			$sql_dmod = "DELETE FROM ".TABLE_PREFIX."_{$var['path']}_media WHERE rmm_mus_id=?";
			$qry_dmod = $conn->prepare($sql_dmod);
			$qry_dmod->bind_param('i', $res['item']);
			$qry_dmod->execute();
			$qry_dmod->close();

			     $folder = array($var['path_media']);
			     for($j=0;$j<count($folder);$j++) {
					$arquivo = $folder[$j].'/'.$imgold;

					if (!empty($folder[$j]) && is_file($arquivo))
						unlink($arquivo);
				 }
		}

		// QUERY PARA INSERIR
		$sql = "INSERT INTO ".TABLE_PREFIX."_${var['table']}_media

			    (rmm_${var['pre']}_id,
			     rmm_media
			     )
			    VALUES
			    (?,
			     ?)";
		$qry=$conn->prepare($sql);
		$qry->store_result();

			 $filename = linkfySmart($res['titulo'].' '.$res['album'].' '.$code);
			 $handle = new Upload($_FILES['mp3']);

			if ($handle->uploaded) {
				$handle->file_new_name_body  = $filename;
				$handle->Process($var['path_media']);
				if (!$handle->processed) echo 'error : ' . $handle->error;

				$mp3 = $handle->file_dst_name;


				$qry->bind_param('is', $res['item'], $mp3);
				$qry->execute();
				$qry->close();
			}

	}
}