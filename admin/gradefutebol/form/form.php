 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
	<li><label for="time" class="error-validate">Entre com os <b>times</b></label></li>
      <li><label for="horario" class="error-validate">Entre com um <b>horario</b></label></li>
	<li><label for="data" class="error-validate">Informe uma <b>data</b> válida</label></li>
      <li><label for="apresentador" class="error-validate">Entre com um <b>apresentador</b></label></li>
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
      <label class="control-label" for="times">* Times</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Times' name='times' id='times' value='<?=$val['times']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data">* Data</label>
      <div class="controls">
        <input type="text" class="input-small required data" placeholder='dd/mm/YYYY' name='data' id='data' value='<?=dateen2pt('-', $val['data'], '/')?>'>
        <p class='help-block'>Data do jogo</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="horario">* Horario</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Horario' name='horario' id='horario' value='<?=$val['horario']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="apresentador">Apresentador</label>
      <div class="controls">
        <input type="text" class="input-xlarge" placeholder='Apresentador' name='apresentador' id='apresentador' value='<?=$val['apresentador']?>'>
      </div>
    </div>

  </fieldset>


    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


