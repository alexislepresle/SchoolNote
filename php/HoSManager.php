<?php
require_once("bdd.php");
require_once("Student.php");

class HoSManager{

    private static $GET_CURRENT_HoS = 'SELECT * FROM HoS WHERE annee is to_char(sysdate, \'YY\')';

    static function selectCurrent(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_HoS);
        $query->execute();
        $query = $query->fetch;

        print_r($query);

        if (!empty($query)){
           return new HoS();
        }else{
            return NULL;
        }
    }
}



?>