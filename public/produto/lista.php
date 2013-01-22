<div class="column grid_12 busca">

			<div class='breadcrumb-agro'>
				<h5>
					<a href="<?=ABSPATH?>" title="<?=SITE_NAME?>">Início</a>
					 > <a href="<?=ABSPATH?>lista" title="Comercialização">Comercialização</a>
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

						<div class='column filtro'>
							<form name="filtrar" class="form-inline" action='<?=ABSPATH?>busca' method="post">
								<input type="hidden" name="from" value="filtrar">


								<select name='filtroLocalizacao' id='filtroLocalizacao' class='filtroLocalizacao input-medium'>
									<option value=''>Localização</option>
									<?php if (!isset($val['filtroLocalizacao']))  $val['filtroLocalizacao'] = array(); ?>
									<?=convertCatList2Option(getLocalizacao(), $val['filtroLocalizacao'])?>
								</select>

								<select name='filtroUsuario' id='filtroUsuario' class='filtroUsuario'>
									<option value=''>Revendedor</option>
									<?php if (!isset($val['filtroUsuario']))  $val['filtroUsuario'] = array(); ?>
									<?=convertCatList2Option(getUsuarios(), $val['filtroUsuario'])?>
								</select>

								<select name='filtroProduto' id='filtroProduto' class='filtroProduto'>
									<?php if (!isset($val['filtroProduto']))  $val['filtroProduto'] = array(); ?>
									<?=convertCatList2Option(getProdutosByOptions(null, 'Produto', 'titulo', true), $val['filtroProduto'])?>
								</select>

								<button type="submit" class="btn">Filtrar</button>
							</form>
						</div>

						<table class="lista-produtos" id="alternatecolor" width="100%">
							<tr>
								<th width="60px">UF</th>
								<th align="left">Produto</th>
								<th align="left">Revenda</th>
								<th align="left">Fabricante</th>
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
									<td><a href='<?=$lista['link']?>'><?=$lista['empresa']?></td></td>
									<td><a href='<?=$lista['link']?>'><?=$lista['fabricante']?></a></td>
									<td align=center><a href='<?=$lista['link']?>'><?=$lista['valor']?></a></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
