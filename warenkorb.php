<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link = DbFunctions::connectWithDatabase();
$benutzerID = $_SESSION['benutzerID'];

// Warenkorb aus Session initialisieren
if (!isset($_SESSION['warenkorb'])) {
    $_SESSION['warenkorb'] = [];
}

$aktion = $_POST['aktion'] ?? $_GET['aktion'] ?? '';

// ── Platz zum Warenkorb hinzufügen (kommt von kauf.php) ──────────────
if ($aktion === 'hinzufuegen' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
        die("CSRF-Token ungültig!");
    }

    $spielID = (int)($_POST['spiel_id'] ?? 0);
    $arenaID = (int)($_POST['arena_id'] ?? 0);

    if ($spielID > 0 && $arenaID > 0) {
        // Prüfen ob Platz noch frei und nicht schon im Warenkorb
        $bereitsImKorb = false;
        foreach ($_SESSION['warenkorb'] as $item) {
            if ($item['arena_id'] == $arenaID && $item['spiel_id'] == $spielID) {
                $bereitsImKorb = true;
                break;
            }
        }

        if (!$bereitsImKorb && TicketEntity::istPlatzVerfuegbar($link, $arenaID)) {
            $platz = TicketEntity::holePlatzPerID($link, $arenaID);
            $spiel = TicketEntity::holeSpielPerID($link, $spielID);

            if ($platz && $spiel) {
                $_SESSION['warenkorb'][] = [
                    'arena_id'    => $arenaID,
                    'spiel_id'    => $spielID,
                    'block'       => $platz['block'],
                    'reihe'       => $platz['reihe'],
                    'platz'       => $platz['platz'],
                    'kategorie'   => $platz['beschreibung'],
                    'preis'       => $platz['preis'],
                    'gegner'      => $spiel['gegner'],
                    'datum'       => $spiel['datum'],
                    'heim_auswaerts' => $spiel['heim_auswaerts'],
                ];
            }
        }
    }
    header('Location: warenkorb.php');
    exit();
}

// ── Artikel entfernen ────────────────────────────────────────────────
if ($aktion === 'entfernen' && isset($_GET['index'])) {
    $index = (int)$_GET['index'];
    if (isset($_SESSION['warenkorb'][$index])) {
        array_splice($_SESSION['warenkorb'], $index, 1);
    }
    header('Location: warenkorb.php');
    exit();
}

// ── Kauf abschließen ────────────────────────────────────────────────
if ($aktion === 'kaufen' && $_SERVER['REQUEST_METHOD'] === 'POST') {

    if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
        die("CSRF-Token ungültig!");
    }

    if (empty($_SESSION['warenkorb'])) {
        header('Location: warenkorb.php');
        exit();
    }

    $bestellIDs = [];
    $fehler     = false;

    foreach ($_SESSION['warenkorb'] as $item) {
        // Nochmal prüfen ob Platz noch frei
        if (!TicketEntity::istPlatzVerfuegbar($link, $item['arena_id'])) {
            $fehler = true;
            break;
        }
        $bestellID = TicketEntity::erstelleBestellung(
            $link,
            $benutzerID,
            $item['arena_id'],
            $item['spiel_id']
        );
        if ($bestellID) {
            TicketEntity::setzePlatzStatus($link, $item['arena_id'], false);
            $bestellIDs[] = $bestellID;
        } else {
            $fehler = true;
            break;
        }
    }

    if (!$fehler && !empty($bestellIDs)) {
        // Warenkorb leeren
        $_SESSION['warenkorb'] = [];
        // Zur Ticketansicht weiterleiten
        $ids = implode(',', $bestellIDs);
        header('Location: ticket.php?ids=' . $ids);
        exit();
    } else {
        $smarty->assign('fehler', ['Ein oder mehrere Plätze sind nicht mehr verfügbar. Bitte Warenkorb prüfen.']);
    }
}

// ── Anzeige ──────────────────────────────────────────────────────────
$warenkorb   = $_SESSION['warenkorb'];
$gesamtpreis = 0;
foreach ($warenkorb as $item) {
    $gesamtpreis += $item['preis'];
}

$smarty->assign('warenkorb',   $warenkorb);
$smarty->assign('gesamtpreis', number_format($gesamtpreis, 2, ',', '.'));
$smarty->assign('csrfToken',   Sicherheit::csrfTokenErstellen());
$smarty->assign('seitentitel', 'Warenkorb');
$smarty->display('warenkorb.tpl');
?>
