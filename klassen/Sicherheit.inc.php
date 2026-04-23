<?php
class Sicherheit {

    // Zahl größer als Minimum
    static function groesserAls($zahl, $min) {
        if($zahl > $min){
            return true;
        } else {
            return false;
        }
    }

    // Zahl kleiner als Maximum
    static function kleinerAls($zahl, $max) {
        if($zahl < $max){
            return true;
        } else {
            return false;
        }
    }

    // Zahl zwischen Min und Max
    static function zwischen($zahl, $min, $max) {
        if($zahl >= $min && $zahl <= $max){
            return true;
        } else {
            return false;
        }
    }

    // Wert ist Zahl
    static function istZahl($wert) {
        if(is_numeric($wert)){
            return true;
        } else {
            return false;
        }
    }

    // String ist x || y || z
    static function erlaubteStrings($wert, $x, $y, $z) {
        if($wert == $x || $wert == $y || $wert == $z){
            return true;
        } else {
            return false;
        }
    }

    // Pflichtfeld
    static function pflichtfeld($wert) {
        if(isset($wert) && trim($wert) !== ''){
            return true;
        } else {
            return false;
        }
    }

    // Wert ist String
    static function istString($wert) {
        if(is_string($wert)){
            return true;
        } else {
            return false;
        }
    }

    // Zahl nur in 1er Schritten
    static function schrittEins($zahl) {
        if(is_numeric($zahl) && $zahl == (int)$zahl){
            return true;
        } else {
            return false;
        }
    }
}
?>