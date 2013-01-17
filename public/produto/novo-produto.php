	<div class="row novo-produto">
		<div class="column grid_12">
			<h1>Novo Produto</h1>
			<p><em>Todos os campos com - <span class="color-red">*</span> - são obrigatórios.</em></p>
			<p><br /></p>
		</div>
		<div class="column grid_12">
			<form name="registrar" class="form-horizontal" method="post">
				<input type="hidden" name="from" value="novo-produto">
				<input type="hidden" name="usr_id" value="<?=$usr['id']?>">

				<div class="control-group">
					<label class="control-label" for="grupoquimico"><span class="color-red">*</span> Grupo</label>
					<div class="controls">
					<select name="grupoquimico" id="grupoquimico" class="filtroGrupo required">
						<?php
								$sql = "SELECT cat_id, cat_titulo FROM ".TP."_categoria WHERE cat_status=1 AND cat_area='Grupo Quimico' ORDER BY cat_titulo;";
								if (!$qry = $conn->prepare($sql))
									echo $conn->error;
								else {
									$qry->bind_result($id, $titulo);
									$qry->execute();
									while($qry->fetch()) {
						 ?>
							<option value='<?=$id?>' <?php if(isset($val['filtroGrupoQuimico']) && $val['filtroGrupoQuimico']==$id) echo ' selected';?>><?=$titulo?></option>
						<?php
								 }
								$qry->close();
							 }
						?>
					</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="fabricante">Fabricante</label>
					<div class="controls">
					<select name="fabricante" id="fabricante" class="filtroFabricante">
						<option value="">Selecione</option>
						<?php
							$sql = "SELECT cat_id, cat_titulo FROM ".TP."_categoria WHERE cat_status=1 AND cat_area='Fabricante' ORDER BY cat_titulo;";
							if (!$qry = $conn->prepare($sql))
								echo $conn->error;
							else {
								$qry->bind_result($id, $titulo);
								$qry->execute();
								while($qry->fetch()) {
						 ?>
						<option value='<?=$id?>' <?php if(isset($val['filtroFabricante']) && $val['filtroFabricante']==$id) echo ' selected';?>><?=$titulo?></option>
						<?php
								 }
								$qry->close();
							 }
						?>
					</select>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="pro_id"><span class="color-red">*</span> Produto</label>
					<div class="controls">
					<select name="pro_id" id="pro_id" class="required filtroProduto">
						<option value="">Selecione</option>
						<?php
								$sql = "SELECT pro_id, pro_tipo, pro_grupoquimico, pro_titulo FROM ".TP."_produto WHERE pro_status=1 ORDER BY pro_titulo ASC;";
								if (!$qry = $conn->prepare($sql))
									echo $conn->error;
								else {
									$qry->bind_result($id, $tipo, $grupoquimico, $titulo);
									$qry->execute();
									while($qry->fetch()) {
						 ?>
						<option value='<?=$id?>' <?php if(isset($val['pro_id']) && $val['pro_id']==$id) echo ' selected';?>><?=$titulo?></option>
						<?php
								 }
								$qry->close();
							 }
						?>
					</select>
					<p class="help-block">Selecione um produto</p>
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
					<label class="control-label" for="peso"><span class="color-red">*</span> Peso</label>
					<div class="controls">
						<input type="text" class="input-small required" placeholder='Peso do Produto' name='peso' id='peso' value="<?=isset($val['peso']) ? $val['peso'] : null?>">
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
					<label class="control-label" for="datavalidade"><span class="color-red">*</span> Data Validade</label>
					<div class="controls">
						<div id="datecontainer">
							<input type="text" class="input-small required data pull-left" placeholder='Data de Validade do Produto' name='datavalidade' id='datavalidade' value="<?=isset($val['datavalidade']) ? $val['datavalidade'] : null?>">
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
					      <button type="submit" class="btn-agro">Cadastrar</button>
					</div>
				</div>
			</form>
		</div>
	</div>
