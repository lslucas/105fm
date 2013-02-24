<?php

	// Common PHP settings
	date_default_timezone_set('Europe/Berlin');

	ini_set('error_reporting', E_ALL);
	ini_set('display_errors', 1);

	$mail_address = 'thehexman@thehexman.dyndns.org';
	ini_set('sendmail_from', $mail_address);


	// Require our libs
	require_once('../../phmte.php');

	// Init a new Template object with a path to the template
	$tpl_path	= 'template.html';
	$tpl		= new HTMLMailTemplate($tpl_path);

	// Generate a new TemplateInformation object, where the Variables will be stored
	// Several additional engine settings can also be set here, like charset and content-type of the mail, or tagnames inside the template file.
	$params		= new HTMLMailTemplateInformation();
	$params->vars = array(	'OrderNumber' => 'TST0012345',
							'Headline1' => 'The Order has been generated',
							'Receiver' => $mail_address,
							'Documents' => array(
												array('DocumentTitle' => 'Document 1', 'DocumentNumber' => '1234567890'),
												array('DocumentTitle' => 'Document 2', 'DocumentNumber' => '0987654321')
											)
						);

	// Add attachments (example: this source code file)
	$params->attachments = array(__FILE__);

	// Tell the engine to fill the template with these params
	$tpl->FillTemplate($params);

	// Get the prepared mail and send it
	$mail = $tpl->GetMail();
	#print nl2br(print_r($mail,true));
	$mail->Send();

	print "Mail successfully sent.";

?>