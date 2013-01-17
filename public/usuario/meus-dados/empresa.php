		<input type='hidden' name='id' value='<?=isset($val['id']) ? $val['id'] : null?>'/>
		<input type='hidden' name='querystring' value='<?=isset($querystring) ? $querystring : null?>'/>
		<div class="control-group">
			<label class="control-label" for="cnpj">CNPJ</label>
			<div class="controls">
				<input type="text" class="input-xlarge cnpj" placeholder='CNPJ da empresa ' name='cnpj' id='cnpj' value="<?=isset($val['cnpj']) ? $val['cnpj'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="nome_fantasia">Nome Fantasia</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Nome Fantasia da empresa' name='nome_fantasia' id='nome_fantasia' value="<?=isset($val['nome_fantasia']) ? $val['nome_fantasia'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="inscricao_estadual">Inscrição Estadual</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Inscrição Estadual da empresa ' name='inscricao_estadual' id='inscricao_estadual' value="<?=isset($val['inscricao_estadual']) ? $val['inscricao_estadual'] : null?>">
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="contato">* Contato</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Contato' name='contato' id='contato' value='<?=isset($val['contato']) ? $val['contato'] : null?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="telefone1">Telefone 1</label>
			<div class="controls">
				<input type="text" class="input-small phone" placeholder='Telefone com DDD' name='telefone1' id='telefone1' value='<?=isset($val['telefone1']) ? $val['telefone1'] : null?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="telefone2">Telefone 2</label>
			<div class="controls">
				<input type="text" class="input-small" placeholder='Telefone com DDD' name='telefone2' id='telefone2' value='<?=isset($val['telefone2']) ? $val['telefone2'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="foto">Logomarca</label>
			<div class="controls">
				 <input class="input-xlarge" type='file' name='foto' id='foto' >
					 <br/><small>- JPEG, PNG ou GIF; <?=$var['imagemSizeTexto']?></small>
			</div>
		</div>