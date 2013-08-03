<?php

    if (isset($_POST['diasemana'])) {

       $sqldel = "DELETE FROM ".TABLE_PREFIX."_${var['table']}_semana WHERE pro_id=?";
       if ($qrydel = $conn->prepare($sqldel)) {
         $qrydel->bind_param('i',$res['item']);
         $qrydel->execute();
         $qrydel->close();
       }

      $sql= "INSERT INTO ".TABLE_PREFIX."_${var['table']}_semana (pro_id, pro_diasemana, pro_hora, pro_hora_fim) VALUES (?, ?, ?, ?)";
      $qry=$conn->prepare($sql);
      $qry->store_result();

       foreach ($_POST['diasemana'] as $int=>$diasemana) {
        if (empty($diasemana))
          continue;

           $hora = $_POST['hora'][$diasemana];
           $hora_fim = $_POST['hora_fim'][$diasemana];
           $qry->bind_param('iiss', $res['item'], $diasemana, $hora, $hora_fim);
           $qry->execute();
       }

       $qry->close();

}
