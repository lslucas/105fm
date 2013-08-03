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
    <input type='hidden' name='assunto' value='<?=$val['assunto']?>'/>
    <input type='hidden' name='nome' value='<?=$val['nome']?>'/>
    <input type='hidden' name='email' value='<?=$val['email']?>'/>
    <input type='hidden' name='cidade' value='<?=$val['cidade']?>'/>
    <input type='hidden' name='estado' value='<?=$val['estado']?>'/>
    <input type='hidden' name='telefone' value='<?=$val['telefone']?>'/>
    <input type='hidden' name='datahora' value='<?=$val['timestamp']?>'/>
    <input type='hidden' name='ip' value='<?=$val['ip']?>'/>

    <b>Assunto:</b> <?=$val['assunto']?><br/>
    <b>Nome:</b> <?=$val['nome']?><br/>
    <b>Email:</b> <?=$val['email']?><br/>
    <b>Cidade/UF:</b> <?=$val['cidade']?>/<?=$val['estado']?><br/>
    <b>Telefone:</b> <?=$val['telefone']?><br/>
    <b>Mensagem:</b> <?=$val['mensagem']?><br/>
    <b>Data/Hora:</b> <?=$val['timestamp']?><br/>
    <b>IP:</b> <?=$val['ip']?><br/>
    <br/><hr/>

    <div class="control-group">
      <label class="control-label" for="reposta">* Resposta</label>
      <div class="controls">
        <textarea placeholder='Resposta' name='texto' id='texto' rows=25 cols=100 class='required tinymce' style='width:680px'>
          <h3>Pergunta</h3>
          <?=$val['mensagem']?>

          <hr/>
          <h3>Resposta</h3>
          <?=!empty($val['resposta']) ? $val['resposta'] : 'Resposta'?>
        </textarea>
      </div>
    </div>

  </fieldset>


    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>



</form>


