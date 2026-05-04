<?php

class TicketEntity {
    
    // --------------------------------------------------------
    // BENUTZER
    // --------------------------------------------------------
    
    public static function registriereBenutzer($link, $email, $passwort, $vorname, $nachname) {
        $hash     = password_hash($passwort, PASSWORD_BCRYPT);
        $email    = DbFunctions::escape($link, $email);
        $vorname  = DbFunctions::escape($link, $vorname);
        $nachname = DbFunctions::escape($link, $nachname);
        $hash     = DbFunctions::escape($link, $hash);
        $query = "INSERT INTO benutzer (email, passwort_hash, vorname, nachname)
              VALUES ('$email', '$hash', '$vorname', '$nachname')";
        return DbFunctions::executeQuery($link, $query);
    }
    
    public static function holeBenutzerPerEmail($link, $email) {
        $email = DbFunctions::escape($link, $email);
        $query = "SELECT id, email, passwort_hash, vorname, nachname
                  FROM benutzer WHERE email = '$email'";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    
    public static function holeBenutzerPerID($link, $benutzerID) {
        $benutzerID = (int) $benutzerID;
        $query = "SELECT id, email, vorname, nachname
                  FROM benutzer WHERE id = $benutzerID";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    public static function emailExistiert($link, $email) {
        $email = DbFunctions::escape($link, $email);
        $query = "SELECT COUNT(*) FROM benutzer WHERE email = '$email'";
        return DbFunctions::getFirstFieldOfResult($link, $query) > 0;
    }
    
    // --------------------------------------------------------
    // SPIELE
    // --------------------------------------------------------
    // Alle Plätze ohne Spiel-Filter (für initiales Laden)
    public static function holeAllePlaetze($link) {
        $query = "SELECT a.id, a.block, a.reihe, a.platz,
                     p.beschreibung, p.preis
              FROM arena a
              JOIN preiskategorie p ON a.preiskategorie_id = p.id
              WHERE a.verfuegbar = 1
              ORDER BY p.preis ASC, a.block ASC, a.reihe ASC, a.platz ASC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    // Platz-Verfügbarkeit ohne spielID prüfen
    public static function istPlatzVerfuegbar($link, $arenaID) {
        $arenaID = (int) $arenaID;
        $query = "SELECT verfuegbar FROM arena WHERE id = $arenaID";
        return DbFunctions::getFirstFieldOfResult($link, $query) == 1;
    }
    
    // Platz-Status setzen
    public static function setzePlatzStatus($link, $arenaID, $verfuegbar) {
        $arenaID    = (int) $arenaID;
        $status     = $verfuegbar ? 1 : 0;
        $query = "UPDATE arena SET verfuegbar = $status WHERE id = $arenaID";
        return DbFunctions::executeQuery($link, $query);
    }
    
    public static function holeAktiveSpiele($link) {
        $query = "SELECT id, gegner, datum, heim_auswaerts
                  FROM spiele
                  WHERE datum >= CURDATE()
                  ORDER BY datum ASC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    public static function holeSpielPerID($link, $spielID) {
        $spielID = (int) $spielID;
        $query = "SELECT id, gegner, datum, heim_auswaerts
                  FROM spiele WHERE id = $spielID";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    public static function fuegeSpielHinzu($link, $gegner, $datum, $heimAuswaerts) {
        $gegner        = DbFunctions::escape($link, $gegner);
        $datum         = DbFunctions::escape($link, $datum);
        $heimAuswaerts = DbFunctions::escape($link, $heimAuswaerts);
        $query = "INSERT INTO spiele (gegner, datum, heim_auswaerts)
                  VALUES ('$gegner', '$datum', '$heimAuswaerts')";
        DbFunctions::executeQuery($link, $query);
        return DbFunctions::getFirstFieldOfResult($link, "SELECT LAST_INSERT_ID()");
    }
    
    // --------------------------------------------------------
    // PREISKATEGORIEN
    // --------------------------------------------------------
    
    public static function holeAllePreiskategorien($link) {
        $query = "SELECT id, beschreibung, preis
                  FROM preiskategorie
                  ORDER BY preis ASC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    public static function holePreiskategoriePerID($link, $kategorieID) {
        $kategorieID = (int) $kategorieID;
        $query = "SELECT id, beschreibung, preis
                  FROM preiskategorie WHERE id = $kategorieID";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    // --------------------------------------------------------
    // ARENA (Sitzplätze)
    // --------------------------------------------------------
    
    public static function holeVerfuegbarePlaetze($link, $spielID) {
        $spielID = (int) $spielID;
        // Plätze die für dieses Spiel noch nicht gebucht sind
        $query = "SELECT a.id, a.block, a.reihe, a.platz,
                         p.beschreibung, p.preis
                  FROM arena a
                  JOIN preiskategorie p ON a.preiskategorie_id = p.id
                  WHERE a.verfuegbar = 1
                    AND a.id NOT IN (
                        SELECT arena_id FROM bestellungen WHERE spiel_id = $spielID
                    )
                  ORDER BY p.preis ASC, a.block ASC, a.reihe ASC, a.platz ASC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    public static function holeVerfuegbarePlaetzeNachKategorie($link, $spielID, $kategorieID) {
        $spielID     = (int) $spielID;
        $kategorieID = (int) $kategorieID;
        $query = "SELECT a.id, a.block, a.reihe, a.platz,
                         p.beschreibung, p.preis
                  FROM arena a
                  JOIN preiskategorie p ON a.preiskategorie_id = p.id
                  WHERE a.verfuegbar = 1
                    AND a.preiskategorie_id = $kategorieID
                    AND a.id NOT IN (
                        SELECT arena_id FROM bestellungen WHERE spiel_id = $spielID
                    )
                  ORDER BY a.block ASC, a.reihe ASC, a.platz ASC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    public static function holePlatzPerID($link, $arenaID) {
        $arenaID = (int) $arenaID;
        $query = "SELECT a.id, a.block, a.reihe, a.platz, a.verfuegbar,
                         p.beschreibung, p.preis
                  FROM arena a
                  JOIN preiskategorie p ON a.preiskategorie_id = p.id
                  WHERE a.id = $arenaID";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    
    // --------------------------------------------------------
    // BESTELLUNGEN
    // --------------------------------------------------------
    
    public static function erstelleBestellung($link, $benutzerID, $arenaID, $spielID, $preis) {
        $benutzerID = (int) $benutzerID;
        $arenaID    = (int) $arenaID;
        $spielID    = (int) $spielID;
        $preis      = number_format((float) $preis, 2, '.', '');
        $query = "INSERT INTO bestellungen (benutzer_id, arena_id, spiel_id, preis_bezahlt)
                  VALUES ($benutzerID, $arenaID, $spielID, $preis)";
        DbFunctions::executeQuery($link, $query);
        return DbFunctions::getFirstFieldOfResult($link, "SELECT LAST_INSERT_ID()");
    }
    
    public static function holeBestellungenVonBenutzer($link, $benutzerID) {
        $benutzerID = (int) $benutzerID;
        $query = "SELECT b.id, b.preis_bezahlt, b.bestellt_am,
                         s.gegner, s.datum, s.heim_auswaerts,
                         a.block, a.reihe, a.platz,
                         p.beschreibung AS kategorie
                  FROM bestellungen b
                  JOIN spiele        s ON b.spiel_id = s.id
                  JOIN arena         a ON b.arena_id = a.id
                  JOIN preiskategorie p ON a.preiskategorie_id = p.id
                  WHERE b.benutzer_id = $benutzerID
                  ORDER BY b.bestellt_am DESC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    public static function holeBestellungPerID($link, $bestellungID, $benutzerID) {
        $bestellungID = (int) $bestellungID;
        $benutzerID   = (int) $benutzerID;
        $query = "SELECT b.id, b.preis_bezahlt, b.bestellt_am,
                         s.gegner, s.datum, s.heim_auswaerts,
                         a.block, a.reihe, a.platz,
                         p.beschreibung AS kategorie
                  FROM bestellungen b
                  JOIN spiele        s ON b.spiel_id = s.id
                  JOIN arena         a ON b.arena_id = a.id
                  JOIN preiskategorie p ON a.preiskategorie_id = p.id
                  WHERE b.id = $bestellungID AND b.benutzer_id = $benutzerID";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    // --------------------------------------------------------
    // ADMIN
    // --------------------------------------------------------
    
    public static function holeAlleBestellungen($link) {
        $query = "SELECT b.id, b.preis_bezahlt, b.bestellt_am,
                         u.vorname, u.nachname, u.email,
                         s.gegner, s.datum,
                         a.block, a.reihe, a.platz,
                         p.beschreibung AS kategorie
                  FROM bestellungen b
                  JOIN benutzer      u ON b.benutzer_id = u.id
                  JOIN spiele        s ON b.spiel_id    = s.id
                  JOIN arena         a ON b.arena_id    = a.id
                  JOIN preiskategorie p ON a.preiskategorie_id = p.id
                  ORDER BY b.bestellt_am DESC";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
}
?>
