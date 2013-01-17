

<div class="column grid_10 busca">

	<div>
		<div class='span2'>
			<h3>Configurações</h3>
		</div>
		<div class='span3'>
			<ul class='configlist'>
				<li><a href="<?=ABSPATH?>meus-dados/configuracoes-conta">Configuração de Conta<br/><small>Nome, email, senha e telefone</small></a></li>
				<li><a href="<?=ABSPATH?>meus-dados/empresa">Dados da Empresa</a></li>
				<li><a href="<?=ABSPATH?>meus-dados/endereco-localidade">Endereço e Localidade</a></li>
			</ul>
		</div>
		<br clear='all'/>
		<br/>
		<div class='span2'>
			<h3>Produtos</h3>
		</div>
		<div class='span3'>
			<ul class='configlist'>
				<li><a href="<?=ABSPATH?>novo-produto">Novo Produto</a></li>
			</ul>
		</div>
	</div>
	<br clear='all'/>
	<hr>

	<div class="row">

		<div class="span10">
			<div class="row lista">

				<table class="lista-produtos" id="alternatecolor" width="100%">
						<tr>
							<th width="60px">Código</th>
							<th align="left">Grupo Químico</th>
							<th align="left">Fabricante</th>
							<th align="left">Produto</th>
							<th width="80px" class='pagination-centered'>R$</th>
							<th width="60px" class='pagination-centered'>Visto</th>
						</tr>
						<tbody>
						<?php
							if (count($myProducts)==0)
								echo "<tr><td colspan=6>Você ainda não possui nenhum produto!</td></tr>";
							foreach ($myProducts as $id => $lista) {
						?>
							<tr>
								<td align=center><?=$lista['codigo']?></td>
								<td><?=$lista['grupoquimico']?></td>
								<td><?=$lista['fabricante']?></td>
								<td><a href='<?=$lista['link']?>'><?=$lista['titulo']?></a></td>
								<td align=center><?=$lista['valor']?></td>
								<td align=center><?=$lista['views']?></td>
							</tr>
							<?php } ?>
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
