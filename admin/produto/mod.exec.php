<?php

  foreach($_POST as $chave=>$valor) {
   $res[$chave] = $valor;
  }


# include de mensagens do arquivo atual
include_once 'inc.exec.msg.php';


 ## verifica se existe um titulo/nome/email com o mesmo nome do que esta sendo inserido
 $sql_valida = "SELECT ${var['pre']}_codigo retorno FROM ".TABLE_PREFIX."_${var['table']} WHERE ${var['pre']}_codigo=?";
 $qry_valida = $conn->prepare($sql_valida);
 $qry_valida->bind_param('s', $res['codigo']);
 $qry_valida->execute();
 $qry_valida->store_result();

  #se existe um titulo/nome/email assim nao passa
  if ($qry_valida->num_rows<>0 && $act=='insert') {
   echo $msgDuplicado;
   $qry_valida->close();


  #se nao existe faz a inserção
  } else {

     #autoinsert
     include_once $rp.'inc.autoinsert.php';

     $sql= "UPDATE ".TP."_${var['table']} SET
        ${var['pre']}_codigo=?,
        ${var['pre']}_fabricante=?,
        ${var['pre']}_grupoquimico=?,
        ${var['pre']}_tipo=?,
        ${var['pre']}_titulo=?,
        ${var['pre']}_descricao=?,
        ${var['pre']}_valor=?,
        ${var['pre']}_valor_unidade=?,
        ${var['pre']}_peso_unidade=?,
        ${var['pre']}_unidade_medida=?
        ";
     $sql.=" WHERE ${var['pre']}_id=?";
   if (!$qry=$conn->prepare($sql))
     echo divAlert($conn->error);

   else {

    // $res['titulo'] = mysql_real_escape_string($res['titulo']);
    $res['valor'] = !empty($res['valor']) ? Currency2Decimal($res['valor'], 1) : null;
    $res['valor_unidade'] = !empty($res['valor_unidade']) ? Currency2Decimal($res['valor_unidade'], 1) : null;
    $qry->bind_param('siiissdddii',
      $res['codigo'],
      $res['fabricante'],
      $res['grupoquimico'],
      $res['tipo'],
      $res['titulo'],
      $res['descricao'],
      $res['valor'],
      $res['valor_unidade'],
      $res['peso_unidade'],
      $res['unidade_medida'],
      $res['item']
    );
    $qry->execute();
    $qry->close();

    echo $msgSucesso;
    include_once 'helper/exec.galeria.php';//photos
    include_once 'helper/exec.taxonomy.php';//taxonomy

    //list
    include_once 'list.php';
   }

 }