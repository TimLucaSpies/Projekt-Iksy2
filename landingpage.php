<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link = DbFunctions::connectWithDatabase();

// Kommende Spiele laden
$spiele = TicketEntity::holeAktiveSpiele($link);

$smarty->assign('spiele', $spiele);
$smarty->assign('seitentitel', 'Willkommen');

$smarty->display('landingpage.tpl');
?>
