<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");

if (Sicherheit::istEingeloggt()) {
    header('Location: index.php');
    exit();
}

$link = DbFunctions::connectWithDatabase();
$PHP_SELF = $_SERVER['PHP_SELF'];
$smarty->assign('PHP_SELF', $PHP_SELF);
$smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());

$fehler = [];

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    
    if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
        die("CSRF-Token ungültig!");
    }
    
    $vorname         = trim($_POST['vorname']          ?? '');
    $nachname        = trim($_POST['nachname']         ?? '');
    $email           = trim($_POST['email']            ?? '');
    $passwort        = trim($_POST['passwort']         ?? '');
    $passwortWdh     = trim($_POST['passwortWdh']      ?? '');
    
    // Validierung
    if (!Sicherheit::pflichtfeld($vorname) || strlen($vorname) > 80) {
        $fehler[] = "Bitte gültigen Vornamen eingeben (max. 80 Zeichen).";
    }
    if (!Sicherheit::pflichtfeld($nachname) || strlen($nachname) > 80) {
        $fehler[] = "Bitte gültigen Nachnamen eingeben (max. 80 Zeichen).";
    }
    if (!Sicherheit::validiereEmail($email)) {
        $fehler[] = "Bitte eine gültige E-Mail-Adresse eingeben.";
    }
    if (!Sicherheit::validierePasswort($passwort)) {
        $fehler[] = "Passwort muss mindestens 8 Zeichen, einen Großbuchstaben und eine Zahl enthalten.";
    }
    if ($passwort !== $passwortWdh) {
        $fehler[] = "Passwörter stimmen nicht überein.";
    }
    
    if (empty($fehler)) {
        if (TicketEntity::emailExistiert($link, $email)) {
            $fehler[] = "Diese E-Mail-Adresse ist bereits registriert.";
        } else {
            $vornameSauber  = Sicherheit::bereinigeName($vorname);
            $nachnameSauber = Sicherheit::bereinigeName($nachname);
            
            $erfolg = TicketEntity::registriereBenutzer($link, $email, $passwort, $vornameSauber, $nachnameSauber);
            
            if ($erfolg) {
                // Direkt einloggen nach Registrierung
                $benutzer = TicketEntity::holeBenutzerPerEmail($link, $email);
                $_SESSION['benutzerID'] = $benutzer['benutzerID'];
                $_SESSION['vorname']    = $benutzer['vorname'];
                $_SESSION['nachname']   = $benutzer['nachname'];
                $_SESSION['email']      = $benutzer['email'];
                $_SESSION['rolle']      = $benutzer['rolle'];
                
                header('Location: index.php?registriert=1');
                exit();
            } else {
                $fehler[] = "Registrierung fehlgeschlagen. Bitte versuche es erneut.";
            }
        }
    }
    
    $smarty->assign('csrfToken', Sicherheit::csrfTokenErstellen());
    $smarty->assign('fehler', $fehler);
    // Felder vorausfüllen (außer Passwort)
    $smarty->assign('vorname',  htmlspecialchars($vorname));
    $smarty->assign('nachname', htmlspecialchars($nachname));
    $smarty->assign('email',    htmlspecialchars($email));
}

$smarty->display('registrierung.tpl');
?>