<?php
session_start();

// Vorname vor dem Löschen merken
$vorname = $_SESSION['vorname'] ?? 'Fan';

// Session vollständig beenden
session_unset();
session_destroy();

// Session-Cookie löschen
if (isset($_COOKIE[session_name()])) {
    setcookie(session_name(), '', time() - 3600, '/');
}

// Neue saubere Session für Smarty starten
session_start();
require_once("includes/startTemplate.php");

$smarty->assign('vorname', htmlspecialchars($vorname));
$smarty->assign('seitentitel', 'Auf Wiedersehen');
$smarty->display('logout.tpl');
?>
