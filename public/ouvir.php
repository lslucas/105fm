<!DOCTYPE html>
<html class="no-js" lang="pt-br">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta charset="UTF-8">
    <title>Rádio 105FM</title>
    <!-- css -->
    <link href="css/ouvir.css" rel="stylesheet" type="text/css" />
    <link href="js/custom-scrollbar-plugin/jquery.mCustomScrollbar.css" rel="stylesheet" type="text/css" />
    <!-- end css -->
    </head>
<body>
    <!--
    <div id="radioTopo">
        <img src="<?=STATIC_PATH?>radio/headerRadio.jpg" width="172" height="45">
    </div>
    -->
<?php
$incJS .= "
    var t = setTimeout(\"resizeTo(990, 601);\", 5000);
";
echo "<script type='text/javascript'>\n";
echo 'var jsonMusicas = [';

// $jsonMusic = array();
foreach ($musicas as $int=>$musica) {
    echo "\n\t{";
    echo "\n\t\ti: {$int},";
    echo "\n\t\ttitle: \"{$musica['titulo']}\",";
    echo "\n\t\tmp3: \"{$musica['link']}\",";
    echo "\n\t\tartist: \"{$musica['artista']}\",";
    echo "\n\t\tthumb: \"{$musica['thumb']}\"";
    echo "\n\t}";
    if (($int+1)<count($musicas))
        echo ",";
}
// echo json_encode($jsonMusic);
/*
        {
            i: 11,
            title:"Thin Ice",
            mp3:"http://www.jplayer.org/audio/mp3/Miaow-10-Thin-ice.mp3",
            oga:"http://www.jplayer.org/audio/ogg/Miaow-10-Thin-ice.ogg",
            artist:"Emicida",
            thumb:"http://localhost/funkdacapital/public/images/radio/capaDisco.jpg"
        }*/
echo '];';
echo "\njsonMusicas = JSON.stringify(jsonMusicas);";
echo "</script>";
?>
    <div id="jquery_jplayer"></div>
    <div class="jp-no-solution hide">
        <span>Update Required</span>
        To play the media you will need to either update your browser to a recent version or update your <a href="http://get.adobe.com/flashplayer/" target="_blank">Flash plugin</a>.
    </div>
    <div id="radioPlayer">
        <div id="radioBotoes">
            <div id="topBotoes">
                <p class="txtTitulo">
                    <img src="<?=STATIC_PATH?>radio/radioGuime.jpg" width="80" height="80">
                    <span class='track-name'></a><br>
                    <q class="txtRadioArtista linksOrange" id='artistName'></q>
                </p>
            </div>
            <div id="navBotoes">
                <div class='play-pause_controls'>
                    <div class='jp-pause hide'></div>
                    <div class='jp-play'></div>
                </div>
                <div class='controls'>
                    <div class='jp-next'></div>
                    <div class="jp-progress">
                        <div class="jp-seek-bar" style="width: 100%; ">
                            <div class="jp-play-bar" style="width: 0.8049560671125708%; "></div>
                        </div>
                    </div>
                    <!-- <img src="<?=STATIC_PATH?>radio/track.jpg" width="790" height="27" class='jp-progress'> -->
                </div>
                <div class='volume-controls'>
                    <img src="<?=STATIC_PATH?>radio/volume.jpg" width="22" height="27" class='jp-mute'>
                    <div class='jp-unmute'></div>
                </div>
            </div>
        </div>
        <div class="jp-playlist">
            <ul>
                <li></li>
            </ul>
        </div>
    </div>

<script type='text/javascript'>
    var basename='<?=$basename?>';
    var ABSPATH = '<?=ABSPATH?>';
</script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js"></script>
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.8/jquery-ui.min.js"></script>
<script src="js/custom-scrollbar-plugin/jquery.mousewheel.min.js"></script>
<script src="js/custom-scrollbar-plugin/jquery.mCustomScrollbar.js"></script>
<script type="text/javascript" src="js/jplayer/jquery.jplayer.min.js"></script>
<script type="text/javascript" src="js/jplayer/add-on/jplayer.playlist.js"></script>
<script type="text/javascript" src="js/jquery.maskable.js"></script>
<!-- js -->
<!-- end js -->
<script type="text/javascript" src="js/modules/radio/header.js"></script>
<script type='text/javascript'>
/*
    <?=isset($incJS) ? $incJS : null?>

    $(function() {
        <?=isset($incjQuery) ? $incjQuery : null?>
    });
*/
</script>
</body>
</html>