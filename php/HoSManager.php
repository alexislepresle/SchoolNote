<?php
require_once("bdd.php");
require_once("HoS.php");

class HoSManager{

    private static $GET_ALL_HoS = 'SELECT * FROM TEACHER WHERE IS_DIRECTOR_OF_STUDIES IS 1 ';
    private static $EXIST = 'SELECT * FROM TEACHER WHERE MAILTEACHER = ? AND IS_DIRECTOR_OF_STUDIES = 1';


    static function selectCurrent(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_HoS);
        $query->execute();
        $query = $query->fetch;

        print_r($query);

        if (!empty($query)){
           return HoSManager::getHoS($query);
        }else{
            return NULL;
        }
    }

    static function getHoS($ligne){
        return new HoS($ligne['N_TEACHER'], $ligne['LASTNAMETEACHER'], $ligne['FIRSTNAMETEACHER'], $ligne['MAILTEACHER'], $ligne['PASSWORDTEACHER'], $ligne['IS_DIRECTOR_OF_STUDIES']);
    }

    static function exist($mail){

        $mail = htmlentities($mail);

        $query = Bdd::getInstance()->prepare(self::$EXIST);
        $query->bindParam(1, $mail, PDO::PARAM_STR, 40);
        $query->execute();
        $query = $query->fetch();

        if (!empty($query)){
            return HoSManager::getHoS($query);
        }else{
            return NULL;
        }
    }
}

$var = HoSManager::exist('fabienne.jort@unicaen.fr');
print_r($var);

?>