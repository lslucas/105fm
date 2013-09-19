                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/galeria.jpg" width="968" height="385" alt="Fotos da 105 FM" title="Fotos da 105 FM" />
                                    <div class="SlideDescription">Fotos da 105 FM</div>
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

                        <div id="fotos" class="box">
                        	<h1 class="uppercase purple" style="margin-left:10px;">Galeria de Fotos</h1>
                                <?php
                                    $total = count($fotos)-1;
                                    $page=0;
                                    $i=0;
                                    foreach ($fotos as $page=>$gal) {
                                ?>
                                <ul class="pic clearfix">
                                    <?php
                                        foreach ($gal as $int=>$foto) {
                                    ?>
                                    <li <?php if ($int==3) echo "class='last'"; ?>>
                                            <p class="data"><?=$foto['data']?></p>
                                            <center>
                                    	<a id='galeria<?=$foto['foto_id']?>' href="javascript:;">
                                                <img src="<?=$foto['capa']?>" alt="<?=$foto['legenda']?>"/>
                                            </a>
                                        </center>
                                            <p align="center"><?=$foto['titulo']?></p>
                                    </li>
                                    <?php if (isset($galeria[$foto['foto_id']])) { ?>
                                     <script type='text/javascript'>
                                        $("#galeria<?=$foto['foto_id']?>").click(function() {
                                            $.fancybox([
                                                <?php foreach ($galeria[$foto['foto_id']] as $int=>$gl) { ?>
                                                {
                                                    'href' : '<?=$gl['imagem']?>',
                                                    'title' : '<?=$gl['legenda']?>'
                                                }
                                                <?php
                                                    if (count($galeria[$foto['foto_id']])>1 && ($int+1)<count($galeria[$foto['foto_id']]))
                                                        echo ',';
                                                    }
                                                ?>
                                            ], {'type' : 'image'}
                                            );
                                        });
                                    </script>
                                    <?php
                                            }
                                        }
                                    ?>
                                </ul>
                                <?php
                                    }
                                ?>

                            <div class="clear"></div>
                            <br />

                            <div class="hr"></div>
                            <br />

                            <div class="clear"></div>
                            <div id="pager" class="paginationstyle" style="width: 300px; margin:15px auto;">
                                <a class="prev" href="#" rel="previous">Anterior</a> <span class="flatview"></span> <a class="next" href="#" rel="next">Pr&oacute;ximo</a>
                            </div>

                            <div class="clear"></div>
                        </div>
		                <div class="clear"></div>

                    </div>
                    <!--End Centro-->