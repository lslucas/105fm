<?php
	/*
	 *LOAD BASICS
	 */
	include_once 'load.php';


	/**
	  * Set 404
	 */
	if(!empty($basename) && (!file_exists("public/$basename.php") && !file_exists("public/$basename")) && !isset($queryAlias[$basename]))
		 header('HTTP/1.0 404 Not Found');


	/*
	 *HEADERS PARA TODAS AS PAGINAS
	*/
	if ($basename<>'ajax')
		include_once 'modules/autoload/header.php';


	/*
	 *HEADERS AND MODULE HEADERS
	*/
	if (isset($queryAlias[$basename]) && file_exists("modules/{$queryAlias[$basename]['basename']}/header.php"))
		include_once "modules/{$queryAlias[$basename]['basename']}/header.php";

	elseif(!empty($basename)) {

		//remove extension
		if (strpos($basename, '.')===true) {
			$ext = file_extension($basename);
			$basename = str_replace($ext, '', $basename);
		}

		//remove querystring
		if (strpos($basename, '?')!==false) {
			$baseexplode = explode('?', $basename);
			$basename	 = $baseexplode[0];
		}

		if (file_exists("modules/{$basename}/header.php"))
			include_once "modules/{$basename}/header.php";

	} elseif (file_exists('modules/default/header.php'))
		include_once "modules/default/header.php";


	/*
	 *EXEC SUBMIT
	 */
	$exec_submit = null;
	if (isset($queryAlias[$basename]) && in_array('send', $_tmp))
		$exec_submit = "modules/{$queryAlias[$basename]['basename']}/{$basename}/exec.php";
	elseif (isset($basename) && isset($querystring) && is_array($url) && in_array('send', $url))
		$exec_submit = "modules/{$basename}/{$querystring}/exec.php";
	elseif (isset($querystring) && strpos($querystring, 'send')!==false)
		$exec_submit = "modules/{$basename}/exec.php";

	if (!empty($exec_submit) && file_exists($exec_submit))
		include_once $exec_submit;


	/**
	 *HTML HEADERS
	 */
	if ($basename<>'ajax')
		include_once 'public/header.php';



	/**
	 *HTML CONTAINER
	 */
	if (isset($queryAlias[$basename]) && file_exists($queryAlias[$basename]['path']))
		include_once $queryAlias[$basename]['path'];

	elseif (!isset($querystring) || empty($querystring)) {

		if(!empty($basename) && file_exists("public/{$basename}.php"))
			include_once "public/{$basename}.php";
		elseif(!empty($basename) && file_exists("public/{$basename}"))
			include_once "public/{$basename}";
		elseif (empty($basename))
			include_once 'public/default.php';
		else
			include_once 'public/erro-404.php';

	} else {

		if(!empty($querystring) && file_exists("public/modules/{$basename}/{$querystring}.php"))
			include_once "public/modules/{$basename}/{$querystring}.php";
		elseif(!empty($querystring) && file_exists("public/modules/{$basename}/{$querystring}"))
			include_once "public/modules/{$basename}/{$querystring}";
		elseif(!empty($basename) && file_exists("public/{$basename}.php"))
			include_once "public/{$basename}.php";
		//else
			//include_once 'public/default.php';

	}


	/**
	 *HTML FOOTER
	*/
	if ($basename<>'ajax')
		include_once 'public/footer.php';
