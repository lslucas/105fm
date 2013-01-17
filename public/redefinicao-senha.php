    <!-- *** CONTENT *** -->
    <article>
    	<h2 id="titulo_pagina">Redefinição de senha</h2>

     <form method='post' name='redefinicao-senha'>
        <input type='hidden' name='token' value='<?=md5($_SERVER['REMOTE_ADDR'].time())?>'/>
        <input type='hidden' name='from' value='<?=$basename?>'/>
        <section class="box">
        	<strong id="instrucao_titulo">Insira uma nova senha para garantir seu acesso ao site.</strong>

        	<ul id="form">
                <li>
                    <strong class="input_titulo" id="titulo_senha">Senha:</strong>
                    <input type="password" class="senha required" name='senha' id='senha' value='<?=$val['senha']?>'>
                    <div class="erro invisible errorSenha">Campo obrigatório, mínimo 6 caracteres</div>
                </li>

                <li>
                    <strong class="input_titulo" id="titulo_confirme">Confirme a senha:</strong>
                    <input type="password" class="senha2 required" name='confirmaSenha' id='confirme' value='<?=$val['confirmaSenha']?>'>
                    <div class="erro invisible errorConfirmaSenha">Esse campo deve ser idêntico ao campo Senha</div>
                </li>

                <li>
                        <div id="btn_enviar">Enviar</div>
                </li>
            </ul>
        </section>
        </form>
    </article>
    <!-- *** END CONTENT *** -->