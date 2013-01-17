<?php

	include_once 'load.php';
	$code = isset($querystring) ? $querystring : trim($_GET['code']);
	/*
	 *Resgata url do banner, computa click e manda pra url
	 */
	$sqlb = "SELECT ban_id, ban_url FROM ".TABLE_PREFIX."_banner ";
	$sqlb.=" WHERE ban_status=1 AND ban_code=?";
	$banners = array();

	if (!$qryb=$conn->prepare($sqlb))
		echo 'Erro SQL de banners';

	else {
		$qryb->bind_param('s', $code);
		$qryb->bind_result($id, $url);
		$qryb->execute();
		$qryb->store_result();
		$num = $qryb->num_rows;
		$qryb->fetch();
		$qryb->close();

		plusBannerClicks($id);
		header('Location: '.$url);

	}
