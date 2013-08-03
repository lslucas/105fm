                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="img/banners/105fm.jpg" width="968" height="385" alt="Promoções da 105 FM" title="Promoções da 105 FM" />

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
                                            description: {hide: true, background: '#000000', opacity: 0.4, height: 50, position: 'bottom'},
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
                       	  <h1 class="uppercase navy" style="margin-left:10px;"><img src="img/cadastre-se.png" width="177" height="38" alt="Cadastre-se" /></h1>
                          <!--End -->
                        <div class="clear"></div>
                              <img src='<?=ABSPATH?>img/prazo-premios.jpg' border=0 style='float:right; margin-top:-50px'/>
                       	  <p>&nbsp;</p>
                          <?php
                            if (isset($res) && $res!==true)
                              echo '<p align="center"><center><h3>Atenção</h3>Login ou senha inválidos!</center></p><br/>';
                          ?>
                       	  <form id="form1" name="form1" method="post" action="">
                            <input type='hidden' name='submited' value='<?=md5(time())?>'/>
                            <input type='hidden' name='from' value='login'/>
                       	    <table width="483" border="0">
                       	      <tr>
                       	        <td class="align_right">E-MAIL:</td>
                       	        <td><label for="email"></label>
                   	            <input type="text" name="email" id="email" value='<?=isset($_POST['email']) ? $_POST['email'] : null?>'/></td>
                   	          </tr>
                       	      <tr>
                       	        <td class="align_right">SENHA:</td>
                       	        <td><label for="senha"></label>
                   	            <input type="password" name="senha" id="senha" value='<?=isset($_POST['senha']) ? $_POST['senha'] : null?>'/></td>
                   	          </tr>
                                <tr>
                                <td>&nbsp;</td>
                                <td><span style='margin-left:10px;'></span>Não tem cadastro? <a href="<?=ABSPATH?>cadastro">Cadastre-se</a>
                              </tr>
                       	      <tr>
                       	        <td>&nbsp;</td>
                       	        <td><input type='image' src="img/enviar.png" alt="Enviar" width="92" height="33" class="align_right" /></td>
                              </tr>
                            </table>
                       	  </form>
                       	  <p style="margin-left:10px;">&nbsp;</p>
                       	  <div class="clear"></div>
                      </div>
		<div class="clear"></div>
                    </div>
                    <!--End Centro-->