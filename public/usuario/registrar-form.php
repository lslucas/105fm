<div class="column grid_12">
	<h3>Registrar novo usuário</h3>
	<p><em>Todos os campos com - <span class="r">*</span> - são obrigatórios.</em></p>
	<p><br /></p>
</div>
<form name='registrar' class="form-horizontal" method='post' enctype='multipart/form-data'>
	<input type='hidden' name='from' value='<?=$basename?>'/>

	<div class="column grid_12">
		<div class='span12' style='text-align:center;'>
			<label class='span3'>
				<img class="img-polaroid pull-right" src="http://placehold.it/215x215/&text=Plano 1">
				<br/><input type='radio' name='plan_id' value='146'/> Plano 1
			</label>
			<label class='span3'>
				<img class="img-polaroid pull-right" src="http://placehold.it/215x215/&text=Plano 2">
				<br/><input type='radio' name='plan_id' value='147'/> Plano 2
			</label>
			<label class='span3'>
				<img class="img-polaroid pull-right" src="http://placehold.it/215x215/&text=Plano 3">
				<br/><input type='radio' name='plan_id' value='148'/> Plano 3
			</span>
		</div>
	</div>

	<div class="column grid_6">
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
			<label class="control-label" for="rg">RG</label>
			<div class="controls">
				<input type="text" class="input-xlarge" placeholder='RG do anunciante' name='rg' id='rg' value="<?=isset($val['rg']) ? $val['rg'] : null?>">
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="cpf">CPF</label>
			<div class="controls">
				<input type="text" class="input-xlarge cpf" placeholder='CPF' name='cpf' id='cpf' value="<?=isset($val['cpf']) ? $val['cpf'] : null?>">
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="nascimento">* Data de Nascimento</label>
			<div class="controls">
				<input type="text" class="input-xlarge required data" placeholder='Nascimento' name='nascimento' id='nascimento' value='<?=isset($val['nascimento']) ? $val['nascimento'] : null?>'>
			</div>
		</div>

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

		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn cadastrar">Registrar</button>
			</div>
		</div>
	</div>

	<div class="column grid_6">
		<textarea name="contrato" id="contrato" class="input-xlarge contrato" disabled>
Termos e Condições Gerais de uso do site

Sed et sit adipiscing porttitor, phasellus tincidunt, facilisis, pulvinar facilisis? Egestas parturient. Pulvinar proin, massa, risus, integer, vel nisi et platea augue! Augue habitasse! Pellentesque in porta nunc et enim, elementum pellentesque adipiscing enim urna! Ultricies, urna nunc dictumst lacus. Arcu sagittis vel et magnis, urna lorem magna, non nec! Scelerisque? Porta nunc mauris penatibus, enim pulvinar, vut, augue in, sed cursus massa tortor odio montes, hac habitasse, augue et, cum sociis, cras turpis nec amet, elit pellentesque, pulvinar elementum et integer tortor ac lectus a, lectus elementum! Et pulvinar, lacus, rhoncus nunc aliquet lectus ac, turpis proin et, aliquet, tincidunt tortor integer auctor amet, velit cursus enim! Ac odio, dis lectus sagittis ultricies ut a dolor hac duis aenean.

Magna, amet et integer tempor, et dis, dis quis vel nisi, mus pulvinar aliquam! Cum, massa et sed dictumst rhoncus aliquam vel adipiscing augue sit odio auctor penatibus pellentesque ridiculus facilisis, dapibus platea. Nec tincidunt? Rhoncus urna pid enim, ridiculus amet urna mauris quis, rhoncus elit parturient? Purus magna nec lundium dolor adipiscing! Amet amet, porta porta ultricies odio, elit pulvinar ridiculus aenean cum dolor etiam porttitor pulvinar ut, egestas non! Lacus hac odio, rhoncus dapibus augue augue urna? Nec? Et parturient? Porttitor, amet sagittis vel elementum, tortor adipiscing! Dis adipiscing! Scelerisque tempor risus sed porttitor, vut aliquet integer aenean arcu a nunc pid? In eu placerat! Dictumst, duis auctor et! Cum. Natoque, tempor, ac elementum mauris rhoncus cursus.

Mus elit! Eu sagittis duis integer dapibus, ultrices parturient aenean a, est proin sit ut facilisis scelerisque? In nisi, porttitor rhoncus nisi augue! Velit cursus nisi in odio platea rhoncus sagittis integer mid, et ut ac mattis urna? Integer augue vel elementum in diam purus etiam risus? Enim auctor nec elementum nec et dolor elementum sed? In vel vel, adipiscing turpis. Parturient magna! Integer eu. Cum eu elit placerat pulvinar mus tortor penatibus magna, mauris cras magnis placerat etiam, et phasellus tincidunt est, lorem vel ut mauris, porta velit sagittis tristique placerat nunc amet porttitor aenean ac a, et penatibus ut ridiculus phasellus! Purus, scelerisque, nunc amet lorem integer. Dolor phasellus, vel nunc arcu dapibus, tempor et nisi dictumst.
		</textarea>
		<p>&nbsp;</p>
		<label><input type="checkbox" name="lido" id="valor" value="" class="fl" >Li e concordo com os termos de condições de uso do site</label>
	</div>

</form>
