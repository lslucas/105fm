<?php
 #define o charset padrão do php
 ini_set('default_charset','utf-8');

 //define fusohorario padrao
 date_default_timezone_set('America/Sao_Paulo');
$host = $_SERVER['HTTP_HOST']=='localhost' || $_SERVER['HTTP_HOST']=='agrosshop' ? 'localhost' : $_SERVER['HTTP_HOST'];

//APIS
define('OAUTH_CONSUMER_KEY', 'dj0yJmk9dHkxSktldHA3OFF3JmQ9WVdrOVNEWnZaRVZLTXpBbWNHbzlNVFEyT0RjMU9USTJNZy0tJnM9Y29uc3VtZXJzZWNyZXQmeD1hNQ--');
define('OAUTH_CONSUMER_SECRET', '87ab3be4e530f779822efa54532f0ed4696eb214');
define('OAUTH_APP_ID', 'H6odEJ30');

# EMAILS
########

define('EMAIL','neto@techtravel.com.br');
define('EMAIL_CONTACT','neto@techtravel.com.br');
define('EMAIL_NAME','agrosshop');
define('BBC1_EMAIL','lslucas@gmail.com');
define('BBC2_EMAIL','');
define('BBC3_EMAIL','');
define('BBC4_EMAIL','');
define('BBC1_NOME','Lucas Serafim');
define('BBC2_NOME','');
define('BBC3_NOME','');
define('BBC4_NOME','');
define('ADM_EMAIL','');


if ($host=='localhost') {

	/**
	 * EMAIL SERVER
	 */
	define('MAIL_HOST', 'smtp.gmail.com');
	define('MAIL_SMTPAUTH', 'login');
	define('MAIL_SMTPSECURE', 'tls');
	define('MAIL_PORT', 587);
	define('MAIL_USER', 'noreply@techtravel.com.br');
	define('MAIL_PASS', 'mvdbt9TT');

	/**
	 * CONEXÃO COM O DB
	 */
	define('DB_SERVER','localhost');
	define('DB_USER','root');
	define('DB_PASS','mvdbt9');
	define('DB_DATABASE','agrosshop');

	error_reporting(E_ALL);
	ini_set('display_errors','On');

	//host
	$vhost = 'http://localhost/';


	if (!isset($rph))
		$rph = dirname($_SERVER['PHP_SELF']);
	define('STATIC_PATH', $rph.'images/');

} else {

	/**
	 * EMAIL SERVER
	 */
	define('MAIL_HOST', 'smtp.gmail.com');
	define('MAIL_SMTPAUTH', 'login');
	define('MAIL_SMTPSECURE', 'tls');
	define('MAIL_PORT', 587);
	define('MAIL_USER', 'noreply@techtravel.com.br');
	define('MAIL_PASS', 'mvdbt9TT');

	/**
	 * CONEXAO COM O DB
	 */
	define('DB_SERVER','agrosshop.cpvaflkdqugq.sa-east-1.rds.amazonaws.com');
	define('DB_USER','agrouser');
	define('DB_PASS','mvdbt9AGRO');
	define('DB_DATABASE','agrosshop');

	ini_set('display_errors','Off');

	//host
	$vhost = 'http://'.$_SERVER['HTTP_HOST'].'/';

	if (!isset($rph))
		$rph = dirname($_SERVER['PHP_SELF']);

	define('STATIC_PATH', $rph.'images/');
}

#prefixo das tabelas
define('TABLE_PREFIX','agr');
define('TP', TABLE_PREFIX);

$path = 'admin';
$base = $vhost.$path.'/';

if (!isset($abspath))
	$abspath = realpath(dirname('global.php')).'/';

// include path para o zend
if(in_array($host, array('localhost', 'agrosshop'))) ini_set('include_path', ".:/usr/share/php/.:/opt/local/lib/php:.{$abspath}:.{$abspath}vendor");
else ini_set('include_path', '.:/.:/usr/share/php/zend-framework/');



#rp relative path, caminho relativo para a raiz do back-end
if (@!file_exists('inc.header.php')) {

	if (@file_exists('../inc.header.php')) $rp = '../';
	if (@file_exists('../../inc.header.php')) $rp = '../../';

} else $rp = '';

$rpadm = $rph.'admin/';


/**
 * VARIAVEIS GLOBAIS
 */
define('SITE_NAME','AGROSSHOP');
$BUSINESS = '';
$BUSINESS = null;
if ($host=='localhost') define('SITE_URL','http://localhost/agroshop');
else define('SITE_URL','http://agrosshop.com.br');
define('PAINEL_URL', SITE_URL.'/admin');
$SITE_URL = SITE_URL;
define('RODAPE','<a href="'.SITE_URL.'">'.SITE_NAME.'</a>');

define('SITE_ADM_IMGPATH','images');
define('FILE_LOGO','logo.jpg');
define('SITE_ADMLOGO','<img src="'.SITE_ADM_IMGPATH.'/'.FILE_LOGO.'" border="0">');
define('URL_ADMLOGO','<img src="'.SITE_URL.SITE_ADM_IMGPATH.'/'.FILE_LOGO.'" border="0">');
define('PATH_ADMLOGO',$rp.'images/admin_logo.png');

define('PATH_FILE',$rp.'../public/upload');
define('PATH_IMG',$rp.'../public/images');

define('CSS', $rph.'css/');
define('JS', $rph.'js/');

//pega o menor valor e define como o máximo que o servidor suporta para upload
$max_upload = (int)(ini_get('upload_max_filesize'));
$max_post = (int)(ini_get('post_max_size'));
$memory_limit = (int)(ini_get('memory_limit'));
$upload_mb = min($max_upload, $max_post, $memory_limit);
define('MAX_UPLOAD', $upload_mb);

/**
 * DEBUG
 */
define('DEBUG',0);
define('DEBUG_LOG',$rp.'debug.log');

/**
 * LOADING DO AJAX
 */
$LOADING = <<<end
		// BOX DE CARREGAMENTO
		$.blockUI({
			message: "<img src='images/loading.gif'>",
			css: {
				top:  ($(window).height()-24)/2+'px',
				left: ($(window).width()-24)/2+'px',
				width: '24px'
			}
		});
end;


//path, modulo atual
$p  = isset($_GET['p'])?$_GET['p']:'';
$ap = !empty($p)?$rp.$p.'/':'';

//verifica se é insert, update ou none
if(isset($_GET['insert'])) $act = 'insert';
elseif(isset($_GET['update'])) $act='update';
else $act='';

// TINYMCE BBCODE
#|,forecolor,backcolor,image,
$TinyMCE = <<<end
   forced_root_block : false,
   force_br_newlines : true,
   force_p_newlines : false,
	//script_url : "{$rp}js/tinymce/jscripts/tiny_mce/tiny_mce.js",
	mode : "exact",
	theme : "advanced",
	plugins : "legacyoutput,safari,iespell,contextmenu,paste,directionality,noneditable,visualchars,xhtmlxtras,template,inlinepopups,nonbreaking, preview, searchreplace,noneditable, table",
	onchange_callback: function(editor) {
		tinyMCE.triggerSave();
		$("#" + editor.id).valid();
	},
    inline_styles : false,
    paste_auto_cleanup_on_paste: true,
    paste_convert_headers_to_strong : true,
    convert_fonts_to_spans : false,
    valid_elements : ""
	    +"a[href|target],"
	    +"b,"
	    +"br,"
	    +"font[color|face|size|style],"
	    +"span[class|align|style],"
	    +"img[src|id|width|height|align|hspace|vspace],"
	    +"i,"
	    +"li,"
	    +"p[align|class],"
	    +"h1,"
	    +"h2,"
	    +"h3,"
	    +"h4,"
	    +"h5,"
	    +"h6,"
	    +"textformat[blockindent|indent|leading|leftmargin|rightmargin|tabstops],"
	    +"u"
    ,
	// Theme options
	theme_advanced_buttons1 : "bold,italic,strikethrough,|,paste,pastetext,pasteword,|,justifyleft,justifycenter,justifyright,justifyfull,|,sub,sup,|,charmap,emotions,|,formatselect,removeformat,cleanup",
	theme_advanced_buttons2 : "search,replace,|,bullist,numlist,|,outdent,indent,blockquote,|,undo,redo,|,link,unlink,anchor,image,|,insertdate,inserttime,preview,|,forecolor,backcolor,|,code",
	theme_advanced_buttons3 : "tablecontrols",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "none",
	theme_advanced_resizing : true

end;


$TinyMCESimple = <<<end
   forced_root_block : false,
   force_br_newlines : true,
   force_p_newlines : false,
	mode : "exact",
	theme : "advanced",
	plugins : "legacyoutput,safari,contextmenu,directionality,noneditable,visualchars,xhtmlxtras,template,inlinepopups,nonbreaking, preview, noneditable",
	onchange_callback: function(editor) {
		tinyMCE.triggerSave();
		$("#" + editor.id).valid();
	},
    inline_styles : false,
    paste_auto_cleanup_on_paste: true,
    paste_convert_headers_to_strong : true,
    convert_fonts_to_spans : false,
    valid_elements : ""
	    +"a[href|target],"
	    +"b,"
	    +"br,"
	    +"img[src|id|width|height|align|hspace|vspace],"
	    +"i,"
	    +"li,"
	    +"p[align|class],"
	    +"textformat[blockindent|indent|leading|leftmargin|rightmargin|tabstops],"
	    +"u"
    ,
	// Theme options
	theme_advanced_buttons1 : "bold,italic,strikethrough,|,bullist,numlist,|,removeformat, code, preview",
	theme_advanced_buttons2 : "",
	theme_advanced_buttons3 : "",
	theme_advanced_toolbar_location : "top",
	theme_advanced_toolbar_align : "left",
	theme_advanced_statusbar_location : "none",
	theme_advanced_resizing : true

end;

//"a[href|target=_blank],strong/b,div[align],br," +"basefont[color|face|id|size],"
#HTML DO EMAIL DO ADMINISTRADOR
$SITE_NAME = SITE_NAME;
$administrador_email_header = <<<end
<html>
<head>
<meta http-equiv="Content-Type" content="text/html;charset=utf-8"/>
<title>$SITE_NAME</title>
<style type='text/css'>
  <!--
body {
	margin-left: 0px;
	margin-top: 0px;
	margin-right: 0px;
	margin-bottom: 0px;
	font-size: 12px;
	font-family: Tahoma, Arial, Helvetica, sans-serif;
	background-repeat: no-repeat;
	background-position: center center;
	background-attachment: fixed;

} h1,h2,h3,h4,h5 {
	color: #145675;
	font-weight: bolder;
	font-size: 12pt;

} a {
 color: #145675;
 background-color: transparent;
 text-decoration: none;
 font-weight: normal;

} a:visited {
 color: #036EBF;
 text-decoration: none;

} a:hover {
 color: #78251B;
 background-color: #d0baba;
 text-decoration: none;
} .central {
 width:450px;
 margin:20px;
}
}-->
  </style>

</head>
<body>
<div class="central">
 <h3>$SITE_NAME</h3>
end;

$administrador_email_footer = <<<end
</div>
</body>
</html>
end;
$user_email_header = $administrador_email_header;
$user_email_footer = $administrador_email_footer;
