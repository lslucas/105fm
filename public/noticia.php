
<?php include_once 'public/navbar/categoria.php' ?>
<div class="column grid_7">
	<?php
		if (empty($titulo))
			echo "<center>Notícia não existe!";
		else {
	?>
	<h3><?=$data?> - <?=$titulo?></h3>
	<hr>
	<p>
		<?php
			if (!empty($imagem))
				echo "<img src='{$imagem}' border=0 width=280 style='margin-right:15px; margin-bottom:5px;' class='img-polaroid pull-left'/>";
		?>
		<?=$texto?>
	</p>
	<?php } ?>
</div>