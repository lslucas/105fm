<?php

	/**
	 * ZERAR SENHA
	 */
	if (isset($_POST['form_name']) && $_POST['form_name']=='esqueci-senha') {
		include_once 'modules/classes/cadastro.php';

		$val = array();
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		$cadastro = new Cadastro();
		$res = $cadastro->zerarSenha($val['email']);

		if (isset($res['alert'])) {
			echo "\n\n";
			echo "$(form+' .errorEmail').text('{$res['alert']}').removeClass('invisible');\n";
			echo "$(form+' input[name=\"email\"]').addClass('erro_campo').focus();\n";
		} else {
			echo "\n";
			echo "$('#esqueci').fadeOut();\n";
			echo "$('#login').fadeOut();\n";
			echo "$('#enviado').fadeIn();\n";
			echo "$(form+' input[name=\"email\"]').val('');";
		}

	}

	/**
	 * EDITAR DADOS
	 */
	if (isset($_POST['from']) && $_POST['from']=='editar-dados') {

		include_once 'modules/classes/cadastro.php';

		$msg = $msgTitle = $res = null;
		$val = array();


		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		$cadastro = new Cadastro();
		$resCadastro = $cadastro->validaCadastroAjax($val);

		if ($resCadastro!==true) {
			echo "\n\n";
			if (isset($resCadastro['cpf'])) {
				echo "$(form+' .errorCpf').text('{$resCadastro['cpf']}').removeClass('invisible');";
				echo "$(form+' input[name=\"cpf\"]').addClass('erro_campo').focus();";
			}

			if (isset($resCadastro['email'])) {
				echo "$(form+' .errorEmail').text('{$resCadastro['email']}').removeClass('invisible');";
				echo "$(form+' input[name=\"email\"]').addClass('erro_campo').focus();";
			}
		}

	}

	/**
	 * MEUS NÚMEROS // EDITAR CUPOM
	 */
	if (isset($_POST['from']) && in_array($_POST['from'], array('meus-numeros', 'editar-cupom'))) {

		include_once 'modules/classes/compra.php';

		$msg = $msgTitle = $res = null;
		$val = array();


		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		$compra = new Compra();
		$resCompra = $compra->validaCompraAjax($val);

		if ($resCompra!==true) {
			echo "\n\n";
			echo "$(form+' .errorCoo').text('{$resCompra['alert']}').removeClass('invisible');";
			echo "$(form+' input[name=\"coo\"]').addClass('erro_campo').focus();";
		}

	}

	/**
	 * PARTICIPAR
	 */
	if (isset($_POST['from']) && $_POST['from']=='participar') {

		include_once 'modules/classes/cadastro.php';
		include_once 'modules/classes/compra.php';
		include_once 'modules/classes/cupons.php';

		$msg = $msgTitle = $res = null;
		$val = array();


		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		$cadastro = new Cadastro();
		$resCadastro = $cadastro->validaCadastroAjax($val);

		if ($resCadastro!==true) {
			echo "\n\n";
			if (isset($resCadastro['cpf'])) {
				echo "$(form+' .errorCpf').text('{$resCadastro['cpf']}').removeClass('invisible');";
				echo "$(form+' input[name=\"cpf\"]').addClass('erro_campo').focus();";
			}

			if (isset($resCadastro['email'])) {
				echo "$(form+' .errorEmail').text('{$resCadastro['email']}').removeClass('invisible');";
				echo "$(form+' input[name=\"email\"]').addClass('erro_campo').focus();";
			}
		}

		$compra = new Compra();
		$resCompra = $compra->validaCompraAjax($val);

		if ($resCompra!==true) {
			echo "\n\n";
			echo "$(form+' .errorCoo').text('{$resCompra['alert']}').removeClass('invisible');";
			echo "$(form+' input[name=\"coo\"]').addClass('erro_campo').focus();";
		}

	}

	/**
	 * COMPARTILHE
	 */
	if (isset($_POST['form_name']) && $_POST['form_name']=='compartilhe') {
		include_once 'modules/classes/mail.php';

		$msg = $msgTitle = $res = $error = null;
		$val = array();

		/**
		 * Envia email
		 */
		foreach ($_POST as $key=>$value)
			$val[$key] = trim($value);

		if (empty($val['email']) || !validaEmail($val['email']))
			$error .= "<li>Preencha um email válido!</li>";
		if (empty($val['emailAmigo']))
		// if (empty($val['emailAmigo']) || !validaEmail($val['emailAmigo']))
			$error .= "<li>Preencha um email do amigo válido!</li>";
		if (empty($val['mensagem']))
			$error .= "<li>Escreva sua mensagem!</li>";

		if (empty($error)) {

			$emailAmigo = explode(',', $val['emailAmigo']);
			foreach ($emailAmigo as $emlAmigo) {
				$args = array(
			            'fromName'=>'',
			            'fromEmail'=>$val['email'],
			            'nome'=>'',
			            'email'=>trim($emlAmigo),
			            'mensagem'=>$val['mensagem'],
			          );
				$mail = new Mail();

				if ($mail->compartilhe($args))
					echo "\n $(compForm+' input, '+compForm+' textarea').val('');";
			}
		}


	}

	/**
	 * Filtros
	 */
	if (isset($_POST['from']) && $_POST['from']=='filtro') {

		if (isset($_POST['grupoquimico']) && isset($_POST['fabricante']) ) {

			$area = 'Produto';
			$grupoquimico = isset($_POST['grupoquimico']) ? apenasNumeros($_POST['grupoquimico']) : null;
			$fabricante = isset($_POST['fabricante']) ? apenasNumeros($_POST['fabricante']) : null;
			$values = getProdutosByOptions(array('fabricante'=>$fabricante, 'grupoquimico'=>$grupoquimico), 'Produto');

			if (count($values)<=1) {
				$valuesEmpty = array('id'=>-1, 'titulo'=>'Nenhum Produto com os filtros selecionados!');
				array_push($values, $valuesEmpty);
			}

			$optList = convertCatList2Option($values);
			echo "\n $('select.filtro{$area}').html(\"{$optList}\");";


		} elseif (!isset($_POST['fabricante'])) {

			$area = 'Fabricante';
			$grupoquimico = apenasNumeros($_POST['grupoquimico']);
			// $values = array(0=> array('id'=>0, 'titulo'=>'Fabricante'));

			//fabricante
			$fabricanteValues = getCategoriaListArea($area, $grupoquimico, 'Fabricante');
			if (count($fabricanteValues)<=1) {
				$valuesEmpty = array('id'=>-1, 'titulo'=>'Nenhum Fabricante com o Grupo Químico selecionado!');
				array_push($fabricanteValues, $valuesEmpty);
			}

			$optListFabricante = convertCatList2Option($fabricanteValues);
			echo "\n $('select.filtro{$area}').html(\"{$optListFabricante}\");";

			//produto
			$produtoValues = getProdutosByOptions(array('grupoquimico'=>$grupoquimico), 'Produto');
			if (count($produtoValues)<=1) {
				$valuesEmpty = array('id'=>-1, 'titulo'=>'Nenhum Produto com os filtros selecionados!');
				array_push($produtoValues, $valuesEmpty);
			}

			$optListProduto = convertCatList2Option($produtoValues);
			echo "\n $('select.filtroProduto').html(\"{$optListProduto}\");";

		}

	}