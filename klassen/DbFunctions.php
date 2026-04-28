<?php

class DbFunctions
{
    
    public static function connectWithDatabase()
    {
        $link = mysqli_connect('127.0.0.1', 'wiInf', 'wiInf');    
        mysqli_set_charset($link, 'utf8');
        $query = "USE wiInf_gruppe1_Kartenverkauf";      
        self::executeQuery($link, $query);
        return $link;
    }
    
    public static function getAssociativeResultArray($link, $query)
    {

        
        $result = DbFunctions::executeQuery($link, $query);
        if ($result == null || mysqli_num_rows($result) == 0) {
            return null;
        }
        $rows = mysqli_num_rows($result);
        for ($i = 0; $i < $rows; $i ++) {
            $resultArray[$i] = mysqli_fetch_assoc($result);
        }
        mysqli_free_result($result);
        return ($resultArray);
    }
    
    public static function getColumnArray($link, $query) //Gibt normal Array zurück
    {
        $result = self::executeQuery($link, $query);
        if ($result == null || mysqli_num_rows($result) == 0) return null;
        
        $arr = [];
        while ($row = mysqli_fetch_row($result)) {
            $arr[] = $row[0];   // nur erste Spalte
        }
        mysqli_free_result($result);
        return $arr;
    }
    
    
    
    public static function getHashFromFirstRow($link, $query)
    {
        //Ruft das erste Ergebnis einer Abfrage als assoziatives Array ab.
        //Bsp: ["name" => "Max", "alter" => 25]
        $resultArray = DbFunctions::getAssociativeResultArray($link, $query);
        if (is_null($resultArray)) {
            return null;
        }
        return ($resultArray[0]);
    }
    
    public static function getHash($link, $query)
    {
        //Erstellt ein assoziatives Array, wobei die erste Spalte der Schlüssel und die zweite der Wert ist.
        $result = self::executeQuery($link, $query);
        $countRows = mysqli_num_rows($result);
        if ($countRows == 0) {
            return null;
        }
        $fieldList = array();
        for ($i = 0; $i < $countRows; $i ++) {
            $row = mysqli_fetch_row($result);
            $fieldList[$row[0]] = $row[1];
        }
        mysqli_free_result($result);
        return $fieldList;
    }
    
    public static function executeQuery($link, $query)
    {
        $result = mysqli_query($link, $query);
        if ($result === false) {
            return null;
        }
        return $result;
    }
    
    public static function getErrorNumber($link)
    {
        return (mysqli_errno($link));
    }
    
    public static function getErrorText($link)
    {
        return (mysqli_error($link));
    }
    
    public static function getLastInsertId($link)
    {
        return mysqli_insert_id($link);
    }
    
    public static function escape($link, $str)
    {
        if (ini_get('magic_quotes_gpc')) {
            $str = stripslashes($str);
        }
        return mysqli_real_escape_string($link, $str);
    }
    
    public static function getFirstFieldOfResult($link, $query)
    {
        $result = self::executeQuery($link, $query);
        if (mysqli_num_rows($result) == 0) {
            return null;
        }
        $row = mysqli_fetch_row($result);
        mysqli_free_result($result);
        return ($row[0]);
    }
}
?>