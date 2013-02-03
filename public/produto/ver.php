
<?php include_once 'public/navbar/home.php'; ?>
<div class="column grid_7">
	<?php
		if (count($cpr)==0)
			echo "<center>Produto não existe ou já foi vendido!";
		else {
	?>
	<h3><?=$cpr['titulo']?></h3>
	<hr>
	<p>
		<?php
			if (!empty($pro['galeria'][0]['img']))
				echo "<img src='{$pro['galeria'][0]['imagem']}' border=0 width=280 class='img-polaroid produtoImagem'/>";
		?>
		<?=$pro['descricao']?>
		<?php if (!empty($cpr['quantidade'])) { ?>
			<br/>Quantidade: <?=$cpr['quantidade']?>
		<?php } ?>
		<?php if (!empty($cpr['quantidade_minima_venda'])) { ?>
			<br/>Quantidade Mínima de Venda: <?=$cpr['quantidade_minima_venda']?>
		<?php } ?>
		<?php if (!empty($cpr['datapagamento'])) { ?>
			<br/>Data para pagamento: <?=$cpr['datapagamento']?>
		<?php } ?>
		<?php if (!empty($cpr['datavalidade'])) { ?>
			<br/>Validade produto: <?=$cpr['datavalidade']?>
		<?php } ?>
		<?php if (!empty($cpr['embalagem'])) { ?>
			<br/>Embalagem : <?=$cpr['embalagem']?>
		<?php } ?>
		<?php if (!empty($cpr['observacao'])) { ?>
			<br/>Observação: <?=$cpr['observacao']?>
		<?php } ?>
		<?php if (!empty($cpr['valor'])) { ?>
			<h4><?=$cpr['valor']?></h4>
		<?php } ?>
	</p>

	<br clear='all'/>
	<div id='detalhes'>
		<ul class="nav nav-tabs" id="myTab">
			<!-- <li class="active"><a href="#dadostecnicos">Dados Técnicos</a></li> -->
			<li class='active'><a href="#infovendedor">Informações do vendedor</a></li>
			<li><a href="#contato">Entrar em Contato</a></li>
		</ul>
		<div class="tab-content">
<!-- 			<div class="tab-pane active" id="dadostecnicos">
			</div> -->
			<div class="tab-pane active" id="infovendedor">
				<?php
					if (!isset($usr) || empty($usr['id']))
						echo "<div class='alert alert-warning'>Você precisa ser registrado para ver as informações do vendedor!<br/>Faça o <a href='".ABSPATH."login'>login</a> ou <a href='".ABSPATH."registrar'>registre-se aqui</a></div>";
					else {
				?>
				<ul class='unstyled'>
				<?php
					if (!empty($vend['empresa']))
						echo "<li>Empresa: {$vend['nome_fantasia']}</li>";
					if (!empty($vend['cnpj']))
						echo "<li>CNPJ: {$vend['cnpj']}</li>";
					if (!empty($vend['contato']))
						echo "<li>Contato: {$vend['contato']}</li>";
					if (!empty($vend['email']))
						echo "<li>Email: {$vend['email']}</li>";
					if (!empty($vend['telefone1']))
						echo "<li>Telefone 1: {$vend['telefone1']}</li>";
					if (!empty($vend['telefone2']))
						echo "<li>Telefone 2: {$vend['telefone2']}</li>";
				?>
				</ul>
				<?php } ?>
			</div>
			<div class="tab-pane" id="contato">
				<?php
					if (!isset($usr) || empty($usr['id']))
						echo "<div class='alert alert-warning'>Você precisa ser registrado para poder entrar em contato com o vendedor!<br/>Faça o <a href='".ABSPATH."login'>login</a> ou <a href='".ABSPATH."registrar'>registre-se aqui</a></div>";
					else {
				?>
				<p>Entre em contato com o vendedor através do formulário ou das informações de contato abaixo:</p>
				<?php
				echo "<center><ul class='unstyled'>";
				if (!empty($vend['contato']))
					echo "<li>Contato: {$vend['contato']}</li>";
				if (!empty($vend['email']))
					echo "<li>Email: {$vend['email']}</li>";
				if (!empty($vend['telefone1']))
					echo "<li>Telefone 1: {$vend['telefone1']}</li>";
				if (!empty($vend['telefone2']))
					echo "<li>Telefone 2: {$vend['telefone2']}</li>";
				echo "</ul></center>";
			?>
				<form class="form-horizontal" name='contato-vendedor' method='post'>
				<input type='hidden' name='form' value='contato-vendedor'>
				<input type='hidden' name='produto' value='<?=$cpr['titulo']?>'>
				<input type='hidden' name='link' value='<?=full_url()?>'>
				<input type='hidden' name='contatoVendedor' value='<?=$vend['contato']?>'>
				<input type='hidden' name='emailVendedor' value='<?=$vend['email']?>'>
				  <div class="control-group">
				    <label class="control-label"><h2 class="form-signin-heading">Contato</h2></label>
				  </div>
				  <div class="control-group">
				    <label class="control-label" for="email">Email</label>
				    <div class="controls">
				      <input type="text" name="email" class='input-xlarge' placeholder="Email" value='<?=isset($usr['email']) ? $usr['email'] : null?>'>
				    </div>
				  </div>
				  <div class="control-group">
				    <label class="control-label" for="mensagem">Mensagem</label>
				    <div class="controls">
					<textarea name='mensagem' id="mensagem" class='input-xlarge' rows=4></textarea>
				    </div>
				  </div>
				  <div class="control-group">
				    <div class="controls">
				      <button type="submit" class="btn">Enviar</button>
				    </div>
				  </div>
				</form>
				<?php } ?>
			</div>
		</div>
<!--
		<hr>
		<h3>Perguntas ao vendedor</h3>
		<form name='pergunta' method='post'>
			<textarea class="span10" name="pergunta" id="pergunta" cols="110" title="Escreva sua pergunta..." placeholder="Escreva sua pergunta..." style="height: 22px; width:752px;"></textarea>
			<br clear='all'/><p align='right'><input type='submit' class='btn' value='Enviar'></p>
		</form>
		<table>
			<tbody class='line1'>
				<tr>
					<td width='60px'>
						<img src='http://placehold.it/50x50' border=0>
					</td>
					<td class='pull-left'>
						<b>Fulano</b> perguntou a 2 dias atrás
						<br/>When checking the type of the parameter in a method using the ParameterReflection, this commit first checks the value of the variable before checking the docblock.
					</td>
				</tr>
			</tbody>
			<tbody>
				<tr>
					<td width='60px'>
						<img src='http://placehold.it/50x50' border=0>
					</td>
					<td class='pull-left'>
						<b>Sicrano</b> perguntou a 8 dias atrás
						<br/>When checking the type of the parameter in a method using the ParameterReflection, this commit first checks the value of the variable before checking the docblock.
					</td>
				</tr>
			</tbody>
		</table>
		<?php
			$incjQuery .= "
				$('textarea[name=\"pergunta\"]').focusin(function() {
					$(this).height('80px');
				});
				$('textarea[name=\"pergunta\"]').focusout(function() {
					if ($(this).val()=='')
						$(this).height('22px');
				});
			";
		 ?>
-->
	</div>
	<?php } ?>
</div>