<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

// Bereits eingeloggt → weiterleiten
if (Sicherheit::istEingeloggt()) {
    header('Location: index.php');
    exit();
}

$link = DbFunctions::connectWithDatabase();
$PHP_SELF = $_SERVER['PHP_SELF'];
$smarty->assign('PHP_SELF', $PHP_SELF);
$smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());
$smarty->assign('seitenbild', 'images/Stadion.jpg');
$smarty->assign('wappen', 'images/Schalke_04.png');

$fehler = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    // CSRF-Prüfung
    if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
        die("CSRF-Token ungültig!");
    }

    $email    = trim($_POST['email']    ?? '');
    $passwort = trim($_POST['passwort'] ?? '');

    // Eingabevalidierung
    if (!Sicherheit::pflichtfeld($email)) {
        $fehler[] = "Bitte E-Mail eingeben.";
    }
    if (!Sicherheit::pflichtfeld($passwort)) {
        $fehler[] = "Bitte Passwort eingeben.";
    }

    if (empty($fehler)) {
        $benutzer = TicketEntity::holeBenutzerPerEmail($link, $email);

        if ($benutzer && Sicherheit::pruefePasswort($passwort, $benutzer['passwortHash'])) {
            // Session befüllen
            $_SESSION['benutzerID'] = $benutzer['benutzerID'];
            $_SESSION['vorname']    = $benutzer['vorname'];
            $_SESSION['nachname']   = $benutzer['nachname'];
            $_SESSION['email']      = $benutzer['email'];
            $_SESSION['rolle']      = $benutzer['rolle'];

            // Admin → Adminbereich, sonst Startseite
            if ($benutzer['rolle'] === 'admin') {
                header('Location: admin.php');
            } else {
                header('Location: index.php');
            }
            exit();
        } else {
            $fehler[] = "E-Mail oder Passwort ist falsch.";
        }
    }

    // CSRF-Token neu setzen für nächsten Versuch
    $smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());
    $smarty->assign('fehler', $fehler);
    $smarty->assign('email', htmlspecialchars($email));
}

$smarty->display('login.tpl');
?>