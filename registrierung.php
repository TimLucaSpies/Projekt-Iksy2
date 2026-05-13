<?php
session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/TicketEntity.php");
require_once("klassen/Sicherheit.php");
require_once("klassen/ProfilbildHelper.php");

if (Sicherheit::istEingeloggt()) {
    header('Location: login.php');
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
            
            $erfolg = TicketEntity::registriereBenutzer(
                $link, $email, $passwort, $vornameSauber, $nachnameSauber
                );
            
            if ($erfolg) {
                $benutzer = TicketEntity::holeBenutzerPerEmail($link, $email);
                
                // Session befüllen
                $_SESSION['benutzerID'] = $benutzer['id'];
                $_SESSION['vorname']    = $benutzer['vorname'];
                $_SESSION['nachname']   = $benutzer['nachname'];
                $_SESSION['email']      = $benutzer['email'];
                $_SESSION['rolle']      = $benutzer['rolle'] ?? 'kunde';
                $_SESSION['profilbild'] = null;
                
                // Profilbild verarbeiten falls hochgeladen
                if (isset($_FILES['profilbild']) && $_FILES['profilbild']['error'] !== UPLOAD_ERR_NO_FILE) {
                    $dateiname = ProfilbildHelper::verarbeiteUpload(
                        $_FILES['profilbild'],
                        (int) $benutzer['id']
                        );
                    if ($dateiname) {
                        // In DB speichern
                        BenutzerEntity::aktualisiereProfilbild($link, $benutzer['id'], $dateiname);
                        $_SESSION['profilbild'] = $dateiname;
                    }
                }
                
                header('Location: login.php');
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