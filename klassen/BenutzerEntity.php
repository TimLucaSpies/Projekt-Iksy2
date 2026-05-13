<?php

class BenutzerEntity {
    
    // --------------------------------------------------------
    // BENUTZER
    // --------------------------------------------------------
    
    public static function holeBenutzerPerID($link, $benutzerID) {
        $benutzerID    = (int)$benutzerID;
        $query = "SELECT id, email, vorname, nachname, `alter`, profilbild,
          zahlungsmethode, strasse, hausnummer, plz, ort
          FROM benutzer
          WHERE id = $benutzerID";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    public static function holeBenutzerPerEmail($link, $email) {
        $email = DbFunctions::escape($link, $email);
        $query = "SELECT id, email, passwort_hash, vorname, nachname, rolle, profilbild
          FROM benutzer WHERE email = '$email'";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    
      
    public static function aktualisiereStammdaten($link, $benutzerID, $vorname, $nachname, $alter) {
        $benutzerID =(int) $benutzerID;
        $vorname =DbFunctions::escape($link, $vorname);
        $nachname = DbFunctions::escape($link, $nachname);
        $alter =(int) $alter;
        $query = "UPDATE benutzer SET vorname = '$vorname', nachname = '$nachname', `alter` = $alter";
        return DbFunctions::executeQuery($link, $query);
    }
    
    public static function aktualisiereAdresse($link, $benutzerID, $strasse, $hausnummer, $plz, $ort) {
        $benutzerID = (int) $benutzerID;
        $strasse    = DbFunctions::escape($link, $strasse);
        $hausnummer = DbFunctions::escape($link, $hausnummer);
        $plz        = DbFunctions::escape($link, $plz);
        $ort        = DbFunctions::escape($link, $ort);
        $query      = "UPDATE benutzer
                       SET strasse    = '$strasse',
                           hausnummer = '$hausnummer',
                           plz        = '$plz',
                           ort        = '$ort'
                       WHERE id = '$benutzerID'";
        return DbFunctions::executeQuery($link, $query);
    }
    
    public static function aktualisiereZahlung($link, $benutzerID, $methode) {
        $benutzerID = (int) $benutzerID;
        $methode    = DbFunctions::escape($link, $methode);
        $query      = "UPDATE benutzer
                       SET zahlungsmethode = '$methode'
                       WHERE id = '$benutzerID'";
        return DbFunctions::executeQuery($link, $query);
    }
    
   public static function aktualisiereProfilbild($link, $benutzerID, $dateiname) {
        $benutzerID = (int) $benutzerID;
        $dateiname  = DbFunctions::escape($link, $dateiname);
        $query      = "UPDATE benutzer
                       SET profilbild = '$dateiname'
                       WHERE id = '$benutzerID'";
        return DbFunctions::executeQuery($link, $query);
    }
}
    