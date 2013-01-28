
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
				<?php if (isset($usr['id']) && !empty($usr['id'])) { ?>
				<a href='<?=ABSPATH?>lista' class='btn-agro'>
				<?php } else { ?>
				<a href='<?=ABSPATH?>login' class='btn-agro'>
				<?php } ?>
					<div style='float:left; width:244px; height:146px; background-image: url("<?=STATIC_PATH?>assets/bt_comprar.png");'>&nbsp;</div>
				</a>
				<div style='float:left; width:9px; height:146px; background-image: url("<?=STATIC_PATH?>assets/bt_ou.png");'>&nbsp;</div>
				<?php if (isset($usr['id']) && !empty($usr['id'])) { ?>
				<a href='<?=ABSPATH?>novo-produto' class='btn-agro'>
				<?php } else { ?>
				<a href='<?=ABSPATH?>login' class='btn-agro'>
				<?php } ?>
					<div style='float:left; width:264px; height:146px; background-image: url("<?=STATIC_PATH?>assets/bt_vender.png");'>&nbsp;</div>
				</a>
			</div>

			<h3>Classificados</h3>
			<hr>

			<div style='width:190px;' class='pull-left'>
			<?=bannerHome($banners, 1)?>
			</div>
			<div style='width:190px;' class='pull-left'>
			<?=bannerHome($banners, 1)?>
			</div>
			<div style='width:160px;' class='pull-left'>
			<?=bannerHome($banners, 1)?>
			</div>

		</div>
