<?php

if (isset($_POST['act']))
  include_once 'mod.exec.php';
else if (isset($_GET['insert']) XOR isset($_GET['update']))
	include_once 'form/form.php';
elseif (isset($_GET['delete']))
	include_once 'mod.delete.php';
elseif (isset($_GET['delete_galeria']))
	include_once 'helper/del.galeria.php';
elseif (isset($_GET['principal']))
    include_once 'helper/exec.principal.php';
elseif (isset($_GET['status']))
	include_once 'helper/status.php';
else
	include_once 'list.php';
