<?php
/*
 *INICIO MSG ERROS
 */
$nomeAcao = $act=='insert'?'cadastrado':'alterado';

//duplicado
$msgDuplicado = <<<end
<div class='alert alert-error'>
	<a class="close" data-dismiss="alert">×</a>
	Já existe um produto com o código <b>{$val['codigo']}</b>!
	<br>
	<p class='small'>
		<a href='javascript:history.back(-1);'>Voltar ao formulário</a>
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
	Produto $nomeAcao!
	<br/><p class='small'>
		<a href='?p={$var['path']}&insert'>Novo</a>
	</p>
</div>
end;
