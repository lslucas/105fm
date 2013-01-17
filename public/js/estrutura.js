var timer = null;

function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\ ".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA -Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

$(document).ready(function()
{
	$.getDocHeight = function()
	{
		return Math.max(
			$(document).height(),
			$(window).height(),
			$('body').height(),
			$('html').height(),
			$('#wrapper').height(),
			/* For opera: */
			document.documentElement.clientHeight
		);
	};

	$('#compartilhe').hide();
	$('#lightbox').hide();
	$('#sucesso').hide();
	$('#lightbox').width("100%");
	$('#lightbox').height($.getDocHeight());
	//$('#lightbox').height($('#wrap').height());







	$('#share .email').click(function()
	{
		$('#lightbox').css('filter', 'alpha(opacity=80)');
		$('#lightbox').fadeIn();
		$('#compartilhe').fadeIn();


		$('html, body').animate({scrollTop:0}, 'slow');
	});

	$('#compartilhe #btn_enviar').click(function()
	{
		var compForm = 'form[name="compartilhe"]';
		var email = $(compForm+' input[name="email"]').val();
		var emailAmigo = $(compForm+' input[name="emailAmigo"]').val();
		var mensagem = $(compForm+' textarea[name="mensagem"]').val();

		$(compForm+' input, '+compForm+' textarea').removeClass('erro_campo');
		$(compForm+' .erro').addClass('invisible');

		if (email=='' || !validateEmail(email)) {
			$(compForm+' .errorEmail').removeClass('invisible');
			$(compForm+' input[name="email"]').addClass('erro_campo');
		} else if (emailAmigo=='') {
		// } else if (emailAmigo=='' || !validateEmail(emailAmigo)) {
			$(compForm+' .errorEmailAmigo').removeClass('invisible');
			$(compForm+' input[name="emailAmigo"]').addClass('erro_campo');
		} else if (mensagem=='') {
			$(compForm+' .errorMensagem').removeClass('invisible');
			$(compForm+' textarea[name="mensagem"]').addClass('erro_campo');

		} else {
			$('#compartilhe').stop().fadeTo(300, 0, function() {
				$('#compartilhe').hide();
				$.ajax({
					type: "POST",
					url: 'ajax.php',
					data: $(compForm).serialize(),
					success: function(data){
						eval(data);
						$('#sucesso').stop().fadeTo(300, 1);
					}
				});
			});
		}


		$('html, body').animate({scrollTop:0}, 'slow');
	});

	$('#sucesso #btn_enviar').click(function()
	{
		$('#sucesso').stop().fadeTo(300, 0, function()
		{
			$('#sucesso').hide();
			$('#compartilhe').stop().fadeTo(300, 1);
		});


		$('html, body').animate({scrollTop:0}, 'slow');
	});






	$('#lightbox').click(function()
	{
		fecharLightbox()
	});

	$('#sucesso #btn_fechar').click(function()
	{
		fecharLightbox()
	});

	$('#compartilhe #btn_fechar').click(function()
	{
		fecharLightbox()
	});

	function fecharLightbox()
	{
		$('#lightbox').fadeOut();
		$('#compartilhe').fadeOut();
		$('#sucesso').fadeOut();
	}










	$('#meus_numeros').hide();
	$('#esqueci').hide();
	$('#enviado').hide();




	$('.meusnumeros').click(function()
	{
		clearInterval(timer);
        showMenu();
	});

    $('#meus_numeros').hover(function()
	{
        clearInterval(timer);
    });

    $('#meus_numeros').mouseleave(function()
	{
        timer = setTimeout('hideMenu()', 500);
    });

	$('#btn_esqueci').click(function()
	{
		$('#login').fadeOut();
		$('#esqueci').fadeIn();
		$('#enviado').fadeOut();
	});

	$('#btn_cancelar').click(function()
	{
		$('#esqueci').fadeOut();
		$('#login').fadeIn();
		$('#enviado').fadeOut();
	});

	$('#btn_voltar').click(function()
	{
		$('#esqueci').fadeIn();
		$('#enviado').fadeOut();
		$('#login').fadeOut();
	});
});



function showMenu()
{
    clearInterval(timer);

	$('#login').show();
	$('#esqueci').hide();
	$('#enviado').hide();
    $('#meus_numeros').stop().fadeTo(300, 1);
}

function hideMenu()
{
    clearInterval(timer);

    $('#meus_numeros').stop().fadeTo(300, 0, function()
	{
        $('#meus_numeros').hide();
    });
}
