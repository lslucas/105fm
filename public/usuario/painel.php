

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
			<h3>Meus Produtos</h3>
		</div>
		<div class='span3'>
			<ul class='configlist'>
				<li><a href="<?=ABSPATH?>interesse">Interesses de Compras</a></li>
				<li><a href="<?=ABSPATH?>novo-produto">Adicionar Oferta</a></li>
				<li><a href="<?=ABSPATH?>anuncio">Adicionar Anúncio</a></li>
			</ul>
		</div>
	</div>
	<br clear='all'/>
	<hr>

	<div class="row">

		<div class="span10">
			<div class="row lista">

				<ul class="nav nav-tabs" id="myTab">
					<li class='active'><a href="#listaOfertas">Lista de Ofertas</a></li>
					<li><a href="#listaAnuncios">Lista de Anuncios</a></li>
				</ul>
				<div class="tab-content">
					<div class="tab-pane active" id="listaOfertas">
						<table class="lista-produtos" id="alternatecolor" width="100%">
								<tr>
									<th width="60px">UF</th>
									<th align="left">Produto</th>
									<th align="left">Embalagem</th>
									<th width="30px" align="left">Qtd.</th>
									<th width="80px" class='pagination-centered'>R$</th>
									<th width="60px" class='pagination-centered'>Visto</th>
									<th width="60px">--</th>
								</tr>
								<tbody>
								<?php
									if (count($myProducts)==0)
										echo "<tr><td colspan=6>Você ainda não possui nenhum produto!</td></tr>";
									foreach ($myProducts as $id => $lista) {
								?>
									<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="rm-<?=linkfy($lista['titulo'])?>">
										<div class="modal-header">
											<a class="close" data-dismiss="modal">×</a>
											<h3>Remover</h3>
										</div>
										<div class="modal-body">
										<p>Deseja remover <b><?=$lista['titulo']?></b>?<div class='alert alert-warning small'>Você não poderá recuperar esse ítem!</div></p>
										</div>
										<div class="modal-footer">
											<a href="javascript:void(0);" class="btn" data-dismiss='modal'>Cancelar</a>
											<a href="javascript:void(0);" id='<?=$lista['id']?>' class="btn-rm btn btn-danger btn-primary">Remover</a>
										</div>
									</div>
									<tr id='tr<?=$lista['id']?>'>
										<td align=center><a href='<?=$lista['link']?>'><?=$lista['uf']?></a></td>
										<td><a href='<?=$lista['link']?>'><?=$lista['titulo']?></a></td>
										<td><a href='<?=$lista['link']?>'><?=$lista['peso_unidade_medida']?></a></td>
										<td><a href='<?=$lista['link']?>'><?=$lista['quantidade']?></a></td>
										<td align=center><a href='<?=$lista['link']?>'><?=$lista['valor']?></a></td>
										<td align=center><a href='<?=$lista['link']?>'><?=$lista['views']?></a></td>
										<td align=center>
											<a href='<?=ABSPATH?>editar-produto/<?=$lista['id']?>' title='Editar item'><i class='icon-edit '></i></a>
											&nbsp; <a href='#rm-<?=linkfy($lista['titulo'])?>' role='button' data-toggle='modal'  title='Remover item'><i class='icon-remove '></i></a>
										</td>
									</tr>
									<?php } ?>
							</tbody>
						</table>
					</div>
					<div class="tab-pane" id="listaAnuncios">
						<table class="lista-produtos" id="alternatecolor" width="100%">
								<tr>
									<th width="60px">UF</th>
									<th align="left">Anuncio</th>
									<th align="left">Tipo</th>
									<th width="100px" class='pagination-centered'>R$</th>
									<th width="60px" class='pagination-centered'>Visto</th>
									<th width="60px">--</th>
								</tr>
								<tbody>
								<?php
									if (count($myAnuncios)==0)
										echo "<tr><td colspan=6>Você ainda não possui nenhum anuncio!</td></tr>";
									foreach ($myAnuncios as $id => $lista) {
								?>
									<div class="modal hide fade" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true" id="rm-<?=linkfy($lista['titulo'])?>">
										<div class="modal-header">
											<a class="close" data-dismiss="modal">×</a>
											<h3>Remover</h3>
										</div>
										<div class="modal-body">
										<p>Deseja remover <b><?=$lista['titulo']?></b>?<div class='alert alert-warning small'>Você não poderá recuperar esse ítem!</div></p>
										</div>
										<div class="modal-footer">
											<a href="javascript:void(0);" class="btn" data-dismiss='modal'>Cancelar</a>
											<a href="javascript:void(0);" id='<?=$lista['id']?>' class="btn-rm-anuncio btn btn-danger btn-primary">Remover</a>
										</div>
									</div>
									<tr id='tr<?=$lista['id']?>'>
										<td align=center><a href='<?=$lista['link']?>'><?=$lista['uf']?></a></td>
										<td><a href='<?=$lista['link']?>'><?=$lista['titulo']?></a></td>
										<td><a href='<?=$lista['link']?>'><?=$lista['tipo']?></a></td>
										<td align=center><a href='<?=$lista['link']?>'><?=$lista['valor']?></a></td>
										<td align=center><a href='<?=$lista['link']?>'><?=$lista['views']?></a></td>
										<td align=center>
											<a href='<?=ABSPATH?>anuncio/<?=$lista['id']?>' title='Editar item'><i class='icon-edit '></i></a>
											&nbsp; <a href='#rm-<?=linkfy($lista['titulo'])?>' role='button' data-toggle='modal'  title='Remover item'><i class='icon-remove '></i></a>
										</td>
									</tr>
									<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
