<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link       = DbFunctions::connectWithDatabase();
$benutzerID = $_SESSION['benutzerID'];

$bestellungen = TicketEntity::holeBestellungenVonBenutzer($link, $benutzerID);

$smarty->assign('bestellungen', $bestellungen);
$smarty->assign('seitentitel',  'Meine Bestellungen');
$smarty->display('meine_bestellungen.tpl');
?>
