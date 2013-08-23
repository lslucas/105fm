 <div class='alert alert-error completeform-error hide'>
	<a class="close" data-dismiss="alert">×</a>
	Antes de prosseguir preencha corretamente o formulário e revise os campos abaixo:
	<br/><br/>
	<ol>
		<li><label for="titulo" class="error-validate">Digite o <b>nome/titulo</b> do show</label></li>
		<li><label for="data" class="error-validate">Informe uma <b>data</b> válida</label></li>
		<li><label for="artista" class="error-validate">Digite o(s) <b>artista(s)</b></label></li>
		<li><label for="local" class="error-validate">Informe o <b>local</b> do evento</label></li>
		<li><label for="url" class="error-validate">Informe uma <b>url</b> válida para mais informações sobre o show</label></li>
	</ol>
</div>



<form method='post' action='?<?=$_SERVER['QUERY_STRING']?>' id='form_<?=$p?>' class='form-horizontal cmxform' enctype="multipart/form-data">
 <input type='hidden' name='act' value='<?=$act?>'>
<?php
  if ($act=='update') {
    echo "<input type='hidden' name='item' value='${_GET['item']}'>";
    echo "<input type='hidden' name='code' value='${val['code']}'>";
  }
?>

<h1>
<?php
  if ($act=='insert') echo $var['insert'];
   else echo $var['update'];
?>
</h1>
<p class='header'>Todos os campos com <b>- * -</b> são obrigatórios.</p>

  <fieldset>

    <div class="control-group">
      <label class="control-label" for="foto">* Flyer</label>
      <div class="controls">
        <?php

            $num=0;
          if ($act=='update') {

            $sql_gal = "SELECT rpg_id, rpg_imagem, rpg_legenda, rpg_pos FROM ".TABLE_PREFIX."_r_${var['table']}_galeria WHERE rpg_{$var['pre']}_id=? AND rpg_imagem IS NOT NULL ORDER BY rpg_pos ASC;";
            $qr_gal = $conn->prepare($sql_gal);
            $qr_gal->bind_param('s',$_GET['item']);
            $qr_gal->execute();
            $qr_gal->store_result();
            $num = $qr_gal->num_rows;
            $qr_gal->bind_result($g_id, $g_imagem, $g_legenda, $g_pos);
            $i=0;


                if ($num>0) {

              echo '<table id="posGaleria" cellspacing="0" cellpadding="2">';
              while ($qr_gal->fetch()) {

            $arquivo = $var['path_original']."/".$g_imagem;
        ?>
        <tr id="<?=$g_id?>">
          <td width='20px' title='Clique e arraste para mudar a posição da foto' class='tip'></td>

          <td>
        <small>
            [<a href='?p=<?=$p?>&delete_galeria&item=<?=$g_id?>&prefix=r_<?=$var['table']?>_galeria&pre=rpg&col=imagem&folder=<?=$var['imagem_folderlist']?>&noVisual' title="Clique para remover o ítem selecionado" class='tip trash-galeria' style="cursor:pointer;" id="<?=$g_id?>">remover</a>]
        </small>
          </td>
          <td>
            <a href='$imagThumb<?=$i?>?width=100%' id='imag<?=$i?>' class='betterTip' target='_blank'>
          <img src='images/lupa.gif' border='0' style='background-color:none;padding-left:10px;cursor:pointer'></a> &nbsp; <span style='font-size:8pt; color:#777;'><?=!empty($g_legenda) ? $g_legenda : '[sem legenda]'?></span>
           <div id='imagThumb<?=$i?>' style='float:left;display:none;'>
           <?php

              if (file_exists(substr($var['path_thumb'],0)."/".$g_imagem))
               echo "<img src='".substr($var['path_thumb'],0)."/".$g_imagem."'>";

                 else echo "<center>imagem não existe.</center>";
            ?>
           </div>
          </td>
        </tr>
          <?php
              $i++;

          }
          }

        }
           echo '</table><br>';
       ?>
         <div class='divImagem'>
         <input class="galeria" type='file' name='galeria0' id='galeria' alt='0' style="height:18px;font-size:7pt;margin-bottom:8px; width:500px;">
         <br clear='all'/><textarea class="legenda" name='legenda0' id='legenda' alt='0' style="margin-bottom:8px; width:500px;" rows=2></textarea>
         <br><span class='small'>- JPEG, PNG ou GIF;<?=$var['imagemWidth_texto'].$var['imagemHeight_texto']?></span>
         <hr noshade size=1 style='border-color:#C4C4C4; background-color:#FFF; width:520px;'/>
         </div>
        <p class='help-block'>Clique ao lado da lupa para ordenar as fotos, a primeiro sempre é a capa!</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="titulo">* Título</label>
      <div class="controls">
        <input type="text" class="input-xlarge required" placeholder='Título' name='titulo' id='titulo' value='<?=$val['titulo']?>'>
        <p class="help-block">Informe o nome/título do show</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="linhafina">* Breve Descrição</label>
      <div class="controls">
        <input type="text" class="input-xlarge" placeholder='Breve Descrição' name='linhafina' id='linhafina' value='<?=$val['linhafina']?>'>
        <p class="help-block">Subtítulo/breve descrição</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data_inicio">* Data de Início</label>
      <div class="controls">
        <input type="text" class="input-xlarge required data" placeholder='Data Início da Promoção' name='data_inicio' id='data_inicio' value='<?=dateen2pt('-', $val['data_inicio'], '/')?>'>
        <p class="help-block">Informe a data de início</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="data_termino">Data de Término</label>
      <div class="controls">
        <input type="text" class="input-xlarge data" placeholder='Data Fim da Promoção' name='data_termino' id='data_termino' value='<?=dateen2pt('-', $val['data_termino'], '/')?>'>
        <p class="help-block">Informe a data de término da promoção</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="descricao">* Descrição do Evento</label>
      <div class="controls">
        <textarea name='descricao' class='required' id='descricao' rows=3  style="width:500px;" ><?=$val['descricao']?></textarea>
        <p class="help-block">Informe a descrição</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="ganhadores">Ganhadores</label>
      <div class="controls">
        <textarea name='ganhadores' class='' id='ganhadores' rows=3  style="width:500px;" ><?=$val['ganhadores']?></textarea>
        <p class="help-block">Informe os ganhadores</p>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label" for="regulamento">Regulamento</label>
      <div class="controls">
        <textarea name='regulamento' class='tinymce' id='regulamento' rows=20  style="width:500px;" ><?=!empty($val['regulamento']) ? $val['regulamento'] : '<P ALIGN=CENTER STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=4 STYLE="font-size: 16pt"><B>REGULAMENTO</B></FONT></FONT></P>
<P ALIGN=CENTER STYLE="margin-bottom: 0in; line-height: 100%"><FONT FACE="Arial, serif"><FONT SIZE=3>Promoção
Cultural</FONT></FONT></P>
<P ALIGN=CENTER STYLE="margin-bottom: 0in; line-height: 100%"><A NAME="_GoBack"></A>
<BR>
</P>
<P ALIGN=CENTER STYLE="margin-bottom: 0in; line-height: 100%">“<FONT SIZE=4><B>Na
boa com um galaxy na mão”</B></FONT></P>
<P ALIGN=CENTER STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%">
           <FONT SIZE=3 STYLE="font-size: 13pt"><B>Período de
participação: de 10 de Agosto a 26 de Outubro de 2013. </B></FONT>
</P>
<P ALIGN=JUSTIFY STYLE="margin-bottom: 0in; line-height: 100%"><FONT SIZE=4>  </FONT></P>
<OL>
  <LI><P STYLE="margin-bottom: 0in; line-height: 100%"><B>DO CONCURSO</B></P>
</OL>
<P STYLE="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><BR>
</P>
<OL>
  <OL>
    <LI><P STYLE="margin-bottom: 0in; line-height: 100%">A Promoção
    Cultural “Na boa com um galaxy na mão” será promovida pela
    Rádio 105FM       (realizadora), em todo território nacional.</P>
  </OL>
</OL>
<P STYLE="margin-left: 0.26in; margin-bottom: 0in; line-height: 100%">
<BR>
</P>
<OL>
  <OL>
    <OL>
      <LI><P STYLE="margin-bottom: 0in; line-height: 100%">A
      participação nesta Promoção Cultural é voluntária e
      gratuita, não implica em qualquer ônus, de qualquer natureza
      para os participantes inscritos e participantes premiados ao
      final.</P>
    </OL>
  </OL>
</OL>
<P STYLE="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><BR>
</P>
<OL>
  <OL>
    <OL START=2>
      <LI><P STYLE="margin-bottom: 0in; line-height: 100%">A presente
      Promoção Cultural será realizada exclusivamente através do
      hotsite www.radio105fm.com.br/promocoes</P>
    </OL>
  </OL>
</OL>
<P STYLE="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%; text-decoration: none">
<BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<OL>
  <OL>
    <OL START=3>
      <LI><P STYLE="margin-bottom: 0in; line-height: 100%">O objetivo
      dessa Promoção Cultural é eleger, seguindo as regras aqui
      determinadas, as melhores respostas elaboradas sobre a pergunta:
      “Qual sua maior virtude’’?.</P>
    </OL>
  </OL>
</OL>
<P STYLE="margin-left: 0.75in; margin-bottom: 0in; line-height: 100%">
<BR>
</P>
<OL START=2>
  <LI><P STYLE="margin-bottom: 0in; line-height: 100%"><B>DA
  PARTICIPAÇÃO</B></P>
</OL>
<P STYLE="margin-left: 0.2in; margin-bottom: 0in; line-height: 100%"><BR>
</P>
<OL>
  <OL>
    <LI><P STYLE="margin-bottom: 0in; line-height: 100%">O concurso
    será aberto a todas as pessoas físicas interessadas, residentes e
    domiciliadas em território nacional, maiores de 18 ( dezoito)anos
    de idade.</P>
  </OL>
</OL>
<P STYLE="margin-left: 0.26in; margin-bottom: 0in; line-height: 100%">
<BR>
</P>
<OL>
  <OL START=2>
    <LI><P STYLE="margin-bottom: 0in; line-height: 100%">A participação
     é voluntária e gratuita , não estando vinculada a aquisição
    (ou uso) de qualquer produto, bem, serviço ou direito. A
    participação não implica em qualquer ônus, de qualquer natureza
    para participantes inscritos e para o participante premiado ao
    final.</P>
  </OL>
</OL>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<OL>
  <OL START=3>
    <LI><P STYLE="margin-bottom: 0in; line-height: 100%">Para
    participar do concurso os interessados, deverão no período
    compreendido entre 00:30 do dia 10   de Agosto  até as 23:59m do
    dia 26 de Outubro ( horário oficial de Brasília) acessar o
    hotsite www.radio105fm.com.br/promocoes e fornecer , a titulo
    exclusivo de identificação os seguintes dados pessoais: nome,
    e-mail, cidade, bairro, CPF, RG, telefone residencial, celular com
    DDD.</P>
  </OL>
</OL>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.3.1 Além dos
dados acima, o participante deverá responder a seguinte pergunta
“qual a sua maior virtude?”.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.3.2 Os
participantes deverão ter no mínimo 18 (dezoito) anos no ato da
inscrição, observando que o fornecimento de dados incorreto e/ou
incompletos fará com que sejam imediatamente desclassificados desta
Promoção Cultural.</P>
<P STYLE="margin-left: 0.5in; margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-left: -0.39in; margin-bottom: 0in; line-height: 100%">
            2.3.3 A resposta deverá ser original, isto é resultado
da criação intelectual do participante, não              sendo
aceita cópia (total ou parcial) de criação de terceiros, sob pena
de desclassificação imediata do participante. Qualquer resposta de
conteúdo improprio, assim como, aquele em desconformidade com o
parágrafo  acima será automaticamente desclassificado.</P>
<P STYLE="margin-left: -0.39in; margin-bottom: 0in; line-height: 100%">
<BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.3.4 No ato de sua
resposta o participante deverá  ler o regulamento e aceitar as
condições, renunciando a qualquer questionamento  sobre  os
critérios de julgamento adotados.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.3.5 Serão
desclassificadas pelo mediador as respostas que contiverem
referencias a pedofelia, violência, palavras de baixo calão ou
contrários à moral e  e/ou aos bons costumes.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.3.6 Igualmente, a
resposta que demonstrar qualquer tipo de discriminação por conta de
crença, raça, cor, sexo, nacionalidade ou origem étnica, será
imediatamente desclassificada.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<OL>
  <OL START=4>
    <LI><P STYLE="margin-bottom: 0in; line-height: 100%">A Rádio 105FM
    poderá  exercer sobre a  resposta vencedora  toda e qualquer
    exploração, envolvendo  aplicações diretas e indiretas,
    processo de reprodução e divulgação, podendo desde já,
    quaisquer  acordos comerciais com terceiros para exploração,
    fabricação, reprodução, distribuição e comercialização da
    resposta vencedora.</P>
  </OL>
</OL>
<P STYLE="margin-left: 0.26in; margin-bottom: 0in; line-height: 100%">

</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.5  A Realizadora
não será responsável por problemas, falhas ou funcionamento
técnico, de qualquer tipo, em rede de computadores, servidores ou
provedores, equipamentos de computadores, hardware ou software, ou
erro, interrupção, defeito, atraso ou falha em operações ou
transmissões para o correto processamento das participações, em
razão de problemas técnicos, congestionamento na internet ou na
FanPage do facebook ligada ao concurso, vírus, falha de
programação(bugs) ou violação por terceiros (hackers).</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">2.6 Não poderão
participar desta Promoção Cultural os funcionários, estagiários e
terceirizados da empresa realizadora. Além dessas, não poderão
participar dessa Promoção Cultural, qualquer pessoa que esteja
direta ou indiretamente ligada ao grupo envolvido, bem como seus
cônjuges e parentes de até segundo grau, sob pena de
desclassificação e de responsabilização sob pena de lei.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><B>3. FORMA DE
JULGAMENTO</B></P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">3.1 As respostas
enviadas, durante o período de participação, desde que aceitas na
forma especifica em regulamento, serão avaliadas e julgadas por uma
Comissão julgadora, formada por 3 jurados selecionados pela
realizadora, que escolherá a 1 (uma) resposta vencedora.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">3.2 Os parâmetros
que serão utilizados pelos profissionais que efetuarão o julgamento
das melhores respostas serão: originalidade, criatividade e
adequação ao tema.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">3.3 A Comissão
Julgadora se reserva o direto de corrigir eventuais erros na grafia,
ou de concordância (nominal ou verbal) das respostas antes da
divulgação no site, desde que não implique em perda do significado
destas.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">3.4 Os nomes dos
vencedores serão divulgados através do hotsite da Rádio 105FM
<A HREF="http://www.radio105fm.com.br/promoçoes">www.radio105fm.com.br/promoçoes</A>
a partir do dia 26 de Outubro. A veiculação do resultado  poderá
ser realizada também em outros meios de comunicação, ou outra
forma.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-left: 0.25in; margin-bottom: 0in; line-height: 100%">
<B>4. PRÊMIO</B></P>
<P STYLE="margin-bottom: 0in; line-height: 100%"> O autor que enviar
a resposta escolhida pela comissão julgadora como sendo a melhor
fará jus a seguinte premiação: 1(um) Galaxy S4.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">4.1 Os prêmios
distribuídos neste Concurso são pessoais e intrasferíveis e, em
nenhuma hipótese, poderão ser convertidos ou trocados por quaisquer
outros bens ou produtos.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5<B>. ENTREGA DO
PRÊMIO</B></P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5.1  O ganhador
efetuará a retirada do prêmio na sede da realizadora, no prazo
máximo de  5 (cinco) dias, contados da  data de divulgação do
resultado, devendo este apresentar o CPF e RG e assinar um Termo de
Recebimento e Quitação de Prêmio.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5.2 O prêmio a ser
distribuído  destina- se  ao contemplado e será entregue em seu
nome, sendo vedada sua transferência antes da entrega.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5.3 Não há
possibilidade de troca de prêmio conquistado nem sua conversão em
dinheiro.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5.4 Na eventualidade
do contemplado falecer, o prêmio será entregue a seu inventariante,
que poderá comprovar tal condição.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5.5 Em ocorrendo do
ganhador não comparecer  no prazo do item 5.1, este perderá o
direito de receber o prêmio.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">5.6 Os prêmios
serão entregues livres e desembaraçados de qualquer ônus para o
contemplado.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><FONT SIZE=3><B>6.
CONSIDERAÇÕES GERAIS</B></FONT></P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.1 Ao inscrever-se
para participar da Promoção Cultural, o participante estará
concordando com os termos deste Regulamento e, automaticamente,
autorizando a Realizadora a utilizar, de modo gratuito, definitivo e
irrevogável, a sua resposta, o seu nome, imagem e som de voz em
qualquer veiculo de imprensa, mídia ou internet, para a divulgação
da Promoção Cultural, cedendo também à Realizadora, em caráter
definitivo, absoluto e de forma irrevogável  e gratuita todos os
direitos  autorais.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.2 O participante
reconhece e aceita expressamente que a Realizadora não poderá ser
responsabilizada por qualquer dano ou prejuízo oriundo da
participação nesta Promoção Cultural ou da eventual aceitação
do prêmio.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.3 O presente
Regulamento poderá ser alterado e/ou o Concurso suspenso  ou
cancelado, sem aviso prévio, por motivo de força maior ou por
qualquer outro motivo que esteja fora do controle da Realizadora.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.4 Qualquer duvida
ou divergência ou situação não prevista neste regulamento será
julgada  e decidida de forma soberana e irrecorrível pela Comissão
Julgadora.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.5 A participação
 nesse Concurso implica na aceitação total e irrestrita de todos os
itens deste regulamento.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.6 Este Regulamento
será divulgado no hotsite da Realizadora
www.radio105fm.com.br/promocoes.</P>
<P STYLE="margin-bottom: 0in; line-height: 100%"><BR>
</P>
<P STYLE="margin-bottom: 0in; line-height: 100%">6.7 A presente
Promoção Cultural foi promovida em observância às determinações
legais, não possuindo finalidade comercial, com caráter
exclusivamente “ cultural”.</P>'?></textarea>
      </div>
    </div>

    <div class="control-group">
      <label class="control-label">Para participar</label>
      <div class="controls">
        <label><input type='checkbox' name='enviar_texto' id='enviar_texto' value='1' <?php if (isset($val['enviar_texto']) && $val['enviar_texto']==1) echo ' checked'; ?>>
        Enviar Texto</label>
        <label><input type='checkbox' name='enviar_arquivo' id='enviar_arquivo' value='1' <?php if (isset($val['enviar_arquivo']) && $val['enviar_arquivo']==1) echo ' checked'; ?>>
        Enviar Arquivo</label>
        <p class="help-block">Selecione caso os participantes tenham que enviar algum texto, arquivo ou foto para concorrer</p>
      </div>
    </div>

  </fieldset>

    <div class='form-actions'>
		<input type='submit' value='ok' class='btn btn-primary'>
		<input type='button' id='form-back' value='voltar' class='btn'>
	</div>

</form>