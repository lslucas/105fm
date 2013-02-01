(function($) {
  $.fn.showModal = function(args) {

	if (!args) {
		if(typeof console.log == 'function') console.log('showModal: Argumento inválido!');
		else alert('showModal: Argumento inválido!');

		return false;
	}

	if (!isJson(args))
		args = '{"content": "'+args+'"}';
	args = JSON.parse(args)

	//titulo do modal
	var title = '';
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
		if (args.button.color)
			btn_color = args.button.color;

		var btn_class = '';
		if (args.button.classe)
			btn_class = args.button.classe;

		var btn_id = '';
		if (args.button.id)
			btn_id = args.button.id;

		var btn_name = '';
		if (args.button.name)
			btn_name = args.button.name;

		var btn_href = 'javascript:void(0);';
		if (args.button.href)
			btn_href = args.button.href;

		var btn_target = ' ';
		if (args.button.target)
			btn_target = " target='"+args.button.target+"' ";

		if (args.button)
			actionButton1 = "<a href='"+btn_href+"'"+btn_target+"id='"+btn_id+"' name='"+btn_name+"' class='btn-rm btn "+btn_class+" "+btn_color+"'>"+args.button.value+"</a>";

	}

	// botão de ação 2
	var actionButton2 = '';
	if (args.button2) {

		var btn_color = 'btn-primary';
		if (args.button2.color)
			btn_color = args.button2.color;

		var btn_class = '';
		if (args.button2.classe)
			btn_class = args.button2.classe;

		var btn_id = '';
		if (args.button2.id)
			btn_id = args.button2.id;

		var btn_name = '';
		if (args.button2.name)
			btn_name = args.button2.name;

		var btn_href = 'javascript:void(0);';
		if (args.button2.href)
			btn_href = args.button2.href;

		var btn_target = ' ';
		if (args.button2.target)
			btn_target = " target='"+args.button2.target+"' ";

		if (args.button2)
			actionButton2 = "<a href='"+btn_href+"'"+btn_target+"id='"+btn_id+"' name='"+btn_name+"' class='btn-rm btn "+btn_class+" "+btn_color+"'>"+args.button2.value+"</a>";

	}

	// cria template do modal
	var template = "<div class='modal fade hide' id='msg-modal'>";
	if (title!='')
		template += "<div class='modal-header'> <a class='close' data-dismiss='modal'>×</a>"+title+"</div>";
	template += "<div class='modal-body'>";
	if (title=='')
		template += "<a class='close' data-dismiss='modal'>×</a>";
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
  };
})(jQuery);