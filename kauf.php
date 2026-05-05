<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link     = DbFunctions::connectWithDatabase();
$PHP_SELF = $_SERVER['PHP_SELF'];

$spielID = isset($_GET['spiel_id']) ? (int)$_GET['spiel_id'] : 0;
if ($spielID <= 0) { header('Location: spielplan.php'); exit(); }

$spiel = TicketEntity::holeSpielPerID($link, $spielID);
if (!$spiel) { header('Location: spielplan.php'); exit(); }

$plaetze = TicketEntity::holeVerfuegbarePlaetze($link, $spielID);

$smarty->assign('PHP_SELF',    $PHP_SELF);
$smarty->assign('csrfToken',   Sicherheit::csrfTokenErstellen());
$smarty->assign('spiel',       $spiel);
$smarty->assign('plaetze',     $plaetze);
$smarty->assign('spielID',     $spielID);
$smarty->assign('seitentitel', 'Tickets kaufen');

$fehler = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
        die("CSRF-Token ungültig!");
    }

    $arenaID = (int)($_POST['arena_id'] ?? 0);

    if ($arenaID <= 0) {
        $fehler[] = "Bitte wähle einen Sitzplatz aus.";
    }

    if (empty($fehler)) {
        $bereitsImKorb = false;
        if (isset($_SESSION['warenkorb'])) {
            foreach ($_SESSION['warenkorb'] as $item) {
                if ($item['arena_id'] == $arenaID && $item['spiel_id'] == $spielID) {
                    $bereitsImKorb = true;
                    break;
                }
            }
        }

        if ($bereitsImKorb) {
            $fehler[] = "Dieser Platz liegt bereits in deinem Warenkorb.";
        } elseif (!TicketEntity::istPlatzVerfuegbar($link, $arenaID)) {
            $fehler[] = "Dieser Platz ist leider nicht mehr verfügbar.";
        } else {
            $platz = TicketEntity::holePlatzPerID($link, $arenaID);
            if (!isset($_SESSION['warenkorb'])) {
                $_SESSION['warenkorb'] = [];
            }
            $_SESSION['warenkorb'][] = [
                'arena_id'       => $arenaID,
                'spiel_id'       => $spielID,
                'block'          => $platz['block'],
                'reihe'          => $platz['reihe'],
                'platz'          => $platz['platz'],
                'kategorie'      => $platz['beschreibung'],
                'preis'          => $platz['preis'],
                'gegner'         => $spiel['gegner'],
                'datum'          => $spiel['datum'],
                'heim_auswaerts' => $spiel['heim_auswaerts'],
            ];
            header('Location: warenkorb.php');
            exit();
        }
    }

    $plaetze = TicketEntity::holeVerfuegbarePlaetze($link, $spielID);
    $smarty->assign('plaetze',   $plaetze);
    $smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());
    $smarty->assign('fehler',    $fehler);
}

$smarty->display('kauf.tpl');
?>
