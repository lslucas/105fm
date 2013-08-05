                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/banner-concurso-cultural.jpg" width="968" height="385" alt="Promoções da 105 FM" title="Promoções da 105 FM" />
                                    <div class="SlideDescription">Promoções da 105 FM</div>
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

                        <div id="promos" class="box">
                        	<h1 class="uppercase navy" style="margin-left:10px;">Promoções</h1>
                      	<ul id="lista-eventos">
                                <?php
                                    foreach ($promocoes as $int=>$promo) {
                                ?>
                                <li class="agend">
                                    <div class="f_left clearfix">
                                        <a href="<?=$promo['imagem']?>" class="fancy" rel="evento" title="<?=$promo['legenda']?>"><img src="<?=$promo['thumb']?>" alt="<?=$promo['legenda']?>" /></a>
                                        <p><a href="<?=$promo['imagem']?>" class="fancy" rel="evento" title="<?=$promo['legenda']?>">Clique para ampliar o flyer</a>
                                    </div>
                                    <div class="dados-promo">
                                        <span class="item uppercase red"><?=$promo['titulo']?></span>
                                        <h5 class="black"><?=$promo['linhafina']?>
                                            <span>
                                            <?php if ($promo['participar'] && empty($promo['ganhadores'])) { ?>
                                                |   <a href='<?=ABSPATH?>participacao/<?=$promo['id']?>/<?=linkfy($promo['titulo'])?>' style='color: red;'>Participar</a>
                                            <?php } ?>
                                            <?php if (!empty($promo['ganhadores'])) { ?>|   <a href="#ganhadores<?=$int?>" class='inlinemodal' title="Veja os ganhadores">Veja os ganhadores</a><?php } ?>
                                        </span>
                                        </h5>
                                        <div class='ganhadores hide' id='ganhadores<?=$int?>'>
                                            <h3>Ganhadores da Promoção <?=$promo['titulo']?></h3>
                                            <div style='float:right'><a href="javascript:;" onclick="$.fancybox.close();">Fechar</a></div>
                                            <p><?=$promo['ganhadores']?></p>
                                        </div>
                                        <!-- <span class="data"><?=$promo['data']?></span> -->
                                        <br />
                                        <p><?=$promo['descricao']?></p>
                                        <br />

                                    </div>
                                </li>
                                <?php
                                    }
                                ?>
                           	</ul>
                            <div id="pager" class="paginationstyle" style="width: 300px; margin:15px auto;">
                                <a class="prev" href="#" rel="previous">Anterior</a> <span class="flatview"></span> <a class="next" href="#" rel="next">Pr&oacute;ximo</a>
                            </div>

                            <div class="clear"></div>
                        </div>
		                <div class="clear"></div>

                    </div>
                    <!--End Centro-->
