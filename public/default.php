
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
				<?php /* ?><br/><?=cotacao()?>*/ ?>
				<img src='http://placehold.it/265x325' border='0'/>
				<img src='http://placehold.it/265x325' border='0' style='margin-left:6px;'/>
			</div>

		</div>
