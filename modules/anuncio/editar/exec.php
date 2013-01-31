<?php

	if(isset($val['from']) && $val['from']=='anuncio') {

		$res = $classificado->atualiza($val);

		/**
		 *Se não houve erro redireciona usuario logado ao painel dele
		 */
		if (isset($res['success']))
			header('Location: '.ABSPATH.'painel');

	} else
		$val = $classificado->getInfoById($querystring);