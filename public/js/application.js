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

	// if (!$.browser.mobile) {
	    $('body').on('click', 'a[href^="tel:"]', function() {
	            $(this).attr('href',
	                $(this).attr('href').replace(/^tel:/, 'callto:'));
	    });
	// }

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


	/* APAGA ITEM DO PAINEL DO USUARIO
	************************************/
	$(".btn-rm").click(function(event){
		event.preventDefault();
		var id_rm = $(this).attr('id');

		$('.modal').modal('hide');
		$.ajax({
			type: "POST",
			data: 'id='+id_rm+'&from=rm-item',
			url: ABSPATH+'ajax.php',
			success: function(data){
				if (data==true) {
					showModal('{"title": "Sucesso!", "content":"Item removido com êxito!"}');
					$('#tr'+id_rm).hide();
				} else
					showModal('{"title": "Erro!", "content":"Houve um problema ao tentar remover o item selecionado, tente mais tarde!"}');
			}
		});

	});

	/* APAGA INTERESSE DO PAINEL DO USUARIO
	************************************/
	$(".btnint-rm").click(function(event){
		event.preventDefault();
		var id_rm = $(this).attr('id');

		$('.modal').modal('hide');
		$.ajax({
			type: "POST",
			data: 'id='+id_rm+'&from=rm-interesse',
			url: ABSPATH+'ajax.php',
			success: function(data){
				if (data==true) {
					showModal('{"title": "Sucesso!", "content":"Item removido com êxito!"}');
					$('#tr'+id_rm).hide();
				} else
					showModal('{"title": "Erro!", "content":"Houve um problema ao tentar remover o item selecionado, tente mais tarde!"}');
			}
		});

	});
	/* FIM: APAGA*/

	/**
	 * bind table row click
	 */
	 /*
	$("tr").bind("click", function(){
		if ($('a:hover').attr('href')!=undefined)
			window.location = $('a:hover').attr('href');
		else if ($(this).attr('data-href')) {
			window.location = $(this).attr('data-href');
		} else
			return false;
	});
	 */

	/**
	 * showOnClick
	 */
	 $('.showOnClick').click(function() {
	 	var target = $(this).attr('data-target');
	 	$(target).show().find('input').attr('disabled', false);
	 });

	 // update showonclick
 	if ($('#nomeProduto').val()!='') $('#outroProduto').show().find('input').attr('disabled', false);
	 else $('#outroProduto').hide().find('input').attr('disabled', true);

 	if ($('#nomeFabricante').val()!='') $('#outroFabricante').show().find('input').attr('disabled', false);
	 else $('#outroFabricante').hide().find('input').attr('disabled', true);

 	if ($('#nomeEmbalagem').val()!='') $('#outraEmbalagem').show().find('input').attr('disabled', false);
	 else $('#outraEmbalagem').hide().find('input').attr('disabled', true);

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
		var grupoquimico = $('select.filtroGrupo').val();

		if (fabricante<0 || grupoquimico<0)
			return false;

	 	$('#outroFabricante').hide().find('input').val('').attr('disabled', true);
		$.ajax({
			type: "POST",
			url: ABSPATH+'ajax.php',
			data: 'from=filtro&fabricante='+fabricante+'&grupoquimico='+grupoquimico,
			success: function(data) {
				eval(data);
			}
		});

	});

	$('.filtroProduto').change(function(){
		var produto = $(this).val();

		if (produto>0)
		 	$('#outroProduto').hide().find('input').val('').attr('disabled', true);
	});


	/*
	 *Modal Global de mensagens e alertas
	 */
	function showModal(args)
	{
		if (!args) {
			if(typeof console.log == 'function') console.log('showModal: Argumento inválido!');
			else alert('showModal: Argumento inválido!');

			return false;
		}

		args = JSON.parse(args);

		//titulo do modal
		var title = null;
		if (args.title)
			title = " <h3>"+args.title+"</h3>";

		// botão fechar/cancelar
		if (args.buttonClose)
			var closeButton = args.buttonClose;
		else
			closeButton = 'Fechar';

		// botão de ação 1
		var actionButton1 =  '';
		if (args.button) {

			var btn_color = 'btn-primary';
			if (args.button.color!=undefined)
				btn_color = args.button.color;

			var btn_class = '';
			if (args.button.class!=undefined)
				btn_class = args.button.class;

			var btn_id = '';
			if (args.button.id!=undefined)
				btn_id = args.button.id;

			var btn_name = '';
			if (args.button.name!=undefined)
				btn_name = args.button.name;

			var btn_href = 'javascript:void(0);';
			if (args.button.href!=undefined)
				btn_href = args.button.href;

			var btn_target = ' ';
			if (args.button.target!=undefined)
				btn_target = " target='"+args.button.target+"' ";

			if (args.button)
				actionButton1 = "<a href='"+btn_href+"'"+btn_target+"id='"+btn_id+"' name='"+btn_name+"' class='btn-rm btn "+btn_class+" "+btn_color+"'>"+args.button.value+"</a>";

		}

		// botão de ação 2
		var actionButton2 = '';
		if (args.button2) {

			var btn_color = 'btn-primary';
			if (args.button2.color!=undefined)
				btn_color = args.button2.color;

			var btn_class = '';
			if (args.button2.class!=undefined)
				btn_class = args.button2.class;

			var btn_id = '';
			if (args.button2.id!=undefined)
				btn_id = args.button2.id;

			var btn_name = '';
			if (args.button2.name!=undefined)
				btn_name = args.button2.name;

			var btn_href = 'javascript:void(0);';
			if (args.button2.href!=undefined)
				btn_href = args.button2.href;

			var btn_target = ' ';
			if (args.button2.target!=undefined)
				btn_target = " target='"+args.button2.target+"' ";

			if (args.button2!=undefined)
				actionButton2 = "<a href='"+btn_href+"'"+btn_target+"id='"+btn_id+"' name='"+btn_name+"' class='btn-rm btn "+btn_class+" "+btn_color+"'>"+args.button2.value+"</a>";

		}

		// cria template do modal
		var template = "<div class='modal fade hide' id='msg-modal'>";
		template += "<div class='modal-header'> <a class='close' data-dismiss='modal'>×</a>"+title+"</div>";
		template += "<div class='modal-body'>";
		template += "<p>"+args.content+"</p>";
		template += "</div>";
		template += "<div class='modal-footer'>";

		template += actionButton1;
		template += actionButton2;
		template += "	<a href='javascript:void(0);' class='btn' data-dismiss='modal'>"+closeButton+"</a>";
		template += "</div></div>";


		if ($('#html-msg'))
			$('#html-msg').html(template);
		else
			$(template).appendTo('body');

		$('#msg-modal').modal('show');

	}

});