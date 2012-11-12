<?php
/*
 *INICIO MSG ERROS
 */
$nomeAcao = $act=='insert'?'registred':'modified';

//duplicado
$msgDuplicado = <<<end
<div class='alert alert-error'>
	<a class="close" data-dismiss="alert">×</a>
	Email <b>- $res[email] -</b> already exists!
	<br>
	<p class='small'>
	<a href='javascript:history.back(-1);'>Go back and try again</a>
</div>
end;

# erro
$msgErro = <<<end
<div class='alert alert-error'>Error!
	<a class="close" data-dismiss="alert">×</a>
	<br>
	<pre>$conn->error()</pre>
</div>
end;

# sucesso
$msgSucesso = <<<end
<div class='alert alert-success'>
	<a class="close" data-dismiss="alert">×</a>
	Administrator $nomeAcao!
	<br><p class='small'>
		<a href='?p=$p&insert'>New administrator?</a>
	</a>
</div>
end;
