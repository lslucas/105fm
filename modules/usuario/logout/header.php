<?php

	$_SESSION[TP] = array();
	session_destroy();

	if (isset($_REQUEST['backto']))
		header('Location: '.$_REQUEST['backto']);
	else
		header('Location: '.ABSPATH);

