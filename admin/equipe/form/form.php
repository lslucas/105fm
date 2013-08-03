<?php

	// $lstProdutosRelacionados = array();
	if ($act=='update') {
/*
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
 */
	}

?>
 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de continuar corrija os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="titulo" class="error-validate">Entre com o nome do <b>apresentador</b></label></li>
		<li><label for="texto" class="error-validate">Entre com um <b>texto</b></label></li>
		<li><label for="programa" class="error-validate">Entre com o nome do <b>programa</b></label></li>
		<li><label for="imagem" class="error-validate">Entre com a <b>imagem do programa</b></label></li>
	</ol>
</div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
	if ($act=='update') {
		echo "<input type='hidden' name='item' value='${_GET['item']}'>";
	}
?>

<h1>
<?php
	if ($act=='insert') echo "Novo Apresentador";
	 else echo "Alterar Apresentador: ".$val['titulo'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

	<fieldset>

		<div class="control-group">
		  <label class="control-label" for="imagem">Imagem</label>
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

								if (file_exists(substr($var['path_imagem'], 0)."/".$g_imagem))
									echo "<img src='".substr($var['path_thumb'],0)."/".$g_imagem."'>";

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
			<label class="control-label" for="nome">* Apresentador</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Nome do Apresentador' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
			</div>
		</div>

		<div class="control-group">
			<label class="control-label" for="programa">* Programa</label>
			<div class="controls">
				<input type="text" class="input-xlarge required" placeholder='Programa' name='programa' id='programa' value='<?=isset($val['programa']) ? $val['programa'] : null?>'>
			</div>
		</div>

	    <div class="control-group">
	      <label class="control-label" for="texto">* Texto</label>
	      <div class="controls">
	        <textarea placeholder='Detalhes do apresentador' name='texto' id='texto' rows=25 cols=100 class='required tinymce' style='width:680px'><?=stripslashes($val['texto'])?></textarea>
	      </div>
	    </div>

	</fieldset>

		<div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>


</form>