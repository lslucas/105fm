    <!-- *** CONTENT *** -->
    <article>
    	<h2 id="titulo_pagina">CONFIRA SE OS SEUS DADOS ESTÃO CORRETOS. ALTERE SE NECESSÁRIO.</h2>

    <form name='editar-dados' method='post'>
        <input type='hidden' name='token' value='<?=md5($_SERVER['REMOTE_ADDR'].time())?>'/>
        <input type='hidden' name='from' value='<?=$basename?>'/>
        <input type='hidden' name='id' value='<?=$usr['id']?>'/>
        <section class="box">
        	 <div id="dados_pessoais_esq">
            	<h3>Dados Pessoais</h3>

                <ul>
                    <li>
                        <strong id="titulo_nome">Nome Completo:</strong>
                        <input type="text" class="nome required" name='nome' id='nome' value='<?=$val['nome']?>'>
                        <div class="erro invisible errorNome">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_cpf">CPF:</strong>
                        <div id="btn_cpf">Por que?</div>
                        <div id="cpf_balloon">Nós precisamos dessas informações para poder identificar o vencedor da promoção. E fique tranquilo! Seus dados serão armazenados com toda a segurança.</div>
                        <input type="text" class="cpf required" name='cpf' id='cpf' value='<?=$val['cpf']?>'>
                        <div class="erro invisible errorCpf">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_telefone">Telefone:</strong>
                        <input type="text" class="required telefone1_1 telefone1" name='ddd1' id='ddd1' value='<?=$val['ddd1']?>' maxlength=2>
                        <input type="text" class="required telefone1_2 telefone1" name='telefone1_1' id='telefone1_1' value='<?=$val['telefone1_1']?>' maxlength=5>
                        <input type="text" class="required telefone1_3 telefone1 " name='telefone1_2' id='telefone1_2' value='<?=$val['telefone1_2']?>' maxlength=4>

                        <input type="text" class="required telefone2_1" name='ddd2' id='ddd2' value='<?=$val['ddd2']?>' maxlength=2>
                        <input type="text" class="required telefone2_2" name='telefone2_1' id='telefone2_1' value='<?=$val['telefone2_1']?>' maxlength=5>
                        <input type="text" class="required telefone2_3" name='telefone2_2' id='telefone2_2' value='<?=$val['telefone2_2']?>' maxlength=4>
                        <div class="erro invisible errorTelefone">Campo obrigatório, preencha ao menos um dos campos de telefone</div>
                    </li>

                    <li>
                        <strong id="titulo_nascimento">Data de Nascimento</strong>
                        <input type="text" class="data_nascimento_dia nascimento" name='nasc_dia' value='<?=$val['nasc_dia']?>' maxlength=2>
                        <input type="text" class="data_nascimento_mes nascimento" name='nasc_mes' value='<?=$val['nasc_mes']?>' maxlength=2>
                        <input type="text" class="data_nascimento_ano nascimento" name='nasc_ano' value='<?=$val['nasc_ano']?>' maxlength=4>
                        <div class="erro invisible errorNascimento">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_email">E-mail:</strong>
                        <input type="text" class="email required" name='email' id='email' value='<?=$val['email']?>'>
                        <div class="erro invisible errorEmail">Campo obrigatório, preencha um email válido</div>
                    </li>

                    <li>
                        <strong id="titulo_email2">Confirme seu E-mail:</strong>
                        <input type="text" class="email2 required" name='confirmaEmail' id='confirmaEmail' value='<?=$val['confirmaEmail']?>'>
                        <div class="erro invisible errorConfirmaEmail">Confirme seu E-mail está diferente do campo E-mail</div>
                    </li>
                </ul>
            </div>

            <div id="dados_pessoais_dir">
                <ul>
                    <li>
                        <strong id="titulo_endereco">Endereço:</strong>
                        <input type="text" class="endereco required" name='endereco' id='endereco' value='<?=$val['endereco']?>'>
                        <div class="erro invisible errorEndereco">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_complemento">Complemento:</strong>
                        <input type="text" class="numero" name='numero' id='numero' value='<?=$val['numero']?>'>
                        <input type="text" class="complemento" name='complemento' id='complemento' value='<?=$val['complemento']?>'>
                        <div class="erro invisible">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_cep">CEP:</strong>
                        <input type="text" class="cep1 cep" name='cep1' id='cep1' value='<?=$val['cep1']?>' maxlength=5>
                        <input type="text" class="cep2 cep" name='cep2' id='cep2' value='<?=$val['cep2']?>' maxlength=3>

                        <div id="nao_sei_cep"><a href="http://www.buscacep.correios.com.br/" target="_blank">Não sei CEP</a></div>

                        <select id='estado' name="estado">
                            <option value="">Selecione</option>
                            <option value="AC"<?=$val['estado']=='AC' ? ' selected' : null?>>Acre</option>
                            <option value="AL"<?=$val['estado']=='AL' ? ' selected' : null?>>Alagoas</option>
                            <option value="AM"<?=$val['estado']=='AM' ? ' selected' : null?>>Amazonas</option>
                            <option value="AP"<?=$val['estado']=='AP' ? ' selected' : null?>>Amapá</option>
                            <option value="BA"<?=$val['estado']=='BA' ? ' selected' : null?>>Bahia</option>
                            <option value="CE"<?=$val['estado']=='CE' ? ' selected' : null?>>Ceará</option>
                            <option value="DF"<?=$val['estado']=='DF' ? ' selected' : null?>>Distrito Federal</option>
                            <option value="ES"<?=$val['estado']=='ES' ? ' selected' : null?>>Espirito Santo</option>
                            <option value="GO"<?=$val['estado']=='GO' ? ' selected' : null?>>Goiás</option>
                            <option value="MA"<?=$val['estado']=='MA' ? ' selected' : null?>>Maranhão</option>
                            <option value="MG"<?=$val['estado']=='MG' ? ' selected' : null?>>Minas Gerais</option>
                            <option value="MS"<?=$val['estado']=='MS' ? ' selected' : null?>>Mato Grosso do Sul</option>
                            <option value="MT"<?=$val['estado']=='MT' ? ' selected' : null?>>Mato Grosso</option>
                            <option value="PA"<?=$val['estado']=='PA' ? ' selected' : null?>>Pará</option>
                            <option value="PB"<?=$val['estado']=='PB' ? ' selected' : null?>>Paraíba</option>
                            <option value="PE"<?=$val['estado']=='PE' ? ' selected' : null?>>Pernambuco</option>
                            <option value="PI"<?=$val['estado']=='PI' ? ' selected' : null?>>Piauí</option>
                            <option value="PR"<?=$val['estado']=='PR' ? ' selected' : null?>>Paraná</option>
                            <option value="RJ"<?=$val['estado']=='RJ' ? ' selected' : null?>>Rio de Janeiro</option>
                            <option value="RN"<?=$val['estado']=='RN' ? ' selected' : null?>>Rio Grande do Norte</option>
                            <option value="RO"<?=$val['estado']=='RO' ? ' selected' : null?>>Rondônia</option>
                            <option value="RR"<?=$val['estado']=='RR' ? ' selected' : null?>>Roraima</option>
                            <option value="RS"<?=$val['estado']=='RS' ? ' selected' : null?>>Rio Grande do Sul</option>
                            <option value="SC"<?=$val['estado']=='SC' ? ' selected' : null?>>Santa Catarina</option>
                            <option value="SE"<?=$val['estado']=='SE' ? ' selected' : null?>>Sergipe</option>
                            <option value="SP"<?=$val['estado']=='SP' ? ' selected' : null?>>São Paulo</option>
                            <option value="TO"<?=$val['estado']=='TO' ? ' selected' : null?>>Tocantins</option>
                        </select>
                        <div class="erro invisible errorEstado">Selecione um estado</div>
                    </li>

                    <li>
                        <strong id="titulo_cidade">Cidade:</strong>
                        <input type="text" class="cidade" name='cidade' id='cidade' value='<?=$val['cidade']?>'>
                        <div class="erro invisible errorCidade">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_senha">Senha:</strong>
                        <input type="password" class="senha required" name='senha' id='senha' value='<?=$val['senha']?>'>
                        <div class="erro invisible errorSenha">Campo obrigatório, mínimo 6 caracteres</div>
                    </li>

                    <li>
                        <strong id="titulo_senha2">Confirme sua Senha:</strong>
                        <input type="password" class="senha2 required" name='confirmaSenha' id='confirmaSenha' value='<?=$val['confirmaSenha']?>'>
                        <div class="erro invisible errorConfirmaSenha">Esse campo deve ser idêntico ao campo Senha</div>
                    </li>
                </ul>
            </div>
        </section>


        <section class="box">
        	<ul id="check_holder">
            	<li>
                    <input type="checkbox" name='newsletter' class='check' value='1'<?=isset($val['newsletter'])  && $val['newsletter']==1 ? ' checked' : null?>>
                    <div id="check_label1">Quero receber e-mail com informações e promoções da STi e SEMP TOSHIBA.</div>
                </li>

                <li>
                    <input type="checkbox" disabled=disabled name='aceito' class='check' value='1' checked>
                    <div id="check_label2"><a href="<?=ABSPATH?>regulamento" target='_blank'>Aceito os termos do regulamento desta promoção.</a></div>
                </li>
            </ul>
        </section>

        <div id="btn_cancelar"><a href="<?=ABSPATH?>meus-numeros">Cancelar</a></div>
        <div id="btn_salvar"><a href="#">Salvar</a></div>
    </form>

    </article>
    <!-- *** END CONTENT *** -->