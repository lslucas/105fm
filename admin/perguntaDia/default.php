<?php
if (isset($_POST['act']))
  include_once 'mod.exec.php';
else if (isset($_GET['insert']) XOR isset($_GET['update']))
	include_once 'form/form.php';
elseif (isset($_GET['delete']))
	include_once 'mod.delete.php';
elseif (isset($_GET['delete_galeria']))
	include_once 'helper/del.galeria.php';
elseif (isset($_GET['status']))
	include_once 'helper/status.php';
elseif (isset($_GET['respostas']))
    include_once 'list.respostas.php';
else
	include_once 'list.php';
