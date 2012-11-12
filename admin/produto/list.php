<?php
	include_once 'helper/list.php';
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>
<div class='small' align='right'><?=$total?></div>

<div style='display:inline-block; width:100%;'>

	<div style='float:left; margin-right: 20px; width:600px;'>
		<p class='small' style='float:left;'>
		Filtrar por &nbsp; <?=$letras?>
		</p>
	</div>

	<div style='float:right; width:90px; text-align:right; '>

		<div class="btn-group">
		  <button class="btn btn-mini">Ordenar por</button>
		  <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>
		  </button>
		  <ul class="dropdown-menu">
			<li><a href="?p=<?=$p.$pag.$letter?>&orderby=<?=$var['pre'].'_data'?> ASC"<?php if($orderby==$var['pre'].'_data ASC') echo ' selected';?>">Data Asc</a></li>
			<li><a href="?p=<?=$p.$pag.$letter?>&orderby=<?=$var['pre'].'_data'?> DESC"<?php if($orderby==$var['pre'].'_data DESC') echo ' selected';?>">Data Dec</a></li>
			<li><a href="?p=<?=$p.$pag.$letter?>&orderby=<?=$var['pre'].'_titulo'?> ASC"<?php if($orderby==$var['pre'].'_titulo ASC') echo ' selected';?>">Título Asc</a></li>
			<li><a href="?p=<?=$p.$pag.$letter?>&orderby=<?=$var['pre'].'_titulo'?> DESC"<?php if($orderby==$var['pre'].'_titulo DESC') echo ' selected';?>">Título Desc</a></li>
		  </ul>
		</div>

	</div>


</div>
<div align=left>
		<form name='search' action='<?=$_SERVER['PHP_SELF']?>' method='get' class='form form-horizontal'>
			<input type='hidden' name='p' value='<?=$p?>'/>
			<input type='text' name='q' class='input-large' placeholder='Título ou Descrição' value='<?=isset($_GET['q']) ? $_GET['q'] : null?>'>
			<input type='submit' value='search' class='btn btn-primary'>
			<!--
			<div style='float:right;'>
				<a href='<?=$var['path']?>/helper/xls.php' target='_blank' class='btn btn-mini'>Exportar Excel</a>
			</div>
			-->

		</form>
</div>
<table class="table table-condensed table-striped">
   <thead>
      <tr>
        <th width="120px">Dono</th>
        <th width="120px">Grupo Qui.</th>
        <th width="120px">Fabricante</th>
        <th>Título</th>
      </tr>
   </thead>
   <tbody>
<?php

    $j=0;

    while ($qry->fetch()) {

$delete_images = "&prefix={$var['path']}&pre={$var['pre']}&col=imagem&folder=${var['imagem_folderlist']}";
$statusOnLabel = "<font color=#000000>Ativo</font>";
$statusOnIcon = "<i class=icon-eye-open></i> ";
$statusOffLabel =  "<font color=#999999>Inativo</font>";
$statusOffIcon = "<i class=icon-eye-close></i> ";
$altStatus = '{"ativo": "'.$statusOnIcon.$statusOnLabel.'", "inativo": "'.$statusOffIcon.$statusOffLabel.'"}';

if ($status==1)
	$descStatus = $statusOnIcon.$statusOnLabel;
else
	$descStatus = $statusOffIcon.$statusOffLabel;

$row_actions = <<<end
		<div class="btn-group">
          <a class="btn btn-mini" href="javascript:void(0);"><i class="icon-cog"></i></a>
          <a class="btn btn-mini dropdown-toggle" data-toggle="dropdown" href="javascript:void(0);" style='line-height:15px;'><span class="caret"></span></a>
          <ul class="dropdown-menu">
            <li><a href="?p=$p&update&item=$id" class='tip' title='Click to edit'><i class="icon-pencil"></i> Editar</a></li>
			<li><a href="?p=$p&status&item=$id&noVisual" class='tip status status$id'  alt='{$altStatus}' title='Click to change for block or visible' id='$id' name='$titulo'>{$descStatus}</a></li>
          </ul>
		</div>
end;




?>
	<div class="modal fade" id="rm-modal<?=$id?>">
		<div class="modal-header">
			<a class="close" data-dismiss="modal">×</a>
			<h3>Remover</h3>
		</div>
		<div class="modal-body">
		<p>Deseja remover <b><?=$titulo?></b>?<div class='alert alert-warning small'>O item será removido permanentemente!</div></p>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0);" class="btn" data-dismiss='modal'>Cancelar</a>
			<a href="index.php?p=<?=$p?>&delete&item=<?=$id?>&noVisual<?=$delete_images?>" id='<?=$id?>' class="btn-rm btn btn-danger btn-primary">Remover</a>
		</div>
	</div>
	<tr id="tr<?=$id?>">
		<td>
			<?=$nome?>
		</td>
		<td>
			<?=$grupoquimico?>
		</td>
		<td>
			<?=$fabricante?>
		</td>
		<td>
			<?php if (!empty($codigo)) echo "<span class='label'>{$codigo}</span>"; ?>
			<?=$titulo?>
			<?php
				echo "<blockquote>";
				if (!empty($valor)) echo 'Valor total R$ '.Moeda($valor).'<br/>';
				if (!empty($valor_unidade)) echo 'Valor/Unidade R$ '.Moeda($valor_unidade).'<br/>';
				if (!empty($qtd)) echo 'Total de unidades '.$qtd.'<br/>';
				if (!empty($peso_unidade)) echo 'Peso por unidade '.$peso_unidade.' '.$unidade_medida.'<br/>';
				echo "</blockquote>";
			?>
			<?=$row_actions?>
		</td>
		<!--
		<td align=center>
			<a href="?p=<?=$p?>&principal&item=<?=$id?>&noVisual" class='tip principal principal<?=$id?>' title='Clique para alterar para vídeo principal ou não principal' id='<?=$id?>' name='<?=$title?>'><?=$principal==1?'Sim':'Não'?></a>
		</td>
		-->
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
	      echo "  <a href='${nav_nexturl}' class='${nav_nextclass}navbar more'>Mais</a>";
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
