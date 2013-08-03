                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <?php /* ?>
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/noticias.jpg" width="968" height="385" alt="Notícias da 105 FM" title="Notícias da 105 FM" />
                                    <div class="SlideDescription">Notícias da 105 FM</div>

                                    <img src="<?=ABSPATH?>img/banners/noticias.jpg" width="968" height="385" alt="Notícias da 105 FM" title="Notícias da 105 FM" />
                                    <div class="SlideDescription">Notícias da 105 FM</div>

                                    <img src="<?=ABSPATH?>img/banners/noticias.jpg" width="968" height="385" alt="Notícias da 105 FM" title="Notícias da 105 FM" />
                                    <div class="SlideDescription">Notícias da 105 FM</div>

                                    <img src="<?=ABSPATH?>img/banners/noticias.jpg" width="968" height="385" alt="Notícias da 105 FM" title="Notícias da 105 FM" />
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
                                            loading: {background: '#ffffff', opacity: 0.5, image: '<?=ABSPATH?>img/loading.gif'},
                                            buttons: {hide: true, opacity: 1, prev: {className: 'RadioPrev', label: ''}, next: {className: 'RadioNext', label: ''}},
                                            description: {hide: true, background: '#000000', opacity: 0.4, height: 50, position: 'bottom'},
                                            navigation: {container: 'RadioNav', label: '<img src="<?=ABSPATH?>img/clear.gif" />'}
                                        }
                                    });
                                    //-->
                                </script>

                                <div class="c"></div>
                            </div>
                            <!--End Banner-->
                           */ ?>
                            <div class="clear"></div>
                        </div>
                        <!--End Banner Wrapper-->
                        <div class="clear"></div>

                        <div id="noticia-teste" class="box noticia">
                        	<h1 class="uppercase green" style="margin-left:10px;"><?=$titulo?> <span class="data"><?=$data?></span></h1>
                            <div class="conteudo-noticia">
                                <p><?=$texto?></p>
                            </div>
                            <div class="galeria-noticia">
                            	<div class="img-noticia">
                                	<img src="<?=$imagem?>" alt="<?=$titulo?>" />
                                </div>
                                <ul class="util">
                                	<li class="print"><a href="javascript:document.print();" title="Imprima esta notícia" onclick="window.print();">Imprimir</a></li>
                                    <!-- <li class="send"><a href="enviar.html" title="Envie para um amigo" class="fancy">Enviar para um amigo</a></li> -->
                                    <li class="share"><a href="http://www.facebook.com/sharer.php?u='+ document.location.href + '&t='+ document.title;+'" target="blank">Compartilhe</a></li>
                                    <?php /* ?>
                                    <li class="prev"><a href="<?=$prev['link']?>" title="Notícia Anterior">Anterior</a></li>
                                    <li class="next"><a href="<?=$next['link']?>" title="Próxima Notícia">Próxima</a></li>
                                    php */ ?>
                                </ul>
                            </div>
                            <div class="clear"></div>
                            <br />

                            <div class="hr"></div>
                            <br />

                            <div id="pager" class="paginationstyle" style="width: 300px; margin:15px auto; display:none;">
                                <a class="prev" href="#" rel="previous">Anterior</a> <span class="flatview"></span> <a class="next" href="#" rel="next">Pr&oacute;ximo</a>
                            </div>
                            <div class="clear"></div>

                        </div>
		                <div class="clear"></div>

                    </div>
                    <!--End Centro-->