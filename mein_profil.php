<?php
use function couchbase\extension\transactionNewAttempt;

session_start();
require_once("includes/startTemplate.php");
require_once("klassen/DbFunctions.php");
require_once("klassen/BenutzerEntity.php");
require_once("klassen/Sicherheit.php");

Sicherheit::requireLogin();

$link       = DbFunctions::connectWithDatabase();
$benutzerID = $_SESSION['benutzerID'];

$fehler = [];
$erfolg = false;

if ($_SERVER['REQUEST_METHOD'] === 'POST'){
    $aktion = $_POST['aktion'] ?? '';
    
    if($aktion === 'stammdaten'){
        $vorname = trim($_POST['vorname'] ?? '');
        $name = trim($_POST['name']  ?? '');
        $alter = intval($_POST['alter'] ?? 0);
        
        if (empty($vorname)) $fehler[] = 'Bitte gib deinen Vorname ein.';
        if (empty($name)) $fehler[] = 'Bitte gib deinen Nachnamen ein.';
        if ($alter <1 || $alter > 120 ) $fehler[]= 'Bitte gib ein gültiges Alter ein.';
        
        if(empty($fehler)){
            BenutzerEntity::aktualisiereStammdaten($link, $benutzerID, $vorname, $name, $alter);
            $erfolg = true;
        }
    }
    if ($aktion === 'adresse'){
        $strasse = trim($_POST['strasse'] ?? '');
        $hausnummer = trim($_POST['hausnummer'] ?? '');
        $plz = trim($_POST['plz'] ?? '');
        $ort = trim($_POST['ort'] ?? '');
        
        if(empty($strasse)) $fehler[] = 'Straße fehlt.';
        if(empty($hausunmmer)) $fehlr[] = 'Hausnummer fehlt';
        if(empty($plz)) $fehlt[] = 'PLz fehlt';
        if(empty($ort)) $fehler[] = 'Ort fehlt';
        
        if(empty($fehler)){
            BenutzerEntity::aktualisiereAdresse($link, $benutzerID, $strasse, $hausnummer, $plz, $ort);
            $erfolg = true;
        }
    }
    
    if($aktion === 'zahlung'){
        
        $methode = trim($_POST['zahlungsmethode'] ?? '');
        $erlaubt = ['paypal','kreditkarte', 'rechnung', 'sofortüberweisung'];
        
        if(!in_array($methode, $erlaubt)){
            $fehler[] = 'Bitte wähle eine gültge Zahlungsmethode.';
        }
        if (empty($fehler)){
            BenutzerEntity::aktualisiereZahlung($link, $benutzerID, $methode);
            $erfolg = true;
        }
    }
    
    if($aktion === 'profilbild'){
        require_once("klassen/ProfilbildHelper.php");
        if(!isset($_FILES['profilbild']) || $_FILES['profilbild']['error'] === UPLOAD_ERR_NO_FILE){
            $fehler[] = 'Bitte wähle eine Datei aus.';
        } else {
            $dateiname = ProfilbildHelper::verarbeiteUpload(
                $_FILES['profilbild'],
                (int) $benutzerID
                );
            if ($dateiname === false) {
                $fehler[] = 'Upload fehlgeschlagen. Erlaubt sind JPEG, PNG und WebP bis 2 MB.';
            } elseif ($dateiname !== null) {
                BenutzerEntity::aktualisiereProfilbild($link, $benutzerID, $dateiname);
                $_SESSION['profilbild'] = $dateiname;
                $erfolg = true;
            }
        }
    }
        
        
}
$benutzer = BenutzerEntity::holeBenutzerPerID($link, $benutzerID);

$smarty->assign('benutzer', $benutzer);
$smarty->assign('fehler',  $fehler);
$smarty->assign('erfolg',  $erfolg);
$smarty->assign('seitentitel', 'Mein Profil');
$smarty->display('mein_profil.tpl');
?>
