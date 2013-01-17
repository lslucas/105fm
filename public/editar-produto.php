    <!-- *** CONTENT *** -->
    <article>
    	<h2 id="titulo_pagina">CONFIRA SE OS SEUS DADOS ESTÃO CORRETOS. ALTERE SE NECESSÁRIO.</h2>

        <section class="box">
     <form method='post' name='editar-produto'>
        <input type='hidden' name='token' value='<?=md5($_SERVER['REMOTE_ADDR'].time())?>'/>
        <input type='hidden' name='from' value='<?=$basename?>'/>
        <input type='hidden' name='id' value='<?=$val['id']?>'/>
            <div id="dados_nota">
                <ul>
                    <li>
                        <strong id="titulo_cupom">Número do Cupom Fiscal</strong>
                        <input type="text" class="required cupom " name='coo' id='coo' value='<?=$val['coo']?>'>
                        <div class="erro invisible errorCoo">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_cnpj">CNPJ do Estabelecimento</strong>
                        <input type="text" class="cnpj required" name='cnpj' id='cnpj' value='<?=$val['cnpj']?>'>
                        <div class="erro invisible errorCnpj">Campo obrigatório. Informe um CNPJ válido</div>
                    </li>

                    <li>
                        <strong id="titulo_nome_estabelecimento">Nome do Estabelecimento</strong>
                        <input type="text" class="nome_estabelecimento required" name='estabelecimento' id='estabelecimento' value='<?=$val['estabelecimento']?>'>
                        <div class="erro invisible errorEstabelecimento">Campo obrigatório</div>
                    </li>

                    <li>
                        <strong id="titulo_data_compra">Data da Compra</strong>
                        <input type="text" class="data_compra_dia" placeholder='DD' name='compra_dia' value='<?=$val['compra_dia']?>' maxlength=2>
                        <input type="text" class="data_compra_mes" placeholder='MM' name='compra_mes' value='<?=$val['compra_mes']?>' maxlength=2>
                        <input type="text" class="data_compra_ano" placeholder='AAAA' name='compra_ano' value='<?=$val['compra_ano']?>' maxlength=4>
                        <div id="info">*Válido para compras realizadas<br />de 21/11/2012 a 23/12/2012</div>
                        <div class="erro invisible errorDataCompra">Campo obrigatório. Válido para compras realizadas de 21/11/2012 a 23/12/2012</div>
                    </li>

                    <li>
                        <strong id="titulo_produto_comprado">Produto Comprado</strong>
                        <select name='produto_cat' id='produto_cat' class='categoria'/>
                            <option value=''>Selecione a Categoria</option>
                            <?=makeOptionProductCat($val['produto_cat'])?>
                        </select>
                        <?=makeSelectProducts($val['produto'])?>
                        <div class="erro invisible errorProduto">Campo obrigatório</div>
                    </li>

                    <li>
                    	<div id="btn_salvar"><a href="#">Salvar alterações</a></div>
                        <div id="btn_cancelar"><a href="<?=ABSPATH?>meus-numeros">Cancelar</a></div>
                    </li>
                </ul>
            </div>
        </form>

            <div id="nf">
            	<h3>Veja como localizar o número do seu cupom fiscal nos exemplos abaixo:</h3>

                <div class="separador"></div>

                <div id="nf_holder">
                    <ul id="nf_img">
                        <li><img src="<?=ABSPATH?>image/content/participar/nf1.png" border="0" /></li>
                        <li><img src="<?=ABSPATH?>image/content/participar/nf2.png" border="0" /></li>
                        <li><img src="<?=ABSPATH?>image/content/participar/nf3.png" border="0" /></li>
                    </ul>
                </div>

                <div id="nf_titulo">Confira os exemplos de cupons abaixo.</div>

                <ul id="paginacao">
                	<li class="one"></li>
                    <li class="two"></li>
                    <li class="three"></li>
                </ul>

                <div class="separador"></div>

                <div id="btn_duvida"><a href="<?=ABSPATH?>como-funciona">Dúvidas? Clique aqui</a></div>
            </div>
        </section>

        <p id="obs">* O número da sorte é gerado com base no número de um único cupom fiscal cadastrado. Portanto, se o cliente tiver adquirido mais de um produto STi em uma mesma compra ele terá direito a apenas um número da sorte. Já, se cada produto for lançado em cupons fiscais diferentes, cada um deles poderá ser cadastrado e gerar mais números da sorte.</p>

    </article>
    <!-- *** END CONTENT *** -->