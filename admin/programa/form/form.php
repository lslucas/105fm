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
        <input type="text" class="input-xlarge required" placeholder='Nome do Programa' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
        <p class="help-block">Informe o nome/título do show</p>
      </div>
    </div>

     <div class="control-group">
      <label class="control-label" for="apresentacao">* Apresentação</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Apresentadores' name='apresentacao' id='apresentacao' value='<?=$val['apresentacao']?>'>
        <p class="help-block">Informe o(s) Apresentadores</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="texto">* Descrição do Programa</label>
      <div class="controls">
        <textarea name='texto' class='required' id='descricao' rows=3  style="width:500px;" ><?=$val['texto']?></textarea>
        <p class="help-block">Informe a descrição</p>
      </div>
    </div>


  <div class="control-group">
    <label class="control-label" for="diasemana">* Dias da Semana</label>
    <div class="controls">
         <?php

            $sql_week = "SELECT pro_diasemana, pro_hora, pro_hora_fim FROM ".TABLE_PREFIX."_programa_semana WHERE pro_id=?";
            $qry_week = $conn->prepare($sql_week);
            $qry_week->bind_param('i', $val['id']);
            $qry_week->bind_result($diasemana, $hora, $hora_fim);
            $qry_week->execute();
            $weekRange = array();

            while($qry_week->fetch()) {
              $weekRange[$diasemana]['dia'] = $diasemana;
              $weekRange[$diasemana]['hora'] = $hora;
              $weekRange[$diasemana]['hora_fim'] = $hora_fim;
            }

            for ($i = 1; $i <= 7; $i++) {
              $hora = isset($weekRange[$i]['hora']) ? substr($weekRange[$i]['hora'], 0, 5) : null;
              $hora_fim = isset($weekRange[$i]['hora_fim']) ? substr($weekRange[$i]['hora_fim'], 0, 5) : null;
              $week = isset($weekRange[$i]['dia']) ? $weekRange[$i]['dia'] : null;

              echo "<div style='display:block; border-bottom:1px solid #ccc; height:32px; margin-bottom:5px;'><label style='float:left; width:100px'>";
              echo "<input type='checkbox' class='required' title='Selecione ao menos um dia da semana' name='diasemana[]' id='diasemana' value='{$i}'";
              if (!empty($week))
                echo " checked";
              echo "> ".traduzWeek($i);
              echo "</label>";
              echo " Inicio: <input style='display:table-cell; margin-left:5px; width:40px' class='hour' type='text' name='hora[{$i}]' value='{$hora}'>";
              echo " &nbsp; &nbsp; Fim: <input style='display:table-cell; margin-left:5px; width:40px' class='hour' type='text' name='hora_fim[{$i}]' value='{$hora_fim}'>";
              echo "</div>";
            }
        ?>
    </div>
  </div>


  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>

</form>