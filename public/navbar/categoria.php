		<div class="column grid_3">
			<aside class="cat">
				<section>
					<h4>Grupo Quimico</h4>
					<ul>
						<?php
							$grupoQuimico = getCategoriaListArea('Grupo Quimico', null, null, 6);
							foreach ($grupoQuimico as $int=>$gq) {
								$link = linkfy(ABSPATH.'lista/grupoquimico-'.$gq['titulo']);
						 ?>
						<li><a href='<?=$link?>'><?=$gq['titulo']?></a></li>
						<?php } ?>
					</ul>
				</section>

				<section>
					<h4>Fabricantes</h4>
					<ul>
						<?php
							$fabricantes = getCategoriaListArea('Fabricante', null, null, 8);
							foreach ($fabricantes as $int=>$fa) {
								$link = linkfy(ABSPATH.'lista/fabricante-'.$fa['titulo']);
						 ?>
						<li><a href='<?=$link?>'><?=$fa['titulo']?></a></li>
						<?php } ?>
					</ul>
				</section>
			</aside>
		</div>
