<?php
require_once("bdd.php");
require_once("Absence.php");

class AbsenceManager{

    private static $GET_ALL_ABSENCE = 'SELECT mod.CODEMODULE, tea.LASTNAMETEACHER, N_STUDENT, les.CODETYPE, hos.LASTNAMEHEADOFSTUDY, DATEBEGIN, DATEEND FROM ABSENCE abs,  ';

    static function selectCurrent(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_ABSENCE);
        $query->execute();
        $query = $query->fetch;

        print_r($query);

        if (!empty($query)){
           return new Absence();
        }else{
            return NULL;
        }
    }
}



?>