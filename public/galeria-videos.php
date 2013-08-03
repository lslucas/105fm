                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/banner-videos.jpg" width="968" height="385" alt="Vídeos da 105 FM" title="Vídeos da 105 FM" />
                                    <div class="SlideDescription">Vídeos da 105 FM</div>
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

                        <div id="videos" class="box">
                        	<h1 class="uppercase navy" style="margin-left:10px;">Galeria de Vídeos</h1>
                        	<ul class="clearfix">
                                <?php
                                    $total = count($videos)-1;
                                    $page=0;
                                    $i=0;
                                    foreach ($videos as $page=>$vid) {
                                        $urlvideo = preg_replace('/watch\?v\=/', 'embed/', $vid['youtube']);
                                        $urlvideo = $urlvideo."?autoplay=1&wmode=transparent";

                                        $class = $i%2 ? ' esq' : ' dir';
                                ?>
                                <li class="vdo<?=$class?>">
                                    <a href="<?=$urlvideo?>" class="fancybox.iframe fancybox-video f_left" rel="videos" title="<h4><?=preg_replace('/"/', "'", $vid['titulo'])?></h4>"><img src="<?=$vid['imagem']?>" alt="<?=$vid['titulo']?>" height=149 /></a>
                                    <div class="video-info f_left">
                                        <h5><?=$vid['titulo']?></h5>
                                        <p class="data"><?=$vid['data']?></p>
                                    </div>
                                </li>
                                <?php
                                    }
                                ?>
                           	</ul>
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
                    <script type='text/javascript'>
                    $(function() {
                        $(".fancybox-video").fancybox({
                            prevEffect  : 'none',
                            nextEffect  : 'none',
                            maxWidth    : 800,
                            maxHeight   : 600,
                            fitToView   : false,
                            autosize    : true,
                            helpers : {
                                title   : {
                                    type: 'inside'
                                },
                                overlay : {
                                    opacity : 0.8,
                                    css : {
                                        'background-color' : '#000'
                                    }
                                }
                            }
                        });
                    });
                    </script>