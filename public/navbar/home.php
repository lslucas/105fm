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
					<h4>Cotações</h4>
					<ul>
						<li style='width:100%; height:50px; display:table; position:relative;'>
							<img src='<?=STATIC_PATH?>assets/dolar.png' class='pull-left' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:20px; width:100%;  '>
								R$ <?=cotacao()?>
							</div>
						</li>
						<li style='width:100%; height:50px; display:table; position:relative;'>
							<img src='<?=STATIC_PATH?>assets/euro.png' class='pull-left' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:20px; width:100%;  '>
								R$ <?=cotacao('EUR')?>
							</div>
						</li>
						<li style='width:100%; height:50px; display:table; position:relative;'>
							<img src='<?=STATIC_PATH?>assets/libra.png' class='pull-left' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:20px; width:100%;  '>
								R$ <?=cotacao('GBP')?>
							</div>
						</li>
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
			</aside>
		</div>
