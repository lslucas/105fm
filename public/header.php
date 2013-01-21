<!DOCTYPE html>
<html lang="pt-BR">
	<head>
		<meta charset="utf-8">
		<meta name="robots" content="index,follow" />
		<title><?=SITE_NAME?></title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author" content="Lucas Serafim - http://lucasserafim.com.br">
		<meta name="google-site-verification" content="IjitGvBpvYlvTY8vOsV3jFdDyjbacRFLD9w5fEdpA6U" />

		<link href="<?=STATIC_PATH?>favicon.png" rel="shortcut icon"/>

		<script type='text/javascript'>var ABSPATH = '<?=ABSPATH?>'; var LOADING = "<?=$LOADING?>";</script>
		<link href="<?=ABSPATH?>bootstrap/css/bootstrap.min.css" rel="stylesheet">
		<!-- <link rel="stylesheet" href="//code.jquery.com/ui/1.9.2/themes/base/jquery-ui.css" /> -->
		<link rel="stylesheet" href="<?=ABSPATH?>css/style.css" type="text/css" media="screen" />
		<link rel="stylesheet" href="<?=ABSPATH?>css/application.css" type="text/css">
		<link href="<?=ABSPATH?>css/datepicker.css" rel="stylesheet" type="text/css"/>
		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
			<script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->

		<!--[if lt IE 7]>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE7.js"></script>
		<![endif]-->

		<!--[if lt IE 8]>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE8.js"></script>
		<![endif]-->

		<!--[if lt IE 9]>
			<script src="http://ie7-js.googlecode.com/svn/version/2.1(beta4)/IE9.js"></script>
		<![endif]-->
	</head>

	<body>
		<header>
		<div class="row">
			<a href='<?=ABSPATH?>'>
				<div class="column grid_2">
					<h1 id='logo'>Agrosshop</h1>
				</div>
			</a>

			<div class="column grid_7">
				<nav class="cat">
					<ul>
						<li><a href='<?=ABSPATH?>'>Home</a></li>
						<li><a href='<?=ABSPATH?>como-funciona'>Como Funciona</a></li>
						<li><a href='<?=ABSPATH?>lista'>Comercialização</a></li>
						<?php if (!empty($usr['id'])) { ?>
						<li><a href='<?=ABSPATH?>novo-produto'>Novo Produto</a></li>
						<li><a href='<?=ABSPATH?>painel'>Painel</a></li>
						<?php } else { ?>
						<li><a href='<?=ABSPATH?>registrar'>Registrar</a></li>
						<?php } ?>
					</ul>
				</nav>
			</div>

			<div class="column grid_3">
				<nav class="usr">
					<ul>
						<?php if (!empty($usr['id'])) { ?>
						<li><a href='<?=ABSPATH?>painel'><?=$usr['primeiroNome']?></a></li>
						<li><a href='<?=ABSPATH?>sair'>Sair</a></li>
						<?php } else { ?>
						<li><a href='<?=ABSPATH?>login'>Entrar</a></li>
						<?php } ?>
						<li><a href='<?=ABSPATH?>sobre'>Sobre</a></li>
						<li><a href='<?=ABSPATH?>fale-conosco'>Contato</a></li>
					</ul>
				</nav>
			</div>
		</div>

		<div class="row search">
			<div class="column grid_10">
				<form method="post" action="<?=ABSPATH?>busca">
					<div id='buscaBox' class='pull-left'>
						Busca por
						<input type="text" name="q" value="" class='searchFields'/>
						em
						<select name="q_grupoquimico" id="q_grupoquimico" class="searchFields">
							<option value="">Grupo Quimico</option>
							<?=convertCatList2Option(getCategoriaListArea('Grupo Quimico'))?>
						</select>
					</div>
					<input type="submit" name="send" value="" class='searchButton pull-left' />
				</form>
			</div>

			<div class="column grid_2">
				<a href="<?=ABSPATH?>fale-conosco" title="Encontre formas de contato"><img src="<?=STATIC_PATH?>layout/suporte.png" class="suporte" /></a>
			</div>
		</div>
	</header>


	<?php //if (!in_array($basename, array('novo-produto'))) { ?>
	<!-- CONTENT -->
	<div class="row<?=isset($rowContentClass) ? ' '.$rowContentClass : null?>">
	<?php //} ?>