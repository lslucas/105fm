<?php

	if(isset($val['from']) && $val['from']=='anuncio') {

		$res = $classificado->atualiza($val);
		/**
		 *Se não houve erro redireciona usuario logado ao painel dele
		 */
		// if (isset($res['success']))
			// header('Location: '.ABSPATH.'painel');
		if (isset($res['success']))
			$toScript = showModal(array('title'=>'', 'content'=>'Anuncio atualizado com êxito!'));
	} else
		$val = $classificado->getInfoById($querystring);

$incjQuery .= "

	/*
	 *adiciona mais um campo file a cada vez que é clicado no elemento
	 *com a classe class='addImagem'
	 */
	if ($('.addImagem')) {
		$('.addImagem').click(function(e){
			var i = parseInt($('.galeria:last').attr('alt'));

			$('.divImagem:first').clone().insertAfter('.divImagem:last').slideDown();
			$('.divImagem:last > .legenda').val('');
			$('.divImagem:last > .galeria').val('');
		});
	}

	/* APAGA IMAGEM/ARQUIVO
	************************************/
	$('.drop-image').click(function(event){

		event.preventDefault();
		var id_trash = $(this).attr('id');
		var args = '';

		if (!$(this).attr('alt'))
			args = '{\"title\": \"Remover Imagem\", \"content\": \"Realmente quer apagar essa imagem?\", \"buttonClose\": \"Cancelar\", \"button\": {\"id\": \"yes-drop-image\", \"value\": \"Remover\", \"color\": \"btn-danger\"}}';
		else
			args = $(this).attr('alt');
		$().showModal(args);

		// ACAO AO CLICAR EM SIM
		$('#yes-drop-image').click(function(){

			// {$LOADING}
			$.ajax({
				type: 'POST',
				url: ABSPATH+'ajax/anuncio/drop-image/'+id_trash,
				success: function(data){
					eval(data);

				}
			});
		});
	});

/*
$(document).on('dragover', function (e) {
	e = e.originalEvent;
	e.preventDefault();
	e.dataTransfer.dropEffect = 'copy';
}).on('drop', load);
$('#file-input').on('change', load);
*/
";