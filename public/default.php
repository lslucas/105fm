
		<?php include_once 'navbar/home.php' ?>
		<div class="column grid_7 content">
			<section class="slide">
				<div id="feature">
					<ul class="bjqs">
						<?php foreach ($destaque as $int => $dest) { ?>
						<li>
							<?php if (!empty($dest['link'])) echo "<a href='{$dest['link']}'>"; ?>
							<img src="<?=$dest['imagem']?>" title="<?=$dest['descricao']?>">
							<?php if (!empty($dest['link'])) echo "</a>"; ?>
						</li>
						<?php } ?>
					</ul>
				</div>
			</section>

			<div class="row produtos">
				<div style='width:20px;' class='pull-left'>&nbsp;</div>
				<?php if (isset($usr['id']) && !empty($usr['id'])) { ?>
				<a href='<?=ABSPATH?>lista' class='btn-agro'>
				<?php } else { ?>
				<a href='<?=ABSPATH?>login' class='btn-agro'>
				<?php } ?>
					<div class='pull-left' style='width:244px; height:146px; background-image: url("<?=STATIC_PATH?>assets/bt_comprar.png");'>&nbsp;</div>
				</a>
				<div class='pull-left' style='width:9px; height:146px; background-image: url("<?=STATIC_PATH?>assets/bt_ou.png");'>&nbsp;</div>
				<?php if (isset($usr['id']) && !empty($usr['id'])) { ?>
				<a href='<?=ABSPATH?>novo-produto' class='btn-agro'>
				<?php } else { ?>
				<a href='<?=ABSPATH?>login' class='btn-agro'>
				<?php } ?>
					<div class='pull-left' style='width:264px; height:146px; background-image: url("<?=STATIC_PATH?>assets/bt_vender.png");'>&nbsp;</div>
				</a>
			</div>

			<h3>Classificados</h3>
			<hr>

			<div class="row produtos">
				<section class="item">
					<img src="<?=STATIC_PATH?>prod-teste1.jpg" class="thumb" />
					<p><strong>Caminhão</strong></p>
					<p>R$ 70.000</p>
					<a href="javascript:alert('Em Breve!');"><img src="<?=STATIC_PATH?>em-breve_cinza.png" class="info" /></a>
				</section>

				<section class="item">
					<img src="<?=STATIC_PATH?>prod-teste2.jpg" class="thumb" />
					<p><strong>Colheitadeira</strong></p>
					<p>R$ 240.000</p>
					<a href="javascript:alert('Em Breve!');"><img src="<?=STATIC_PATH?>em-breve_cinza.png" class="info" /></a>
				</section>

				<section class="item">
					<img src="<?=STATIC_PATH?>prod-teste3.jpg" class="thumb" />
					<p><strong>Pesticida Aéreo</strong></p>
					<p>R$ 150.000</p>
					<a href="javascript:alert('Em Breve!');"><img src="<?=STATIC_PATH?>em-breve_cinza.png" class="info" /></a>
				</section>
			</div>

		</div>
