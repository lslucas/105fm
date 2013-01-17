		<input type='hidden' name='id' value='<?=isset($val['id']) ? $val['id'] : null?>'/>
		<input type='hidden' name='querystring' value='<?=isset($querystring) ? $querystring : null?>'/>
		<div class="control-group">
			<label class="control-label" for="endereco">Endereço</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Endereço da empresa ' name='endereco' id='endereco' value="<?=isset($val['endereco']) ? $val['endereco'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="complemento">Complemento</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='Complemento' name='complemento' id='complemento' value="<?=isset($val['complemento']) ? $val['complemento'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cidade"><span class='color-red'>*</span> Cidade</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Cidade' name='cidade' id='cidade' value="<?=isset($val['cidade']) ? $val['cidade'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="uf"><span class='color-red'>*</span> UF</label>
			<div class="controls">
				<input type="text" class="input-small required" maxlength='2' placeholder='UF' name='uf' id='uf' value="<?=isset($val['uf']) ? $val['uf'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cep"><span class='color-red'>*</span> CEP</label>
			<div class="controls">
				<input type="text" class="input-small required cep" max-length='10' placeholder='CEP' name='cep' id='cep' value="<?=isset($val['cep']) ? $val['cep'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="tipo"><span class='color-red'>*</span> Tipo</label>
			<div class="controls">
				<select name="tipo" id="tipo" class="required">
					<option value='' <?php if(isset($val['tipo']) && empty($val['tipo'])) echo ' selected';?>>Selecione</option>
					<option value='comercial' <?php if(isset($val['tipo']) && $val['tipo']=='comercial') echo ' selected';?>>Comercial</option>
					<option value='residencial' <?php if(isset($val['tipo']) && $val['tipo']=='residencial') echo ' selected';?>>Residencial</option>
			</select>
			</div>
		</div>