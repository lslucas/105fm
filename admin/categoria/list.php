<?php

  /*
   *quarda marcas
   */
  $sql_marcas = "SELECT cat_titulo, cat_id FROM ".TABLE_PREFIX."_categoria WHERE cat_area='Marca'";
  $qry_marcas = $conn->prepare($sql_marcas);
  $qry_marcas->bind_result($nome, $id);
  $qry_marcas->execute();
  $marcas = array();

	  while ($qry_marcas->fetch()) {
		  $marcas[$id] = $nome;
	  }

  $qry_marcas->close();


//filtro
$whr = isset($_GET['a'])?$_GET['a']:'';
$where    = !empty($whr)
	  ? " WHERE ${var['pre']}_area='{$whr}'"
	  : " ";



$sql = "SELECT  ${var['pre']}_id,
		${var['pre']}_titulo,
		${var['pre']}_area,
		${var['pre']}_idrel,
		${var['pre']}_status,
		(SELECT rcg_imagem FROM ".TABLE_PREFIX."_r_${var['pre']}_galeria WHERE rcg_${var['pre']}_id=${var['pre']}_id ORDER BY rcg_pos DESC LIMIT 1) imagem

		FROM ".TABLE_PREFIX."_${var['path']}
	  {$where}
		ORDER BY cat_area, cat_titulo ASC";

 if (!$qry = $conn->prepare($sql)) {
  echo 'Houve algum erro durante a execução da consulta<p class="code">'.$sql.'</p><hr>';

  } else {

    $qry->execute();
    $qry->bind_result($id, $nome, $area, $idrel, $status, $imagem);
	$qry->store_result();
	$total = $qry->num_rows;

    if($total==0) $total = 'no category';
    elseif ($total==1) $total = "1 category";
	else $total = $total.' category';
?>
<h1><?=$var['mono_plural']?></h1>
<p class='header'></p>
<div class='small' align='right'><?=$total?></div>
<table class="table table-condensed table-striped">
   <thead>
      <tr>
        <th width="100px">Area</th>
        <th style='min-width:120px;'>Nome</th>
      </tr>
   </thead>
   <tbody>
<?php

    $j=0;
    // Para cada resultado encontrado...
    while ($qry->fetch()) {

// $delete_images = "&prefix=r_${var['pre']}_galeria&pre=rcg&col=imagem&folder=${var['imagem_folderlist']}";
$delete_images = null;
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
            <li><a href="#rm-modal{$id}" class='tip' data-toggle='modal' title="Click to remove"><i class="icon-trash"></i> Remove</a></li>
			<li><a href="?p=$p&status&item=$id&noVisual" class='tip status status$id'  alt='{$altStatus}' title='Click to change for block or visible' id='$id' name='$nome'>{$descStatus}</a></li>
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
		<p>Deseja remover <b><?=$nome?></b>?<div class='alert alert-warning small'>Será removido permanentemente!</div></p>
		</div>
		<div class="modal-footer">
			<a href="javascript:void(0);" class="btn" data-dismiss='modal'>Cancelar</a>
			<a href="index.php?p=<?=$p?>&delete&item=<?=$id?>&noVisual<?=$delete_images?>" id='<?=$id?>' class="btn-rm btn btn-danger btn-primary">Remover</a>
		</div>
	</div>
	<tr id="tr<?=$id?>">
		<td>
			<?=$area?>
		</td>
		<td>
			<?=$nome?>
			<?=$row_actions?>
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

  }
