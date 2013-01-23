				<div class="column grid_3">
					<aside class="src">
						<section>
							<h4>Filtro</h4>

							<?php if (count($filtro['localizacao'])>0) { ?>
							<strong>Localização</strong>
							<ul>
								<?php foreach ($filtro['localizacao'] as $int=>$loc) { ?>
								<li><?=$loc['link']?></li>
								<?php } ?>
							</ul>
							<?php } ?>

							<?php
							/*
							<?php if (count($filtro['faixaPreco'])>0) { ?>
							<strong>Faixa de preços</strong>
							<ul>
								<?php foreach ($filtro['faixaPreco'] as $int=>$fp) { ?>
								<li><?=$fp['link']?></li>
								<?php } ?>
							</ul>
							<?php } ?>
							 */?>

							<!--
							<strong>Ou filtrar por</strong>
							<ul>
								<li><a href="#" title="">Pagamento parcelado</a> (203)</li>
								<li><a href="#" title="">Novo</a> (50) | <a href="#" title="">Usado</a> (203)</li>
								<li><a href="#" title="">Frete grátis</a> (6)</li>
								<li><a href="#" title="">Melhores vendedores</a> (1)</li>
								<li><a href="#" title="">Preço fixo</a> (249) | <a href="#" title="">Arremate</a> (4)</li>
								<li><a href="#" title="">Começam hoje</a> (15)</li>
								<li><a href="#" title="">Termina hoje</a> (8)</li>
							</ul>
							-->
							<?php if (count($filtro['localizacao'])>0 || count($filtro['faixaPreco'])>0) { ?>
							<div class='pull-right'>
								<small><a href='<?=ABSPATH?>lista'>Limpar Filtros</a></small>
							</div>
							<?php } else echo "<small>Nada para filtrar!</small>"; ?>
							<br/>
						</section>
					</aside>
				</div>