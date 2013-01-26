 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
	<li><label for="titulo" class="error-validate">Digite o <b>título</b> da notícia</label></li>
      <li><label for="categoria" class="error-validate">Selecione uma <b>categoria</b></label></li>
	<li><label for="data" class="error-validate">Informe uma <b>data</b> válida</label></li>
      <li><label for="texto" class="error-validate">Escreva um <b>texto</b></label></li>
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
  if ($act=='insert') echo $var['insert'];
   else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

  <fieldset>

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
      <label class="control-label" for="titulo">* Título</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Título da notícia' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data">* Data</label>
      <div class="controls">
        <input type="text" class="input-small required data" placeholder='dd/mm/YYYY' name='data' id='data' value='<?=dateen2pt('-', $val['data'], '/')?>'>
        <p class='help-block'>Data de publicação<br/><b>Dica:</b> Informe uma data no futuro para que a notícia somente seja exibido nessa data</p>
      </div>
    </div>

<!--
    <div class="control-group">
      <label class="control-label" for="resumo">* Resumo</label>
      <div class="controls">
        <textarea placeholder='Resumo para a listagem' name='resumo' id='resumo' rows=3 cols=100 class='required' style='width:680px'><?=stripslashes($val['resumo'])?></textarea>
      </div>
    </div>
  -->

    <div class="control-group">
      <label class="control-label" for="texto">* Texto</label>
      <div class="controls">
        <textarea placeholder='Conteúdo do post' name='texto' id='texto' rows=25 cols=100 class='required tinymce' style='width:680px'><?=stripslashes($val['texto'])?></textarea>
      </div>
    </div>

  </fieldset>


    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


