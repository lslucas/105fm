<?php

  foreach($_GET as $chave=>$valor) {
   $res[$chave] = $valor;
  }

 $col = isset($_GET['status']) ? 'status' : (isset($_GET['destaque']) ? 'destaque' :  (isset($_GET['principal']) ? 'principal' :  null));
 $sql_guarda = "SELECT ${var['pre']}_titulo, ${var['pre']}_{$col} FROM ".TABLE_PREFIX."_${var['path']}";
 $sql_guarda.= " WHERE ${var['pre']}_id=?";
 if (!$qry_guarda = $conn->prepare($sql_guarda))
	 echo $conn->error;

 else {

	 $qry_guarda->bind_param('i', $res['item']);
	 $ok = $qry_guarda->execute()==true?true:false;
	 $num = $qry_guarda->num_rows();
	 $qry_guarda->bind_result($nome,$status);
	 $qry_guarda->fetch();
	 $qry_guarda->close();


	 if ($ok) {

		 $novoStatus  = $status==1?0:1;

		 if (isset($_GET['status']))
			 $novoStatusT = $status==1?'Bloqueado':'Ativo';
		 elseif (isset($_GET['destaque']))
			 $novoStatusT = $status==1?'Marcando como não destaque':'Marcado como destaque';
		 elseif (isset($_GET['principal']))
			 $novoStatusT = $status==1?'NÃO Principal':'Principal';


		 if (isset($_GET['destaque'])) {
			 $sql_pre  = "UPDATE ".TABLE_PREFIX."_${var['path']} SET ${var['pre']}_{$col}=0";
			 $sql_pre .= " WHERE ${var['pre']}_id=?";
			 if ($qry_pre  = $conn->prepare($sql_pre)) {
				 $qry_pre->bind_param('s', $res['item']);
				 $qry_pre->execute();
				 $qry_pre->close();
			 }
		 }

/*
		 if (isset($_GET['principal'])) {
			 $sql_pre  = "UPDATE ".TABLE_PREFIX."_${var['path']} SET ${var['pre']}_{$col}=0";
			 $sql_pre .= " WHERE ${var['pre']}_id=?";
			 if ($qry_pre  = $conn->prepare($sql_pre)) {
				 $qry_pre->bind_param('s', $res['item']);
				 $qry_pre->execute();
				 $qry_pre->close();
			 }
		 }
		 */


		 $sql_status  = "UPDATE ".TABLE_PREFIX."_${var['path']} SET ${var['pre']}_{$col}=${novoStatus}";
		 $sql_status .= " WHERE ${var['pre']}_id=?";
		 $qry_status  = $conn->prepare($sql_status);
		 $qry_status->bind_param('s', $res['item']);

			 if ($qry_status->execute()) {

				/*
				 *log
				 */
				 if (isset($_GET['status']))
					 $acao = 'Status: '.$novoStatusT;
				 elseif (isset($_GET['destaque']))
					 $acao = 'Destaque: '.$novoStatusT;
				 elseif (isset($_GET['principal']))
					 $acao = 'Principal: '.$novoStatusT;
				 $antes = $col." = {$status}";
				 $depois = $col." = {$novoStatus}";
				 logextended($acao, $p, array('antes'=>$antes, 'depois'=>$depois, 'log_id'=>$log_id));


				echo "<b>${nome}</b> agora está <b>${novoStatusT}</b>";
		 }

	   $qry_status->close();

	 }


 }