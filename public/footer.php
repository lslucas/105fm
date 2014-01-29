                </div>
                <!--End Page-->
                <div class="clear"></div>

                <!--Barra Rodapé-->
                <div id="footer_wrapper" class="clearfix">
                    <div id="footer" align="center">
                        <div class="fone uppercase navy bold" align="center">Fone de Ouvintes: (11) 3171.0075</div>
                        <ul id="menu-inferior" class="clearfix" style='width:297px;'>
                            <li class="item"><a class="uppercase" href="<?=ABSPATH?>" title="Home">Home</a></li>
<!--                             <li class="item"><a class="uppercase" href="<?=ABSPATH?>quem-somos" title="Quem Somos">A Rádio</a></li>
                            <li class="item"><a class="uppercase" href="<?=ABSPATH?>equipe" title="Nossa Equipe">Equipe</a></li> -->
                            <li class="item"><a class="uppercase" href="<?=ABSPATH?>programacao" title="Nossos Programas">Programação</a></li>
<!--                             <li class="item"><a class="uppercase" href="<?=ABSPATH?>agenda" title="Agenda">Agenda</a></li>
                            <li class="item"><a class="uppercase" href="<?=ABSPATH?>promocoes" title="Promoções">Promoções</a></li>
                            <li class="item"><a class="uppercase" href="<?=ABSPATH?>noticias" title="Notícias">Notícias</a></li>
                            <li class="item"><a class="uppercase" href="<?=ABSPATH?>galeria" title="Galeria">Galeria</a></li> -->
                            <li class="item" style='border-right:0px'><a href="<?=ABSPATH?>comercial" title="Comercial">Comercial</a></li>
                        </ul>
                        <div class="clear"></div>

                        <div id="contato-footer" align="center">
                            <p class="uppercase radio yellow bold">RÁDIO 105 FM - 105,1 - SÃO PAULO</p>
                            <p>Avenida Carlos Salles Block, 658 - 4º andar - Anhangabaú</p>
                            <p>Jundiaí - SP. CEP: 13208-100. Telefone: +55 (11) 3819-3541</p>
                            <p>Comercial <a class="mail" href="mailto:comercial@radio105fm.com.br">comercial@radio105fm.com.br</a> &nbsp; Fale Conosco <a class="mail" href="mailto:faleconosco@radio105fm.com.br">105fm@radio105fm.com.br</a></p>
                            </p>
                        </div>
                        <div class="clear"></div>

                        <div id="bottom" align="center">
                            <a class="pump f_right" href="http://www.agenciapump.com.br" title="Ag&ecirc;ncia Pump" target="_blank"><img src="<?=ABSPATH?>img/logo-pump.png" alt="Ag&ecirc;ncia Pump" /></a>
                            <!--<p align="center" class="copyright">Rádio 105 FM Copyright 2013 © - Todos os direitos reservados</p>-->
                        </div>
                        <div class="clear"></div>
                    </div>
                </div>
            </div>
        </div>
    <div id='html-msg'></div>
    <div id='msg-modal'></div>
    <script src="<?=ABSPATH?>bootstrap/js/bootstrap.min.js"></script>
    <script src="<?=ABSPATH?>js/jquery.doesExist.js"></script>
    <!--<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>
    <script src="<?=ABSPATH?>js/application.js"></script>

    <script src="<?=ABSPATH?>js/jquery.showModal.js"></script>
-->
     <?php
        /**
         *  Exibe mensagens de erro
         */
        if (isset($res['error']))
            $toScript = showModal(array('title'=>(isset($res['error']['title']) ? $res['error']['title'] : null), 'content'=>$res['error']['text']));
     ?>
     <script type='text/javascript'>
        delete window.alert;
        <?=isset($toJS) ? $toJS : null?>
        <?=isset($incJS) ? $incJS : null?>

        $(function() {
            if ($('#myCarousel') && typeof $.carousel == 'function' )
                $('#myCarousel').carousel();
            if ($(':input') && typeof $.autotab_magic == 'function' )
                $(':input').autotab_magic();

            <?=isset($incjQuery) ? $incjQuery : null?>
            <?=isset($toScript) ? $toScript : null?>

        });

        $(document).ready(function() {
            <?=isset($incReady) ? $incReady : null?>
        });
    </script>
    <script type="text/javascript">
        window.___gcfg = {lang: 'en'};
        (function()
        {var po = document.createElement("script");
        po.type = "text/javascript"; po.async = true;po.src = "https://apis.google.com/js/plusone.js";
        var s = document.getElementsByTagName("script")[0];
        s.parentNode.insertBefore(po, s);
        })();
    </script>
    <script>
      (function(i,s,o,g,r,a,m){i['GoogleAnalyticsObject']=r;i[r]=i[r]||function(){
      (i[r].q=i[r].q||[]).push(arguments)},i[r].l=1*new Date();a=s.createElement(o),
      m=s.getElementsByTagName(o)[0];a.async=1;a.src=g;m.parentNode.insertBefore(a,m)
      })(window,document,'script','//www.google-analytics.com/analytics.js','ga');

      ga('create', 'UA-42853077-1', 'radio105fm.com.br');
      ga('send', 'pageview');
    </script>
    </body>
</html>
