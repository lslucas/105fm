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
                        pa.ppa_arquivo `tamanho`,
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
                              $arquivo,
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
                $row[$position]['arquivo'] = $arquivo;
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
        // return utf8_decode(html_entity_decode($str));
        return '<td>'.html_entity_decode($str).'</td>';
      }

      # file name for download
      $filename = "105fm_".slugify($row[$id]['promocao'])."_".date('d-m-Y').".xls";

      header("Content-Disposition: attachment; filename=\"$filename\"");
      echo '<head> <meta http-equiv=Content-Type content="text/html; charset=utf-8"> </head>';
      header("Content-Type: application/vnd.ms-excel;");
      // header("Content-Type: application/vnd.ms-excel; charset=utf-8");


      echo "<table>";
      if(count($row)>0) {

            # display field/column names as first row
            echo "<tr>";
            echo "<th colspan=12><h1>".$row[$id]['promocao']."</h1></th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td><i>Gerado em ".date('d/m/Y H:i')."</i></td>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan=12>&nbsp;</td>";
            echo "</tr>";

            echo "<tr style='border:1px solid #EEE;'>";
            echo "<th>Nome</th>";
            echo "<th>Email</th>";
            echo "<th>CPF</th>";
            echo "<th>RG</th>";
            echo "<th>CEP</th>";
            echo "<th>Endereço</th>";
            echo "<th>Número</th>";
            echo "<th>Complemento</th>";
            echo "<th>Bairro</th>";
            echo "<th>Cidade/UF</th>";
            echo "<th>Telefone</th>";
            echo "<th>Resposta</th>";
            echo "<th>Campo 1</th>";
            echo "<th>Campo 2</th>";
            echo "<th>Arquivo</th>";
            echo "<th>Data/Hora Cadastro</th>";
            echo "</tr>";
            echo "<tr>";
            echo "<td colspan=12></td>";
            echo "</tr>";
           // }
            $i=$totalValor=0;
            foreach ($row as $id=>$arr) {
                echo "<tr style='border:1px solid #EEE;'>";
                $arquivo = empty($arr['arquivo']) || file_exists('storage/promocao/'.$arr['arquivo']) ? 'sem arquivo' : "<a href='http://radio105fm.com.br/storage/promocao/{$arr['arquivo']}'>{$arr['arquivo']}</a>";

                echo cleanData($arr['nome']);
                echo cleanData($arr['email']);
                echo cleanData($arr['cpf']);
                echo cleanData($arr['rg']);
                echo cleanData($arr['cep']);
                echo cleanData($arr['endereco']);
                echo cleanData($arr['numero']);
                echo cleanData($arr['complemento']);
                echo cleanData($arr['bairro']);
                echo cleanData($arr['cidade'].'/'.$arr['uf']);
                echo cleanData($arr['telefone']);
                echo cleanData($arr['resposta']);
                echo cleanData($arr['campo1']);
                echo cleanData($arr['campo2']);
                echo cleanData($arquivo);
                echo cleanData($arr['cadastro']);
                $totalValor++;

              echo "</tr>";
            }

            echo "<tr><td colspan=12></td></tr>";
            echo "<tr><td colspan=12></td></tr>";
            echo "<tr>".cleanData("Total de Cadastros até agora: {$totalValor}")."</tr>";
            echo "</table>";

      }



   }
