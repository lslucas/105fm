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


								<select name='filtroGrupoQuimico' id='filtroGrupoQuimico' class='filtroGrupo input-medium'>
									<option value=''>Grupo</option>
									<?php if (!isset($val['filtroGrupoQuimico']))  $val['filtroGrupoQuimico'] = array(); ?>
									<?=convertCatList2Option(getCategoriaListArea('Grupo Quimico'), $val['filtroGrupoQuimico'])?>
								</select>

								<select name='filtroFabricante' id='filtroFabricante' class='filtroFabricante'>
									<option value=''>Fabricante</option>
									<?php if (!isset($val['filtroFabricante']))  $val['filtroFabricante'] = array(); ?>
									<?=convertCatList2Option(getCategoriaListArea('Fabricante'), $val['filtroFabricante'])?>
								</select>

								<select name='filtroProduto' id='filtroProduto' class='filtroProduto'>
									<option value=''>Produto</option>
									<?php if (!isset($val['filtroProduto']))  $val['filtroProduto'] = array(); ?>
									<?=convertCatList2Option(getCategoriaListArea('Produto'), $val['filtroProduto'])?>
								</select>

								<button type="submit" class="btn">Filtrar</button>
							</form>
						</div>

						<table class="lista-produtos" id="alternatecolor" width="100%">
							<tr>
								<th width="60px">UF</th>
								<th align="left" width='106px'>Grupo Químico</th>
								<th align="left">Fabricante</th>
								<th align="left">Produto</th>
								<th width="80px" class='pagination-centered'>R$</th>
							</tr>
							<tbody>
							<?php
								if (count($listaGeral)==0)
									echo "<tr><td colspan=6>Nenhum produto disponivel!</td></tr>";
								foreach ($listaGeral as $int=>$lista) {
							?>
								<tr data-href='<?=$lista['link']?>'>
									<td align=center><?=$lista['uf']?></td>
									<td><?=$lista['grupoquimico']?></td>
									<td><?=$lista['fabricante']?></td>
									<td><?=$lista['titulo']?></td>
									<td align=center><?=$lista['valor']?></td>
								</tr>
								<?php } ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
