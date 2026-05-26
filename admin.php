<?php
  session_start();                                                                                                     
  require_once("includes/startTemplate.php");
  require_once("klassen/DbFunctions.php");
  require_once("klassen/TicketEntity.php");                                                                            
  require_once("klassen/Sicherheit.php");
                                                                                                                       

  Sicherheit::requireLogin();
  Sicherheit::requireAdmin(); 
  
  $link   = DbFunctions::connectWithDatabase();                                                                        
  $fehler = [];
  $erfolg = '';                                                                                                        
                  
  if ($_SERVER['REQUEST_METHOD'] === 'POST') {
      if (!Sicherheit::csrfTokenPruefen($_POST['csrfToken'] ?? '')) {
          die("CSRF-Token ungültig!");                                                                                 
      }
                                                                                                                       
      $gegner        = trim($_POST['gegner']        ?? '');
      $datum         = trim($_POST['datum']          ?? '');
      $heimAuswaerts = trim($_POST['heim_auswaerts'] ?? '');
                                                                                                                       
      if (!Sicherheit::pflichtfeld($gegner)) {                                                                         
          $fehler[] = "Bitte Gegnername eingeben.";                                                                    
      }                                                                                                                
      if (!Sicherheit::validiereDatum($datum)) {
          $fehler[] = "Bitte gültiges Datum eingeben.";                                                                
      }                                                                                                                
      if (!in_array($heimAuswaerts, ['Heim', 'Auswärts'])) {                                                           
          $fehler[] = "Bitte Heim oder Auswärts auswählen.";                                                           
      }                                                                                                                
   
      if (empty($fehler)) {                                                                                            
          TicketEntity::fuegeSpielHinzu($link, $gegner, $datum, $heimAuswaerts);
          $erfolg = "Spiel erfolgreich hinzugefügt.";                                                                  
      }                                                                                                                
  }                                                                                                                    
                                                                                                                       
  // Tabellen     
  $bestellungen = TicketEntity::holeAlleBestellungen($link);
  $spiele       = TicketEntity::holeAktiveSpiele($link);                                                               
                                                                                                                       
  // Statistiken                                                                                                       
  $gesamtTickets   = TicketEntity::getGesamtTickets($link);                                                            
  $gesamtEinnahmen = number_format(TicketEntity::getGesamtEinnahmen($link), 2, ',', '.');
  $gesamtKunden    = TicketEntity::getGesamtKunden($link);                                                             
                                                                                                                       
  // Chart-Daten                                                                                                       
  $chartSpiele     = json_encode(TicketEntity::getTicketsProSpiel($link)    ?? []);                                    
  $chartEinnahmen  = json_encode(TicketEntity::getEinnahmenProSpiel($link)  ?? []);                                    
  $chartKategorien = json_encode(TicketEntity::getTicketsProKategorie($link) ?? []);                                   
                                                                                                                       
  // Smarty                                                                                                            
  $smarty->assign('bestellungen',    $bestellungen);
  $smarty->assign('spiele',          $spiele);                                                                         
  $smarty->assign('fehler',          $fehler);
  $smarty->assign('erfolg',          $erfolg);                                                                         
  $smarty->assign('csrfToken',       Sicherheit::csrfTokenErstellen());                                                
  $smarty->assign('gesamtTickets',   $gesamtTickets);                                                                  
  $smarty->assign('gesamtEinnahmen', $gesamtEinnahmen);                                                                
  $smarty->assign('gesamtKunden',    $gesamtKunden);                                                                   
  $smarty->assign('chartSpiele',     $chartSpiele);                                                                    
  $smarty->assign('chartEinnahmen',  $chartEinnahmen);
  $smarty->assign('chartKategorien', $chartKategorien);                                                                
  $smarty->assign('seitentitel',     'Admin-Panel');                                                                   
  $smarty->display('admin.tpl');                                                                                       
  ?>                       