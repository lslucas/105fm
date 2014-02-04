<?php

?>

                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/contato.jpg" width="968" height="385" alt="Fale com a 105 FM" title="Fale com a 105 FM" />
                                    <div class="SlideDescription">Fale com a 105 FM</div>
                                </div>
                                <div class="c"></div>
                                <div id="RadioNav"></div>
                                <div class="c"></div>

                                <script type="text/javascript">
                                    <!--
                                    efeitos = 'rain,stairs,fade';
                                    var demoSlider_2 = Sliderman.slider({container: 'RadioBanner', width: 968, height: 385, effects: efeitos,
                                        display: {
                                            autoplay: 7000,
                                            loading: {background: '#ffffff', opacity: 0.5, image: 'img/loading.gif'},
                                            buttons: {hide: true, opacity: 1, prev: {className: 'RadioPrev', label: ''}, next: {className: 'RadioNext', label: ''}},
                                            // description: {hide: true, background: '#000000', opacity: 0.4, height: 50, position: 'bottom'},
                                            navigation: {container: 'RadioNav', label: '<img src="img/clear.gif" />'}
                                        }
                                    });
                                    //-->
                                </script>

                                <div class="c"></div>
                            </div>
                            <!--End Banner-->
                            <div class="clear"></div>
                        </div>
                        <!--End Banner Wrapper-->
                        <div class="clear"></div>

                        <div id="centro" class="box clearfix">
                            <br />
                        	<h1 class="uppercase" style="margin-left:30px;">Contato</h1>
                            <p style="font-size:14px; padding-left:30px;">Fale com a 105FM.</p>

                            <div class="form f_left">
                                <p>Preencha os campos a seguir, e logo retornaremos o seu contato.</p>
                                <br /><br />
                                <form name="radioform" method="post" action="<?=ABSPATH.$basename?>" accept-charset="UTF-8">
                                	   <input type='hidden' name='from' value='fale-conosco'/>
                                    <p class="text name">
                                        <label for="nome">Nome:</label>
                                        <input name="nome" type="text" id="nome" value="" />
                                    </p>
                                    <p class="text email">
                                        <label for="email">E-Mail:</label>
                                        <input name="email" type="email" id="email" value="" />
                                    </p>
                                      <p class="text email">
                                        <label for="cpf">CPF:</label>
                                        <input name="cpf" type="cpf" id="email" value="" />
                                    </p>
                                    <p class="text email">
                                        <label for="rg">RG:</label>
                                        <input name="rg" type="rg" id="email" value="" />
                                    </p>
                                     <p class="text email">
                                        <label for="bairro">Bairro:</label>
                                        <input name="bairro" type="bairro" id="email" value="" />
                                    </p>
                                    <p class="text cidade">
                                	<span>
                                            <label for="cidade">Cidade:</label>
                                            <input name="cidade" type="text" id="cidade" value="" />
                                        </span>
                                    	<span class="uf">
                                            <label for="estado">Estado:</label>
                                            <input name="estado" type="text" id="estado" value="" />
                                        </span>
                                    </p>

                                    <p class="text assunto">
                                        <label for="assunto">Assunto:</label>
                                                <!-- <option value="programacao">Programação musical</option> -->
                                        <select name="assunto" id="assunto" style='width:290px; margin-bottom:10px'>
                                            <option value="">Escolha um assunto</option>
                                            <optgroup label="Fale com a rádio">
                                                <option value="promocoes">Promoções</option>
                                                <option value="site">Site da rádio</option>
                                                <option value="suporte">Suporte</option>
                                                <option value="comercial">Comercial</option>
                                            </optgroup>
                                            <optgroup label="Programas">
                                                <option value="arquivo-samba">Arquivo do Samba</option>
                                                <option value="balanco-rap">Balanço Rap</option>
                                                <option value="black-105">Black 105</option>
                                                <option value="bom-dia-com-fe">Bom Dia com Fé</option>
                                                <option value="charmin-love">Charmin Love</option>
                                                <option value="conexao-105-com-sandra-groth">Conexão 105 com Sandra Groth</option>
                                                <option value="encontro-das-tribos">Encontro das Tribos</option>
                                                <option value="espaco-rap">Espaço Rap</option>
                                                <option value="festa-da-105">Festa da 105</option>
                                                <option value="festa-dj-hum">Festa DJ Hum</option>
                                                <option value="portal-105fm">Portal da 105 FM</option>
                                                <option value="rap-du-bom">Rap du Bom</option>
                                                <option value="rede-nacional-do-samba">Rede Nacional do Samba</option>
                                                <option value="selecao-ouvinte-com-giuliano-faccio">Seleção do Ouvinte com Giuliano Faccio</option>
                                                <option value="selecao-ouvinte-com-fabiano-olivato">Seleção do Ouvinte com Fabiano Olivato</option>
                                                <option value="selecao-ouvinte-com-mauricio-oliveira">Seleção do Ouvinte com Maurício Oliveira</option>
                                                <option value="selecao-ouvinte-com-sandra-groth">Seleção do Ouvinte com Sandra Groth</option>
                                                <option value="toque-direto">Toque Direto</option>
                                                <option value="ofereca-uma-musica">"Ofereça uma música" no Toque Direto - Oferecimento Musical</option>
                                                <option value="aniversario">"Coloque a data de seu aniversário" no Toque Direto - Aniversário do Dia</option>
                                                <!-- <option value="caracteristicas">"Coloque suas características" no Toque Direto - Ponto de Encontro</option> -->
                                                <option value="recados-imediatos">Recados Imediatos</option>
                                                <option value="festa-conexao">Festa Conexão</option>
                                            </optgroup>
                                          </select>
                                    </p>
                                    <p class="text telefone">
                                        <label for="telefone">Telefone:</label>
                                    	<span class="ddd">
                                            <input name="ddd" type="text" id="ddd" value="" maxlength="3" width="10" />
                                        </span>
                                        <input name="telefone" type="text" id="telefone" value="" maxlength="14" />
                                    </p>
                                    <br />
                                    <p class="text textarea">
                                        <label for="mensagem">Mensagem:</label>
                                        <textarea name="mensagem" id="mensagem" rows="7" cols="7"></textarea>
                                    </p>
                                    <p class="obg f_left">
                                        <!--<span>* Campos Obrigatórios</span>-->
                                    </p>
                                    <p class="submit f_right">
                                        <input type="submit" name="Submit" value="Enviar" />
                                    </p>
                                </form>
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />
                                <br />

                            </div>
                            <div id="infos">
	<p class="loguinho"><img src="img/logo-mini.png" alt="Rádio 105 FM" /></p>
								<h5 class="uppercase">RÁDIO 105FM - 105.1<br /><span>SÃO PAULO</span></h5>
                                <h5 class="fone uppercase"> (11) 3819-3541</h5>
                                <p>
	Av. Carlos Salles Block, 658.<br />
                                    4º andar - Anhangabaú.<br />
                                    Jundiaí - SP<br />
                                    CEP: 13208-100<br />
                                </p>
                                <p>
                                    Comercial: <a href="mailto:comercial@radio105fm.com.br" title="Contato">comercial@radio105fm.com.br</a>
                                    <br /><br />
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--End Centro-->