<?php
   
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


    $ROOT_DIR='/home/iksy/Iksy05/ProjektGruppe1/';       //Pfad ggf anpassen
    require_once("$ROOT_DIR/vendor/autoload.php");
    
    $smarty=new Smarty\Smarty();
    $smarty->setTemplateDir("$ROOT_DIR/smarty/templates/");
    $smarty->setCompileDir("$ROOT_DIR/smarty/templates_c/");
    $smarty->setConfigDir("$ROOT_DIR/smarty/configs/");
    $smarty->setCacheDir("$ROOT_DIR/smarty/cache/");
?>