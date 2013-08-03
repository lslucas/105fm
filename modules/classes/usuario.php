<?php

include_once 'modules/classes/mail.php';

class Usuario extends Mail {

    public function __construct()
    {
        $this->_timestart = microtime(true); //benchmark
        $this->_args = array();
        $args  = array();
    }

    private function validaParametrosBasico($action)
    {
        global $usr, $hashids;

        if (isset($usr) && !empty($usr) && empty($this->_args['email'])) {
            $this->_args['email'] = $usr['email'];
            // $this->_args['confirmaEmail'] = $usr['email'];
        }

        $args = $this->_args;
        if (!is_array($args))
            exit(__FUNCTION__.' Parâmetros inválidos!');

        $return = null;


        if (!isset($args['nome']) || empty($args['nome']))
            $return .= '<li>Preencha seu nome</li>';
        if ($action!='atualiza' && (empty($args['email']) || !validaEmail($args['email'])))
            $return .= '<li>Entre com um email válido!</li>';
        // if (!empty($args['email']) && $args['email']<>$args['confirmaEmail'])
            // $return .= '<li>Confirmação de Email inválido!</li>';
        if (!isset($args['nascimento']) || empty($args['nascimento']))
            $return .= '<li>Informe sua data de nascimento</li>';
        if (!isset($args['sexo']) || empty($args['sexo']))
            $return .= '<li>Informe seu sexo</li>';
        if (!isset($args['cep']) || empty($args['cep']))
            $return .= '<li>Informe seu CEP</li>';
        if (!isset($args['endereco']) || empty($args['endereco']))
            $return .= '<li>Informe seu Endereço</li>';
        if (!isset($args['numero']) || empty($args['numero']))
            $return .= '<li>Informe o número de sua residência</li>';
        if (!isset($args['bairro']) || empty($args['bairro']))
            $return .= '<li>Informe o bairro de sua residência</li>';
        if (!isset($args['cidade']) || empty($args['cidade']))
            $return .= '<li>Informe a cidade de sua residência</li>';
        if (!isset($args['uf']) || empty($args['uf']))
            $return .= '<li>Informe o UF (estado) de sua residência</li>';
        if (!isset($args['telefone']) || empty($args['telefone']))
            $return .= '<li>Informe ao menos um telefone para contato</li>';
        // if (empty($args['cpf']) || !validaCPF($args['cpf']))
            // $return .= '<li>Entre com um CPF válido</li>';
        if ($action!='atualiza' && (empty($args['senha']) || strlen($args['senha'])<6))
            $return .= '<li>Entre com uma senha válida com 6 caracteres ou mais! Sua senha possui '.strlen($args['senha']).' caracteres</li>';
        if (!empty($args['senha']) && $args['senha']<>$args['confirmaSenha'])
            $return .= '<li>Confirmação de senha Inválida</li>';

        // if (empty($args['nascimento']) || !validaNascimento($nasc_ano, $nasc_mes, $nasc_dia))
            // $return .= '<li>Preencha sua data de nascimento</li>';
        // elseif ($idade<18)
            // $return .= '<li>Ops, você precisa ter mais de 18 anos para se registrar!</li>';

        // $this->_args['newsletter'] = !isset($this->_args['newsletter']) ? 0 : $this->_args['newsletter'];
        if (isset($this->_args['id']) && !empty($this->_args['id']) && !is_numeric($this->_args['id'])) {
            $id = $hashids->decrypt($this->_args['id']);
            $this->_args['id'] = $id[0];
        }

        if (empty($return))
            return true;
        else return $this->trataHtmlErros($return);
    }

    private function validaParametros($action)
    {
        $args = $this->_args;
        return $this->validaParametrosBasico($action);
    }

    private function trataHtmlErros($return)
    {
        $html = "<ul class='unstyled'>";
        $html .= $return;
        $html .= "</ul>";
        return $html;
    }

    public function validaCadastroAjax($args)
    {
        $this->_args = $args;
        $return  = true;
        if ($this->emailExists($args['email']))
            $return = array('email'=>'Email já está cadatrado!');
        // if ($this->cpfExists($args['cpf']))
            // $return = array('cpf'=>'CPF já está cadatrado!');
        return $return;
    }

    public function novoCadastro($args)
    {

        $this->_args = $args;
        $res = $this->validaParametros('insere');
        if ($res === true) {

            if ($this->validaCadastro()) {

                if ($this->gravaCadastro())
                    $return['success'] = array('text'=>'Cadastrado com sucesso!', 'cols'=>array('id'=>$this->getIdByEmail($this->_args['email'])));
                else
                    $return['error'] = array('text'=>'Houve algum problema!');

            } else $return['error'] = array('text'=>'Email já está cadatrado!');

        } else
            $return['error'] = array('text'=>$res);

        return $return;
    }

    public function atualizaCadastro($args)
    {

        $this->_args = $args;
        $res = $this->validaParametros('atualiza');
        if ($res === true) {

            if ($this->validaCadastro()) {

                if ($this->updateCadastro())
                    $return['success'] = array('text'=>'Atualizado com sucesso!', 'cols'=>array('id'=>$this->getIdByEmail($this->_args['email'])));
                else
                    $return['error'] = array('text'=>'Houve algum problema!');

            } else $return['error'] = array('text'=>'Email já existe cadastrado!');

        } else
            $return['error'] = array('text'=>$res);

        return $return;
    }

    /**
     * Valida se email existe
     * @return bool
     */
    public function emailExists($eml)
    {
        global $conn, $hashids;

        $sufix = null;
        if (!empty($this->_args['id'])) {
            $id = $hashids->decrypt($this->_args['id']);
            $id = $id[0];
            $sufix = " AND `usr_id`<>".$id;
        }

        $sql = "SELECT SQL_CACHE NULL FROM `".TABLE_PREFIX."_usuario` WHERE `usr_email`=\"{$eml}\" {$sufix}";
        $res = $conn->query($sql);
        $num = $res->num_rows;

        if ($num>0) return true;
        else return false;
    }

    /**
     * Valida se cpf existe
     * @return bool
     */
    public function cpfExists($cpf)
    {
        global $conn, $hashids;

        $sufix = null;
        if (!empty($this->_args['id'])) {
            $id = $hashids->decrypt($this->_args['id']);
            $id = $id[0];
            $sufix = " AND `usr_id`<>".$id;
        }

        $sql = "SELECT SQL_CACHE NULL FROM `".TABLE_PREFIX."_usuario` WHERE `usr_cpf`=\"{$cpf}\" {$sufix}";
        $res = $conn->query($sql);
        $num = $res->num_rows;

        if ($num>0) return true;
        else return false;
    }

    /**
     * Valida se cadastro [cpf] já existe
     * @return bool
     */
    private function validaCadastro()
    {
        global $conn, $hashids;


        $sufix = null;
        if (!empty($this->_args['id'])) {
            if (!is_numeric($this->_args['id'])) {
                $id = $hashids->decrypt($this->_args['id']);
                $id = $id[0];
            } else
                $id = $this->_args['id'];

            $sufix = " AND `usr_id`<>".$id;
        }

        $sql = "SELECT SQL_CACHE NULL FROM `".TABLE_PREFIX."_usuario` WHERE (`usr_email`=\"{$this->_args['email']}\" ) {$sufix}";
        $res = $conn->query($sql);
        $num = $res->num_rows;

        if ($num>0) return false;
        else return true;
    }

    private function gravaCadastro()
    {
        return $this->gravaCadastroBasico();
    }

    private function gravaCadastroBasico()
    {
        global $conn, $aes;

        if ($this->validaCadastro()) {

            $sqlins = "INSERT INTO `".TP."_usuario`
                            (
                             `usr_nome`,
                             `usr_email`,
                             `usr_senha`,
                             `usr_nascimento`,
                             `usr_sexo`,
                             `usr_cep`,
                             `usr_endereco`,
                             `usr_numero`,
                             `usr_complemento`,
                             `usr_bairro`,
                             `usr_cidade`,
                             `usr_uf`,
                             `usr_telefone`,
                             `usr_ip`
                             ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";
            if (!$qryins = $conn->prepare($sqlins))
                return false;

            else {
                $senhaEncrypted = $aes->encrypt($this->_args['senha']);
                $qryins->bind_param('ssssssssssssss',
                                        $this->_args['nome'],
                                        $this->_args['email'],
                                        $senhaEncrypted,
                                        $this->_args['nascimento'],
                                        $this->_args['sexo'],
                                        $this->_args['cep'],
                                        $this->_args['endereco'],
                                        $this->_args['numero'],
                                        $this->_args['complemento'],
                                        $this->_args['bairro'],
                                        $this->_args['cidade'],
                                        $this->_args['estado'],
                                        $this->_args['telefone'],
                                        $_SERVER['REMOTE_ADDR']
                                    );
                $qryins->execute();
                $qryins->close();

                // $this->fileUpload();
                return true;
            }

        } else return false;
    }

    private function updateCadastro()
    {
        return $this->updateCadastroBasico();
    }

    private function updateCadastroBasico()
    {
        global $conn, $aes, $hashids, $usr;

        if (!is_numeric($this->_args['id'])) {
            $id = $hashids->decrypt($this->_args['id']);
            $id = $id[0];
        } else
            $id = $this->_args['id'];

        $sqlupd = "UPDATE `".TP."_usuario`
                        SET
                             `usr_nome`=?,
                             `usr_nascimento`=?,
                             `usr_sexo`=?,
                             `usr_cep`=?,
                             `usr_endereco`=?,
                             `usr_numero`=?,
                             `usr_complemento`=?,
                             `usr_bairro`=?,
                             `usr_cidade`=?,
                             `usr_uf`=?,
                             `usr_telefone`=?,
                             `usr_ip`=?
                         WHERE `usr_id`=?";
        if (!$qryupd = $conn->prepare($sqlupd))
            return false;

        else {

            $qryupd->bind_param('sssssssssssss',
                                    $this->_args['nome'],
                                    $this->_args['nascimento'],
                                    $this->_args['sexo'],
                                    $this->_args['cep'],
                                    $this->_args['endereco'],
                                    $this->_args['numero'],
                                    $this->_args['complemento'],
                                    $this->_args['bairro'],
                                    $this->_args['cidade'],
                                    $this->_args['uf'],
                                    $this->_args['telefone'],
                                    $_SERVER['REMOTE_ADDR'],
                                    $id
                                );
            $qryupd->execute();
            $qryupd->close();


            /**
             * Se foi preenchido a senha
             */
            if (!empty($this->_args['senha'])) {
                $senhaEncrypted = $aes->encrypt($this->_args['senha']);
                $sqlpass = "UPDATE `".TP."_usuario` SET `usr_senha`=? WHERE `usr_id`=?";
                if (!$qrypass = $conn->prepare($sqlpass))
                    return false;
                else {
                    $qrypass->bind_param('si', $senhaEncrypted, $id);
                    $qrypass->execute();
                    $qrypass->close();
                }

                $pass = $this->_args['senha'];
            } else
                $pass = $aes->decrypt($usr['senha']);


            /**
             * Se email foi preenchido
             */
            if (!empty($this->_args['email'])) {
                $sqleml = "UPDATE `".TP."_usuario` SET `usr_email`=? WHERE `usr_id`=?";
                if (!$qryeml = $conn->prepare($sqleml))
                    return false;
                else {
                    $qryeml->bind_param('si', $this->_args['email'], $id);
                    $qryeml->execute();
                    $qryeml->close();
                }

                $login = $this->_args['email'];
            }

            $this->login($login, $pass);
            return true;
        }
    }

    private function fileUpload()
    {
        global $conn, $_FILES, $var;

        if (isset($_FILES['foto'])) {
            include_once "admin/_inc/class.upload.php";

            $handle = new Upload($_FILES['foto']);
            $filename = linkfy($_FILES['foto']['name'].'_'.time());

            if ($handle->uploaded) {
                $handle->file_new_name_body  = $filename;
                $handle->Process($var['pathOriginal']);
                #$handle->jpeg_quality        = 90;
                if (!$handle->processed) echo 'error : ' . $handle->error;

                $handle->file_new_name_body  = $filename;
                if ($handle->image_x>$var['imagemWidth'] || $handle->image_y>$var['imagemHeight']) {
                    $handle->image_resize        = true;
                    $handle->image_ratio          = true;
                    // $handle->image_ratio_crop     = true;
                    $handle->image_ratio_no_zoom_out = true;
                    $handle->image_x            = $var['imagemWidth'];
                    $handle->image_y            = $var['imagemHeight'];
                }
                $handle->jpeg_quality            = 90;
                $handle->process($var['pathImagem']);
                if (!$handle->processed) echo 'error : ' . $handle->error;

                $imagem = $handle->file_dst_name;

                $sql = "UPDATE `".TABLE_PREFIX."_usuario` SET `usr_logo`='{$imagem}' WHERE `usr_id`=\"{$this->_args['id']}\"";
                $res = $conn->query($sql);
            }
        }

    }

    /**
     * Resgata id do usuário
     * @return bool
     */
    public function getIdByEmail($eml)
    {
        global $conn;

        $sql = "SELECT usr_id FROM `".TP."_usuario` WHERE `usr_email`=?;";
        if (!$res = $conn->prepare($sql))
            echo __FUNCTION__.$conn->error;
        else {
            $res->bind_param('s', $eml);
            $res->bind_result($id);
            $res->execute();
            $res->fetch();
            $res->close();
        }

        if (!empty($id)) return $id;
        else return false;
    }

    /**
     * Dados básico do usuário
     * @return bool
     */
    public function getBasicInfoById($id)
    {
        global $conn, $hashids;

        if (!is_numeric($id)) {
            $id = $hashids->decrypt($id);
            $id = $id[0];
        }

        $sql = "SELECT
                     `usr_id`,
                     `usr_nome`,
                     `usr_email`,
                     `usr_senha`,
                     `usr_nascimento`,
                     `usr_sexo`,
                     `usr_cep`,
                     `usr_endereco`,
                     `usr_numero`,
                     `usr_complemento`,
                     `usr_bairro`,
                     `usr_cidade`,
                     `usr_uf`,
                     `usr_telefone`,
                     `usr_ip`,
                     DATE_FORMAT(`usr_nascimento`, '%d/%m/%Y')
                    FROM `".TP."_usuario`
                    WHERE `usr_id`=?;";
        if (!$res = $conn->prepare($sql))
            echo __FUNCTION__.$conn->error;
        else {

            $res->bind_param('i', $id);
            $res->bind_result($usr_id, $nome, $email, $senha, $nascimento, $sexo, $cep, $endereco,  $numero, $complemento, $bairro, $cidade, $uf, $telefone, $ip, $nascimento_pt);
            $res->execute();
            $res->fetch();
            $res->close();

            if (!empty($id)) {

                if (!empty($nascimento_pt))
                    list($nasc_dia, $nasc_mes, $nasc_ano) = explode('/', $nascimento_pt);
                else
                    $nasc_dia = $nasc_mes = $nasc_ano = null;

                $usr = array(
                         'id'=>$hashids->encrypt($usr_id),
                         'nome'=>$nome,
                         'email'=>$email,
                         'sexo'=>$sexo,
                         'telefone'=>$telefone,
                         'nascimentoEn'=>$nascimento,
                         'nascimento'=>$nascimento_pt,
                         'nasc_dia'=>$nasc_dia,
                         'nasc_mes'=>$nasc_mes,
                         'nasc_ano'=>$nasc_ano,
                         'endereco'=>$endereco,
                         'numero'=>$numero,
                         'complemento'=>$complemento,
                         'cidade'=>$cidade,
                         'uf'=>$uf,
                         'cep'=>$cep,
                     );

                return $usr;

            } else
                return false;
        }

    }

    /**
     * Faz login
     * @return bool
     */
    public function login($eml, $pass)
    {
        global $conn, $hashids, $aes;

        $sql = "SELECT usr_id FROM `".TP."_usuario` WHERE `usr_email`=? AND `usr_senha`=?;";
        if (!$res = $conn->prepare($sql))
            echo __FUNCTION__.$conn->error;
        else {

            $senha = $aes->encrypt($pass);
            $res->bind_param('ss', $eml, $senha);
            $res->bind_result($id);
            $res->execute();
            $res->fetch();
            $res->close();

            if (!empty($id)) {
                session_cache_limiter('private');

                if (isset($this->_args['remember-me']))
                    session_cache_expire(10080);
                else
                    session_cache_expire(120);

                $usr = $this->getBasicInfoById($id);
                $usr['senha'] = $senha;
                $_SESSION[TP]['usr'] = $usr;

                if ($this->updateUltimoLogin())
                    return true;

            } else
                return false;
        }

    }

    /**
     * Atualiza ultimo login
     * @return bool
     */
    public function zerarSenha($eml)
    {
        global $conn, $hashids, $aes;

        if (!$this->emailExists($eml))
            $return = array('alert'=>'Email não está cadastrado!');
        else {

            $time   = time();
            $cadId = $this->getIdByEmail($eml);

            $return = false;
            $sql = "UPDATE `".TP."_usuario` SET usr_zerasenhaTime=? WHERE `usr_email`=?;";
            if (!$res = $conn->prepare($sql))
                echo __FUNCTION__.$conn->error;
            else {
                $res->bind_param('ss', $time, $eml);
                $res->execute();
                $res->close();

                $usr= $this->getBasicInfoById($cadId);
                $usr['url'] = SITE_URL."/redefinicao-senha/{$time}";

                $token = time();
                $usr['novaSenha'] = $hashids->encrypt($token);
                $this->mudarSenha($token, $usr['novaSenha']);
                $mail = new Mail();
                return $mail->zerarSenha($usr);
            }

        }

        return $return;
    }

    /**
     * Atualiza senha
     * @return bool
     */
    public function mudarSenha($token, $senha)
    {
        global $conn, $hashids, $aes;

        $time   = time();
        $senhaEncrypted = $aes->encrypt($senha);

        $return = false;
        $sql = "UPDATE `".TP."_usuario` SET usr_senha=?, usr_zerasenhaTime=NULL WHERE `usr_zerasenhaTime`=?;";
        if (!$res = $conn->prepare($sql))
            echo __FUNCTION__.$conn->error;
        else {
            $res->bind_param('ss', $senhaEncrypted, $token);
            $res->execute();
            $res->close();

            $return = true;
        }

        return $return;
    }

    /**
     * Valida token da redefinicao de senha
     * @return bool
     */
    public function validaToken($token)
    {
        global $conn;

        $sql = "SELECT SQL_CACHE NULL FROM `".TABLE_PREFIX."_usuario` WHERE `usr_zerasenhaTime`=\"{$token}\"";
        $res = $conn->query($sql);
        $num = $res->num_rows;

        if ($num>0) return true;
        else return false;
    }

    /**
     * Atualiza ultimo login
     * @return bool
     */
    public function updateUltimoLogin()
    {
        global $conn, $hashids;

        $id = $hashids->decrypt($_SESSION[TP]['usr']['id']);
        $id = $id[0];

        $sql = "UPDATE `".TP."_usuario` SET usr_ultimo_login=NOW() WHERE `usr_id`=?;";
        if (!$res = $conn->prepare($sql))
            echo __FUNCTION__.$conn->error;
        else {
            $res->bind_param('i', $id);
            $res->execute();
            $res->close();
        }

        if (!empty($id)) return $id;
        else return false;
    }

}