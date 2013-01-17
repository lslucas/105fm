<div class="column grid_12">

	<div class='breadcrumb-agro'>
		<h5>
			<a href="<?=ABSPATH?>" title="<?=SITE_NAME?>">Início</a>
			 > <a href="<?=ABSPATH?>painel" title="Painel">Painel de Controle</a>
			<?php
				if ($querystring=='configuracoes-conta')
					echo " > <a href='".ABSPATH."painel/meus-dados/{$querystring}'>Meus Dados: Configurações de Conta</a>";
				elseif ($querystring=='empresa')
					echo " > <a href='".ABSPATH."painel/meus-dados/{$querystring}'>Meus Dados: Empresa</a>";
				elseif ($querystring=='endereco-localidade')
					echo " > <a href='".ABSPATH."painel/meus-dados/{$querystring}'>Meus Dados: Endereço e Localidade</a>";
			?>
		</h5>
	</div>


	<h3>Atualizar</h3>
	<p><em>Todos os campos com - <span class="r">*</span> - são obrigatórios.</em></p>
	<p><br /></p>
</div>
<form name='registrar' class="form-horizontal" method='post' enctype='multipart/form-data'>
	<input type='hidden' name='from' value='<?=$basename?>'/>


		<?php
			if (file_exists('public/usuario/meus-dados/'.$querystring.'.php'))
				include_once 'meus-dados/'.$querystring.'.php';
		 ?>



		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn-agro">Atualizar</button>
			</div>
		</div>
	</div>
	<?php /*
	<div class="column grid_6">
		<textarea name="contrato" id="contrato" class="input-xlarge contrato" disabled>
Termos e Condições Gerais de uso do site

Sed et sit adipiscing porttitor, phasellus tincidunt, facilisis, pulvinar facilisis? Egestas parturient. Pulvinar proin, massa, risus, integer, vel nisi et platea augue! Augue habitasse! Pellentesque in porta nunc et enim, elementum pellentesque adipiscing enim urna! Ultricies, urna nunc dictumst lacus. Arcu sagittis vel et magnis, urna lorem magna, non nec! Scelerisque? Porta nunc mauris penatibus, enim pulvinar, vut, augue in, sed cursus massa tortor odio montes, hac habitasse, augue et, cum sociis, cras turpis nec amet, elit pellentesque, pulvinar elementum et integer tortor ac lectus a, lectus elementum! Et pulvinar, lacus, rhoncus nunc aliquet lectus ac, turpis proin et, aliquet, tincidunt tortor integer auctor amet, velit cursus enim! Ac odio, dis lectus sagittis ultricies ut a dolor hac duis aenean.

Magna, amet et integer tempor, et dis, dis quis vel nisi, mus pulvinar aliquam! Cum, massa et sed dictumst rhoncus aliquam vel adipiscing augue sit odio auctor penatibus pellentesque ridiculus facilisis, dapibus platea. Nec tincidunt? Rhoncus urna pid enim, ridiculus amet urna mauris quis, rhoncus elit parturient? Purus magna nec lundium dolor adipiscing! Amet amet, porta porta ultricies odio, elit pulvinar ridiculus aenean cum dolor etiam porttitor pulvinar ut, egestas non! Lacus hac odio, rhoncus dapibus augue augue urna? Nec? Et parturient? Porttitor, amet sagittis vel elementum, tortor adipiscing! Dis adipiscing! Scelerisque tempor risus sed porttitor, vut aliquet integer aenean arcu a nunc pid? In eu placerat! Dictumst, duis auctor et! Cum. Natoque, tempor, ac elementum mauris rhoncus cursus.

Mus elit! Eu sagittis duis integer dapibus, ultrices parturient aenean a, est proin sit ut facilisis scelerisque? In nisi, porttitor rhoncus nisi augue! Velit cursus nisi in odio platea rhoncus sagittis integer mid, et ut ac mattis urna? Integer augue vel elementum in diam purus etiam risus? Enim auctor nec elementum nec et dolor elementum sed? In vel vel, adipiscing turpis. Parturient magna! Integer eu. Cum eu elit placerat pulvinar mus tortor penatibus magna, mauris cras magnis placerat etiam, et phasellus tincidunt est, lorem vel ut mauris, porta velit sagittis tristique placerat nunc amet porttitor aenean ac a, et penatibus ut ridiculus phasellus! Purus, scelerisque, nunc amet lorem integer. Dolor phasellus, vel nunc arcu dapibus, tempor et nisi dictumst.
		</textarea>
		<p>&nbsp;</p>
		<label><input type="checkbox" name="lido" id="valor" value="1" class="fl" checked disabled>Li e concordo com os termos de condições de uso do site</label>
	</div>
 */?>

</form>
