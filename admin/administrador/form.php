<div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de continuar, corrija os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="nome" class="error-validate">Digite o nome</label></li>
		<li><label for="email" class="error-validate">Entre com um email válido</label></li>
		<li><label for="mod_id" class="error-validate">Selecione um ou mais módulos</label></li>
	</ol>
</div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' class='form-horizontal cmxform'>
 <input type='hidden' name='act' value='insert'>
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

<?php
	if ($act=='update' &&  $_GET['item']==$_SESSION['user']['id']) {
?>
<div class='alert alert-warning'>
	Para trocar a senha <a href='<?=$rp?>?p=<?=$p?>&alterasenha'>clique aqui</a>.
</div>
<?php } ?>


  <fieldset>
    <!--<legend>Legend text</legend>-->
    <div class="control-group">
      <label class="control-label" for="nome">* Nome</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Nome' name='nome' id='nome' value='<?=$val['nome']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="email">* Email</label>
      <div class="controls">
        <input type="text" class="input-xlarge email required" placeholder='email@provedor.com.br' name='email' id='email' value='<?=$val['email']?>'>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="mod_id">* Modulo</label>
      <div class="controls">
	  <?php

	   if ($act=='insert') {
	    $sql_mod = "SELECT mod_id,mod_nome FROM ".TABLE_PREFIX."_modulo WHERE mod_status=1 AND mod_private=0";
	    $qry_mod = $conn->prepare($sql_mod);
	    $qry_mod->bind_result($id, $nome);

	    } else {
	     $sql_mod = "SELECT mod_id,mod_nome,(SELECT COUNT(ram_id) FROM ".TABLE_PREFIX."_r_adm_mod WHERE ram_mod_id=mod_id and ram_adm_id=".$val['id'].") checked FROM ".TABLE_PREFIX."_modulo WHERE mod_status=1 AND mod_private=0";
	    $qry_mod = $conn->prepare($sql_mod);
	    $qry_mod->bind_result($id, $nome,$checked);
	   }


	   $qry_mod->execute();

	   $i=0;
	   while ($qry_mod->fetch()) {

	    if ($act=='update') {
	      $check[$id] = ($checked>0)?' checked':'';

	    } else $check[$id] = '';

	  ?>
	   <label><input type='checkbox' class='required' title='Selecione ao menos um módulo' name='mod_id[]' id='mod_id' value='<?=$id?>'<?=$check[$id]?>> <?=$nome?></label>
	  <?php $i++;} $qry_mod->close(); ?>
      </div>
    </div>

  </fieldset>


	<?php
	 if ($act=='insert') {
	?>
	<div class='alert alert-info'>
		<a class="close" data-dismiss="alert">×</a>
		<h4 class="alert-heading">Atenção:</h4> A senha sera automaticamente gerada e enviada por email.
	</div>
	<?php
	 }
	?>


    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>


</form>


