                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div class="SliderName_2_left">
                                    <a href="<?=$equipePrev['link']?>" id="sliderPrevBtn">&nbsp;</a>
                                </div>
                                 <div class="SliderName_2_right">
                                    <a href="<?=$equipeNext['link']?>" id="sliderNextBtn">&nbsp;</a>
                                </div>
                                <div id="RadioBanner" class="">
                                    <img src="<?=$equipe['imagem']?>" width="968" height="385" alt="105 FM" title="105 FM" />
                                    <div class="SlideDescription"><?=$equipe['titulo']?></div>
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

                                       // next button click
                                        $("#sliderNextBtn").click(function() {
                                          demoSlider_2.next();
                                        });

                                        // previous button click
                                        $("#sliderPrevBtn").click(function() {
                                          demoSlider_2.prev();
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

                        <div id="rap" class="clearfix box">
                            <h2 class="uppercase"><?=$equipe['titulo']?></h2>
                            <p><?=$equipe['texto']?></p>
                            <br />
                            <br />

<!--                             <div id="banner-h" class="clearfix" align="center">
                                <a href="link.html" title="Publicidade Horizontal" target="_blank"><img src="<?=ABSPATH?>img/banner-horizontal.jpg" width="680" height="80" /></a>
                            </div> -->
                            <br />
			                <div class="clear"></div>

                        </div>

                        <div id="right-col">
                            <div id="programa" class="box">
                                <h2 class="uppercase">Programa</h2>
                                <p>Programa: <?=$equipe['programa']?></p>
                            </div>
                            <div class="clear"></div>
<!--                             <div id="banner-v" class="clearfix">
                                <a href="link.html" title="Publicidade Vertical" target="_blank"><img src="<?=ABSPATH?>img/banner-vertical.jpg" width="220" height="405" /></a>
                            </div> -->
                        </div>
                    </div>
                    <!--End Centro-->