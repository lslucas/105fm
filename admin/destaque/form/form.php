 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="titulo" class="error-validate">Digite o título</label></li>
		<li><label for="resumo" class="error-validate">Informe o resumo</label></li>
             <li><label for="texto" class="error-validate">Informe o texto</label></li>
             <li><label for="data" class="error-validate">Informe a data</label></li>
	</ol>
</div>



<form method='post' action='?<?php echo $_SERVER['QUERY_STRING']?>' id='form_<?php echo $p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?php echo $act?>'>
<?php
	if ($act=='update')
		echo "<input type='hidden' name='item' value='${_GET['item']}'>";
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
      <label class="control-label" for="foto">Fotos<!--<br/><span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar + fotos</a></span>--></label>
      <div class="controls">
    	  <?php

            $num=0;
    	    if ($act=='update') {

    		    $sql_gal = "SELECT rdg_id, rdg_imagem, rdg_pos FROM ".TABLE_PREFIX."_r_${var['table']}_galeria WHERE rdg_{$var['pre']}_id=? AND rdg_imagem IS NOT NULL ORDER BY rdg_pos ASC;";
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

					  $arquivo = $var['path_original']."/".$g_imagem;
    	  ?>
    		<tr id="<?php echo $g_id?>">
    		  <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

    		  <td>
				<small>
    		    [<a href='?p=<?php echo $p?>&delete_galeria&item=<?php echo $g_id?>&prefix=r_<?php echo $var['path']?>_galeria&pre=rdg&col=imagem&folder=<?php echo $var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?php echo $g_id?>">remover</a>]
				</small>
    		  </td>
    		  <td>
    		    <a href='$imagThumb<?php echo $i?>?width=100%' id='imag<?php echo $i?>' class='betterTip' target='_blank'>
    			<img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>
    			 <div id='imagThumb<?php echo $i?>' style='float:left;display:none;'>
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
    		   <br><span class='small'>- JPEG, PNG ou GIF;<?php echo $var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
    		 </div>
		   <?php

    	       }
           ?>
    		 <div class='divImagem'>
    		   <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
    		   <br><span class='small'>- JPEG, PNG ou GIF;<?php echo $var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
    		 </div>
            <?php //} ?>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="descricao">Descricao</label>
      <div class="controls">
        <input type="text" class="input-xlarge " placeholder='Descrição do destaque' name='descricao' id='descricao' value='<?php echo $val['descricao']?>'>
      </div>
    </div>

     <div class="control-group">
      <label class="control-label" for="link">Link</label>
      <div class="controls">
        <input type="text" class="input-xlarge url" placeholder='Link do destaque' name='link' id='link' value='<?php echo $val['link']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data">* Data</label>
      <div class="controls">
        <input type="text" class="input-xlarge required data" placeholder='dd/mm/YYYY' name='data' id='data' value='<?php echo dateen2pt('-',$val['data'],'/')?>'>
        <p class="help-block">Entre com a data de cadastro (para ordenação e entrada no site)</p>
      </div>
    </div>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


