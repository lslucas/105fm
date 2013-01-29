	<?php if (!in_array($basename, array('meus-dados', 'lista', 'lista-por-interesse', 'lista-geral-de-interesses',  'fale-conosco', 'busca'))) { ?>
		<?php include_once 'navbar/banners.php' ?>
	<?php } ?>
	</div><!-- ROW -->

	<footer>
		<div class="row">
			<div class="column grid_7">
				<p>© AGROSSHOP 2012 · <a href="<?=ABSPATH?>politica-privacidade" title="">Política de Privacidade</a> · <a href="<?=ABSPATH?>termos-uso" title="">Termos de Uso</a> · <a href='<?=ABSPATH?>como-funciona'>Como Funciona</a></p>
			</div>

			<div class="column grid_5">
				<p class="fr"><a href="#" title="">Topo</a></p>
			</div>
		</div>
	</footer>
	<div id='html-msg'></div>
	<div id='msg-modal'></div>
	<?php if ($host!='localhost' && !empty($usr['id'])) { ?>
	<script src="http://54.232.122.95:6789/socket.io/socket.io.js"></script>
	<?php } ?>
	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
	<!--<script src="//code.jquery.com/ui/1.9.2/jquery-ui.js"></script>-->
	<script src="<?=ABSPATH?>bootstrap/js/bootstrap.min.js"></script>
	<script src="<?=ABSPATH?>js/jquery.doesExist.js"></script>
	<script src="<?=ABSPATH?>js/slider.js"></script>
	<script src="<?=ABSPATH?>js/script.js"></script>
	<script src="<?=ABSPATH?>js/jquery.autotab-1.1b.js"></script>
	<script src="<?=ABSPATH?>js/jquery.mask.js"></script>
	<script src="<?=ABSPATH?>js/jquery.price_format.js"></script>
	<script src="<?=ABSPATH?>js/jquery-ui-1.8.18.custom.min.js"></script>
	<script src="<?=ABSPATH?>js/application.js"></script>
	<?php if ($host!='localhost' && !empty($usr['id'])) { ?>
	<script src="<?=ABSPATH?>js/chatbox.js"></script>
	<?php } ?>
	<?php
		/**
		 *  Exibe mensagens de erro
		 */
		if (isset($res['error']))
			$toScript = showModal(array('title'=>(isset($res['error']['title']) ? $res['error']['title'] : null), 'content'=>$res['error']['text']));
	 ?>
	<script type='text/javascript'>

		<?=isset($toJS) ? $toJS : null?>
		<?=isset($incJS) ? $incJS : null?>

		$(function() {
			$('#myCarousel').carousel();
			$(':input').autotab_magic();
			<?=isset($incjQuery) ? $incjQuery : null?>
			<?=isset($toScript) ? $toScript : null?>
		});
	</script>
	<?php /*
<script type="text/javascript">
	var _gaq = _gaq || [];
	_gaq.push(['_setAccount', 'UA-6929407-17']);
	_gaq.push(['_trackPageview']);

	(function() {
		var ga = document.createElement('script'); ga.type = 'text/javascript'; ga.async = true;
		ga.src = ('https:' == document.location.protocol ? 'https://ssl' : 'http://www') + '.google-analytics.com/ga.js';
		var s = document.getElementsByTagName('script')[0]; s.parentNode.insertBefore(ga, s);
	})();
</script>
*/ ?>
</body>
</html>