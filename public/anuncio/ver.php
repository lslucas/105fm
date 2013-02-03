
<?php include_once 'public/navbar/home.php'; ?>
<div class="column grid_7">
	<?php
		if (count($ucl)==0)
			echo "<center>Produto não existe ou já foi vendido!";
		else {
	?>
	<h3><?=$ucl['titulo']?></h3>
	<hr>
	<p>
		<?php
			if (!empty($ucl['galeria'][0]['img']))
				echo "<img src='{$ucl['galeria'][0]['imagem']}' border=0 class='img-polaroid produtoImagem' id='imagemGrande'/>";

			//thumbs
			if (count($ucl['galeria'])>1) {
				foreach ($ucl['galeria'] as $int=>$thumbs) {
					if ($int==5)
						break;
					echo "<img src='{$thumbs['thumb']}' rel='{$thumbs['imagem']}' border=0 width=104 class='img-polaroid produtoImagemThumb'/>";
				}
			}
		?>
		<?=$ucl['descricao']?>
		<?php if (!empty($ucl['observacao'])) { ?>
			<br/>Observação: <?=$ucl['observacao']?>
		<?php } ?>
		<?php if (!empty($ucl['valor'])) { ?>
			<h4><?=$ucl['valor']?></h4>
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
				<input type='hidden' name='produto' value='<?=$ucl['titulo']?>'>
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

	</div>
	<?php } ?>
</div>