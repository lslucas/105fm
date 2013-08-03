<?php
    if (empty($basename))
        $bodyId = 'home';
    elseif ($basename=='noticias')
        $bodyId =  'noticia';
     elseif ($basename=='mais-pedidas')
        $bodyId =  'noticia';
    elseif ($basename=='login')
        $bodyId =  'cadastro';
     elseif ($basename=='programacao')
        $bodyId =  'programas';
     elseif ($basename=='comercial')
        $bodyId =  'contato';
     elseif ($basename=='agenda')
        $bodyId = 'agendas';   
     elseif ($basename=='promocoes')
        $bodyId = 'promocoes';   
    else
        $bodyId = $basename;

    /*
    elseif ($basename=='programas')
        $bodyId = 'programas';
    elseif ($basename=='promocoes')
        $bodyId = 'promocoes';
    else
        $bodyId = 'home';
     */

    $lstTarget = array('agenda'=>'eventos', 'promocoes'=>'promos', 'galeria-fotos'=>'fotos', 'galeria-videos'=>'videos');
    if ($basename=='galeria-fotos') {
        $piececlass = 'pic';
        $piececontainer = 'ul';
        $pieces_per_page = 3;
    } elseif ($basename=='galeria-videos') {
        $piececlass = 'vdo';
        $piececontainer = 'li';
        $pieces_per_page = 8;
    // } elseif ($basename!='promocoes') {
    } else {
        $piececlass = 'agend';
        $piececontainer = 'li';
        $pieces_per_page = 3;
    }
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="pt-br">
    <head>
        <!--Meta Dados-->
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <meta name="description" content="Rádio 105 FM - P&aacute;ina Inicial" />
        <meta name="keywords" content="Rádio 105 FM" />
        <meta name="generator" content="" />

        <!--Título-->
        <title><?=SITE_NAME?></title>

        <!--Favicon-->
        <link rel="icon" type="image/vnd.microsoft.icon" href="<?=ABSPATH?>favicon.ico" />
        <link rel="shortcut icon" type="image/x-icon" href="<?=ABSPATH?>favicon.ico" />

        <!--CSS-->
        <link href="<?=ABSPATH?>css/main.css" rel="stylesheet" type="text/css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?=ABSPATH?>css/slide2.css" media="all" />
        <link rel="stylesheet" type="text/css" href="<?=ABSPATH?>js/jcarousel/lib/jquery.jcarousel.css" media="screen" />
        <link rel="stylesheet" href="<?=ABSPATH?>js/fancybox/source/jquery.fancybox.css" type="text/css" media="screen" />
        <link rel="stylesheet" href="<?=ABSPATH?>css/dropdown.css" type="text/css" media="screen, projection" />
        <?php if ($basename=='participacao') { ?>
        <link rel="stylesheet" href="<?=ABSPATH?>css/participacao.css" type="text/css" />
        <?php } ?>
        <?php if (in_array($basename, array('cadastro', 'login'))) { ?>
        <link rel="stylesheet" href="<?=ABSPATH?>css/cadastro.css" type="text/css" />
        <?php } ?>
        <!--[if lte IE 7]>
        <link rel="stylesheet" href="<?=ABSPATH?>css/dropdown-ie.css" type="text/css" media="screen" />
        <![endif]-->

        <!--Javascript-->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
        <script type='text/javascript'>jQuery.migrateMute = false; jQuery.migrateTrace=false;</script>
        <script src="//code.jquery.com/jquery-migrate-1.1.1.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/sliderman.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/pager.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/jquery.dropdownPlain.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/fancybox/source/jquery.fancybox.pack.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/fancybox/lib/jquery.mousewheel-3.0.6.pack.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/jquery.easing.1.3.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/jcarousel/lib/jquery.jcarousel.pack.js"></script>
        <script type="text/javascript" language="javascript" src="<?=ABSPATH?>js/carousel.js"></script>
        <script type="text/javascript">
        $(document).ready(function() {
            $(".fancy").fancybox();

            $(".inlinemodal").fancybox({
                'modal' : true
            });

            <?php if (in_array($basename, array('agenda', 'promocoes', 'galeria-fotos', 'galeria-videos'))) { ?>
             var newscripts=new virtualpaginate({
                piececlass: "<?=isset($piececlass) ? $piececlass : null?>",
                piececontainer: '<?=isset($piececontainer) ? $piececontainer : null?>', //Let script know you're using "p" tags as separator (instead of default "div")
                pieces_per_page: <?=isset($pieces_per_page) ? $pieces_per_page : "''"?>,
                defaultpage: 0,
                wraparound: false,
                persist: true
            })

            newscripts.buildpagination(["pager"])

            <?php if (isset($lstTarget[$basename])) { ?>
            $('#pager a').bind('click',function (e) {
                e.preventDefault();
                var target = this.hash;
                    $target = $('#<?=$lstTarget[$basename]?>');
                $('html, body').stop().animate({
                    'scrollTop': $target.offset().top
                }, 500, 'swing', function () {
                    window.location.hash = target;
                });
            });
            <?php } ?>
            <?php } ?>
        });
        </script>
        <script type='text/javascript'>
            var ABSPATH = '<?=ABSPATH?>';
            var LOADING = "<?=$LOADING?>";
            <?php
            if (!empty($usr['id'])) {
                echo "var USR_NAME = '{$usr['nome']}';";
                echo "var USR_ID = '{$usr['id']}';";
            }
            ?>
        </script>
        <script type="text/javascript" src="<?=ABSPATH?>js/cufon-yui.js"></script>
        <script type="text/javascript" src="<?=ABSPATH?>js/Appleberry_400.font.js"></script>
        <script type="text/javascript">
            Cufon.replace('h1,h2,h3,h4', {fontFamily: 'Appleberry',hover: true});
        </script>

    </head>
    <body id="<?=$bodyId?>">
        <div id="wrapper">
            <div id="wrapper2">
                <div id="page" class="clearfix">
                    <!--Cabeçalho-->
                    <div id="header">

                        <div id="top">
                            <!--Logo do Site-->
                            <a id="logo" href="<?=ABSPATH?>" title="Rádio 105 FM">
                                <img src="<?=ABSPATH?>images/logo.png" alt="Rádio 105 FM" />
                            </a>
                        </div>

                        <!--Publicidade do Topo-->
                        <div id="conexao">
                            <span class="dest-topo">
                                <a href='http://www.guti1001.com.br/site/videos1/flash%2064.html' title='flash' target='_blank'>
                                    <img src="<?=ABSPATH?>images/player/main.png" alt="Destaque Topo" />
                                </a>
                                 <a href='http://www.guti1001.com.br/site/videos1/flash%2064.html' title='flash' target='_blank'>
                                    <img src="<?=ABSPATH?>images/player/flash.png" style='margin-left:-4px;'/>
                                </a>
                                <a href='http://www.guti1001.com.br/105/ini-MediaPlayer.asx' title='windows media player' target='_blank'>
                                    <img src="<?=ABSPATH?>images/player/mediaplayer.png" style='margin-left:-4px;'/>
                                </a>
                                 <a href='http://www.guti1001.com.br/105/ini-QuickTime.qtl' title='quicktime' target='_blank'>
                                    <img src="<?=ABSPATH?>images/player/quicktime.png" style='margin-left:-4px;'/>
                                </a>
                                <a href='http://www.guti1001.com.br/105/ini-winamp.pls' title='winamp' target='_blank'>
                                    <img src="<?=ABSPATH?>images/player/winamp.png" style='margin-left:-4px;'/>
                                </a>
                            </span>
                            <!--
                            <a class="clique uppercase" href="#" title="Ao vivo - Conexão 105">
                                <span>Ao Vivo</span><br />
                                Conexão 105<br />
                                <span class="ouvir">Clique para ouvir</span>
                            </a>
                            -->
                        </div>

                        <!--Info o Topo da Página-->
                        <div id="user-info">
                            <ul>
                                <?php if (empty($usr['nome'])) { ?>
                                <li class="first item"><a class="login" href="<?=ABSPATH?>login">Efetuar Login</a></li>
                                <li class="item"><a class="cadastro" href="<?=ABSPATH?>cadastro">Cadastre-se</a></li>
                                <?php } else { ?>
                                <li class="first item">Olá <b><?=$usr['nome']?></b> &nbsp;</li>
                                <li class="item"><a class="cadastro" href="<?=ABSPATH?>logout">Sair</a></li>
                                <?php } ?>
                            </ul>
                        </div>

                        <div class="clear"></div>

                        <!--Menu Superior-->
                        <div id="menu" class="clearfix">
                            <ul class='dropdown'>
                                <li class="first item active"><a href="<?=ABSPATH?>" title="P&aacute;gina Inicial">Home</a></li>
                                <li class="item"><a href="<?=ABSPATH?>quem-somos" title="Quem Somos">A Rádio</a></li>
                                <li class="item">
                                    <a href="<?=ABSPATH?>equipe" title="Nossa Equipe">Equipe</a>
                                    <ul class='sub_menu'>
                                        <?php foreach ($lstEquipe as $int=>$eq) { ?>
                                        <li><a href='<?=$eq['link']?>'><?=$eq['titulo']?></a></li>
                                        <?php } ?>
                                    </ul>
                                </li>
                                <li class="item"><a href="<?=ABSPATH?>programacao" title="Nossa Programação">Programação</a></li>
                                <li class="item"><a href="<?=ABSPATH?>agenda" title="Agenda">Agenda</a></li>
                                <li class="item"><a href="<?=ABSPATH?>promocoes" title="Promoções">Promoções</a></li>
                                <li class="item"><a href="<?=ABSPATH?>noticias" title="Notícias">Notícias</a></li>
                                <li class="item"><a href="<?=ABSPATH?>galeria-fotos" title="Galeria">Galeria</a></li>
                                <li class="last item"><a href="<?=ABSPATH?>contato" title="Contato">Contato</a></li>
                            </ul>
                        </div>

                    </div>

