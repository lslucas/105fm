<?php
  
  foreach($_GET as $chave=>$valor) {
   $res[$chave] = $valor;
  }

 $col = 'destaque';
 //$col = isset($_GET['principal']) ? 'principal' : (isset($_GET['fraude']) ? 'fraude' :  (isset($_GET['contactado']) ? 'contactado' :  null));
 $sql_guarda = "SELECT ${var['pre']}_titulo, ${var['pre']}_{$col} FROM ".TABLE_PREFIX."_${var['path']}";
 $sql_guarda.= " WHERE ${var['pre']}_id=?";
 if (!$qry_guarda = $conn->prepare($sql_guarda))
     echo $conn->error;

 else {

     $qry_guarda->bind_param('i', $res['item']); 
     $ok = $qry_guarda->execute()==true?true:false;
     $num = $qry_guarda->num_rows();
     $qry_guarda->bind_result($nome,$principal); 
     $qry_guarda->fetch(); 
     $qry_guarda->close();


     if ($ok) {

         $novoprincipal  = $principal==1?0:1;

         if (isset($_GET['principal']))
             $novoprincipalT = $principal==1?'Não Destaque':'Destaque';

         $sql_principal  = "UPDATE ".TABLE_PREFIX."_${var['path']} SET ${var['pre']}_{$col}=${novoprincipal}";
         $sql_principal .= " WHERE ${var['pre']}_id=?";
         $qry_principal  = $conn->prepare($sql_principal);
         $qry_principal->bind_param('s', $res['item']); 

             if ($qry_principal->execute()) {

                /*
                 *log
                 */
                 if (isset($_GET['principal'])) 
                     $acao = 'Marcando como : '.$novoprincipalT;
                 elseif (isset($_GET['fraude'])) 
                     $acao = 'Fraude: '.$novoprincipalT;
                 elseif (isset($_GET['contactado'])) 
                     $acao = 'Contactado: '.$novoprincipalT;
                 $antes = $col." = {$principal}";
                 $depois = $col." = {$novoprincipal}";
                 logextended($acao, $p, array('antes'=>$antes, 'depois'=>$depois, 'log_id'=>$log_id));


                echo "<b>${nome}</b> agora está <b>${novoprincipalT}</b>";
         }

       $qry_principal->close();

     }


 }
