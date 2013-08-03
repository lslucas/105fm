<?php
	/*
	 *Lista posts de acordo com configuração
	 */
            $list = array();
	$sql =  "SELECT
					not_id,
					not_titulo,
					DATE_FORMAT(not_data, '%d/%m/%Y') `data`
				FROM ".TP."_noticia
				WHERE not_status=1
                                            ORDER BY not_data DESC
			";
	 if (!$qry=$conn->prepare($sql))
		 echo "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qry->bind_result($id, $titulo, $data);
		$qry->execute();
		$qry->store_result();

		while ($qry->fetch()) {
                        $list[$id]['titulo'] = '<span class="data_especial">'.$data.'</span>&nbsp;&nbsp;&nbsp;&nbsp;'.$titulo;
                        $list[$id]['data'] = $data;
                        $list[$id]['link'] = ABSPATH.'noticia/' . $hashids->encrypt($id) . '/' .linkfySmart($titulo);
                      }


		$total = $qry->num_rows;
		$qry->close();

	}

