	<!-- <div class="row novo-produto"> -->
	<div class="column grid_10">
		<div class="column">
			<h1>Lista de Interesse</h1>
			<p><em>Todos os campos com - <span class="color-red">*</span> - são obrigatórios.</em></p>
			<p><br /></p>
		</div>

		<div class="column">
			<form name="novo-produto" class="form-horizontal" method="post">
				<input type="hidden" name="from" value="novo-produto">
				<input type="hidden" name="usr_id" value="<?=$usr['id']?>">
				<?php
					if ($basename=='editar-produto')
						echo "<input type='hidden' name='id' value='{$val['id']}'>\n";
				?>

				<div class="control-group">
					<label class="control-label" for="grupoquimico"> Grupo</label>
					<div class="controls">
					<select name="grupoquimico" id="grupoquimico" class="filtroGrupo">
						<?=convertCatList2Option(getCategoriaListArea('Grupo Quimico', null, 'Grupo Quimico'), $val['grupoquimico_id'])?>
					</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fabricante">Fabricante</label>
					<div class="controls">
					<select name="fabricante" id="fabricante" class="filtroFabricante">
						<?=convertCatList2Option(getCategoriaListArea('Fabricante', $val['grupoquimico_id'], 'Fabricante', null, 'cat_titulo'), $val['fabricante_id'])?>
					</select> <small><a href="javascript:void(0);" class='showOnClick' data-target='#outroFabricante'>outro?</a></small>
					</div>

					<div id='outroFabricante' class='hide'>
						<br/><label class="control-label" for="nomeFabricante"><span class="color-red">*</span> Nome do Fabricante</label>
						<div class="controls">
							<input type="text" class="input-xlarge" placeholder='Nome do fabricante' name='nomeFabricante' id='nomeFabricante' disabled=disabled value="<?=isset($val['nomeFabricante']) ? $val['nomeFabricante'] : null?>">
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="pro_id"><span class="color-red">*</span> Produto</label>
					<div class="controls">
					<select name="pro_id" id="pro_id" class="required filtroProduto">
						<?=convertCatList2Option(getTodosProdutos(null, 'Produto'), $val['pro_id'])?>
					</select> <small><a href="javascript:void(0);" class='showOnClick' data-target='#outroProduto'>outro?</a></small>
					</div>

					<div id='outroProduto' class='hide'>
						<br/><label class="control-label" for="nomeProduto"><span class="color-red">*</span> Nome do Produto</label>
						<div class="controls">
							<input type="text" class="input-xlarge" placeholder='Nome do produto' name='nomeProduto' id='nomeProduto' disabled=disabled value="<?=isset($val['nomeProduto']) ? $val['nomeProduto'] : null?>">
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="observacao">Observação</label>
					<div class="controls">
						<textarea name='observacao' id='observacao' class='input-xlarge' cols='90' rows='3'><?=isset($val['observacao']) ? $val['observacao'] : null?></textarea>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
					      <button type="submit" class="btn-agro">Atualizar lista de interesse</button>
					</div>
				</div>
			</form>
		</div>
	</div>
