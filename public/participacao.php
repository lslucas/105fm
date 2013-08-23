<?php
  $pid = $querystring;
  // $pid = $hashids->decrypt($querystring);
  // $pid = isset($pid[0]) ? $pid[0] : null;
  $promo_id = isset($querystring) && !empty($pid) ? $pid : ( isset($_POST['promocao']) ? $_POST['promocao'] : null );
  $incjQuery .= "

    $('.groupLinhaFina, #barra').hide();
    $('.groupForm').hide().find('input, textarea').attr('disabled', 'disabled');

    var selected = $('select[name=\"promocao\"]').val();
    if (selected!='' && selected!=undefined) {
        $('.groupLinhaFina').hide();
        $('.groupForm').hide().find('input, textarea').attr('disabled', 'disabled');

        $('#barra').show();
        $('#contentGroup').show();
        $('#linhafina'+selected).fadeIn();
        $('#form'+selected).fadeIn().find('input, textarea').removeAttr('disabled');

         if (selected=='Aiy9iq') {
          $('.fieldsTime').show().find('input, textarea').removeAttr('disabled');
          console.log('test');
         } else {
          $('.fieldsTime').hide().find('input, textarea').attr('disabled');
          console.log(' not test');
        }
    }

    $('select[name=\"promocao\"]').change(function() {
      var val = $(this).val();

      $('.groupLinhaFina').hide();
      $('.groupForm').hide().find('input, textarea').attr('disabled', 'disabled');
      if (val!='') {
        $('#barra').show();
        $('#contentGroup').show();
        $('#linhafina'+val).fadeIn();
        $('#form'+val).fadeIn().find('input, textarea').removeAttr('disabled');

        if (val=='Aiy9iq')
          $('.fieldsTime').show().find('input, textarea').removeAttr('disabled');
        else
          $('.fieldsTime').hide().find('input, textarea').attr('disabled');
      } else
        $('#contentGroup').hide();
    });

  ";
?>
                    <!--Colunas-->
                    <div id="centro" class="clearfix">
                        <div id="banner-wrapper">
                            <!--Banner Slider-->
                            <div id="slider" style="display:inline-block;">
                                <div id="RadioBanner" class="">
                                    <img src="<?=ABSPATH?>img/banners/105fm.jpg" width="968" height="385" alt="Promoções da 105 FM" title="Promoções da 105 FM" />

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
                                            loading: {background: '#ffffff', opacity: 0.5, image: '<?=ABSPATH?>img/loading.gif'},
                                            buttons: {hide: true, opacity: 1, prev: {className: 'RadioPrev', label: ''}, next: {className: 'RadioNext', label: ''}},
                                            // description: {hide: true, background: '#000000', opacity: 0.4, height: 50, position: 'bottom'},
                                            navigation: {container: 'RadioNav', label: '<img src="<?=ABSPATH?>img/clear.gif" />'}
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
                          <h1 class="uppercase navy" style="margin-left:10px;"><img src="<?=ABSPATH?>img/participacao.png" width="335" height="43" alt="Participe das promoções!" /></h1>
                          <!--End -->
                        <div class="clear"></div>
                          <p>&nbsp;</p>
                          <p class="p">Olá <strong><?=!empty($usr['nome']) ? $usr['nome'] : 'Ouvinte'?></strong>, seja BEM VINDO! </p>
                          <p class="p">Para participar, preencha o formulário ao lado e boa sorte!</p>
                          <p class="p">&nbsp;</p>
                           <!--End -->
                        <div class="clear"></div>
                          <?php
                            if (isset($res['error']['texto']))
                              echo '<p align="center"><center><h3>Atenção</h3>'.$res['error']['texto'].'</center></p><br/>';
                          ?>
                        <form id="form1" name="form1" action="" class='participacao' method="post" enctype='multipart/form-data'>
                            <input type='hidden' name='submited' value='<?=md5(time())?>'/>
                            <input type='hidden' name='from' value='participacao'/>
                            <table width="550" border="0">
                              <tr>
                                <td class="align_right">ESCOLHA A PROMOÇÃO:</td>
                                <td><label for="promocao"></label>
                                  <select name="promocao" id="promocao">
                                    <option value=''>Selecione</option>
                                    <?php foreach ($promocoes as $int=>$pro) { ?>
                                    <option value='<?=$pro['id']?>'<?=!empty($promo_id) && $promo_id==$pro['id'] ? ' selected' : null?>><?=$pro['titulo']?></option>
                                    <?php } ?>
                                </select></td>
                              </tr>
                            </table>
                          <div id='contentGroup'>
                          <p class="p">&nbsp;</p>
                          <div class="align_center" id="barra">
                            <p>&nbsp;</p>
                            <p><span class="pump">
                              <?php foreach ($promocoes as $int=>$pro) { ?>
                              <div id='linhafina<?=$pro['id']?>' class='groupLinhaFina'>
                                <?=$pro['linhafina']?>
                              </div>
                              <?php } ?>
                                  </span>.</p>
                              </div>
                              <p>&nbsp;</p>
                                  <?php foreach ($promocoes as $int=>$pro) { ?>
                                  <table width="550" border="0" id='form<?=$pro['id']?>' class='groupForm'>
                                    <?php if ($pro['enviar_arquivo']==1) { ?>
                                    <tr>
                                      <td width="170" class="align_right">ENVIE UM ARQUIVO:</td>
                                      <td width="328"><input type='file' name='arquivo' id='arquivo'></td>
                                    </tr>
                                    <?php } ?>
                                    <?php if ($pro['id']=='Aiy9iq') { ?>
                                    <tr class='fieldsTime hide'>
                                      <td width='170' class="align_right"><p><label for='campo1'>Time Preferido:</label></p>
                                      <td><input type='text' name="campo1" id='campo1' value='<?=isset($_POST['campo1']) ? $_POST['campo1'] : null?>'></td>
                                    </tr>
                                    <tr class='fieldsTime hide'>
                                      <td width='170' class="align_right"><p><label for='campo2'>Tamanho da Camiseta</label></p>
                                      <td>
                                        <input type='text' name="campo2" id='campo2' value='<?=isset($_POST['campo2']) ? $_POST['campo2'] : null?>'> (P, M, G, GG)
                                        <!--
                                      <select name='campo2' id='campo2'>
                                        <option value=''>Selecione</option>
                                          <option value='P'<?=isset($_POST['campo2']) && $_POST['campo2']=='P' ? ' selected' : null?>>P</option>
                                          <option value='M'<?=isset($_POST['campo2']) && $_POST['campo2']=='M' ? ' selected' : null?>>M</option>
                                          <option value='G'<?=isset($_POST['campo2']) && $_POST['campo2']=='G' ? ' selected' : null?>>G</option>
                                          <option value='GG'<?=isset($_POST['campo2']) && $_POST['campo2']=='GG' ? ' selected' : null?>>GG</option>
                                      </select>
                                    -->
                                    </td>
                                    </tr>
                                    <?php } ?>
                                    <?php if ($pro['enviar_texto']==1) { ?>
                                    <tr>
                                      <td width='170' class="align_right"><p>FRASE:</p>
                                      <p>&nbsp;</p>
                                      <p>&nbsp;</p>
                                      <p>&nbsp;</p></td>
                                      <td><label for="frase"></label>
                                      <textarea name="texto" id='texto' cols="45" rows="5"><?=isset($_POST['texto']) ? $_POST['texto'] : null?></textarea>
                                    </td>
                                    </tr>
                                    <?php } ?>
                                    <?php if (!empty($pro['regulamento'])) { ?>
                                     <tr>
                                      <td width='170' class="align_right"><p>Regulamento:</p>
                                      <p>&nbsp;</p>
                                      <p>&nbsp;</p>
                                      <p>&nbsp;</p></td>
                                      <td>
                                      <div class='regulamento'><?=$pro['regulamento']?></textarea>
                                    </td>
                                    </tr>
                                    <?php } ?>
                                    <tr>
                                      <td class="align_right">&nbsp;</td>
                                      <td align="right" style='padding-top:40px'>
                                        <b>Atenção</b> Ao enviar sua participação você estará concordando com os termos do regulamento da promoção!
                                        <br/><br/><input type='image' src="<?=ABSPATH?>img/enviar.png" alt="Enviar" width="92" height="33" />
                                    </td>
                                    </tr>
                                  </table>
                                <?php } ?>
                                <p>&nbsp;</p>
                        </div>
                      </form>
                      </div>
                        <div class="clear"></div>

                    </div>
                    <!--End Centro-->