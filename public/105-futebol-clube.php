                    <!--Colunas-->
                    <div id="centro" class="clearfix">

                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>images/destaque/noticias.jpg" width="968" height="385" alt="Promoções da 105 FM" title="Promoções da 105 FM" />
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
                            <h1 class="uppercase green" style="margin-left:10px;">105 Futebol Club</h1>
                            <div class="conteudo-noticia" style='width:95%'>
                                <table border=0 width='100%' class='grade'>
                                    <thead>
                                        <tr>
                                            <th width='50px'>Data</th>
                                            <th>Times</th>
                                            <th width='100px'>Horário</th>
                                            <th width='150px'>Apresentador</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    <?php foreach ($list as $id=>$mp) { ?>
                                    <tr>
                                        <td><?=$mp['data']?></td>
                                        <td><?=$mp['times']?></td>
                                        <td><?=$mp['horario']?></td>
                                        <td><?=$mp['apresentador']?></td>
                                    </tr>
                                    <?php } ?>
                                    </tbody>
                                </table>
                            </div>
                            <div class="clear"></div>
                        </div>
		  <div class="clear"></div>
                    </div>
                    <!--End Centro-->
                    <style type='text/css'>
                        table.grade {
                            font-size:1em;
                        }
                        table.grade thead, table.grade tbody {
                            text-align: center;
                        }
                    </style>