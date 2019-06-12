<?php
require_once("bdd.php");
require_once("HoS.php");

class HoSManager{

    private static $GET_ALL_HoS = 'SELECT * FROM HEAD_OF_STUDY';

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