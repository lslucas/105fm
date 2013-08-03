<?php
	include_once 'helper/list.respostas.php';
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>
<div class='small' align='right'><?=$total?></div>

<div align=left>
<div style='float:right;'>
	<a href='?p=<?=$var['path']?>' class='btn btn-info btn-mini'>Voltar</a>
    <!-- <a href='<?=$var['path']?>/helper/xls_votos.php' target='_blank' class='btn btn-mini'>Exportar Excel</a> -->
</div>
</div>

<?php
	if ($total_itens==0)
		echo "<div class='alert alert-info'>Nenhuma postagem!</div>";

	else {
?>
<table class="table table-condensed table-striped">
   <thead>
      <tr>
        <th>Resposta</th>
        <th width="100px"><center>Enviado</center></th>
      </tr>
   </thead>
   <tbody>
<?php

    $j=0;

    while ($qry->fetch()) {
?>
	<tr id="tr<?=$id?>">
		<td>
			<?=$resposta?>
			<br/><i><?=$ip?></i>
		</td>
		<td>
			<?=$timestamp?>
		</td>
	</tr>
<?php
     $j++;
    }

    $qry->close();
?>
    </tbody>
    </table>


	  <?php
        /*
         *paginação
         */
        #$nav_cat       = isset($catid)?'&cat='.$catid:'';
		$queryString = preg_replace("/(\?|&)?(pg=[0-9]{1,})/",'',$_SERVER['QUERY_STRING']);
        $nav_cat='&'.$queryString;

	      $nav_nextclass = $pg_atual==$n_paginas?'unstyle ':'';
	      $nav_nexturl   = $pg_atual==$n_paginas?'javascript:void(0)':'?pg='.($pg_atual+1).$nav_cat;

		  echo "<div class='spacer' style='height:30px;'></div>";
	      echo "<span style='float:left'>";
	      echo "  <a href='${nav_nexturl}' class='${nav_nextclass}navbar more'>Mais ítens</a>";
	      echo "</span>";


	      echo "<span style='float:right'>";

	      $nav_prevclass = $pg_atual==1?'unstyle ':'';
	      $nav_prevurl   = $pg_atual==1?'javascript:void(0)':'?pg=1'.$nav_cat;

	      echo "<a href='${nav_prevurl}' class='${nav_prevclass}navbar prev'>Anterior</a>";


	    for($p=1;$p<=$n_paginas;$p++) {

	      $nav_class = $pg_atual<>$p?'':'unstyle ';
	      $nav_url   = $pg_atual==$p?'javascript:void(0)':'?pg='.$p.$nav_cat;
	  ?>
	  <a href='<?=$nav_url?>' class='<?=$nav_class?> navbar'><?=$p?></a>
	  <?php

	    }

	    echo "<a href='${nav_nexturl}' class='${nav_nextclass}navbar next'>Próximo</a>";
	    echo "</span>";
	  ?>
	</div>
<?php
	}
?>