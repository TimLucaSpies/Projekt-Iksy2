<?php

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$ROOT_DIR = '/home/iksy/iksy05/ProjektGruppe1';  // Pfad ggf. anpassen

require_once("$ROOT_DIR/vendor/autoload.php");

$smarty = new Smarty\Smarty();
$smarty->setTemplateDir("$ROOT_DIR/smarty/templates/");
$smarty->setCompileDir("$ROOT_DIR/smarty/templates_c/");
$smarty->setConfigDir("$ROOT_DIR/smarty/configs/");
$smarty->setCacheDir("$ROOT_DIR/smarty/cache/");

// Session-Infos automatisch an alle Templates übergeben
$smarty->assign('SESSION_eingeloggt',      isset($_SESSION['benutzerID']));
$smarty->assign('SESSION_vorname',         $_SESSION['vorname']    ?? '');
$smarty->assign('SESSION_nachname',        $_SESSION['nachname']   ?? '');
$smarty->assign('SESSION_rolle',           $_SESSION['rolle']      ?? '');
$smarty->assign('SESSION_benutzerID',      $_SESSION['benutzerID'] ?? null);
?>