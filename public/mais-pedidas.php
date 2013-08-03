                    <!--Colunas-->
                    <div id="centro" class="clearfix">

                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/banner-as-mais-pedidas.jpg" width="968" height="385" alt="Promoções da 105 FM" title="Promoções da 105 FM" />
                                    <div class="SlideDescription">Mais Pedidas da 105 FM</div>
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
                            <h1 class="uppercase green" style="margin-left:10px;">Mais Pedidas</h1>
                            <div class="conteudo-noticia" style='width:95%'>
                                <ul class='unstyled mais-pedidas'>
                                    <?php foreach ($musicas as $id=>$mp) { ?>
                                    <li class='clearfix'>
                                        <img src="<?=$mp['artista_imagem']?>" alt="<?=$mp['titulo']?>" width="60" height="60" class='capa'/>
                                        <div>
                                            <a href='<?=$mp['link']?>' target='_blank'>
                                                <span class='music'><?=$mp['titulo']?></span>
                                                <br/><span class='autor'><?=$mp['artista']?></span>
                                            </a>
                                            <br/>
                                            <a class="ouvir" href="<?=$mp['link']?>" target='_blank' title="Ouvir Música: <?=$mp['titulo']?>">
                                                <img src="<?=ABSPATH?>img/botao-ouvir.png" alt="Ouvir" width="57" height="20" class='botaoOuvir'/>
                                            </a>
                                        </div>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <div class="clear"></div>
                        </div>
		  <div class="clear"></div>
                    </div>
                    <!--End Centro-->
                    <style type='text/css'>
                        ul.mais-pedidas li img.capa {
                            float:left;
                            display:inline-block;
                            margin-right:15px;
                        }
                        .botaoOuvir { margin-top:12px;}
                        ul.mais-pedidas {
                            width:100%;
                        }
                        ul.mais-pedidas li {
                            margin-bottom:20px;
                            width:430px;
                            float:left;
                            position: relative;
                        }
                        ul.mais-pedidas li div {
                            position: absolute;
                            display:inline-block
                        }
                        span.autor {
                            font-size: 10px;
                            font-weight: bold;
                            color: #000;
                        }
                        span.music {
                            font-size: 12px;
                            font-weight: bold;
                            text-transform: capitalize;
                        }
                    </style>