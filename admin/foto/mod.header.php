<?php
## NOTA: CASO EM NENHUM OUTRO MODULO SEJA DEFINIDO O ARQUIVO HEADER, ESSE SERA O ARQUIVO PADRAO


# CSS INCLUIDO NO inc.header.php
$include_css = <<<end
end;


# JS INCLUIDO NO inc.header.php, também pode conter codigo js <script>alert();</script>
$pag = isset($_GET['pg'])?'&pg='.$_GET['pg']:'';
$letter = isset($_GET['letra'])?'&letra='.$_GET['letra']:'';
$include_js = <<<end
    <script type="text/javascript" src="${rp}js/jquery.blockUI.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.maskedinput-1.2.2.min.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.validate.min.js"></script>
    <script type="text/javascript" src="${rp}js/jquery.tablednd.js"></script>



<script>
  $(function(){

    // ao arrastar alguma linha altera a posição dos elementos
    // e altera na banco
    $('#posGaleria').tableDnD({
        onDrop: function(table, row) {

	      $.ajax({
		 type: "POST",
		 url: "$p/inc.galeria.pos.php",
		 data: $.tableDnD.serialize()
	      });

        }
    });

    // al passar o mouse sobre a linha add a classe para mostrar a imagem de +
    $("#posGaleria tr").hover(function() {
       $(this.cells[0]).addClass('showDragHandle');
    }, function() {
        $(this.cells[0]).removeClass('showDragHandle');
    });


  });
</script>
end;
