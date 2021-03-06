<?php
## NOTA: CASO EM NENHUM OUTRO MODULO SEJA DEFINIDO O ARQUIVO HEADER, ESSE SERA O ARQUIVO PADRAO


# CSS INCLUIDO NO inc.header.php
$include_css = <<<end
<link href="{$rp}js/redactor/css/redactor.css" media="all" type="text/css" rel="stylesheet">
end;


# JS INCLUIDO NO inc.header.php, também pode conter codigo js <script>alert();</script>
$pag = isset($_GET['pg'])?'&pg='.$_GET['pg']:'';
$letter = isset($_GET['letra'])?'&letra='.$_GET['letra']:'';
$include_js = <<<end
    <script type="text/javascript" src="${rp}js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.maskedinput-1.2.2.min.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.validate.min.js"></script>
    <script src="{$rp}js/redactor/redactor.js"></script>
    <!--
    <script type="text/javascript" src="${rp}js/tinymce/jscripts/tiny_mce/jquery.tinymce.js"></script>
    <script type="text/javascript" src="${rp}js/tinymce/jscripts/tiny_mce/tiny_mce.js"></script>
    -->
<script>
  $(function(){
	$('.tinymce').redactor({
		imageUpload: "{$rp}js/redactor/image_upload.php",
        lang: 'pt_br'
	});


    /* ALTERA PRINCIPAL LISTAGEM
    ************************************/
    $(".principal").click(function(event) {
     event.preventDefault();
     var id_principal = $(this).attr('id');
     var texto_principal = $(this).text();
     var href_principal  = $(this).attr('href');
     var nome_principal  = $(this).attr('name');

        {$LOADING}
        $.ajax({
            type: "POST",
            url: href_principal,
            success: function(data){
             $.unblockUI();
             $.growlUI(data);
                if(texto_principal=="Sim" || texto_principal==" Sim") $('.principal'+id_principal).text('Não');
                else $('.principal'+id_principal).text('Sim');
            }
        });


    });
  });
</script>
end;
