                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/ban-agenda.jpg" width="968" height="385" alt="Agenda da 105 FM" title="Agenda da 105 FM" />
                                    <div class="SlideDescription">Agenda da 105 FM</div>
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

                        <div id="eventos" class="box">
                            <h1 class="uppercase navy" style="margin-left:10px;">Agenda</h1>
                            <ul id="lista-eventos">
                                <?php
                                    foreach ($shows as $int=>$show) {
                                ?>
                                <li class="agend">
                                    <div class="f_left clearfix">
                                        <a href="<?=$show['imagem']?>" class="fancy" rel="evento" title="<?=$show['legenda']?>"><img src="<?=$show['thumb']?>" alt="<?=$show['legenda']?>" /></a>
                                        <p><a href="<?=$show['imagem']?>" class="fancy" rel="evento" title="<?=$show['legenda']?>">Clique para ampliar o flyer</a>
                                    </div>
                                    <div class="dados-evento">
                                        <span class="data"><?=$show['data'].(!empty($show['hora_inicio']) ? ' - '. $show['hora_inicio'] : null)?></span>
                                        <h5 class="uppercase navy"><?=$show['titulo']?></h5>
                                        <?php if (!empty($show['local'])) { ?>
                                        <p class="local black">Local: <?=$show['local']?></p>
                                        <?php } ?>
                                        <br />
                                        <p><?=$show['descricao']?></p>
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