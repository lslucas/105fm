<?php

    if (in_array($basename, array('participar', 'login', 'esqueci-senha')) && (isset($usr) && !empty($usr['id'])))
        header('Location: '.ABSPATH.'participacao');
    // else
        // header('Location: '.ABSPATH.'login');
    // if (!in_array($basename, array('cadastrar', 'participar', 'login', 'esqueci-senha')) && (!isset($usr) || empty($usr['id'])))
        // header('Location: '.ABSPATH.'login');

    include_once 'modules/classes/usuario.php';

    $msg = $msgTitle = $res = null;
    $usuario = new Usuario();
    $val = array();

    if(isset($_POST['from'])) {
        foreach ($_POST as $key=>$value)
            $val[$key] = trim($value);
    }

    /**
     * Cadastra usuário
     */
    if ($basename=='cadastro') {
        if(isset($val['from']) && $val['from']=='cadastro')
            include_once 'registrar/insert.php';
    }

    /**
     * Faz login
     */
    if ($basename=='login') {
        if(isset($val['from']) && $val['from']=='login')
            include_once 'login/header.php';
    }

    /**
     *  POST do esqueci a senha
     * */
    if ($basename=='esqueci-senha') {
        if(isset($val['from']) && $val['from']=='esqueci-senha')
            include_once 'esqueci-senha/header.php';
    }

    /**
     * Meus dados //edicao de usuário
     */
    if ($basename=='meus-dados') {
        if(isset($val['from']) && $val['from']=='meus-dados')
            include_once 'registrar/update.php';
        else {
                $val = $usuario->getBasicInfoById($usr['id']);
            unset($val['email']);
        }
    }

    /**
     * Fecha sessao
     */
    if ($basename=='sair' || $basename=='logout')
        include_once 'logout/header.php';
