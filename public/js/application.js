function validateEmail(email) {
    var re = /^(([^<>()[\]\\.,;:\s@\"]+(\.[^<>()[\]\\.,;:\s@\"]+)*)|(\ ".+\"))@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\])|(([a-zA -Z\-0-9]+\.)+[a-zA-Z]{2,}))$/;
    return re.test(email);
}

function checkdate(input){
	var validformat=/^\d{4}-\d{2}-\d{2}$/ //Basic check for format validity
	var returnval=false

	if (!validformat.test(input))
		return false;
	else{ //Detailed check for valid date ranges
		var monthfield=input.split("-")[1]
		var dayfield=input.split("-")[2]
		var yearfield=input.split("-")[0]
		var dayobj = new Date(yearfield, monthfield-1, dayfield)

		if ((dayobj.getMonth()+1!=monthfield)||(dayobj.getDate()!=dayfield)||(dayobj.getFullYear()!=yearfield))
			return false;
		else
			returnval=true
	}

	return returnval
}


/*
 *placeholder
 */
function placeHolder() {

  //Run this script only for IE
  if (navigator.appName === "Microsoft Internet Explorer") {

	$(function() {

	$("input[type=text]").each(function() {
	  var p;
	 // Run this script only for input field with placeholder attribute
	  if (p = $(this).attr('placeholder')) {
	  // Input field's value attribute gets the placeholder value.

		if ($(this).val()=='')
		  $(this).val(p);

		$(this).css('color', '#257396');
		// On selecting the field, if value is the same as placeholder, it should become blank
		$(this).focus(function() {
		  if (p === $(this).val()) {
			return $(this).val('');
		  }
		});
		 // On exiting field, if value is blank, it should be assigned the value of placeholder
		$(this).blur(function() {
		  if ($(this).val() === '') {
			return $(this).val(p);
		  }
		});
	  }
	});
	$("input[type=password]").each(function() {
	  var e_id, p;
	  if (p = $(this).attr('placeholder')) {
		e_id = $(this).attr('id');
		// change input type so that the text is displayed
		document.getElementById(e_id).type = 'text';
		$(this).val(p);
		$(this).focus(function() {
		  // change input type so that password is not displayed
		  document.getElementById(e_id).type = 'password';
		  if (p === $(this).val()) {
			return $(this).val('');
		  }
		});
		$(this).blur(function() {
		  if ($(this).val() === '') {
			document.getElementById(e_id).type = 'text';
			$(this).val(p);
		  }
		});
	  }
	});
	});
  }

}


$(function() {

	if (!jQuery.browser.mobile) {
	    jQuery('body').on('click', 'a[href^="tel:"]', function() {
	            jQuery(this).attr('href',
	                jQuery(this).attr('href').replace(/^tel:/, 'callto:'));
	    });
	}

	$('.cpf, #cpf').mask('999.999.999-99');
	$('.uf').mask('aa');
	$('#cnpj').mask('99.999.999/9999-99');
	$('#cep').mask('99999-999');
	$('.phone').mask('(99) 9999-9999');
	$('.date, .data').mask('99/99/9999');
	//$('.daymonth').mask('99');
	$('.year, .4digit').mask('9999');
	$('.2digit').mask('99');
	$('.year').mask('9999');
	$('.hour').mask('99:99');

	if(typeof $().priceFormat == 'function') {
	 	//mascaras
		$('.price').priceFormat({
		  prefix: 'R$ ',
		  centsSeparator: ',',
		  thousandsSeparator: '.'
		});

		$('.decimal').priceFormat({
		  prefix: '',
		  centsSeparator: '.',
		  centsLimit: 1,
		  thousandsSeparator: ''
		});
	}

	$('#msg-modal').modal({'backdrop': false});

	//Run this script only for IE
	placeHolder();
	if (navigator.appName === "Microsoft Internet Explorer") {
	  $('form').submit(function() {
	    //Interrupt submission to blank out input fields with placeholder values
	    $("input[type=text]").each(function() {
	      if ($(this).val() === $(this).attr('placeholder')) {
	        $(this).val('');
	      }
	    });
	   $("input[type=password]").each(function() {
	      if ($(this).val() === $(this).attr('placeholder')) {
	         $(this).val('');
	      }
	    });
	  });
	}

	/**
	 * Filtros
	 * @return {[type]} [description]
	 */
	$('.filtroGrupo').change(function(){
		var val = $(this).val();

		if (val<0)
			return false;

		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: 'from=filtro&grupoquimico='+val,
			success: function(data) {
				eval(data);
			}
		});

	});

	$('.filtroFabricante').change(function(){
		var fabricante = $(this).val();
		var grupoquimico = $('select[name="filtroGrupoQuimico"]').val();

		if (val<0)
			return false;

		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: 'from=filtro&fabricante='+val+'&grupoquimico='+grupoquimico,
			success: function(data) {
				eval(data);
			}
		});

	});



	/**
	 * VALIDAÇões
	 */
	$('form[name="participar"] div#btn_cadastrar').click(function() {
		var form = 'form[name="participar"]';

		$(form+' input, '+form+' select'+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('invisible');

		var datacompra = $(form+' input[name="compra_ano"]').val()+'-'+$(form+' input[name="compra_mes"]').val()+'-'+$(form+' input[name="compra_dia"]').val();
		var datanascimento = $(form+' input[name="nasc_ano"]').val()+'-'+$(form+' input[name="nasc_mes"]').val()+'-'+$(form+' input[name="nasc_dia"]').val();
		var ajaxErrors = '';

		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: $(form).serialize(),
			success: function(data){
				ajaxErrors = data;

				if (ajaxErrors!='')
					eval(ajaxErrors);

				else if (!$(form+' input[name="coo"]').val()) {
					$(form+' .errorCoo').removeClass('invisible');
					$(form+' input[name="coo"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="cnpj"]').val()) {
					$(form+' .errorCnpj').removeClass('invisible');
					$(form+' input[name="cnpj"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="estabelecimento"]').val()) {
					$(form+' .errorEstabelecimento').removeClass('invisible');
					$(form+' input[name="estabelecimento"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="compra_dia"]').val() || !$(form+' input[name="compra_mes"]').val() || !$(form+' input[name="compra_ano"]').val()) {
					$(form+' .errorDataCompra').removeClass('invisible');
					$(form+' .dataCompra').addClass('erro_campo').focus();

				} else if (!(datacompra!='--' && datacompra>='2012-11-21' && datacompra<='2012-12-23')) {
					$(form+' .errorDataCompra').removeClass('invisible');
					$(form+' .dataCompra').addClass('erro_campo').focus();

				} else if ($(form+' #produto_cat').val()=='') {
					$(form+' .errorProduto').removeClass('invisible');
					$(form+' #produto_cat"]').addClass('erro_campo').focus();
		/*
				} else if (!$(form+' .produtosList"').val()) {
					$(form+' .errorProduto').removeClass('invisible');
					$(form+' .produtosList"').not('[disabled]').addClass('erro_campo').focus();
		 */
				} else if (!$(form+' input[name="nome"]').val()) {
					$(form+' .errorNome').removeClass('invisible');
					$(form+' input[name="nome"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="cpf"]').val()) {
					$(form+' .errorCpf').removeClass('invisible');
					$(form+' input[name="cpf"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="ddd1"]').val() || !$(form+' input[name="telefone1_1"]').val() || !$(form+' input[name="telefone1_2"]').val()) {
					$(form+' .errorTelefone').removeClass('invisible');
					$(form+' .telefone1').addClass('erro_campo');
					$(form+' input[name="ddd1"]').focus();

				} else if (!$(form+' input[name="nasc_dia"]').val() || !$(form+' input[name="nasc_mes"]').val() || !$(form+' input[name="nasc_ano"]').val()) {
					$(form+' .errorNascimento').removeClass('invisible');
					$(form+' .nascimento').addClass('erro_campo');
					$(form+'  input[name="nasc_dia"]').focus();

				} else if (!checkdate(datanascimento)) {
					$(form+' .errorNascimento').text('Data no formato inválido!').removeClass('invisible');
					$(form+' .nascimento').addClass('erro_campo');
					$(form+'  input[name="nasc_dia"]').focus();

				} else if (datanascimento!='--' && datanascimento>'1999-12-28') {
					$(form+' .errorNascimento').text('Ops, você precisa ter mais de 13 anos para participar!').removeClass('invisible');
					$(form+' .nascimento').addClass('erro_campo');
					$(form+'  input[name="nasc_dia"]').focus();

				} else if (!$(form+' input[name="cep1"]').val() || !$(form+' input[name="cep2"]').val()) {
					// $(form+' .errorCep').removeClass('invisible');
					$(form+' .cep').addClass('erro_campo');
					$(form+' input[name="cep1"]').focus();

				} else if (!$(form+' input[name="email"]').val()) {
					$(form+' .errorEmail').removeClass('invisible');
					$(form+' input[name="email"]').addClass('erro_campo').focus();

				} else if ($(form+' input[name="email"]').val()!=$(form+' input[name="confirmaEmail"]').val()) {
					$(form+' .errorConfirmaEmail').removeClass('invisible');
					$(form+' input[name="confirmaEmail"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="endereco"]').val()) {
					$(form+' .errorEndereco').removeClass('invisible');
					$(form+' input[name="endereco"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="numero"]').val()) {
					$(form+' .errorNumero').removeClass('invisible');
					$(form+' input[name="numero"]').addClass('erro_campo').focus();

				} else if (!$(form+' #estado').val()) {
					$(form+' .errorEstado').removeClass('invisible');
					$(form+' input[name="estado"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="cidade"]').val()) {
					$(form+' .errorCidade').removeClass('invisible');
					$(form+' input[name="cidade"]').addClass('erro_campo').focus();

				} else if ($(form+' input[name="senha"]').val().length<6) {
					console.log($(form+' input[name="senha"]').val().length);
					$(form+' .errorSenha').removeClass('invisible');
					$(form+' input[name="senha"]').addClass('erro_campo').focus();

				} else if ($(form+' input[name="senha"]').val()!=$(form+' input[name="confirmaSenha"]').val()) {
					$(form+' .errorConfirmaSenha').removeClass('invisible');
					$(form+' input[name="confirmaSenha"]').addClass('erro_campo').focus();

				} else
					$(form).submit();
			}
		});
	});


	$('form[name="editar-dados"] div#btn_salvar').click(function() {
		var form = 'form[name="editar-dados"]';
		var datanascimento = $(form+' input[name="nasc_ano"]').val()+'-'+$(form+' input[name="nasc_mes"]').val()+'-'+$(form+' input[name="nasc_dia"]').val();

		$(form+' input, '+form+' select'+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('invisible');

		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: $(form).serialize(),
			success: function(data){
				ajaxErrors = data;

				if (!$(form+' input[name="nome"]').val()) {
					$(form+' .errorNome').removeClass('invisible');
					$(form+' input[name="nome"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="cpf"]').val()) {
					$(form+' .errorCpf').removeClass('invisible');
					$(form+' input[name="cpf"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="ddd1"]').val() || !$(form+' input[name="telefone1_1"]').val() || !$(form+' input[name="telefone1_2"]').val()) {
					$(form+' .errorTelefone').removeClass('invisible');
					$(form+' .telefone1').addClass('erro_campo');
					$(form+' input[name="ddd1"]').focus();

				} else if (!$(form+' input[name="nasc_dia"]').val() || !$(form+' input[name="nasc_mes"]').val() || !$(form+' input[name="nasc_ano"]').val()) {
					$(form+' .errorNascimento').removeClass('invisible');
					$(form+' .nascimento').addClass('erro_campo');
					$(form+'  input[name="nasc_dia"]').focus();

				} else if (!checkdate(datanascimento)) {
					$(form+' .errorNascimento').text('Data no formato inválido!').removeClass('invisible');
					$(form+' .nascimento').addClass('erro_campo');
					$(form+'  input[name="nasc_dia"]').focus();

				} else if (datanascimento!='--' && datanascimento>'1999-12-28') {
					$(form+' .errorNascimento').text('Ops, você precisa ter mais de 13 anos para participar!').removeClass('invisible');
					$(form+' .nascimento').addClass('erro_campo');
					$(form+'  input[name="nasc_dia"]').focus();

				} else if (!$(form+' input[name="cep1"]').val() || !$(form+' input[name="cep2"]').val()) {
					// $(form+' .errorCep').removeClass('invisible');
					$(form+' .cep').addClass('erro_campo');
					$(form+' input[name="cep1"]').focus();

				} else if ($(form+' input[name="email"]').val()!=$(form+' input[name="confirmaEmail"]').val()) {
					$(form+' .errorConfirmaEmail').removeClass('invisible');
					$(form+' input[name="confirmaEmail"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="endereco"]').val()) {
					$(form+' .errorEndereco').removeClass('invisible');
					$(form+' input[name="endereco"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="numero"]').val()) {
					$(form+' .errorNumero').removeClass('invisible');
					$(form+' input[name="numero"]').addClass('erro_campo').focus();

				} else if (!$(form+' #estado').val()) {
					$(form+' .errorEstado').removeClass('invisible');
					$(form+' input[name="estado"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="cidade"]').val()) {
					$(form+' .errorCidade').removeClass('invisible');
					$(form+' input[name="cidade"]').addClass('erro_campo').focus();

				} else if ($(form+' input[name="senha"]').val() && $(form+' input[name="senha"]').val().length<6) {
					console.log($(form+' input[name="senha"]').val().length);
					$(form+' .errorSenha').removeClass('invisible');
					$(form+' input[name="senha"]').addClass('erro_campo').focus();

				} else if ($(form+' input[name="senha"]').val()!=$(form+' input[name="confirmaSenha"]').val()) {
					$(form+' .errorConfirmaSenha').removeClass('invisible');
					$(form+' input[name="confirmaSenha"]').addClass('erro_campo').focus();

				} else if (ajaxErrors!='')
					eval(ajaxErrors);

				else
					$(form).submit();
			}
		});
	});


	$('form[name="editar-cupom"] div#btn_salvar, form[name="meus-numeros"] a#cadastrar').click(function() {

		if ($('form[name="editar-cupom"]').length>0)
			var formName = 'editar-cupom';
		else if ($('form[name="meus-numeros"]').length>0)
			var formName = 'meus-numeros';

		var form = 'form[name="'+formName+'"]';
		var ajaxErrors = false;

		$(form+' input, '+form+' select'+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('invisible');

		var datacompra = $(form+' input[name="compra_ano"]').val()+'-'+$(form+' input[name="compra_mes"]').val()+'-'+$(form+' input[name="compra_dia"]').val();

		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: $(form).serialize(),
			success: function(data){
				ajaxErrors = data;

				if (!$(form+' input[name="coo"]').val()) {
					$(form+' .errorCoo').removeClass('invisible');
					$(form+' input[name="coo"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="cnpj"]').val()) {
					$(form+' .errorCnpj').removeClass('invisible');
					$(form+' input[name="cnpj"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="estabelecimento"]').val()) {
					$(form+' .errorEstabelecimento').removeClass('invisible');
					$(form+' input[name="estabelecimento"]').addClass('erro_campo').focus();

				} else if (!$(form+' input[name="compra_dia"]').val() || !$(form+' input[name="compra_mes"]').val() || !$(form+' input[name="compra_ano"]').val()) {
					$(form+' .errorDataCompra').removeClass('invisible');
					$(form+' .dataCompra').addClass('erro_campo').focus();

				} else if (!(datacompra!='--' && datacompra>='2012-11-21' && datacompra<='2012-12-23')) {
					$(form+' .errorDataCompra').removeClass('invisible');
					$(form+' .dataCompra').addClass('erro_campo').focus();

				} else if ($(form+' #produto_cat').val()=='') {
					$(form+' .errorProduto').removeClass('invisible');
					$(form+' #produto_cat"]').addClass('erro_campo').focus();
		/*
				} else if (!$(form+' .produtosList"').val()) {
					$(form+' .errorProduto').removeClass('invisible');
					$(form+' .produtosList"').not('[disabled]').addClass('erro_campo').focus();
		 */
				} else if (ajaxErrors!='')
					eval(ajaxErrors);

				else
					$(form).submit();
			}
		});
	});


	$('form[name="esqueci-senha"] div#btn_enviar').click(function() {
		var form = 'form[name="esqueci-senha"]';
		var ajaxErrors = '';

		$(form+' input, '+form+' select, '+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('invisible');

		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: $(form).serialize(),
			success: function(data){
				ajaxErrors = data;

				if (!$(form+' input[name="email"]').val() || !validateEmail($(form+' input[name="email"]').val())) {
					$(form+' .errorEmail').removeClass('invisible');
					$(form+' input[name="email"]').addClass('erro_campo').focus();

				} else if (ajaxErrors!='')
					eval(ajaxErrors);
				else
					$(form).submit();
			}

		});

	});

	$('form[name="redefinicao-senha"] div#btn_enviar').click(function() {
		var form = 'form[name="redefinicao-senha"]';

		$(form+' input, '+form+' select, '+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('invisible');

		if (!$(form+' input[name="senha"]').val() || ($(form+' input[name="senha"]').val() && $(form+' input[name="senha"]').val().length<6)) {
			console.log($(form+' input[name="senha"]').val().length);
			$(form+' .errorSenha').removeClass('invisible');
			$(form+' input[name="senha"]').addClass('erro_campo').focus();

		} else if ($(form+' input[name="senha"]').val()!=$(form+' input[name="confirmaSenha"]').val()) {
			$(form+' .errorConfirmaSenha').removeClass('invisible');
			$(form+' input[name="confirmaSenha"]').addClass('erro_campo').focus();

		} else
			$(form).submit();
	});


	$('form[name="fale-conosco"] a#enviar').click(function() {
		var form = 'form[name="fale-conosco"]';

		$(form+' input, '+form+' select, '+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('invisible');

		if (!$(form+' input[name="nome"]').val()) {
			$(form+' .errorNome').removeClass('invisible');
			$(form+' input[name="nome"]').addClass('erro_campo').focus();

		} else if (!$(form+' input[name="email"]').val() || !validateEmail($(form+' input[name="email"]').val())) {
			$(form+' .errorEmail').removeClass('invisible');
			$(form+' input[name="email"]').addClass('erro_campo').focus();

		} else if (!$(form+' #assunto').val()) {
			$(form+' .errorAssunto').removeClass('invisible');
			$(form+' #assunto').addClass('erro_campo').focus();

		} else if (!$(form+' textarea#mensagem2').val()) {
			$(form+' .errorMensagem').removeClass('invisible');
			$(form+' textarea#mensagem2').addClass('erro_campo').focus();

		} else
			$(form).submit();
	});


	$('form[name="login"] div#btn_acessar').click(function() {
		var form = 'form[name="login"]';

		$(form+' input, '+form+' select, '+form+' textarea').removeClass('erro_campo');
		$(form+' .erro').addClass('hide');

		if (!$(form+' input[name="email"]').val() || !validateEmail($(form+' input[name="email"]').val())) {
			$(form+' .errorEmail').removeClass('hide');
			$(form+' input[name="email"]').addClass('erro_campo').focus();

		} else if (!$(form+' input[name="senha"]').val() || ($(form+' input[name="senha"]').val() && $(form+' input[name="senha"]').val().length<6)) {
			console.log($(form+' input[name="senha"]').val().length);
			$(form+' .errorSenha').removeClass('hide');
			$(form+' input[name="senha"]').addClass('erro_campo').focus();

		} else
			$(form).submit();
	});


});