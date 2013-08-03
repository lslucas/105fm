                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>images/programacao.jpg" width="968" height="385" alt="Programação da 105 FM" title="Programação da 105 FM" />
                                    <div class="SlideDescription">Programação da 105 FM</div>
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
                                            loading: {background: '#ffffff', opacity: 0.5, image: '<?=ABSPATH?>img/loading.gif'},
                                            buttons: {hide: true, opacity: 1, prev: {className: 'RadioPrev', label: ''}, next: {className: 'RadioNext', label: ''}},
                                            // description: {hide: true, background: '#000000', opacity: 0.4, height: 50, position: 'bottom'},
                                            navigation: {container: 'RadioNav', label: '<img src="<?=ABSPATH?>img/clear.gif" />'}
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

                        <div id="left-menu" class="clearfix box">
                            <div class="title white" align="center">
                                <h5 class="uppercase white">Programação</h5>
                                <p class="white">Clique para ver a programação</p>
                                <span></span>
                            </div>
                            <ul>
                                <li><a href="<?=ABSPATH?>programacao/domingo" title="Domingo na 105 FM">Domingo</a></li>
                                <li><a href="<?=ABSPATH?>programacao/segunda" title="Segunda na 105 FM">Segunda</a></li>
                                <li><a href="<?=ABSPATH?>programacao/terca" title="Terça na 105 FM">Terça</a></li>
                                <li><a href="<?=ABSPATH?>programacao/quarta" title="Quarta na 105 FM">Quarta</a></li>
                                <li><a href="<?=ABSPATH?>programacao/quinta" title="Quinta na 105 FM">Quinta</a></li>
                                <li><a href="<?=ABSPATH?>programacao/sexta" title="Sexta na 105 FM">Sexta</a></li>
                                <li><a href="<?=ABSPATH?>programacao/sabado" title="Sábado na 105 FM">Sábado</a></li>
                            </ul>
                            <div id="menu-msg" align="center">
                                <p class="bold">ATENÇÃO</p>
                                <p style="font-size:10px !important;">Os horários dos programas poderão<br />
                                ser alterados conforme os<br />
                                horários do futebol.<br />
                                </p>
                                <p style="font-size:10px !important;"><a href="<?=ABSPATH?>105-futebol-clube" title="Programação do Futebol">Veja a grade da programação de futebol.</a></p>
                            </div>
                        </div>

                        <div id="progs" class="box">
                            <h5 class="uppercase">Programação</h5>
                            <ul>
                                <?php foreach ($geralProgramas as $int=>$prog) { ?>
                                <li class="prog <?=$int?>">
                                    <h5><?=$prog['titulo']?></h5>
                                    <div class="clear"></div>
                                    <p><?=$prog['texto']?></p>
                                    <br />
                                    <p><span class="apres">Apresentação: <?=$prog['apresentacao']?></span></p>
                                    <!-- <a class="more" href="105-futebol-clube.html" title="105 FM Futebol Club"></a> -->
                                </li>
                                <?php } ?>
                            </ul>

                        </div>
                        <div class="clear"></div>
                    </div>
                    <!--End Centro-->
