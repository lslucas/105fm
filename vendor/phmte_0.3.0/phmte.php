<?php

/**
* Mail template class
*
* @author: 		Mario Trojan
* @lastchange:	2011-09-04
*/
class HtmlMailTemplate {

	protected $_tpl_id;		// Basename of template path, will be used in exceptions
	protected $_tpl_path;	// Template path from constructor

	protected $_tpl_info;	// Template info class (set in FillTemplate)
	protected $_mail;		// HtmlMail class (set in FillTemplate, get by GetMail)


	/**
	* Construct mail template class for an existing file
	*
	* @author: 		Mario Trojan
	* @lastchange:	2011-09-03
	*
	* @param string	$path		Path to a template file
	*/
	public function __construct ($path) {
		assert('is_file($path)');
		$this->_tpl_path = $path;
		$this->_tpl_id = basename($path);
	}


	/**
	* Load and fill template with external informations
	*
	* - Uses DOM to load HTML file
	* - Creates a protected Mail-Object from the template
	*
	* @author: 		Mario Trojan
	* @lastchange:	2011-09-04
	*
	* @param HtmlMailTemplateInformation	$info		External informations
	*/
	public function FillTemplate (HtmlMailTemplateInformation $info) {
		$this->_tpl_info = $info;

		$dom = new DOMDocument();
		if (!@$dom->loadHTMLFile($this->_tpl_path)) {
			throw new HtmlMailException("HTML-Teplate ".basename($this->_tpl_id)." could not be loaded");
		}

		$mail = new HtmlMail();
		$mail->charset				= $info->charset;
		$mail->content_type			= $info->content_type;

		$mail->attachments			= $info->attachments;
		$mail->additional_headers	= $info->additional_headers;

		// Substitute Variables
		$vars = $dom->getElementsByTagName($this->_tpl_info->mailvar_tagname);

		// Cache found vars because we want to replace them (avoid DOMNodeList iterator problem)
		$vars2 = array();
		foreach ($vars as $var) {
			$vars2[] = $var;
		}

		// Replace vars
		foreach ($vars2 as $var) {
			$key = $var->getAttribute($this->_tpl_info->mailvar_attrname_key);
			$type = $var->getAttribute($this->_tpl_info->mailvar_attrname_type);
			if ($type == '') {
				$type = 'string';
			}

			if (!isset($this->_tpl_info->vars[$key])) {
				throw new HtmlMailException("Unknown var '" . $key . "' in " . $this->_tpl_id);
			}
			switch ($type) {
				case 'string':
					// simply replace placeholder with string
					$text = $dom->createTextNode($this->_tpl_info->vars[$key]);
					$var = $var->parentNode->replaceChild($text, $var);
					break;
				case 'array':
					// Remove + Cache all children
					$to_clone = array();
					$child = $var->firstChild;
					while ($child != null) {
						$next = $child->nextSibling;
						$to_clone[] = $child->parentNode->removeChild($child);
						$child = $next;
					}

					// Duplicate all children once for each array entry
					foreach ($this->_tpl_info->vars[$key] as $entry) {
						$entry_index = 0;
						foreach ($to_clone as $node) {
							// If node is mailval -> replace
							if ($node instanceof DOMElement && $node->tagName == $info->mailval_tagname) {
								// Check if external data is string or array and use correct entry
								$entry_text = $this->FillTemplateSubGetEntryText($entry, $entry_index, $node->getAttribute($info->mailval_attrname_index));
								$node = $dom->createTextNode($entry_text);
								$entry_index++;
							}
							// if node is other element, then clone and check if children contain mailval and replace
							elseif ($node instanceof DOMElement) {
								$node = $node->cloneNode(true);

								$mailvals = $node->getElementsByTagName($info->mailval_tagname);
								// And caching again, stupid dom iterator ...
								$mailvals2 = array();
								foreach ($mailvals as $mailval) {
									$mailvals2[] = $mailval;
								}
								foreach ($mailvals2 as $mailval) {
									// Check if external data is string or array and use correct entry
									$entry_text = $this->FillTemplateSubGetEntryText($entry, $entry_index, $mailval->getAttribute($info->mailval_attrname_index));
									$text = $dom->createTextNode($entry_text);
									$mailval = $mailval->parentNode->replaceChild($text, $mailval);
									$entry_index++;
								}
							}
							else {
								$node = $node->cloneNode(true);
							}
							$var->appendChild($node);
						}
					}

					break;
				default:
					throw new HtmlMailException("Unknown var type '" . $type . "' in " . $this->_tpl_id);
			}
		}

		// Save filled template for debug purposes
		$mail->tpl_filled = $dom->saveHTML();

		// Parse fields
		$mailfields_tagname = $info->mailfields_tagname;
		$mailfields = $dom->getElementsByTagName($mailfields_tagname);
		if ($mailfields->length !== 1) {
			throw new HtmlMailException('Tag "'.$mailfields_tagname.'" is missing in ' . $this->_tpl_id);
		}

		$field_container = $mailfields->item(0);
		$fields = $field_container->getElementsByTagName('*');
		foreach ($fields as $field) {
			$field_name = $field->tagName;
			$field_value = trim($field->nodeValue);

			if ($field_value != '') {
				switch ($field_name) {
					case 'subject':
					case 'from':
					case 'reply_to':
						$mail->$field_name = $field_value;
						break;
					case 'attachment':
						$field_name = 'attachments';
					case 'to':
					case 'cc':
					case 'bcc':
					case 'additional_header':
						if (!isset($mail->$field_name)) $mail->$field_name = array();
						$mail->{$field_name}[] = $field_value;
						break;
				}
			}
		}

		// Parse message
		// Since DOMNode-Parameter for DOMDocument->saveHTML will be introduced in PHP 5.3.6, we need something else
		// Use preg_match to get mailbody from cached template
		$hits = array();
		$mailbody_tagname = $info->mailbody_tagname;
		if (!preg_match('"<'.$mailbody_tagname.'(\s[^>]*)?>(.*)</'.$mailbody_tagname.'>"s', $mail->tpl_filled, $hits)) {
			throw new HtmlMailException($mailbody_tagname . ' could not be parsed from template ' . $this->_tpl_id);
		}
		$mail->message = $hits[2];

		// Save mail in class variable
		$this->_mail = $mail;
	}



	/**
	* Association of variables to placeholders ("mailval") dependant on the template structure and array structure
	*
	* HtmlMailTemplateInformation->vars may for each key contain either
	* a string
	* an array of string
	* an array of arrays (numeric)
	* an array of arrays (associative)
	*
	* This function decides which entry to take dependant on previous entries in the same dataset
	* or an explicit key which is set as an attribute in the mailval tag.
	*
	* @author: 		Mario Trojan
	* @lastchange:	2011-09-04
	*
	* @param HtmlMailTemplateInformation	$info		External informations
	*/
	protected function FillTemplateSubGetEntryText ($entry, $entry_index, $entry_key=null) {
		if (!is_array($entry)) {
			$entry_text = $entry;
		}
		else {
			if ($entry_key == null) {
				$keys = array_keys($entry);
				$entry_key = $keys[$entry_index];
			}

			if (!isset($entry[$entry_key])) {
				throw new HtmlMailException($entry_key . ' is not set in external data for template ' . $this->_tpl_id);
			}

			$entry_text = $entry[$entry_key];
		}
		return $entry_text;
	}



	/**
	* Getter for prepared mail
	*
	* @author: 		Mario Trojan
	* @lastchange:	2011-09-03
	*
	* @return HtmlMail
	*/
	public function GetMail () {
		return $this->_mail;
	}



	/**
	* Send Mail after generation
	*
	* @author: 		Mario Trojan
	* @lastchange:	2011-09-03
	*
	*/
	public function SendMail () {
		$this->_mail->Send();
	}

}



/**
* Data class with external informations to convert template to mail
*
* @author: 		Mario Trojan
* @lastchange:	2011-09-04
*
*/
class HtmlMailTemplateInformation {
	public $vars					= array();
	public $attachments				= array();
	public $additional_headers		= array();

	public $mailvar_tagname			= 'mailvar';
	public $mailvar_attrname_key	= 'key';
	public $mailvar_attrname_type	= 'type';
	public $mailval_tagname			= 'mailval';
	public $mailval_attrname_index	= 'index';
	public $mailfields_tagname		= 'mailfields';
	public $mailbody_tagname		= 'mailbody';

	public $charset					= 'utf8';
	public $content_type			= 'text/html';

}



/**
* Class with created mail
*
* Can be used to send the mail
*
* @author: 		Mario Trojan
* @lastchange:	2011-09-04
*
*/
class HtmlMail {
	public $tpl_filled;							// Filled template as DOM->saveHTML, may contain additional unneccesary information (Doctype declaration, ...)

	public $subject;							// Mail subject
	public $from;								// Mail from (string)
	public $to					= array();		// Mail to (array)
	public $cc					= array();		// Mail cc (array)
	public $bcc					= array();		// Mail bcc (array)
	public $reply_to;							// Mail reply-to (string)
	public $additional_headers	= array();		// Mail additional headers (array)
	public $attachments			= array();		// Paths to Attachments

	public $charset				= 'utf8';		// Mail charset
	public $content_type		= 'text/html';	// Mail content-type

	public $message;							// Html mail body from template


	/**
	* Send this mail
	*
	* @author: 		Mario Trojan
	* @lastchange:	2011-09-04
	*
	*/
	public function Send () {
		$to = implode(',', $this->to);
		$cc = implode(',', $this->cc);
		$bcc = implode(',', $this->bcc);



		$boundary = md5(date('r', time()));
		$boundary_line = '--' . $boundary;


		$headers = '';

		if ($this->from != '') {
			$headers .= "From: " . $this->from . PHP_EOL;
		}

		if ($cc != '') {
			$headers .= "Cc: " . $cc . PHP_EOL;
		}

		if ($bcc != '') {
			$headers .= "Bcc: " . $bcc . PHP_EOL;
		}

		if ($this->reply_to != '') {
			$headers .= "Reply-to: " . $this->reply_to . PHP_EOL;
		}

		// Additional headers
		foreach ($this->additional_headers as $key => $value) {
			if (is_string($key)) {
				$headers .= $key . ': ' . $value . PHP_EOL;
			}
			else {
				$headers .= $value . PHP_EOL;
			}
		}

		$headers .= "MIME-Version: 1.0" . PHP_EOL;
		$headers .= "Content-Type: multipart/mixed; boundary=\"".$boundary."\"" . PHP_EOL;

		$message = '';

		// Include HTML Message
		$message .= $boundary_line . PHP_EOL;
		$message .= "Content-type: ".$this->content_type."; charset=" . $this->charset . PHP_EOL;
		$message .= "Content-Transfer-Encoding: base64" . PHP_EOL . PHP_EOL;

		$message .= chunk_split(base64_encode($this->message)) . PHP_EOL . PHP_EOL;

		// Include Attachments
		foreach ($this->attachments as $attachment) {
			// Prepare attachment
			$contents = file_get_contents($attachment);
			if (!$contents) throw new HtmlMailException(basename($attachment) . " could not be loaded");
			$attachment2 = chunk_split(base64_encode($contents));

			// Write attachment to mail
			$message .= $boundary_line . PHP_EOL;
			$message .= "Content-type: application/octet-stream; name=" . basename($attachment) . PHP_EOL;
			$message .= "Content-Transfer-Encoding: base64" . PHP_EOL;
			$message .= "Content-Disposition: attachment" . PHP_EOL . PHP_EOL;

			$message .= $attachment2 . PHP_EOL . PHP_EOL;
		}

		// Debug
		#print $message;

		// Send mail
		if (!mail($to, $this->subject, $message, $headers)) {
			throw new HtmlMailException ("Mail '" . $subject . "' could not be sent to " . $to);
		}
	}
}



/**
* This exception will be thrown if an error occurs
*
* @author: 		Mario Trojan
* @lastchange:	2011-09-03
*
*/
class HtmlMailException extends Exception {}