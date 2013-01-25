<?php
	if (!isset($usr) || empty($usr['id']))
		header('Location: '.ABSPATH);

	include_once 'modules/classes/compra.php';

	$msg = $msgTitle = $res = null;
	$compra = new Compra();
	$myProducts = $compra->getMyProducts($usr['id']);


	$incJS .= "
        // on connection to server, ask for user's name with an anonymous callback
        socket.on('connect', function(){
            // call the server-side function 'adduser' and send one parameter (value of prompt)
            var nickname = '{$usr['nome']}';
            localStorage.setItem('nickname', nickname);
            socket.emit('adduser', nickname);
        });
	";