<?php
session_start();
require_once("includes/startTemplate.php");

$smarty->assign('seitentitel', 'Impressum');
$smarty->display('impressum.tpl');
?>
