<?php
session_start();
require_once("includes/startTemplate.php");

$smarty->assign('seitentitel', 'Datenschutz');
$smarty->display('datenschutz.tpl');
?>
