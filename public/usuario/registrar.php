<?php
  // if (isset($_POST['submited']))
    // include_once 'modules/usuario/header.php';
?>
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
                          <p>&nbsp;</p>
                          <?php
                            if (isset($res['error']['text']))
                              echo '<p align="center"><center><h3>Atenção</h3>'.$res['error']['text'].'</center></p><br/>';
                          ?>
                          <form id="form1" name="form1" method="post" action="">
                            <input type='hidden' name='submited' value='<?=md5(time())?>'/>
                            <input type='hidden' name='from' value='cadastro'/>
                            <table width="483" border="0">
                              <tr>
                                <td class="align_right">NOME:</td>
                                <td><label for="nome"></label>
                                <input type="text" name="nome" id="nome2" value='<?=isset($_POST['nome']) ? $_POST['nome'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">E-MAIL:</td>
                                <td><label for="email"></label>
                                <input type="text" name="email" id="email" value='<?=isset($_POST['email']) ? $_POST['email'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">DATA DE NASCIMENTO:</td>
                                <td><label for="nascimento"></label>
                                <input type="text" class='data' name="nascimento" id="nascimento" value='<?=isset($_POST['nascimento']) ? $_POST['nascimento'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">SEXO:</td>
                                <td><input type="radio" name="sexo" id="sexo" value="masculino"<?=isset($_POST['sexo']) && $_POST['sexo']=='masculino' ? ' checked' : null?>/>
                                  <span class="alinha">masculino</span>
                                  <input type="radio" name="sexo" id="sexo" value="feminino"<?=isset($_POST['sexo']) && $_POST['sexo']=='feminino' ? ' checked' : null?>/>
                                  <span class="alinha">                                 feminino</span></td>
                              </tr>
                              <tr>
                                <td class="align_right">CEP RESIDENCIAL:</td>
                                <td><label for="cep"></label>
                                <input type="text" name="cep" id="cep" value='<?=isset($_POST['cep']) ? $_POST['cep'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">ENDEREÇO:</td>
                                <td><label for="endereco"></label>
                                <input type="text" name="endereco" id="endereco" value='<?=isset($_POST['endereco']) ? $_POST['endereco'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">NÚMERO:</td>
                                <td><label for="numero"></label>
                                <input type="text" name="numero" id="numero" value='<?=isset($_POST['numero']) ? $_POST['numero'] : null?>'/>
                                &nbsp;<span class="alinha">COMPLEMENTO:
                                <label for="complemento"></label>
                                <input type="text" name="complemento" id="complemento" value='<?=isset($_POST['complemento']) ? $_POST['complemento'] : null?>'/>
                                </span></td>
                              </tr>
                              <tr>
                                <td class="align_right">BAIRRO:</td>
                                <td><label for="bairro"></label>
                                <input type="text" name="bairro" id="bairro" value='<?=isset($_POST['bairro']) ? $_POST['bairro'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">CIDADE:</td>
                                <td><label for="cidade"></label>
                                <input type="text" name="cidade" id="cidade" value='<?=isset($_POST['cidade']) ? $_POST['cidade'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">ESTADO:</td>
                                <td><label for="estado"></label>
                                <input type="text" maxlength='2' name="uf" id="estado" value='<?=isset($_POST['uf']) ? $_POST['uf'] : null?>'/>
                                &nbsp;TELEFONE:
                                <label for="telefone"></label>
                                <input type="text" name="telefone" id="telefone" value='<?=isset($_POST['telefone']) ? $_POST['telefone'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">SENHA:</td>
                                <td><label for="senha"></label>
                                <input type="password" name="senha" id="senha" value='<?=isset($_POST['senha']) ? $_POST['senha'] : null?>'/></td>
                              </tr>
                              <tr>
                                <td class="align_right">CONFIRME A SENHA:</td>
                                <td><label for="confirma"></label>
                                <input type="password" name="confirmaSenha" id="confirma" value='<?=isset($_POST['confirmaSenha']) ? $_POST['confirmaSenha'] : null?>'/></td>
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