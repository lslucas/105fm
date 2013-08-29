<?php

  include_once '../../_inc/global.php';
  include_once '../../_inc/db.php';
  include_once '../../_inc/global_function.php';

   /*
    *pega o nome da festa e verifica se ela existe
    */
    $row = array();
    $sql_cad = "SELECT
                        pro.pro_id,
                        pro.pro_titulo `Promoção`,
                        pa.ppa_texto `resposta`,
                        pa.ppa_campo1 `time`,
                        pa.ppa_campo2 `tamanho`,
                        DATE_FORMAT(pa.ppa_timestamp, '%d/%m/%Y %H:%i:%s') `data cadastro promoção`,

                        usr.usr_nome nome,
                        usr.usr_email email,
                        usr.usr_sexo sexo,
                        usr.usr_rg rg,
                        usr.usr_cpf cpf,
                        usr.usr_cep cep,
                        usr.usr_endereco endereco,
                        usr.usr_numero numero,
                        usr.usr_complemento complemento,
                        usr.usr_bairro bairro,
                        usr.usr_cidade cidade,
                        usr.usr_uf uf,
                        usr.usr_telefone telefone

                      from fm_promocao_participante pa
                      inner join fm_promocao pro
                        on pro.pro_id=pa.ppa_pro_id
                      inner join fm_usuario usr
                        on usr.usr_id=pa.ppa_usr_id

                      where pa.ppa_pro_id IS NOT NULL
                      AND pa.ppa_pro_id=?
                      GROUP BY usr.usr_id
                      order by pa.ppa_id DESC, pa.ppa_id DESC";

    if ($qry_cad = $conn->prepare($sql_cad)){

        $item = trim($_GET['item']);
        $qry_cad->bind_param('i', $item);
        $qry_cad->execute();
        $qry_cad->store_result();
        $qry_cad->bind_result(
                              $id,
                              $promo,
                              $resposta,
                              $campo1,
                              $campo2,
                              $cad_promo,
                              $nome,
                              $email,
                              $sexo,
                              $rg,
                              $cpf,
                              $cep,
                              $endereco,
                              $numero,
                              $complemento,
                              $bairro,
                              $cidade,
                              $uf,
                              $telefone
                              );
        $num = $qry_cad->num_rows;

            $position = 0;
            while($qry_cad->fetch()) {
                $row[$position]['id'] = $id;
                $row[$position]['promocao'] = $promo;
                $row[$position]['resposta'] = $resposta;
                $row[$position]['campo1'] = $campo1;
                $row[$position]['campo2'] = $campo2;
                $row[$position]['cadastro'] = $cad_promo;
                $row[$position]['nome'] = $nome;
                $row[$position]['email'] = $email;
                $row[$position]['sexo'] = $sexo;
                $row[$position]['rg'] = $rg;
                $row[$position]['cpf'] = $cpf;
                $row[$position]['cep'] = $cep;
                $row[$position]['endereco'] = $endereco;
                $row[$position]['numero'] = $numero;
                $row[$position]['complemento'] = $complemento;
                $row[$position]['bairro'] = $bairro;
                $row[$position]['cidade'] = $cidade;
                $row[$position]['uf'] = $uf;
                $row[$position]['telefone'] = $telefone;
                $position++;
            }

        $qry_cad->close();

    } else echo $qry_cad->error;

   if($num==0)
     die('Nenhum email na lista!');

   else {


      function cleanData($str) {
        $str = preg_replace("/\t/", "\\t", $str);
        $str = preg_replace("/\r?\n/", "\\n", $str);
        if(strstr($str, '"')) $str = '"' . str_replace('"', '""', $str) . '"';
        return html_entity_decode($str);
      }

      # file name for download
      $filename = "105fm_".slugify($row[$id]['promocao'])."_".date('d-m-Y').".xls";

      header("Content-Disposition: attachment; filename=\"$filename\"");
      header("Content-Type: application/vnd.ms-excel; charset=utf-8");


      if(count($row)>0) {

            # display field/column names as first row
            echo "105FM ".$row[$id]['promocao']."\n";
            echo "Gerado em ".date('d/m/Y H:i')."\n\n";

            echo "Nome\t";
            echo "Email\t";
            echo "CPF\t";
            echo "RG\t";
            echo "CEP\t";
            echo "Endereço\t";
            echo "Número\t";
            echo "Complemento\t";
            echo "Bairro\t";
            echo "Cidade/UF\t";
            echo "Telefone\t";
            echo "Resposta\t";
            echo "Campo 1\t";
            echo "Campo 2\t";
            echo "Data/Hora Cadastro\t";
            echo "\n";
           // }
            $i=$totalValor=0;
            foreach ($row as $id=>$arr) {

                echo cleanData($arr['nome'])."\t";
                echo cleanData($arr['email'])."\t";
                echo cleanData($arr['cpf'])."\t";
                echo cleanData($arr['rg'])."\t";
                echo cleanData($arr['cep'])."\t";
                echo cleanData($arr['endereco'])."\t";
                echo cleanData($arr['numero'])."\t";
                echo cleanData($arr['complemento'])."\t";
                echo cleanData($arr['bairro'])."\t";
                echo cleanData($arr['cidade'].'/'.$arr['uf'])."\t";
                echo cleanData($arr['telefone'])."\t";
                echo cleanData($arr['resposta'])."\t";
                echo cleanData($arr['campo1'])."\t";
                echo cleanData($arr['campo2'])."\t";
                echo "\n";
                $totalValor++;

            }

            echo "\n";
            echo "\n";
            echo cleanData("Total de Cadastros até agora: {$totalValor}")."\t";

      }



   }
