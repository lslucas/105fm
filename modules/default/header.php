<?php
	if (isset($_GET['sessao-expirada']))
		$toScript = showModal(array('title'=>'Ops', 'content'=>"Sua sessão expirou! Faça login novamente."));
	if (isset($_GET['acesso-restrito']))
		$toScript = showModal(array('title'=>'Acesso Restrito', 'content'=>"Para acessar essa area você precisa estar registrado e logado! <br/>Faça o <a href='".ABSPATH."login'>login</a> ou <a href='".ABSPATH."registrar'>registre-se</a>.<br/><br/>Dúvidas? Entre em contato com <a href='mailto:".EMAIL_CONTACT."'>".EMAIL_CONTACT."</a>"));

	/*
	 *QUERY DESTAQUE
	 */
	$destaque = array();
	$sqls =  "
		SELECT
			des_id,
			des_descricao,
			des_link,
			(SELECT rdg_imagem FROM ".TP."_r_destaque_galeria WHERE rdg_des_id=des_id LIMIT 1) imagem

			FROM ".TP."_destaque
				WHERE
					des_status=1
					AND des_data<=DATE(NOW())
			ORDER BY des_data DESC
			";
	 if (!$qrys=$conn->prepare($sqls))
		 $incMsg .= "<div class='alert alert-error'>".$conn->error."</div>";

	 else {

		$qrys->bind_result(
		 $id,
		 $descricao,
		 $link,
		 $imagem
		);
		$qrys->execute();
		$qrys->store_result();

		$i=0;
		while ($qrys->fetch()) {
			$destaque[$i]['id'] = $id;
			$destaque[$i]['descricao'] = $descricao;
			$destaque[$i]['link'] = $link;
			$destaque[$i]['imagem'] = $rph.'images/destaque/'.$imagem;
			$i++;
		}

		$qrys->close();

	 }

