                    <!-- <a id="popup" class='hide fancybox' href="<?=ABSPATH?>img/popup/comunicado2.jpg">Pop-Up</a> -->
                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <?php
                                        foreach ($destaque as $int=>$dest) {
                                            if (!empty($dest['link']))
                                                echo "<a href='{$dest['link']}'>";
                                    ?>
                                    <img src="<?=$dest['imagem']?>" width="968" height="385" alt="Banner Teste" title="Banner Teste" />
                                    <?php if (!empty($dest['link'])) echo "</a>"; ?>
                                    <div class="SlideDescription"><?=$dest['link']?></div>
                                    <?php } /*?>
                                    <img src="img/banners/banner-teste.jpg" width="968" height="385" alt="Banner Teste" title="Banner Teste" />
                                    <div class="SlideDescription">Rádio 105 FM</div>
                                    <?php */ ?>
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

                        <h4 align="center" class="uppercase dest">Destaques</h4>
                        <div id="destaques" class="clearfix box">
                            <ul class="sub">
                                <?php
                                    foreach ($noticias as $id => $not) {
                                       $class = $int==0 ? 'first' : null;

                                       if (isset($not['id'])) {
                                ?>
                                <li class="<?=$class?>">
                                    <a class="img" href="<?=$not['link']?>" title="<?=$not['titulo']?>">
                                        <div style='background: #fff url(<?=$not['imagem']?>) top left; width:227px; height:121px; overflow:hidden)' alt="<?=$not['titulo']?>"></div>
                                        <!-- <img src="<?=$not['imagem']?>" alt="<?=$not['titulo']?>" width="227" height="121" /> -->
                                    </a>
                                    <h5><a class="uppercase navy" href="<?=$not['link']?>" title="<?=$not['titulo']?>"><?=$not['titulo']?></a> <span class="data"><?=$not['data']?></span></h5>
                                    <p><a class="uppercase" href="<?=$not['link']?>" title="<?=$not['titulo']?>"><?=$not['resumo']?></a></p>
                                </li>
                                <?php
                                        $int++;
                                        }
                                    }
                                ?>
                            </ul>
                        </div>
                        <div id="boxes" class="clearfix">

                            <div id="varios" class="f_right">
                                <div id="videos" class="box boxVideos" style='overflow:hidden;'>
                                    <h2 class="uppercase navy">Vídeos</h2>
                                    <ul>
                                         <?php
                                             $i=0;
                                            foreach ($videos as $int=>$vid) {
                                                $urlvideo = preg_replace('/watch\?v\=/', 'embed/', $vid['youtube']);
                                                $urlvideo = $urlvideo."?autoplay=1&wmode=transparent";

                                                if (!empty($pergunta) && $i==3)
                                                    break;
                                        ?>
                                        <li class="clearfix">
                                            <a class="fancybox.iframe fancybox-video" href="<?=$urlvideo?>"><img src="<?=$vid[ 'imagem']?>" alt="<?=$vid['titulo']?>" width="136" height="92" /></a>
                                            <h5><a class="fancybox.iframe fancybox-video" href="<?=$urlvideo?>" title="<h4><?=preg_replace('/"/', "'", $vid['titulo'])?></h4>"><?=$vid['titulo']?></a></h5>
                                            <br />
                                            <span class="data"><?=$vid['data']?></span>
                                        </li>
                                        <?php $i++; } ?>
                                    </ul>
                                    <a class="bold uppercase navy" href="<?=ABSPATH?>galeria-videos" title="Ver todos">Ver todos</a>
                                </div>
                                <div id="pedidas" class="box boxPedidas" style='overflow:hidden;'>
                                    <h2 class="uppercase red">Mais Pedidas</h2>
                                    <ul class="mais">
                                        <?php
                                            $i=0;
                                            foreach ($musicas as $int=>$mus) {

                                                if (!empty($pergunta) && $i==5)
                                                    break;

                                        ?>
                                        <li class="clearfix">
                                            <img src="<?=$mus['artista_imagem']?>" alt="<?=$mus['titulo']?>" width="60" height="60" />
                                            <div>
                                                <p class="music"><?=$mus['titulo']?> <br /><span class="autor"><?=$mus['artista']?></span></p>
                                                <a class="ouvir" href="<?=$mus['ouvir']?>" target='_blank' title="Ouvir Música: "><img src="img/botao-ouvir.png" alt="Ouvir" width="57" height="20" /></a>
                                            </div>
                                        </li>
                                        <?php $i++; } ?>
                                    </ul>
                                    <a class="bold uppercase red" href="<?=ABSPATH?>mais-pedidas" title="Ver todos">Ver todos</a>
                                </div>
                            </div>
                            <div id="sociais" class="box boxSociais" style='height:575px'>
                                <h2 class="uppercase green">Redes Sociais</h2>
                                <!-- <h4 class="uppercase tweet blue">Twitter</h4> -->
                                <p>
                                    <a class="twitter-timeline" data-dnt="true" href="https://twitter.com/radio105fmsp" data-widget-id="327857383722336257">Tweets by @radio105fmsp</a>
                                    <script>!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+"://platform.twitter.com/widgets.js";fjs.parentNode.insertBefore(js,fjs);}}(document,"script","twitter-wjs");</script>
                                </p>
                                <br/><h4 class="uppercase face navy">Facebook</h4>
                                <iframe src="//www.facebook.com/plugins/likebox.php?href=https%3A%2F%2Fwww.facebook.com%2Fradio105fmoficial&amp;width=296&amp;height=258&amp;show_faces=true&amp;colorscheme=light&amp;stream=false&amp;show_border=false&amp;header=false&amp;appId=496705820402963" scrolling="no" frameborder="0" style="border:none; overflow:hidden; width:296px; height:258px; margin-top:5px;" allowTransparency="true"></iframe>
                            </div>
                            <?php if (!empty($pergunta)) { ?>
                             <div id="pergunta-do-dia" class="box boxPergunta">
                                <h2 class="uppercase red">Pergunta do dia: <small>PARTICIPE DA "PERGUNTA DO DIA" NA CONEXÃO COM A SANDRINHA E FABIANO</small></h2>
                                <div>
                                    <p>
                                        <?=$pergunta?>
                                        <div id='posPergunta'></div>
                                    </p>
                                    <input type='hidden' name='id_pergunta' value='<?=$pergunta_id?>'/>
                                    <textarea name='resposta' id='resposta'></textarea>
                                    <span class="red button f_right" id='responderPerguntaDia' style='cursor:pointer;'>Enviar</a>
                                </div>
                            </div>
                            <?php } ?>
                        </div>

                        <div class="clear"></div>
                        <?php /*
                        <div id="public-h" class="clearfix">
                            <a href="link.html" title="Publicidade Horizontal" target="_blank"><img src="img/banner-horizontal.jpg" width="968" height="119" /></a>
                        </div>
                        <div class="clear"></div>
                         */ ?>

                        <div id="varios" class="f_left">
                            <div id="galeria" class="box slider boxGaleria">
                                <h2 class="uppercase purple">Galeria</h2>
                                <a class="purple button f_right" href="<?=ABSPATH?>galeria-fotos" title="Ver Todas as Galerias">Ver todas</a>
                                <ul class="clearfix">
                                    <?php foreach ($fotos as $int=>$fot) { ?>
                                    <li>
                                        <span class="data"><?=$fot['data']?></span>
                                        <a id='gal<?=$int?>' href="javascript:;">
                                            <img src="<?=$fot['capa']?>" alt="<?=$galeria[$fot['foto_id']][0]['legenda']?>" width="137" height="89" />
                                        </a>
                                        <p class="desc"><?=$fot['titulo']?></p>
                                        <script type='text/javascript'>
                                            $("#gal<?=$int?>").click(function() {
                                                $.fancybox([
                                                    <?php foreach ($galeria[$fot['foto_id']] as $int=>$gal) { ?>
                                                    {
                                                        'href'  : '<?=$gal['imagem']?>',
                                                        'title' : '<?=$gal['legenda']?>'
                                                    },
                                                    <?php } ?>
                                                ], {'type'              : 'image'}
                                                );
                                            });
                                        </script>
                                    </li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php if (!empty($enq_titulo)) { ?>
                            <div id="enquete" class="boxEnquete box clearfix">
                                <h2 class="uppercase orange">Enquete</h2>
                                <div id='pool-container'>
                                    <form name='pool' id="poll" action='<?=ABSPATH?>modules/enquete/submitHome.php' method='post'>
                                        <input type='hidden' name='enq_id' value='<?=$hashids->encrypt($enq_id)?>'/>
                                        <p class="pergunta"><?=$enq_titulo?></p>
                                        <?php if (!empty($enq_res1)) {?>
                                            <label><input name="res" type="radio" value="<?=$hashids->encrypt(1)?>" />
                                            <?=$enq_res1?></label><br/>
                                        <?php } ?>
                                        <?php if (!empty($enq_res2)) {?>
                                            <label><input name="res" type="radio" value="<?=$hashids->encrypt(2)?>" />
                                            <?=$enq_res2?></label><br/>
                                        <?php } ?>
                                         <?php if (!empty($enq_res3)) {?>
                                            <label><input name="res" type="radio" value="<?=$hashids->encrypt(3)?>" />
                                            <?=$enq_res3?></label><br/>
                                        <?php } ?>
                                         <?php if (!empty($enq_res4)) {?>
                                            <label><input name="res" type="radio" value="<?=$hashids->encrypt(4)?>" />
                                            <?=$enq_res4?></label><br/>
                                        <?php } ?>
                                         <?php if (!empty($enq_res5)) {?>
                                            <label><input name="res" type="radio" value="<?=$hashids->encrypt(5)?>" />
                                            <?=$enq_res5?></label>
                                        <?php } ?>
                                        <br/><input type="submit" class="button orange f_right" value="Votar" />
                                    </form>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                        <div id="agenda" class="box f_right boxAgenda">
                            <h2 class="uppercase blue">Agenda</h2>
                            <ul>
                                <?php foreach ($agenda as $int=>$age) { ?>
                                <li>
                                    <span class="data"><?=$age['data']?></span>
                                    <p class="programa uppercase"><?=$age['titulo']?></p>
                                    <span class="local">Local: <?=$age['local']?></span>
                                </li>
                                <?php } ?>
                                <br/><a href='<?=ABSPATH?>agenda' class='bold uppercase navy'>Ver todas</a>
                            </ul>
                        </div>
                        <div class="clear"></div>
                    </div>
                    <!--End Centro-->
                    <script type='text/javascript'>
                    $(function() {

                        var perg = $('.boxPergunta').height();
                        var soci = $('.boxSociais').height();
                        var enq = $('.boxEnquete').height();
                        var age = $('.boxAgenda').height();
                        var gal = $('.boxGaleria').height();
                        var pedi = $('.boxPedidas').height();
                        var heightPerg = perg+pedi+15;
                        var heightEnq = (gal+enq)-27;

                        if ($('.boxPergunta').height()==null)  {
                            $('.boxPedidas').height(soci+'px');
                            $('.boxVideos').height(soci+'px'); //seta altura do box sociais para ficar identico a da coluna de perguntas
                        } else
                            $('.boxSociais').height(heightPerg+'px');

                        $('.boxSociais').height(heightPerg+'px'); //seta altura do box sociais para ficar identico a da coluna de perguntas
                        $('.boxAgenda').height(heightEnq+'px'); //seta altura do box sociais para ficar identico a da coluna de perguntas

                        $('form[name="pool"]').submit(function(e) {
                            e.preventDefault();
                            var that = $(this);
                            var btnVotar = $('form[name=pool] input[type=submit]');

                            btnVotar.attr('value', 'Enviando...').attr('disabled', 'disabled');

                            $.ajax({
                                url: $(that).attr('action'),
                                type: $(that).attr('method'),
                                data: $(that).serialize(),
                                success: function(data) {
                                    $('div#pool-container').html(data);
                                    btnVotar.attr('value', 'Enviando...').removeAttr('disabled');
                                }
                            });
                        });

                        $('span#responderPerguntaDia').click(function(e) {
                            e.preventDefault();

                            console.log($(this).text());
                            /*
                            if ($(this).text()!='Enviar') {
                                $(this).text('Você já respondeu!');
                                return false;
                            }
                             */

                            var that = this;
                            $(this).text('Enviando...');

                            $.ajax({
                                url: '<?=ABSPATH?>modules/perguntaDia/header.php',
                                type: 'post',
                                data: 'resposta='+$('textarea[name="resposta"]').val()+'&id_pergunta='+$('input[name="id_pergunta"]').val(),
                                success: function(data) {
                                    $('div#posPergunta').html('<span class="red">'+data+'</span>');
                                    $(that).text('Enviado!');
                                }
                            });
                        });

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