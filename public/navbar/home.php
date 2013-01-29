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
							<img src='<?=STATIC_PATH?>assets/dolar.png' class='pull-left' title='Dolar' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:20px; width:100%;  '>
								Dolar R$ <?=cotacao()?>
							</div>
						</li>
						<li style='width:100%; height:50px; display:table; position:relative;'>
							<img src='<?=STATIC_PATH?>assets/euro.png' class='pull-left' title='Euro' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:20px; width:100%;  '>
								Euro R$ <?=cotacao('EUR')?>
							</div>
						</li>
						<li style='width:100%; height:50px; display:table; position:relative;'>
							<img src='<?=STATIC_PATH?>assets/libra.png' class='pull-left' title='Libra' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:20px; width:100%;  '>
								Libra R$ <?=cotacao('GBP')?>
							</div>
						</li>
					</ul>
				</section>

				<section>
					<h4>Previsão do Tempo</h4>
					<ul class='previsao-tempo'>
						<li style='width:100%; height:50px; display:table; position:relative;'>
							<img src='<?=$clima['imagem_url']?>' class='pull-left' title='<?=$clima['clima']?>' border=0/>
							<div style='display: table-cell; vertical-align:middle; padding-left:10px; width:100%;  '>
								<h5><?=$clima['cidade']?></h5>
								<b><?=$clima['temperatura']?></b> <small class='orange'>Alta <?=$clima['maxima']?></small> <small>Baixa <?=$clima['minima']?></small>
							</div>
						</li>
					</ul>
				</section>
			</aside>
		</div>
