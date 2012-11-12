<?php
# CSS INCLUIDO NO inc.header.php
$include_css = <<<end
end;


# JS INCLUIDO NO inc.header.php, também pode conter codigo js <script>alert();</script>
$letter = isset($_GET['letra'])?'&letra='.$_GET['letra']:'';
$include_js = <<<end
	<script type="text/javascript" src="${rp}js/jquery.blockUI.js"></script>
	<script type="text/javascript" src="${rp}js/jquery.maskedinput-1.2.2.min.js"></script>
	<script type="text/javascript" src="${rp}js/jquery.validate.min.js"></script>
	<script type="text/javascript" src="${rp}js/jquery.tablednd.js"></script>
	<script type="text/javascript" src="${rp}js/jquery.price_format.js"></script>
	<script type="text/javascript" src="${rp}js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
	<script type="text/javascript" src="${rp}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
	<script>
	  // $(function(){});
	</script>
end;
