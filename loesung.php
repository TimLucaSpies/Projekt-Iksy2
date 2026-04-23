<?php
session_start();
require_once ("includes/startTemplate.inc.php"); // Pfad ggf ändern
require_once ("klassen/Berechnung.inc.php"); // Pfad ggf ändern
require_once ("klassen/Entity.inc.php"); // Pfad ggf ändern
require_once ("klassen/Sicherheit.inc.php"); // Pfad ggf ändern
require_once ("klassen/DbFunctions.inc.php"); // Pfad ggf ändern

define('CSS_BASE', 'css/');
$smarty->assign('CSS_PATH', CSS_BASE);

DEFINE("PATH_AND_FILENAME", "images/graph.svg");
//DEFINE("QR_PATH_AND_FILENAME", "images/qrcode.svg");
DEFINE("ENCODING", "UTF-8");

$PHP_SELF = $_SERVER['PHP_SELF'];
$REQUEST_METHOD = $_SERVER['REQUEST_METHOD'];

$link = DbFunctions::connectWithDatabase();

$ueberschrift = "Bonus Berechnung";
$smarty->assign('ueberschrift', htmlentities($ueberschrift));

if ($REQUEST_METHOD != "POST") {
    $SelectBoxArray = Entity::holeSelectBoxInhalt($link);
    
    if (! isset($_SESSION["csrfToken"])) {
        $_SESSION["csrfToken"] = bin2hex(random_bytes(64));
    }
    $smarty->assign('csrfToken', $_SESSION["csrfToken"]);
    $smarty->assign('PHP_SELF', $PHP_SELF);
    $smarty->assign('SelectBoxArray', $SelectBoxArray);
}
else {
    if (! isset($_POST["csrfToken"]) || ! isset($_SESSION["csrfToken"]) || $_POST["csrfToken"] != $_SESSION["csrfToken"]) {
        unset($_SESSION["csrfToken"]);
        die("CSRF Token ungültig!");
    }
    
    $IdAusSelectBox = $_POST['SelectBoxArray'];
    $variable1= $_POST['variable1'];
    $variable2 = $_POST['variable2'];
    
    $pdf_wunsch = isset($_POST['pdf']);
    
    //Konstanten können dabei mit const MINDESTTEAMUMSATZ = 100000; und dann
    //self::MINDESTUMSATZ genutzt und übergeben werden
    
    $correct = Sicherheit::zwischen($variable1, 10, 80);
    $correct = $correct && Sicherheit::erlaubteStrings($variable2, "grün", "rot", "blau");
    $correct = $correct && Sicherheit::istZahl($IdAusSelectBox);
    
    if (! $correct) {
        $smarty->assign('fehler', true);
    } else {
        
        $indiUmsatz = Entity::holeMitarbeiterUmsatz($link, $IdAusSelectBox );
        $jahresUmsatz = Entity::holeJahresumsatz($link);
        $arrUMSATZ = Entity::holeFuerDiagramm($link);
        $gesamtbonus = Berechnung::berechneBonus($indiUmsatz, $jahresUmsatz, $variable1);
        $gewählterMitarbeiter = Entity::holeNameMitNr($link, $IdAusSelectBox );
        
        $ausgabe1 = "Gesamtumsatz: $jahresUmsatz €";
        $ausgabe2 = "Umsatz generiert durch $gewählterMitarbeiter: $indiUmsatz €";
        $ausgabe3 = "Bitte einen Gehaltsbonus in Höhe von $gesamtbonus % gewähren und eine Grußkarte in der Farbe $variable2 versenden.";
        
        // ---------------- Diagramm ----------------
        $settings = array();
        $width = 700;
        $height = 300;
        $type = 'BarGraph';
        $colours = [['red', 'yellow', 'blue'],['blue','white', 'green']];
        //$colours = ['red', 'yellow', 'blue','white']; //Mehrere Farben
        
        
        //!!!!! Falls X Achse beschriftet werden soll!!!!!
        /*
         foreach ($arrUMSATZ as $key => $value) {
         // Den Schlüssel mit "Test" versehen
         $newKey = 'Test ' . $key;
         
         // Das Array mit dem neuen Schlüssel ersetzen
         $arrUMSATZ[$newKey] = $arrUMSATZ[$key];
         unset($arrUMSATZ[$key]);
         }
         */
        
        //!!!!!Falls Y Achse beschriftet werden soll!!!!!
        /*
         foreach ($arrUMSATZ as $key => $value) {
         // Das Präfix "Test" vor den Wert setzen
         $arrUMSATZ[$key] = 100000+$value; }
         */
        
        //!!!!Falls Dinge aus dem Array gestrichen werden sollen!!!!
        /*
         $arrUMSATZ = array_slice($arrUMSATZ, -6);
         //Oder
         $arrUMSATZ = array_slice($arrUMSATZ, 0, 6);
         */         
        
        $graph = new Goat1000\SVGGraph\SVGGraph($width, $height, $settings);
        $graph->colours($colours);
        $graph->values($arrUMSATZ);
        $output = $graph->fetch($type);
        file_put_contents(PATH_AND_FILENAME, $output);
        
        // ---------------- QR-Code (TCPDF) ----------------
        /*QR CODE: $elementWidth  = "5";
        $elementHeight = "5";
        $color         = "black";
        $url           = "https://www.hs-bochum.de";
        $typeQR        = "QRCODE,L";
        $qrcode = new TCPDF2DBarcode($url, $typeQR);
        $fileContent = $qrcode->getBarcodeSVGcode($elementWidth, $elementHeight, $color);
        file_put_contents(QR_PATH_AND_FILENAME, $fileContent);
        */
        if ($pdf_wunsch) {
            $xTextStart = 10;
            $yTextStart = 30;
            
            $pdf = new TCPDF();
            $pdf->AddPage();
            $pdf->SetFont('Helvetica', "b", 14);
            $pdf->SetXY($xTextStart, $yTextStart);
            $pdf->Cell(16, 3, mb_convert_encoding($ueberschrift, ENCODING));
            
            $pdf->ImageSVG(PATH_AND_FILENAME, $xTextStart, $yTextStart + 10, 175);
            
            //i = kursiv, b = fett, "" = für Normal, U = unterstrichen,
            //d = durchgestrichen, o = Strich darüber,
            //Für Kombination einfach "ib" = fett+kursiv usw.
            $pdf->SetFont('Helvetica', "", 10);
            $pdf->SetXY($xTextStart, 120);
            $pdf->Cell(16, 3, mb_convert_encoding($ausgabe1, ENCODING));
            $pdf->SetFont('Helvetica', "", 10);
            $pdf->SetXY($xTextStart, 125);
            $pdf->Cell(16, 3, mb_convert_encoding($ausgabe2, ENCODING));
            $pdf->SetFont('Helvetica', "bi", 10);
            $pdf->SetXY($xTextStart, 130);
            $pdf->Cell(16, 3, mb_convert_encoding($ausgabe3, ENCODING));
            
            // QR-Code im PDF anzeigen
            /*QRCODE $pdf->SetFont('Helvetica', "b", 12);
            $pdf->SetXY($xTextStart, 140);
            $pdf->Cell(16, 3, mb_convert_encoding("Beispielhafter QR-Code", ENCODING));
            $pdf->ImageSVG(QR_PATH_AND_FILENAME, $xTextStart, 150, 60);
            */
            $pdf->Output();
            exit();
        }
        
        $smarty->assign('PATH_AND_FILENAME', htmlentities(PATH_AND_FILENAME));
        //QR CODE:$smarty->assign('QR_PATH_AND_FILENAME', htmlentities(QR_PATH_AND_FILENAME));
        $smarty->assign('ausgabe1', $ausgabe1);
        $smarty->assign('ausgabe2', $ausgabe2);
        $smarty->assign('ausgabe3', $ausgabe3);
    }
}


/*
 Dezimalzahl runden: $zahl = round($zahl, anzahl_stellen);
 
 Nützliche Array Codes:
 
 Assoziatives Array prüfen:
 echo "<pre>";
 print_r($arr);
 echo "</pre>"; exit();
 
 Prüfen ob ass. Array belegt ist:
 if($Array['Nummer'] == 0){ Hier ist Nummer der Key, also Angabe für den Index. Achtung Es kann auch $Array['Count(Nummer)'], da Key immer genauer Spaltenname der SQL Abfrage wird ... }
 Mit $Größe = count ($arr);
 Kann man Arraygröße bekommen.
 
 Wichtig für Schleifen und co
 foreach ($arr As $key=>$value){
 $arr[$key] = 5                  --> setzt den Wert an Stelle $key auf 5
 } */



$smarty->display('loesung.tpl');
?>
