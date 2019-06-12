<?php
require_once("bdd.php");
require_once("Absence.php");

class AbsenceManager{

    private static $GET_ALL_ABSENCE = 'SELECT mod.CODEMODULE, tea.LASTNAMETEACHER, stu.N_STUDENT, les.CODETYPE, hos.LASTNAMEHEADOFSTUDY, DATEBEGIN, DATEEND FROM ABSENCE abs
										join MODULE mod using(N_TYPE);
										join TEACHER tea using(N_TEACHER)
										join LESSON_TYPE using(N_TYPE)
										join HEAD_OF_STUDY using(N_HEADOFSTUDY)
										join STUDENT using(N_STUDENT)';

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