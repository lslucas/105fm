 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="titulo" class="error-validate">Digite o <b>nome/titulo</b> do show</label></li>
		<li><label for="data" class="error-validate">Informe uma <b>data</b> válida</label></li>
		<li><label for="artista" class="error-validate">Digite o(s) <b>artista(s)</b></label></li>
		<li><label for="local" class="error-validate">Informe o <b>local</b> do evento</label></li>
		<li><label for="url" class="error-validate">Informe uma <b>url</b> válida para mais informações sobre o show</label></li>
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

  <fieldset>

    <div class="control-group">
      <label class="control-label" for="foto">* Flyer</label>
      <div class="controls">
        <?php

            $num=0;
          if ($act=='update') {

            $sql_gal = "SELECT rsg_id, rsg_imagem, rsg_legenda, rsg_pos FROM ".TABLE_PREFIX."_r_${var['table']}_galeria WHERE rsg_{$var['pre']}_id=? AND rsg_imagem IS NOT NULL ORDER BY rsg_pos ASC;";
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
          <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

          <td>
        <small>
            [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=r_<?=$var['table']?>_galeria&pre=rsg&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
        </small>
          </td>
          <td>
            <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip' target='_blank'>
          <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a> &nbsp; <span style='font-size:8pt; color:#777;'><?=!empty($g_legenda) ? $g_legenda : '[sem legenda]'?></span>
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
          }

        }
           echo '</table><br>';
       ?>
         <div class='divImagem'>
         <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
         <br clear='all'/><textarea class="legenda" name='legenda0' id='legenda' alt='0' style="margin-bottom:8px; width:500px;" rows=2></textarea>
         <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
         <hr noshade size=1 style='border-color:#C4C4C4; background-color:#FFF; width:520px;'/>
         </div>
        <p class='help-block'>Clique ao lado da lupa para ordenar as fotos, a primeiro sempre é a capa!</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="titulo">* Título</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Título' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
        <p class="help-block">Informe o nome/título do show</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data_exibir">* Data de Exibição</label>
      <div class="controls">
        <input type="text" class="input-xlarge required date" placeholder='Data de Exibição' name='data_exibir' id='data' value='<?=dateen2pt('-', $val['data_exibir'], '/')?>'>
        <p class="help-block">Informe a data/hora para exibir esse item no site</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data">* Data do Show</label>
      <div class="controls">
        <input type="text" class="input-xlarge required data" placeholder='Data/Hora do Show' name='data' id='data' value='<?=dateen2pt('-', $val['data'], '/')?>'>
        <p class="help-block">Informe a data/hora do show</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="hora_inicio">Hora Inicio</label>
      <div class="controls">
        <input type="text" class="input-small hour" placeholder='Hora de Inicio' name='hora_inicio' id='hora_inicio' value='<?=$val['hora_inicio']?>'>
      </div>
    </div>
<!--
    <div class="control-group">
      <label class="control-label" for="hora_fim">Hora Fim</label>
      <div class="controls">
        <input type="text" class="input-small hour" placeholder='Hora de Fim' name='hora_fim' id='hora_fim' value='<?=$val['hora_fim']?>'>
      </div>
    </div>
    <div class="control-group">
      <label class="control-label" for="artista">* Artista</label>
      <div class="controls">
        <textarea name='artista' class='required' id='artista'><?=$val['artista']?></textarea>
        <p class="help-block">Informe o(s) artista(s)</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="url">URL</label>
      <div class="controls">
        <input type="text" class="input-xlarge url" placeholder='URL de mais informações sobre o show' name='url' id='url' value='<?=$val['url']?>'>
        <p class="help-block">Informe a url ou link para maiores informações sobre o show</p>
      </div>
    </div>
-->

    <div class="control-group">
      <label class="control-label" for="local">* Local</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Local' name='local' id='local' value='<?=$val['local']?>'>
        <p class="help-block">Informe o local ou endereço do show</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="descricao">* Descrição do Evento</label>
      <div class="controls">
        <textarea name='descricao' class='required' id='descricao' rows=3  style="width:500px;" ><?=$val['descricao']?></textarea>
        <p class="help-block">Informe a descrição</p>
      </div>
    </div>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>

</form>