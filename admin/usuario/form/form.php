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
		<li><label for="cidade" class="error-validate">Entre com a <b>Cidade</b></label></li>
		<li><label for="uf" class="error-validate">Entre com a <b>UF</b></label></li>
		<li><label for="cep" class="error-validate">Entre com o <b>CEP</b></label></li>
	</ol>
</div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
	if ($act=='update') {
		echo "<input type='hidden' name='item' value='${_GET['item']}'>";
		if ($act=='update' && !empty($val['address']['id']))
			echo "<input type='hidden' name='adb_id' value='{$val['address']['id']}'>";
	}
?>

<h1>
<?php
	if ($act=='insert') echo $var['insert'];
	 else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

	<fieldset>
		<legend>Informações Básicas</legend>

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
			<label class="control-label" for="senha"><?=$act=='insert' ? '* ' : null?>Senha</label>
			<div class="controls">
				<input type="text" class="input-small<?=$act=='insert' ? ' required ' : null?>" placeholder='Senha' name='senha' id='senha' value="<?=$act=='insert' ? substr($hashids->encrypt(time()), 0, 4) : null?>">
				<p class="help-block">
					<?php if ($act=='insert') { ?>
					Senha gerada automaticamente: <?=substr($hashids->encrypt(time()), 0, 4)?>
					<?php } else { ?>
					Você pode alterar a senha se o usuário perdeu, do contrário deixe em branco. Caso queira uma senha segura e randômica use: <?=substr($hashids->encrypt(time()), 0, 4)?>
					<?php } ?>
				</p>
			</div>
		</div>

		<!--
		<div class="control-group">
			<label class="control-label" for="rg">RG</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='RG' name='rg' id='rg' value="<?=$val['rg']?>">
			</div>
		</div>
		-->

		<div class="control-group">
			<label class="control-label" for="cpf">CPF</label>
			<div class="controls">
				<input type="text" class="input-xlarge cpf" placeholder='CPF' name='cpf' id='cpf' value="<?=$val['cpf']?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="foto">Logotipo<!--<br/><span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar +fotos</a></span>--></label>
			<div class="controls">
				<?php
					$num=0;
					if ($act=='update') {

						$sql_gal = "SELECT tax_id, tax_file, tax_descricao, tax_pos FROM ".TP."_taxonomy WHERE tax_area='{$var['path']}' AND tax_idrel=? AND tax_file IS NOT NULL ORDER BY tax_pos DESC LIMIT 1;";
						if (!$qr_gal = $conn->prepare($sql_gal))
							echo $conn->error;
						else {
							$qr_gal->bind_param('s',$_GET['item']);
							$qr_gal->execute();
							$qr_gal->store_result();
							$num = $qr_gal->num_rows;
							$qr_gal->bind_result($g_id, $g_file, $g_descricao, $g_pos);
							$i=0;

							if ($num>0) {
								echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
								while ($qr_gal->fetch()) {

								$arquivo = $var['path_original']."/".$g_file;
				?>
								<?php /* ?>
								<a href='$imagThumb<?php echo $i?>?width=100%' id='imag<?php echo $i?>' class='betterTip' target='_blank'>
									<img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'>
								</a>
								<div id='imagThumb<?php echo $i?>' style='float:left;display:none;'>
									<?php
										if (file_exists(substr($var['path_thumb'],0)."/".$g_imagem))
											echo "<img src='".substr($var['path_thumb'],0)."/".$g_imagem."'>";
										else
											echo "<center>imagem não existe.</center>";
									?>
								</div>
								<?php */ ?>
								<tr id="<?=$g_id?>">
									<td title='Click and drag to change image position' class='tip'>
										<small>
											[<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=taxonomy&pre=tax&col=file&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover esse item" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remove</a>]
										</small>
										 <img src='<?=substr($var['path_thumb'],0)."/".$g_file?>'>
										 &nbsp; <span style='font-size:8pt; color:#777;'><?=!empty($g_descricao) ? $g_descricao : null?></span>
									</td>
								</tr>
				<?php
							$i++;

								}
							}
						}
					}
					echo '</table><br>';
				 ?>
				 <div class='divImagem'>
					 <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
					 <br><small>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></small>
				 </div>
				<!-- <p class='help-block'>Clique e arraste para alterar a posição</p> -->
			</div>
		</div>

	</fieldset>

	<fieldset>
		<legend>Dados da Empresa</legend>

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
			<label class="control-label" for="contato">Contato</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Contato' name='contato' id='contato' value='<?=$val['contato']?>'>
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

	</fieldset>

	<fieldset>
		<legend>Endereço e Localidade</legend>

		<div class="control-group">
			<label class="control-label" for="endereco">Endereço</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Endereço' name='endereco' id='endereco' value='<?=isset($val['address']['endereco']) ? $val['address']['endereco'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="complemento">Complemento</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Complemento' name='complemento' id='complemento' value='<?=isset($val['address']['complemento']) ? $val['address']['complemento'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cidade">* Cidade</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Cidade' name='cidade' id='cidade' value='<?=isset($val['address']['cidade']) ? $val['address']['cidade'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="uf">* UF</label>
			<div class="controls">
				<input type="text" class="input-small required" maxlength=2 placeholder='UF' name='uf' id='uf' value='<?=isset($val['address']['uf']) ? $val['address']['uf'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cep">* CEP</label>
			<div class="controls">
				<input type="text" class="input-medium required cep" placeholder='CEP' name='cep' id='uf' value='<?=isset($val['address']['cep']) ? $val['address']['cep'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="tipo">Tipo</label>
			<div class="controls">
				<select name="tipo" id="tipo">
					<option value="">Selecione</option>
					<option value="comercial"<?=isset($val['address']['tipo']) && $val['address']['tipo']=='comercial' ? ' selected=selected' : null?>>Comercial</option>
					<option value="residencial"<?=isset($val['address']['tipo']) && $val['address']['tipo']=='residencial' ? ' selected=selected' : null?>>Residencial</option>
				</select>
			</div>
		</div>

	</fieldset>

		<div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>