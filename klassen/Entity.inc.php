<?php

class Entity{
    //Wenn nach Strings gesucht wird diese immer in '' !!!!!
    
    public static function holeSelectBoxInhalt($link){
        //Hier Inhalt der SelectBox mit: $query = "SELECT id, Name/Bezeichnung from TabelleXYZ order by Name/Bezeichnung";
        //return DbFunctions::getHash($link, $query);
        $query = "SELECT mitarbeiterNr, Nachname FROM UmsatzMitarbeiter order by Nachname";
        return DbFunctions::getHash($link, $query);
    }
    
    
    public static function holeFuerDiagramm($link){     
        $query = "Select monat, umsatz from UmsatzTeam"; //HIER KEY-VALUE PAAR!!! 1.=X-Achse, 2.=>Y-Achse
        return DbFunctions::getHash($link, $query);
    }
    
    
    public static function holeMitarbeiterUmsatz($link, $mitarbeiterNr)
    {
        $query = "SELECT Umsatz FROM UmsatzMitarbeiter WHERE mitarbeiterNr = $mitarbeiterNr";
        return DbFunctions::getFirstFieldOfResult($link, $query);
    }

    
    public static function holeJahresumsatz($link)
    {
        $query = "SELECT Sum(Umsatz) FROM UmsatzTeam";
        return DbFunctions::getFirstFieldOfResult($link, $query);
    }

   
    public static function holeNameMitNr($link, $mitarbeiterNr)
    {
        $query = "SELECT nachname FROM UmsatzMitarbeiter where mitarbeiternr = $mitarbeiterNr";
        return DbFunctions::getFirstFieldOfResult($link, $query);
    }
    
    /*
    // Methode, um alle Umsätze eines Teams inklusive Mitarbeitername zu holen
    public static function holeTeamUmsatzMitMitarbeiter($link){
        $query = "SELECT UmsatzTeam.monat, UmsatzTeam.umsatz, UmsatzMitarbeiter.nachname
                  FROM UmsatzTeam
                  JOIN UmsatzMitarbeiter ON UmsatzTeam.mitarbeiterNr = UmsatzMitarbeiter.mitarbeiterNr
                  ORDER BY UmsatzTeam.monat";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    // Methode, um den gesamten Umsatz eines Mitarbeiters und den entsprechenden Teamnamen zu holen
    public static function holeMitarbeiterUndTeamUmsatz($link, $mitarbeiterNr){
        $query = "SELECT UmsatzMitarbeiter.nachname, UmsatzMitarbeiter.umsatz, UmsatzTeam.teamname
                  FROM UmsatzMitarbeiter
                  JOIN UmsatzTeam ON UmsatzMitarbeiter.teamId = UmsatzTeam.teamId
                  WHERE UmsatzMitarbeiter.mitarbeiterNr = $mitarbeiterNr";
        return DbFunctions::getHashFromFirstRow($link, $query);
    }
    
    // Methode, um alle Mitarbeiter mit ihren Teamnamen und Umsätzen anzuzeigen
    public static function holeMitarbeiterMitTeamUmsatz($link){
        $query = "SELECT UmsatzMitarbeiter.nachname, UmsatzTeam.teamname, UmsatzMitarbeiter.umsatz
                  FROM UmsatzMitarbeiter
                  JOIN UmsatzTeam ON UmsatzMitarbeiter.teamId = UmsatzTeam.teamId
                  ORDER BY UmsatzMitarbeiter.nachname";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    // Methode, um den gesamten Umsatz nach Team zu aggregieren
    public static function holeUmsatzNachTeam($link){
        $query = "SELECT UmsatzTeam.teamname, SUM(UmsatzTeam.umsatz) AS GesamtUmsatz
                  FROM UmsatzTeam
                  GROUP BY UmsatzTeam.teamname";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    // Methode, um alle Mitarbeiter und ihren Umsatz zu zeigen, wenn sie in einem bestimmten Team sind
    public static function holeMitarbeiterImTeam($link, $teamId){
        $query = "SELECT UmsatzMitarbeiter.nachname, UmsatzMitarbeiter.umsatz
                  FROM UmsatzMitarbeiter
                  JOIN UmsatzTeam ON UmsatzMitarbeiter.teamId = UmsatzTeam.teamId
                  WHERE UmsatzTeam.teamId = $teamId";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }
    
    // Methode, um die Anzahl der Mitarbeiter pro Team zu zählen
    public static function holeMitarbeiterAnzahlProTeam($link){
        $query = "SELECT UmsatzTeam.teamname, COUNT(UmsatzMitarbeiter.mitarbeiterNr) AS MitarbeiterAnzahl
                  FROM UmsatzTeam
                  LEFT JOIN UmsatzMitarbeiter ON UmsatzTeam.teamId = UmsatzMitarbeiter.teamId
                  GROUP BY UmsatzTeam.teamname";
        return DbFunctions::getAssociativeResultArray($link, $query);
    }*/
}
?>