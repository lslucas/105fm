<?php

	// $lstProdutosRelacionados = array();
	if ($act=='update') {
/*
		$sql_per = "SELECT pro_id, cat_id FROM ".TP."_produto_taxonomy WHERE pro_id=? AND area='produtosRelacionados'";
		if (!$qry_per = $conn->prepare($sql_per))
			echo $conn->error;
		else {
			$qry_per->bind_result($pro_id, $cat_id);
			$qry_per->bind_param('i', $val['id']);
			$qry_per->execute();

				while($qry_per->fetch())
					array_push($lstProdutosRelacionados, $cat_id);

			$qry_per->close();
		}
 */
	}

?>
 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de continuar corrija os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="nome" class="error-validate">Entre com um <b>nome</b></label></li>
		<li><label for="email" class="error-validate">Entre com um <b>email</b></label></li>
		<li><label for="rg" class="error-validate">Entre com uma <b>RG</b></label></li>
		<li><label for="cpf" class="error-validate">Entre com um <b>CPF</b></label></li>
		<li><label for="cnpj" class="error-validate">Entre com um <b>CNPJ</b></label></li>
		<li><label for="inscricao_estadual" class="error-validate">Entre com uma <b>Inscrição Estadual</b></label></li>
		<li><label for="contato" class="error-validate">Entre com o <b>Contato</b></label></li>
		<li><label for="telefone1" class="error-validate">Entre com uma <b>Telefone 1</b></label></li>
		<li><label for="telefone2" class="error-validate">Entre com a <b>Telefone 2</b></label></li>
	</ol>
</div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
	if ($act=='update') {
		echo "<input type='hidden' name='item' value='${_GET['item']}'>";
	}
?>

<h1>
<?php
	if ($act=='insert') echo $var['insert'];
	 else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

		<div class="control-group">
			<label class="control-label" for="nome">* Nome</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Nome' name='nome' id='nome' value='<?=$val['nome']?>'>
				<p class="help-block">Nome de exibição</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="email">* Email</label>
			<div class="controls">
				<input type="text" class="input-xlarge required email" placeholder='Email de contato' name='email' id='email' value="<?=$val['email']?>">
				<p class="help-block">Email de contato</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="rg">RG</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='RG do anunciante' name='rg' id='rg' value="<?=$val['rg']?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cpf">CPF</label>
			<div class="controls">
				<input type="text" class="input-xlarge cpf" placeholder='CPF do anunciante' name='cpf' id='cpf' value="<?=$val['cpf']?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cnpj">CNPJ</label>
			<div class="controls">
				<input type="text" class="input-xlarge cnpj" placeholder='CNPJ da empresa ' name='cnpj' id='cnpj' value="<?=$val['cnpj']?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="nome_fantasia">Nome Fantasia</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Nome Fantasia da empresa' name='nome_fantasia' id='nome_fantasia' value="<?=$val['nome_fantasia']?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="inscricao_estadual">Inscrição Estadual</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Inscrição Estadual da empresa ' name='inscricao_estadual' id='inscricao_estadual' value="<?=$val['inscricao_estadual']?>">
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="contato">* Contato</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Contato' name='contato' id='contato' value='<?=$val['contato']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="telefone1">Telefone 1</label>
			<div class="controls">
				<input type="text" class="input-small phone" placeholder='Telefone com DDD' name='telefone1' id='telefone1' value='<?=$val['telefone1']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="telefone2">Telefone 2</label>
			<div class="controls">
				<input type="text" class="input-small" placeholder='Telefone com DDD' name='telefone2' id='telefone2' value='<?=$val['telefone2']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="ref1">Referência 1</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Referência 1' name='ref1' id='ref1' value='<?=$val['ref1']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="ref2">Referência 2</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Referência 2' name='ref2' id='ref2' value='<?=$val['ref2']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="ref3">Referência 3</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Referência 3' name='ref3' id='ref3' value='<?=$val['ref3']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="refbancaria1">Referência Bancária 1</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Referência Bancária 1' name='refbancaria1' id='refbancaria1' value='<?=$val['refbancaria1']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="refbancaria2">Referência Bancária 2</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Referência Bancária 2' name='refbancaria2' id='refbancaria2' value='<?=$val['refbancaria2']?>'>
			</div>
		</div>

	</fieldset>

		<div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>