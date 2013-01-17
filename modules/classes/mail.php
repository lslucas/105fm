<?php

require_once 'vendor/phmte_0.3.0/phmte.php';

class Mail {

	private function sendEmail($args)
	{
		if (!is_array($args))
			return __FUNCTION__.' parâmetros inválidos';

		$tpl		= new HTMLMailTemplate($this->template);
		$params	= new HTMLMailTemplateInformation();

		$params->vars = $args;
		$tpl->FillTemplate($params);

		$mail = $tpl->GetMail();
		$mailHtml = $mail->message;

		/**
		 * Prepare variables to send email
		 */
		$subject = utf8_decode($this->subject);
		$fromEmail = !isset($args['fromEmail']) ? EMAIL : $args['fromEmail'];
		$fromName = !isset($args['fromName']) ? utf8_decode(SITE_NAME) : htmlentities($args['fromName']);
		$toEmail = !isset($args['email']) ? EMAIL_CONTACT : $args['email'];
		$toName = !isset($args['nome']) ? utf8_decode(SITE_NAME) : htmlentities($args['nome']);
		$htmlMensage = $mailHtml;

		require 'admin/inc.sendmail.header.php';
		return $sended;
	}

	public function compartilhe($args)
	{
		$this->template	= 'public/templates/compartilhe.html';
		$this->subject = SITE_NAME;

		return $this->sendEmail($args);
	}

	public function contatoVendedor($args)
	{
		$this->template	= 'public/templates/contatoVendedor.html';
		$this->subject = $args['assunto'];

		return $this->sendEmail($args);
	}

	public function faleConosco($args)
	{
		$this->template	= 'public/templates/faleConosco.html';
		$this->subject = SITE_NAME.' - '.$args['assunto'];

		return $this->sendEmail($args);
	}

	public function zerarSenha($args)
	{
		$this->template	= 'public/templates/zerarSenha.html';
		$this->subject = 'Sua senha foi redefinida';

		return $this->sendEmail($args);
	}

	public function novoCadastro($args)
	{
		$this->template= 'public/templates/novoCadastro.html';
		$this->subject  = SITE_NAME.' - Cadastro relaizado';

		return $this->sendEmail($args);
	}
}