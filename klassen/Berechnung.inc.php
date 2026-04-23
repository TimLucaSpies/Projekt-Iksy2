<?php
class Berechnung {

    const MINDESTTEAMUMSATZ = 100000; 
    const BONUS_GROSS = 50;        
    const BONUS_KLEIN = 25;        
    const GRENZE_GROSS = 0.10;        
    const GRENZE_KLEIN = 0.05;        
    
    public static function berechneBonus($indiUmsatz, $jahresUmsatz, $hoeheTeambonus) {
        $individuellerBonus = 0;
        $anteil = $indiUmsatz / $jahresUmsatz;
        

        if ($anteil > self::GRENZE_GROSS) {
            $individuellerBonus = self::BONUS_GROSS;
        } elseif ($anteil > self::GRENZE_KLEIN) {
            $individuellerBonus = self::BONUS_KLEIN;
        }
        

        if ($jahresUmsatz >= self::MINDESTTEAMUMSATZ) {
            $individuellerBonus += $hoeheTeambonus;
        }
        
        return $individuellerBonus;
    }
}


//Konstanten: const NAMEKONSTANTE = 10;
//Konstanten aufrufen: Weil hier in der Klasse erstellt mit self::NAMEKONSTANTE
//


?>