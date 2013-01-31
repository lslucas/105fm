<?php

	if (isset($val['from']) && $val['from']=='anuncio') {
		$res = $classificado->nova($val);

		/**
		 *Se não houve erro redireciona usuario logado ao painel dele
		 */
		if (isset($res['success']))
			header('Location: '.ABSPATH.'painel');
	}


$incjQuery .= "

	/*
	 *adiciona mais um campo file a cada vez que é clicado no elemento
	 *com a classe class='addImagem'
	 */
	if ($('.addImagem')) {
		$('.addImagem').click(function(e){
			var i = parseInt($('.galeria:last').attr('alt'));

			$('.divImagem:first').clone().insertAfter('.divImagem:last').slideDown();
			$('.divImagem:last > .legenda').attr('name','legenda'+(i+1)).attr('alt',(i+1)).val('');
			$('.divImagem:last > .galeria').attr('name','galeria'+(i+1)).attr('alt',(i+1)).val('');
		});
	}





	/* APAGA IMAGEM/ARQUIVO
	************************************/
	$('.trash-galeria').click(function(event){

		event.preventDefault();
		var id_trash = $(this).attr('id');
		var href_trash = $(this).attr('href');
		var args = '';


		if (!$(this).attr('alt'))
			args = \"{'title': 'Remove Image', 'content': 'Realmente quer apagar essa imagem?', 'buttonClose': 'Cancelar', 'button': {'id': 'trash-galeria-sim', 'value': 'Remover', 'color': 'btn-danger'}}\";
		else
			args = $(this).attr('alt');

		showModal(args);


		// ACAO AO CLICAR EM SIM
		$('#trash-galeria-sim').click(function(){

			// {$LOADING}
			$.ajax({
				type: 'POST',
				url: href_trash,
				success: function(data){

					$.unblockUI();
					$.growlUI(data);
					$('#'+id_trash).hide();
					$('#msg-modal').modal('hide');

					if ($(this).attr('data-reload'))
						setTimeout(window.location.reload(), 3000);
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