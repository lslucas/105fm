<?php
/*
 *INICIO MSG ERROS
 */
$nomeAcao = $act=='insert'?'registred':'modified';

//duplicado
$msgDuplicado = <<<end
<div class='alert alert-error'>
	<a class="close" data-dismiss="alert">×</a>
	Categoria já existe!
	<br>
	<p class='small'>
		<a href='javascript:history.back(-1);'>Volte e tente novamente</a>
	</p>
</div>
end;

# erro
$msgErro = <<<end
<div class='alert alert-error'>Erro!
	<a class="close" data-dismiss="alert">×</a>
	<br>
	<pre>$conn->error()</pre>
</div>
end;

# sucesso
$msgSucesso = <<<end
<div class='alert alert-success'>
	<a class="close" data-dismiss="alert">×</a>
	Categoria $nomeAcao!
	<br/><p class='small'>
		 <a href='?p={$var['path']}&insert'>Nova Categoria</a>
	</p>
</div>
end;
