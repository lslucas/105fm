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
                                            description: {hide: true, background: '#000000', opacity: 0.4, height: 50, position: 'bottom'},
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
                                    <p class="text sobrenome">
                                        <label for="sobrenome">Sobrenome:</label>
                                        <input name="sobrenome" type="text" id="sobrenome" value="" />
                                    </p>
                                    <p class="text email">
                                        <label for="email">E-Mail:</label>
                                        <input name="email" type="email" id="email" value="" />
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
                                        <input name="assunto" type="text" id="assunto" value="" />
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
                                <h5 class="fone uppercase">(11) 3171-0075</h5>
                                <p>
                                	Av. Carlos Salles Block, 658.<br />
                                    4º andar - Anhangabaú.<br />
                                    Jundiaí - SP<br />
                                    CEP: 13208-100<br />
                                </p>
                                <p>
                                    <a href="mailto:contato@radio105fm.com.br" title="Contato">contato@radio105fm.com.br</a>
                                    <br /><br />
                                </p>
                            </div>
                        </div>
                    </div>
                    <!--End Centro-->