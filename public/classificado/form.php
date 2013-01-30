	<!-- <div class="row produto"> -->
	<div class="column grid_10">
		<div class="column">
			<h1><?=$basename=='classificado' ? 'Inserir Classificado' : 'Editar Classificado '.$val['titulo']?></h1>
			<p><em>Todos os campos com - <span class="color-red">*</span> - são obrigatórios.</em></p>
			<p><br /></p>
		</div>

		<div class="column">
			<form name="produto" class="form-horizontal" method="post">
				<input type="hidden" name="from" value="produto">
				<input type="hidden" name="usr_id" value="<?=$usr['id']?>">
				<?php
					if ($basename=='editar-produto')
						echo "<input type='hidden' name='id' value='{$val['id']}'>\n";
				?>


			    <div class="control-group">
			      <label class="control-label" for="foto">
			        Fotos<!--<br/>
			        <span class='small'>
			          <a href='javascript:void(0);' class='addImagem' id='min'>
			            adicionar + fotos
			          </a>
			        </span>-->
			      </label>
			      <div class="controls">
			    	  <?php

			            $num=0;
			    	    if ($act=='update') {

			    		    $sql_gal = "SELECT rng_id, rng_imagem, rng_pos FROM ".TABLE_PREFIX."_r_${var['table']}_galeria WHERE rng_{$var['pre']}_id=? AND rng_imagem IS NOT NULL ORDER BY rng_pos DESC LIMIT 1;";
			    		    $qr_gal = $conn->prepare($sql_gal);
			    		    $qr_gal->bind_param('s',$_GET['item']);
			    		    $qr_gal->execute();
			    		    $qr_gal->store_result();
			    		    $num = $qr_gal->num_rows;
			    		    $qr_gal->bind_result($g_id, $g_imagem, $g_pos);
			    		    $i=0;

			    	    }

			                if ($num>0) {

			    		      echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
			    		      while ($qr_gal->fetch()) {

								  $arquivo = $var['path_thumb']."/".$g_imagem;
			    	  ?>
			    		<tr id="<?=$g_id?>">
			    		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

			    		  <td>
							<small>
			    		    [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=r_<?=$var['table']?>_galeria&pre=rng&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
							</small>
			    		  </td>
			    		  <td>
			    		    <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip' target='_blank'>
			    			<img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>
			    			 <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
			    			 <?php
			    			    if (file_exists(substr($var['path_thumb'],0)."/".$g_imagem))
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
			    		 <div class='divImagem hide'>
			    		   <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
			    		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
			    		 </div>
					   <?php

			    	       }
			           ?>
			    		 <div class='divImagem'>
			    		   <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
			    		   <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
			    		 </div>
			        <p class="help-block">Foto.</p>
			      </div>
			    </div>

				<div class="control-group">
					<label class="control-label required" for="tipo"><span class="color-red">*</span> Tipo</label>
					<div class="controls">
					<select name="tipo" id="tipo">
						<?=convertCatList2Option(getCategoriaListArea('Tipo Classificado', $val['tipo'], 'Tipo', null, 'cat_titulo'), $val['tipo'])?>
					</select> <small><a href="javascript:void(0);" class='showOnClick' data-target='#outroTipo'>outro?</a></small>
					</div>

					<div id='outroTipo' class='hide'>
						<br/><label class="control-label" for="nomeTipo"><span class="color-red">*</span> Outro Tipo</label>
						<div class="controls">
							<input type="text" class="input-xlarge" placeholder='Outro Tipo' name='nomeTipo' id='nomeTipo' disabled=disabled value="<?=isset($val['nomeTipo']) ? $val['nomeTipo'] : null?>">
						</div>
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="titulo"><span class="color-red">*</span> Título</label>
					<div class="controls">
						<input type="text" class="input-xlarge required" placeholder='Título do Produto' name='titulo' id='titulo' value="<?=isset($val['titulo']) ? $val['titulo'] : null?>">
					</div>
				</div>

				<div class="control-group">
					<label class="control-label" for="modelo">Modelo</label>
					<div class="controls">
						<input type="text" class="input-xlarge" placeholder='Modelo do Produto' name='modelo' id='modelo' value="<?=isset($val['modelo']) ? $val['modelo'] : null?>">
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
					<label class="control-label" for="descricao"><span class="color-red">*</span> Descrição</label>
					<div class="controls">
						<textarea name='descricao' id='descricao' class='input-xlarge required' cols='90' rows='3'><?=isset($val['descricao']) ? $val['descricao'] : null?></textarea>
					</div>
				</div>

				<div class="control-group">
					<div class="controls">
					      <button type="submit" class="btn-agro"><?=$basename=='classificado' ? 'Inserir Classificado' : 'Atualizar Classificado '?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
