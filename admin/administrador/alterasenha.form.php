<?php
 if (isset($_POST) && !empty($_POST)) {
  include_once 'alterasenha.mod.exec.php';
 }

?>
<div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
      Antes de continuar, entre com os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="senha_atual" class="error-validate">Por razões de segurança, informe sua senha atual</label></li>
		<li><label for="senha" class="error-validate">Entre com sua nova senha</label></li>
		<li><label for="confirma_senha" class="error-validate">Confirme sua senha</label></li>
	</ol>
</div>




<form method='post' action='?p=<?=$p?>&alterasenha' class='form-horizontal cmxform'>
 <input type='hidden' name='item' value='<?=$_SESSION['user']['id']?>'>


<h1>Trocar senha</h1>
<p class='header'>Preencha os campos abaixo.</p>


  <fieldset>
    <!--<legend>Legend text</legend>-->
    <div class="control-group">
      <label class="control-label" for="senha_atual">* Senha Atual</label>
      <div class="controls">
        <input type='password' class="input-xlarge required" name='senha_atual' id='senha_atual'>
        <p class="help-block">Por rasões de segurança entre com a senha atual</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="senha">* Nova Senha</label>
      <div class="controls">
        <input type='password' class="input-xlarge required" name='senha' id='senha'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="confirma_senha">* Confirme sua Senha</label>
      <div class="controls">
        <input type='password' class="input-xlarge required" name='confirma_senha' id='confirma_senha'>
        <p class="help-block">Confirmação de senha</p>
      </div>
    </div>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
	</div>

</form>


