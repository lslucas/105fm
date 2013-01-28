<div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="codigo" class="error-validate">Digite o codigo</label></li>
		<li><label for="url" class="error-validate">Entre com uma <b>url</b> válida</label></li>
		<li><label for="imagem" class="error-validate">Informe uma <b>imagem</b></label></li>
	</ol>
</div>


<form method='post' action='?<?php echo $_SERVER['QUERY_STRING']?>' id='form_<?php echo $p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?php echo $act?>'>
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

	<fieldset>

	<div class="control-group">
	  <label class="control-label" for="area">* Area</label>
	  <div class="controls">
		<select class="input-xlarge required" name='area' id='area'>
			<option value=''>Selecione</option>
			<option value='Lateral 1'<?php echo $act=='update' && $val['area']=='Lateral 1' ? ' selected' : null?>>Lateral 1</option>
			<option value='Lateral 2'<?php echo $act=='update' && $val['area']=='Lateral 2' ? ' selected' : null?>>Lateral 2</option>
			<option value='Home Final 1'<?php echo $act=='update' && $val['area']=='Home Final 1' ? ' selected' : null?>>Home Final 1</option>
			<option value='Home Final 2'<?php echo $act=='update' && $val['area']=='Home Final 2' ? ' selected' : null?>>Home Final 2</option>
			<option value='Home Final 3'<?php echo $act=='update' && $val['area']=='Home Final 3' ? ' selected' : null?>>Home Final 3</option>
		</select>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="foto">Imagem do banner ou swf</label>
	  <div class="controls">
		  <?php

			$num=0;
			if ($act=='update') {

				$sql_s = "SELECT ${var['pre']}_id, ${var['pre']}_imagem FROM ".TABLE_PREFIX."_${var['table']} WHERE ${var['pre']}_id=? LIMIT 1";
				if (!$qry_s = $conn->prepare($sql_s))
					echo $conn->error;

				else {

					$qry_s->bind_param('i', $val['id']);
					$qry_s->bind_result($g_id, $g_imagem);
					//$qry_s->store_result();
					$qry_s->execute();
					$qry_s->fetch();
					$num = $qry_s->num_rows();
					$qry_s->close();


					echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';

					if (!empty($g_imagem)) {
						$arquivo = $var['path_original']."/".$g_imagem;
				  ?>
					<tr id="<?php echo $g_id?>">
					  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

					  <td>
						<small>
						[<a href='?p=<?php echo $p?>&delete_galeria&item=<?php echo $g_id?>&prefix=<?php echo $var['table']?>&pre=<?php echo $var['pre']?>&col=imagem&folder=<?php echo $var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?php echo $g_id?>">remover</a>]
						</small>
					  </td>
					  <td>
						<a href='$imagThumb<?php echo $i?>?width=100%' id='imag<?php echo $i?>' class='betterTip' target='_blank'>
						<img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>
						 <div id='imagThumb<?php echo $i?>' style='float:left;display:none;'>
						 <?php

							if (file_exists(substr($var['path_imagem'],0)."/".$g_imagem))
								echo "<img src='".substr($var['path_imagem'],0)."/".$g_imagem."'>";

							   else echo "<center>imagem não existe.</center>";

						  ?>
						 </div>
					  </td>
					</tr>
				  <?php
						  $i++;

					}

						echo '</table><br>';

					?>
					 <div class='divImagem'>
					   <input type='file' name='midia' id='midia' style="margin-bottom:8px; width:500px;">
					   <br><span class='small'>- JPEG, PNG, GIF ou SWF;<?php echo $var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
					 </div>
					<?php

				}

			   } else {
		   ?>
			 <div class='divImagem'>
			   <input type='file' name='midia' id='midia' style="margin-bottom:8px; width:500px;">
			   <br><span class='small'>- JPEG, PNG, GIF ou SWF;<?php echo $var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
			 </div>
			<?php

			   }
			?>
	  </div>
	</div>

	<div class="control-group">
	  <label class="control-label" for="titulo">* Título</label>
	  <div class="controls">
		<input type="text" class="input-xlarge required" placeholder='Nome descritivo do banner' name='titulo' id='titulo' value='<?php echo $val['titulo']?>'>
		<p class="help-block">Informe um nome descritivo, apenas para referência</p>
	  </div>
	</div>


	<div class="control-group">
	  <label class="control-label" for="date_from">* Data de Publicação</label>
	  <div class="controls">
		<input type="text" class="input-xlarge data required" placeholder='Data para exibir no site' name='date_from' id='date_from' value='<?php echo $act=='insert' ? date('d/m/Y') : dateen2pt('-',$val['date_from'],'/')?>'>
		<p class="help-block">Informe uma data para publicação no site </p>
	  </div>
	</div>


	<div class="control-group">
	  <label class="control-label" for="date_to">Data de Retirada do Site</label>
	  <div class="controls">
		<input type="text" class="input-xlarge data" placeholder='Data para retirar do site' name='date_to' id='date_to' value='<?php echo $act=='insert' ? date('d/m/Y') : dateen2pt('-',$val['date_to'],'/')?>'>
		<p class="help-block">Informe uma data para retirada do site </p>
	  </div>
	</div>


	<div class="control-group">
	  <label class="control-label" for="url">URL</label>
	  <div class="controls">
		<input type="text" class="input-xlarge" placeholder='http://destino.com.br' name='url' id='url' value='<?php echo $val['url']?>'>
		<p class="help-block">URL de destino</p>
	  </div>
	</div>
	</fieldset>

	<div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>

</form>

