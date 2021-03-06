<?php
   /*
    *cabeçalho para funcoes,variaveis e conexao com a base
    */
	session_start();
	$rp = !isset($rp) ? 'admin/' : $rp;

	include_once $rp.'_inc/global.php';
	require_once $rp.'_inc/db.php';
	include_once $rp.'_inc/global_function.php';
	include_once 'vendor/hashids.php';
	include_once 'vendor/aes.php';
	include_once "vendor/yos-social-php/lib/Yahoo.inc";

	// The YahooApplication class is used for two-legged authorization,
	// which doesn't need permission from the end user.
	$yql = new YahooApplication(OAUTH_CONSUMER_KEY,OAUTH_CONSUMER_SECRET);
	if ($yql == NULL) {
	   print ("Error: Cannot get yql (YahooApplication object).");
	   exit;
	}


	$aes = new AES('abcdefghijuklmnz0123456789012345', 'ECB');
	$hashids = new hashids(TP, 6);

	$catIdByTitulo = getCategoriaIdByTitulo();
	$catIdByTituloMin = getCategoriaIdByTitulo(true);
	$usr = isset($_SESSION[TP]['usr']) ? $_SESSION[TP]['usr'] : null;
	$uri  = substr($_SERVER['REQUEST_URI'], 1);
	$breadcrumb = null;
	$res = array('error'=> array('texto'=> null, 'text'=>null));

	$backslash_pos = strpos($uri, '/');

	$incjQuery = null;
	$incJS = null;
	$toJS = null;
	$toScript = null;
	$incCSS = null;
	$incMsg = null;
	$return = null;


	// *verifica se está em localhost
	if( $host=='localhost' ) {
		define('ABSPATH', '/'.substr($uri, 0, $backslash_pos+1));
		$uri = substr($uri, $backslash_pos+1);
	} else {
		define('ABSPATH', '/');
		// define('ABSPATH', '/'); #.substr($uri, 0, $backslash_pos)
	}
	// define('ABSPATH', '/');

	$ABSPATH = ABSPATH;
	$LOADING = "<img src='".ABSPATH."admin/images/loading.gif' border=0/>";


	/*
	*separa tudo que tiver /
	*/
	$url = explode('/', $uri);
	/*
	if ($_SERVER['HTTP_HOST']<>'localhost') {
		array_shift($url); //remote apenas
		array_shift($url); //remote apenas
	}
	 */

	//nome do arquivo = $basename.php
	$basename = isset($url[0]) ? $url[0] : null;
	if (strpos($basename, '?')!==false) {
		$basename = explode('?', $basename);
		$basename = $basename[0];
	}

	$querystring = isset($url[1]) ? $url[1] : null;
	$queryaction = isset($url[2]) ? $url[2] : null;
	$queryvalue = isset($url[3]) ? $url[3] : null;

	$querystring_full = array_shift($url);
	$querystring_full = implode('&', $url);
	$querystring_full = count($url)>0 ? $querystring_full: '';

	$QueryString = preg_replace('|[&]|', '/', $querystring);
	$QueryString = str_replace('/p1-Normal', '', $QueryString);
	$QueryString = str_replace('/p1-Thumb', '', $QueryString);
	#echo $basename.$querystring;

	$full_url = full_url();
	$parseFullUrl = parse_url(full_url());
	$urlPath = explode('/', $parseFullUrl['path']);
	$urlPath = array_filter($urlPath);
	$urlParams = $urlPath;
	unset($urlParams[array_search($basename, $urlParams)]);
	sort($urlParams);


	if (strpos($querystring_full, '&') ) {
		$_tmp = explode('&', $querystring_full);
		$item = $_tmp[0];
	} else
		$_tmp = array($querystring_full);


	/*
	 * QUERY STRING ALIAS
	 */
	$queryAlias = array(
		 'carnaval2014'=>array('basename'=>'usuario', 'path'=>'public/usuario/carnaval2014.php'),
		 'cadastro'=>array('basename'=>'usuario', 'path'=>'public/usuario/registrar.php'),
		 'login'=>array('basename'=>'usuario', 'path'=>'public/usuario/login.php'),
		 'respondePergunta'=>array('basename'=>'perguntaDia', 'path'=>'public/perguntaDia.php'),
		 'logout'=>array('basename'=>'usuario', 'path'=>'public/usuario/logout.php'),
		 'esqueci-senha'=>array('basename'=>'usuario', 'path'=>'public/usuario/esqueci-senha.php'),
		 'sair'=>array('basename'=>'usuario', 'path'=>'public/usuario/logout.php'),
	);
