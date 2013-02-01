<?php
	if (isset($val['id'])) {
		$item = $hashids->decrypt($val['id']);
		$item = $item[0];
	}
	$valTipo = isset($val['tipo_id']) ? $val['tipo_id'] : $val['tipo'];
 ?>
	<!-- <div class="row produto"> -->
	<div class="column grid_10">
		<div class="column">
			<h1><?=$basename=='anuncio' && empty($querystring) ? 'Inserir Anuncio' : 'Editar Anuncio '.$val['titulo']?></h1>
			<p><em>Todos os campos com - <span class="color-red">*</span> - são obrigatórios.</em></p>
			<p><br /></p>
		</div>

		<div class="column grid_10">
			<form name="anuncio" class="form-horizontal" method="post" enctype="multipart/form-data">
				<input type="hidden" name="from" value="anuncio">
				<input type="hidden" name="imageName" value="foto">
				<input type="hidden" name="usr_id" value="<?=$usr['id']?>">
				<?php
					if (!empty($querystring))
						echo "<input type='hidden' name='id' value='{$val['id']}'>\n";
				?>


			    <div class="control-group">
			      <label class="control-label" for="foto">
			        <span class="color-red">*</span> Fotos<br/>
			        <small>
			          <a href='javascript:void(0);' class='addImagem' id='min'>
			            adicionar + fotos
			          </a>
			        </small>
			      </label>
			      <div class="controls">
			    	  <?php

			            $num=0;
			    	    if (!empty($querystring)) {

			    		    $sql_gal = "SELECT rcg_id, rcg_imagem, rcg_pos FROM ".TP."_r_classificado_galeria WHERE rcg_ucl_id=? AND rcg_imagem IS NOT NULL ORDER BY rcg_pos ASC;";
			    		    if (!$qr_gal = $conn->prepare($sql_gal))
			    		    	echo $conn->error;

			    		    else {
				    		    $qr_gal->bind_param('i',$item);
				    		    $qr_gal->execute();
				    		    $qr_gal->store_result();
				    		    $num = $qr_gal->num_rows;
				    		    $qr_gal->bind_result($g_id, $g_imagem, $g_pos);
				    		    $i=0;

				                if ($num>0) {

							$imagePath = STATIC_PATH."classificado/thumb/";
				    		      while ($qr_gal->fetch()) {

								$arquivo = $imagePath.$g_imagem;
				    	  ?>
				    	  <div id='boxImage<?=$g_id?>' class='pull-left span2' align=center>
			    			 <?php
				    			    if (file_exists('./public/'.$imagePath.$g_imagem))
					    			     echo "<img src='".substr($imagePath, 0)."/".$g_imagem."' width=100>";
				    			  ?>
							<br/><small>
				    		    [<a href='javascript:void(0);' title="Clique para remover o ítem selecionado" class='tip drop-image' id="<?=$g_id?>">remover</a>]
							</small>
						</div>
				          <?php
				    		      $i++;

					    			}
			    		   echo '<br>';
					   ?>
			    		 <div class='divImagem hide'>
			    		   <input class="galeria" type='file' name='foto[]' id='galeria' alt='0'>
			    		 </div>
					   <?php

					    	       }
					    	       echo "<br clear='all'/>";
					    	     }
				    	     }
			           ?>
			    		 <div class='divImagem' style='display:block; clear:all;'>
			    		   <input class="galeria" type='file' name='foto[]' id='galeria' alt='0'>
			    		 </div>
			        <p class="help-block">- JPEG, PNG ou GIF; Limite de 4 fotos</p>
			      </div>
			    </div>

				<div class="control-group">
					<label class="control-label required" for="tipo"><span class="color-red">*</span> Tipo</label>
					<div class="controls">
					<select name="tipo" id="tipo">
						<?=convertCatList2Option(getCategoriaListArea('Tipo Classificado', null, 'Selecione', null, 'cat_titulo'), $valTipo)?>
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
						<input type="text" class="input-medium price" placeholder='R$ 99,99' name='valor' id='valor' value="<?=isset($val['valor']) ? $val['valor'] : null?>">
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
					      <button type="submit" class="btn-agro"><?=$basename=='anuncio' && empty($querystring) ? 'Inserir Anuncio' : 'Atualizar Anuncio '?></button>
					</div>
				</div>
			</form>
		</div>
	</div>
