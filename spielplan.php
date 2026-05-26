<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");


$link = DbFunctions::connectWithDatabase();
$spiele = TicketEntity::holeAktiveSpiele($link);

foreach ($spiele as &$spiel) {
    $spiel['heim_logo'] = 'images/Schalke_04.png';
    $spiel['gegner_logo'] = 'images/' . $spiel['gegner'] . '.png';
}

$smarty->assign('spiele', $spiele);
$smarty->assign('seitentitel', 'Spielplan');
$smarty->display('spielplan.tpl');
?>