
		<?php include_once 'navbar/categoria.php' ?>
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
				<div style='float:left; width:265px; height:325px; background-image: url("<?=STATIC_PATH?>layout/soybeanplant.jpg"); text-align:center; display:table; position:relative'>
					<div style='display:table-cell; vertical-align:middle; '>
						<?php if (isset($usr['id']) && !empty($usr['id'])) { ?>
						<a href='<?=ABSPATH?>lista' class='btn-agro'>Comprar</a>
						<?php } else { ?>
						<a href='<?=ABSPATH?>login' class='btn-agro'>Comprar</a>
						<?php } ?>
					</div>
				</div>
				<div style='float:left; width:265px; height:325px; background-image: url("<?=STATIC_PATH?>layout/coffeebean.jpg"); margin-left:6px; text-align:center; display:table; position:relative'>
					<div style='display:table-cell; vertical-align:middle; '>
						<?php if (isset($usr['id']) && !empty($usr['id'])) { ?>
						<a href='<?=ABSPATH?>novo-produto' class='btn-agro'>Vender</a>
						<?php } else { ?>
						<a href='<?=ABSPATH?>login' class='btn-agro'>Vender</a>
						<?php } ?>
					</div>
				</div>
			</div>

		</div>
