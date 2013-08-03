                    <!--Colunas-->
                    <div id="centro" class="clearfix">

                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>images/destaque/noticias.jpg" width="968" height="385" alt="Promoções da 105 FM" title="Promoções da 105 FM" />
                                    <div class="SlideDescription">Notícias da 105 FM</div>
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

                        <div id="noticia-teste" class="box noticia">
                            <h1 class="uppercase green" style="margin-left:10px;">Notícias</h1>
                            <div class="conteudo-noticia">
                                <ul class='unstyled'>
                                    <?php foreach ($list as $id=>$not) { ?>
                                    <li><a href='<?=$not['link']?>'><?=$not['titulo']?></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
		  <div class="clear"></div>
                    </div>
                    <!--End Centro-->