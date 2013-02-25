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
      <label class="control-label" for="titulo">* Título</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Título' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
        <p class="help-block">Informe o nome/título do show</p>
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
      <label class="control-label" for="local">* Local</label>
      <div class="controls">
        <textarea name='local' class='required' id='local'><?=$val['local']?></textarea>
        <p class="help-block">Informe o local ou endereço do show</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="url">URL</label>
      <div class="controls">
        <input type="text" class="input-xlarge url" placeholder='URL de mais informações sobre o show' name='url' id='url' value='<?=$val['url']?>'>
        <p class="help-block">Informe a url ou link para maiores informações sobre o show</p>
      </div>
    </div>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


