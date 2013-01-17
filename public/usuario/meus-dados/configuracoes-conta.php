	<!-- <div class="column grid_6"> -->
		<input type='hidden' name='id' value='<?=isset($val['id']) ? $val['id'] : null?>'/>
		<input type='hidden' name='querystring' value='<?=isset($querystring) ? $querystring : null?>'/>
		<div class="control-group">
			<label class="control-label" for="nome">* Nome</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Nome' name='nome' id='nome' value='<?=isset($val['nome']) ? $val['nome'] : null?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="email">* Email</label>
			<div class="controls">
				<input type="text" class="input-xlarge required email" placeholder='Email de contato' name='email' id='email' value="<?=isset($val['email']) ? $val['email'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="confirmaEmail">* Confirmar Email</label>
			<div class="controls">
				<input type="text" class="input-xlarge required email" placeholder='Confirmar Email' name='confirmaEmail' id='confirmaEmail' value="<?=isset($val['confirmaEmail']) ? $val['confirmaEmail'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="senha">* Senha</label>
			<div class="controls">
				<input type="password" class="input-xlarge required" placeholder='Senha' name='senha' id='senha' value="<?=isset($val['senha']) ? $val['senha'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="confirmaSenha">* Confirmação de Senha</label>
			<div class="controls">
				<input type="password" class="input-xlarge required" placeholder='Confirmar Senha' name='confirmaSenha' id='confirmaSenha' value="<?=isset($val['confirmaSenha']) ? $val['confirmaSenha'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cpf">CPF</label>
			<div class="controls">
				<input type="text" class="input-xlarge cpf" placeholder='CPF' name='cpf' id='cpf' value="<?=isset($val['cpf']) ? $val['cpf'] : null?>">
			</div>
		</div>