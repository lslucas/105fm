<div class="column grid_12 busca">

			<div class='breadcrumb-agro'>
				<h5>
					<a href="<?=ABSPATH?>" title="<?=SITE_NAME?>">Início</a>
					 > <a href="<?=ABSPATH?>lista-por-interesse" title="Comercialização">Ofertas em Interesse</a>
					<?php
						if (isset($breadcrumb['grupoquimico']))
							echo " > <a href='".ABSPATH."lista/grupoquimico-".linkfySmart($breadcrumb['grupoquimico'])."'>Grupo Quimico ".$breadcrumb['grupoquimico']."</a>";
						if (isset($breadcrumb['fabricante']))
							echo " > <a href='".ABSPATH."lista/fabricante-".linkfySmart($breadcrumb['fabricante'])."'>Fabricante ".$breadcrumb['fabricante']."</a>";
						if (isset($breadcrumb['produto']))
							echo " > <a href='".ABSPATH."lista/produto-".linkfySmart($breadcrumb['produto'])."'>Produto ".$breadcrumb['produto']."</a>";
					?>
				</h5>
			</div>

			<div class="row">
				<?php include_once 'public/navbar/listaProdutos.php'; ?>

				<div class="pull-left grid_9 content">
					<div class="row lista">

						<table class="lista-produtos" id="alternatecolor" width="100%" style='margin-top:0px'>
							<tr>
								<th width="60px">UF</th>
								<th align="left">Produto</th>
								<th align="left">Revenda</th>
								<th align="left">Embalagem</th>
								<th width='30px' align="left" title='Quantidade'>Qtd.</th>
								<th width="80px" class='pagination-centered'>R$</th>
							</tr>
							<tbody>
							<?php
								if (count($listaGeral)==0)
									echo "<tr><td colspan=6>Nenhum produto disponivel!</td></tr>";
								foreach ($listaGeral as $int=>$lista) {
							?>
								<tr>
									<td align=center><a href='<?=$lista['link']?>'><?=$lista['uf']?></td></td>
									<td><a href='<?=$lista['link']?>'><?=$lista['titulo']?></a></td>
									<td><a href="javascript:void(0);" class='chatwith-<?=$lista['usr_id']?>' name='<?=$lista['empresa']?>'></a><a href='<?=$lista['link']?>'><?=$lista['empresa']?></td></td>
									<td><a href='<?=$lista['link']?>'><?=$lista['peso_unidade_medida']?></a></td>
									<td><a href='<?=$lista['link']?>'><?=$lista['quantidade']?></a></td>
									<td align=center><a href='<?=$lista['link']?>'><?=$lista['valor']?></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
