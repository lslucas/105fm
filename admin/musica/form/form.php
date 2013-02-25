 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="titulo" class="error-validate">Digite o <b>nome</b> do artista ou grupo</label></li>
		<li><label for="art_code" class="error-validate">Selecione um <b>artista</b></label></li>
		<li><label for="data" class="error-validate">Informe uma <b>data</b> válida</label></li>
		<li><label for="album" class="error-validate">Informe um <b>album</b></label></li>
		<li><label for="youtube" class="error-validate">Informe uma url válida para o <b>youtube</b></label></li>
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
      <label class="control-label" for="mp3">MP3<!--<br/><span class='small'><a href='javascript:void(0);' class='addImagem' id='min'>adicionar + fotos</a></span>--></label>
      <div class="controls">
        <?php

            $num=0;
          if ($act=='update') {

            $sql_gal = "SELECT rmm_id, rmm_media, rmm_pos FROM ".TABLE_PREFIX."_${var['table']}_media WHERE rmm_{$var['pre']}_id=? AND rmm_media IS NOT NULL ORDER BY rmm_pos ASC LIMIT 1;";
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
        <tr id="<?=$g_id?>">
          <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

          <td>
        <small>
            [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=<?=$var['table']?>_media&pre=rmm&col=media&folder=<?=$var['path_media']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
        </small>
          </td>
          <td>
            <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip' target='_blank'>
          <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a>
           <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
           <?php

              if (file_exists(substr($var['path_media'],0)."/".$g_imagem))
               echo "<img src='".substr($var['path_media'],0)."/".$g_imagem."'>";

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
           <input class="galeria" type='file' name='mp3' id='mp3' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
           <br><span class='small'>- Apenas MP3</span>
         </div>
       <?php

             }
           ?>
         <div class='divImagem'>
           <input class="galeria" type='file' name='mp3' id='mp3' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
           <br><span class='small'>- Apenas MP3</span>
         </div>
      </div>
    </div>

  <fieldset>
    <div class="control-group">
      <label class="control-label" for="titulo">* Título</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Título' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="art_code">* Artista</label>
      <div class="controls">
		  <select name='art_code' id='art_code'>
			<option>Selecione</option>
			<?php
			  $sql_art = "SELECT art_titulo, art_code FROM ".TABLE_PREFIX."_artista ORDER BY art_titulo";
			  $qry_art = $conn->prepare($sql_art);
			  $qry_art->bind_result($titulo, $code);
			  $qry_art->execute();

				  while ($qry_art->fetch()) {
			?>
		   <option value='<?=$code?>'<?php if ($act=='update' && $val['art_code']==$code) echo ' selected';?>> <?=$titulo?></option>
		<?php } $qry_art->close(); ?>
		  </select>

      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data">* Data de publicação</label>
      <div class="controls">
        <input type="text" class="input-xlarge required data" placeholder='Data de publicação da musica' name='data' id='data' value='<?=dateen2pt('-', $val['data'], '/')?>'>
		<p class="help-block">Informe uma data futura para que a música só seja exibida no site a partir de essa data</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="album">Album</label>
      <div class="controls">
        <input type="text" class="input-xlarge" placeholder='Album da música' name='album' id='album' value='<?=$val['album']?>'>
      </div>
    </div>

<!--
    <div class="control-group">
      <label class="control-label" for="youtube">Youtube</label>
      <div class="controls">
        <input type="text" class="input-xlarge url" placeholder='Vídeo ou Clip da música' name='youtube' id='youtube' value='<?=$val['youtube']?>'>
      </div>
    </div>
-->
	<input type='hidden' name='youtube' value=''/>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


