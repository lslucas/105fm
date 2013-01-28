		<div class="column grid_3">
			<aside class="cat">
				<section>
					<h4>Notícias</h4>
					<ul>
						<?php
							foreach ($listNoticias as $int=>$not) {
						 ?>
						<li><a href='<?=$not['link']?>'><?=$not['titulo']?></a></li>
						<?php } ?>
					</ul>
				</section>

				<section>
					<h4>Clima</h4>
					<ul>
						<li>
							<p align='center'>
								em <?=$clima['cidade']?>
								<br/><?=$clima['imagem']?>
							</p>
						</li>
					</ul>
				</section>

				<section>
					<h4>Cotações</h4>
					<ul>
						<li>
							U$<?=cotacao()?>
							<br/>EUR<?=cotacao('EUR')?>
						</li>
					</ul>
				</section>
			</aside>
		</div>
