                    <!--Colunas-->
                    <div id="centro" class="clearfix">
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
                                    <li class="share"><a href="javascript:postToFeed(); return false;">Compartilhe</a></li>
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
 <script src='http://connect.facebook.net/en_US/all.js'></script>
<script type='text/javascript'>
  FB.init({appId: "496705820402963", status: true, cookie: true});
  function postToFeed() {
    // calling the API ...
    var obj = {
      method: 'feed',
      // redirect_uri: '<?=SITE_URL?>',
      link: '<?=preg_replace("/\'|\"/", '', $url)?>',
      picture: '<?=$imagemUrl?>',
      name: '<?=addslashes($titulo)?>',
      caption: '',
      description: '<?=preg_replace("/\r\n|\r|\n/m",'', nl2br(addslashes($resumo)))?>'
    };

    function callback(response) {
      // document.getElementById('msg').innerHTML = "Post ID: " + response['post_id'];
      return true;
    }

    FB.ui(obj, callback);
  }
</script>