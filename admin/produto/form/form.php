<?php

	$lstProdutosRelacionados = array();
	if ($act=='update') {

		$sql_per = "SELECT pro_id, cat_id FROM ".TP."_produto_taxonomy WHERE pro_id=? AND area='produtosRelacionados'";
		if (!$qry_per = $conn->prepare($sql_per))
			echo $conn->error;
		else {
			$qry_per->bind_result($pro_id, $cat_id);
			$qry_per->bind_param('i', $val['id']);
			$qry_per->execute();

				while($qry_per->fetch())
					array_push($lstProdutosRelacionados, $cat_id);

			$qry_per->close();
		}

	}

?>
 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de continuar corrija os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="usr_id" class="error-validate">Selecione um <b>usuario</b></label></li>
		<li><label for="tipo" class="error-validate">Selecione um <b>tipo</b></label></li>
		<li><label for="fabricante" class="error-validate">Selecione uma <b>fabricante</b></label></li>
		<li><label for="grupoquimico" class="error-validate">Selecione um <b>grupo químico</b></label></li>
		<li><label for="titulo" class="error-validate">Entre com um <b>título</b></label></li>
		<li><label for="qtd" class="error-validate">Entre com um <b>quantidade</b></label></li>
		<li><label for="codigo" class="error-validate">Entre com o <b>código do produto</b></label></li>
		<li><label for="data" class="error-validate">Entre com uma <b>data</b> para ordenação</label></li>
		<li><label for="descricao" class="error-validate">Entre com a <b>descrição</b></label></li>
	</ol>
</div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
	if ($act=='update') {
		echo "<input type='hidden' name='item' value='${_GET['item']}'>";
		echo "<input type='hidden' name='code' value='${val['code']}'>";
	}
?>

<h1>
<?php
	if ($act=='insert') echo $var['insert'];
	 else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

		<div class="control-group">
			<label class="control-label" for="foto">Fotos<br/><span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar +fotos</a></span></label>
			<div class="controls">
				<?php

						$num=0;
					if ($act=='update') {

						$sql_gal = "SELECT rpg_id, rpg_imagem, rpg_legenda, rpg_pos FROM ".TABLE_PREFIX."_${var['table']}_galeria WHERE rpg_{$var['pre']}_id=? AND rpg_imagem IS NOT NULL ORDER BY rpg_pos ASC;";
						$qr_gal = $conn->prepare($sql_gal);
						$qr_gal->bind_param('s',$_GET['item']);
						$qr_gal->execute();
						$qr_gal->store_result();
						$num = $qr_gal->num_rows;
						$qr_gal->bind_result($g_id, $g_imagem, $g_legenda, $g_pos);
						$i=0;

								if ($num>0) {

							echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
							while ($qr_gal->fetch()) {

						$arquivo = $var['path_original']."/".$g_imagem;
				?>
				<tr id="<?=$g_id?>">
					<td title='Click and drag to change image position' class='tip'>
						<small>
							[<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=<?=$var['table']?>_galeria&pre=rpg&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Click to remove this item" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remove</a>]
						</small>
						 <img src='<?=substr($var['path_thumb'],0)."/".$g_imagem?>'>
						 &nbsp; <span style='font-size:8pt; color:#777;'><?=!empty($g_legenda) ? $g_legenda : null?></span>
					</td>
				</tr>
					<?php
							$i++;

					}
					}
				}
					 echo '</table><br>';
			 ?>
				 <div class='divImagem'>
				 <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
				 <br><small>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></small>
				 <hr noshade size=1 style='border-color:#C4C4C4; background-color:#FFF; width:520px;'/>
				 </div>
				<p class='help-block'>Clique e arraste para alterar a posição</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="usr_id">* Usuário</label>
			<div class="controls">
			<select name='usr_id' id='usr_id' class='required'>
				<option value=''>Selecione</option>
				<?php
						$sql = "SELECT usr_id, usr_nome, usr_email FROM ".TP."_usuario WHERE 1 ORDER BY usr_nome";
						if (!$qry = $conn->prepare($sql))
							echo $conn->error;
						else {
							$qry->bind_result($id, $nome, $email);
							$qry->execute();
							while($qry->fetch()) {
				 ?>
				<option value='<?=$id?>' <?php if($val['usr_id']==$id) echo ' selected';?>><?=$nome?> - <?=$email?></option>
				<?php
						 }
						$qry->close();
					 }
					?>
			</select>
			<p class='help-block'>Selecione o usuário dono desse produto</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="tipo">* Tipo</label>
			<div class="controls">
			<select name='tipo' id='tipo' class='required'>
				<option value=''>Selecione</option>
				<?php
						$sql = "SELECT cat_id, cat_titulo FROM ".TP."_categoria WHERE cat_titulo IS NOT NULL AND cat_area='Tipo' ORDER BY cat_titulo";
						if (!$qry = $conn->prepare($sql))
							echo $conn->error;
						else {
							$qry->bind_result($id, $titulo);
							$qry->execute();
							while($qry->fetch()) {
				 ?>
				<option value='<?=$id?>' <?php if($val['tipo']==$id) echo ' selected';?>><?=$titulo?></option>
				<?php
						 }
						$qry->close();
					 }
					?>
			</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="fabricante">* Fabricante</label>
			<div class="controls">
			<select name='fabricante' id='fabricante' class='required'>
				<option value=''>Selecione</option>
				<?php
						$sql = "SELECT cat_id, cat_titulo FROM ".TP."_categoria WHERE cat_titulo IS NOT NULL AND cat_area='Fabricante' ORDER BY cat_titulo";
						if (!$qry = $conn->prepare($sql))
							echo $conn->error;
						else {
							$qry->bind_result($id, $titulo);
							$qry->execute();
							while($qry->fetch()) {
				 ?>
				<option value='<?=$id?>' <?php if($val['fabricante']==$id) echo ' selected';?>><?=$titulo?></option>
				<?php
						 }
						$qry->close();
					 }
					?>
			</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="grupoquimico">* Grupo Químico</label>
			<div class="controls">
			<select name='grupoquimico' id='grupoquimico' class='required'>
				<option value=''>Selecione</option>
				<?php
						$sql = "SELECT cat_id, cat_titulo FROM ".TP."_categoria WHERE cat_titulo IS NOT NULL AND cat_area='Grupo Quimico' ORDER BY cat_titulo";
						if (!$qry = $conn->prepare($sql))
							echo $conn->error;
						else {
							$qry->bind_result($id, $titulo);
							$qry->execute();
							while($qry->fetch()) {
				 ?>
				<option value='<?=$id?>' <?php if($val['grupoquimico']==$id) echo ' selected';?>><?=$titulo?></option>
				<?php
						 }
						$qry->close();
					 }
					?>
			</select>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="data">* Data</label>
			<div class="controls">
				<input type="text" class="input-small required data" placeholder='dd/mm/YYYY' name='data' id='data' value='<?=$act=='insert' ? date('d/m/Y') : date('d/m/Y', unixtimestamp($val['data'], 'YYYY/mm/dd'))?>'>
				<p class='help-block'>Data para ordenação</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="codigo">* Código</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Código' name='codigo' id='codigo' value='<?=$val['codigo']?>'>
				<p class="help-block">Código do produto</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="titulo">* Título</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Título' name='titulo' id='title' value="<?=$val['titulo']?>">
				<p class="help-block">Nome do produto</p>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="descricao">* Descrição</label>
			<div class="controls">
				<textarea class="tinymce_simple input-xxlarge required" placeholder='Descrição' name='descricao' id='descricao' cols=50 rows=12><?=$val['descricao']?></textarea>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="qtd">* Quantidade</label>
			<div class="controls">
				<input type="text" class="input-small number required" placeholder='530' name='qtd' id='qtd' value='<?=$val['qtd']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="qtd_min_venda">Quantidade Mínima para Venda</label>
			<div class="controls">
				<input type="text" class="input-small number" placeholder='530' name='qtd_min_venda' id='qtd_min_venda' value='<?=$val['qtd_min_venda']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="peso_unidade">Peso/Unidade</label>
			<div class="controls">
				<input type="text" class="input-small number" placeholder='' name='peso_unidade' id='peso_unidade' value='<?=$val['peso_unidade']?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="unidade_medida">Unidade de Medida Peso</label>
			<div class="controls">
			<select name='unidade_medida' id='unidade_medida'>
				<option value=''>Selecione</option>
				<option value='Gr' <?php if($val['unidade_medida']=='Grama') echo ' selected';?>>Gr</option>
				<option value='Kg' <?php if($val['unidade_medida']=='Kg') echo ' selected';?>>Kg</option>
				<option value='Ton' <?php if($val['unidade_medida']=='Ton') echo ' selected';?>>Ton</option>
			</select>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="valor_unidade">Valor Unidade</label>
			<div class="controls">
				<input type="text" class="input-small price" placeholder='49,99' name='valor_unidade' id='valor_unidade' value='<?=$val['valor_unidade']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="valor">Valor Total</label>
			<div class="controls">
				<input type="text" class="input-small price" placeholder='49,99' name='valor' id='valor' value='<?=$val['valor']?>'>
			</div>
		</div>

		 <div class="control-group">
			<label class="control-label" for="produtosRelacionados">Produtos Relacionados</label>
			<div class="controls">
			<select name='produtosRelacionados' id='produtosRelacionados' multiple=true size=8>
				<option>Selecione</option>
				<?php
						$whrProdutosRelacionados = null;
						if ($act=='insert')
							$whrProdutosRelacionados = " AND 1 ";
						else
							$whrProdutosRelacionados = "AND pro_id<>{$val['id']} ";

						$sql = "SELECT pro_id, pro_codigo, pro_titulo FROM ".TP."_produto WHERE pro_titulo IS NOT NULL {$whrProdutosRelacionados} ORDER BY pro_tipo,pro_titulo";
						if (!$qry = $conn->prepare($sql))
							echo $conn->error;
						else {
							$qry->bind_result($id, $codigo, $titulo);
							$qry->execute();
							while($qry->fetch()) {
				 ?>
				<option value='<?=$id?>'<?php if(in_array($id, $lstProdutosRelacionados)) echo ' selected';?>><?=$codigo.' - '.$titulo?></option>
				<?php
						 }
						$qry->close();
					 }
					?>
			</select>
			</div>
		</div>

	</fieldset>

		<div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


