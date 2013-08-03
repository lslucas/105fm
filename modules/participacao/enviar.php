<?php

    $promo = isset($val['promocao']) ? $hashids->decrypt($val['promocao']) : null;
    $promo = $promo[0];
    if (empty($val['promocao']) && !empty($promo))
        $res['error']['texto'] .= 'Selecione uma promoção antes de continuar';
    elseif (!isset($usr['id']) || empty($usr['id']))
        $res['error']['texto'] .= 'Você deve estar logado para continuar!';
    elseif ($promo==10 && empty($val['campo1']))
            $res['error']['texto'] .= 'Preencha o Time';
    elseif ($promo==10 && empty($val['campo2']))
            $res['error']['texto'] .= 'Selecione o tamanho da camiseta';
    else {

            $sqlins = "INSERT INTO `".TP."_promocao_participante`
                            (
                             `ppa_usr_id`,
                             `ppa_pro_id`,
                             `ppa_texto`,
                             `ppa_campo1`,
                             `ppa_campo2`,
                             `ppa_campo3`,
                             `ppa_campo4`,
                             `ppa_campo5`,
                             `ppa_ip`,
                             `ppa_n`
                             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

            if (!$qryins = $conn->prepare($sqlins))
                echo $conn->error();
                // return false;

            else {

                $n = $aes->encrypt(md5(time()));
                $uid = $hashids->decrypt($usr['id']);
                $uid = $uid[0];

                $qryins->bind_param('iissssssss',
                                        $uid,
                                        $promo,
                                        $val['texto'],
                                        $val['campo1'],
                                        $val['campo2'],
                                        $val['campo3'],
                                        $val['campo4'],
                                        $val['campo5'],
                                        $_SERVER['REMOTE_ADDR'],
                                        $n
                                    );
                $qryins->execute();
                $qryins->close();

                if (isset($_FILES['arquivo'])) {
                    $imagem = fileUpload('arquivo', array('path'=>'storage/promocao'), $uid.'-'.$promo.'-'.date('ymdHis'));
                    $sql = "UPDATE `".TABLE_PREFIX."_promocao_participante` SET `ppa_arquivo`='{$imagem}' WHERE `ppa_n`=\"{$n}\"";
                    $res = $conn->query($sql);
                }

                $toScript = showModal(array('title'=>'Sucesso!', 'content'=>'Você agora está participando da promoção!'));
                $toJS = "alert('Você agora está participando da promoção!');";

            }

    }
