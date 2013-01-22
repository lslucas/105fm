	<!-- <div class="row novo-produto"> -->
	<div class="column grid_10">
		<div class="column">
			<h1><?=$basename=='novo-produto' ? 'Novo Produto' : 'Editar Produto '.$val['titulo']?></h1>
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
					<label class="control-label" for="valor">Valor</label>
					<div class="controls">
						<input type="text" class="input-small price" placeholder='R$ 99,99' name='valor' id='valor' value="<?=isset($val['valor']) ? $val['valor'] : null?>">
						<p class="help-block">Deixe 0 ou vazio caso queira mostrar <b>sob consulta</b></p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="quantidade"><span class="color-red">*</span> Quantidade</label>
					<div class="controls">
						<input type="text" class="input-small required" placeholder='Quantidade de Produtos' name='quantidade' id='quantidade' value="<?=isset($val['quantidade']) ? $val['quantidade'] : null?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="peso">Peso</label>
					<div class="controls">
						<input type="text" class="input-small" placeholder='Peso do Produto' name='peso' id='peso' value="<?=isset($val['peso']) ? $val['peso'] : null?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="peso_unidade_medida"><span class="color-red">*</span> Unidade de Medida</label>
					<div class="controls">
					<select name="peso_unidade_medida" id="peso_unidade_medida" class="required">
						<option value="">Selecione</option>
						<?php
								$sql = "SELECT cat_id, cat_titulo FROM ".TP."_categoria WHERE cat_status=1 AND cat_area='Unidade de Medida' ORDER BY cat_titulo;";
								if (!$qry = $conn->prepare($sql))
									echo $conn->error;
								else {
									$qry->bind_result($id, $titulo);
									$qry->execute();
									while($qry->fetch()) {
						 ?>
						<option value='<?=$id?>' <?php if(isset($val['peso_unidade_medida']) && $val['peso_unidade_medida']==$id) echo ' selected';?>><?=$titulo?></option>
						<?php
								 }
								$qry->close();
							 }
						?>
					</select>
					<p class="help-block">Selecione a unidade de medida do peso desse ítem</p>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="datavalidade">Data Validade</label>
					<div class="controls">
						<div id="datecontainer">
							<input type="text" class="input-small data pull-left" placeholder='Data de Validade do Produto' name='datavalidade' id='datavalidade' value="<?=isset($val['datavalidade']) ? $val['datavalidade'] : null?>">
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="datapagamento">Data Pagamento</label>
					<div class="controls">
						<div id="datecontainer">
							<input type="text" class="input-small data pull-left" placeholder='Data de Pagamento' name='datapagamento' id='datapagamento' value="<?=isset($val['datapagamento']) ? $val['datapagamento'] : null?>">
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
					      <button type="submit" class="btn-agro"><?=$basename=='novo-produto' ? 'Cadastrar Produto' : 'Atualizar Produto '?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
