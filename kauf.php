<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link = DbFunctions::connectWithDatabase();
$PHP_SELF = $_SERVER['PHP_SELF'];

// Spiel-ID aus URL lesen
$spielID = isset($_GET['spiel_id']) ? (int)$_GET['spiel_id'] : 0;

// Spiel validieren
if ($spielID <= 0) {
    header('Location: spielplan.php');
    exit();
}

$spiel = TicketEntity::holeSpielPerID($link, $spielID);

if (!$spiel) {
    header('Location: spielplan.php');
    exit();
}

// Verfügbare Plätze für dieses Spiel laden
$plaetze = TicketEntity::holeVerfuegbarePlaetze($link, $spielID);

$smarty->assign('PHP_SELF', $PHP_SELF);
$smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());
$smarty->assign('spiel', $spiel);
$smarty->assign('plaetze', $plaetze);
$smarty->assign('spielID', $spielID);
$smarty->assign('seitentitel', 'Tickets kaufen');

$fehler = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
        die("CSRF-Token ungültig!");
    }
    
    $spielID    = intval($_POST['spiel_id']  ?? 0);
    $arenaID    = intval($_POST['arena_id']  ?? 0);
    $benutzerID = $_SESSION['benutzerID'];
    
    if ($arenaID <= 0) {
        $fehler[] = "Bitte wählen Sie einen Sitzplatz aus.";
    }
    
    if (empty($fehler)) {
        if (!TicketEntity::istPlatzVerfuegbar($link, $arenaID)) {
            $fehler[] = "Dieser Platz ist leider gerade vergeben worden.";
        } else {
            $bestellID = TicketEntity::erstelleBestellung($link, $benutzerID, $arenaID, $spielID);
            
            if ($bestellID) {
                TicketEntity::setzePlatzStatus($link, $arenaID, false);
                header('Location: mein_konto.php?kauf=erfolgreich');
                exit();
            } else {
                $fehler[] = "Der Kauf konnte nicht abgeschlossen werden. Bitte versuchen Sie es erneut.";
            }
        }
    }
    
    // Nach Fehler: Plätze neu laden und Fehler anzeigen
    $plaetze = TicketEntity::holeVerfuegbarePlaetze($link, $spielID);
    $smarty->assign('plaetze', $plaetze);
    $smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());
    $smarty->assign('fehler', $fehler);
}

$smarty->display('kauf.tpl');
?>