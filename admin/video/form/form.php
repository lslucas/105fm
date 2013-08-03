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

    <div class="control-group">
      <label class="control-label" for="youtube">* Youtube</label>
      <div class="controls">
        <input type="text" class="input-xlarge url required" placeholder='Vídeo ou Clip da música' name='youtube' id='youtube' value='<?=$val['youtube']?>'>
	  <p class="help-block">Informe a url do vídeo <b>sem</b> nenhum parâmetro extra, exemplo:
		<br/>Essa url está correta: http://www.youtube.com/watch?v=p0oFWgwUqHU
		<br/>Essa url <b>não</b> está correta: http://www.youtube.com/watch?v=p0oFWgwUqHU&feature=player_embedded</p>
      </div>
    </div>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


