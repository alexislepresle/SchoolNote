<?php
require_once("bdd.php");
require_once("Absence.php");

class AbsenceManager{

    private static $GET_ALL_ABSENCE = 'SELECT mod.CODEMODULE, tea.LASTNAMETEACHER, stu.N_STUDENT, les.CODETYPE, DATEBEGIN, DATEEND, COMMENT FROM ABSENCE abs
										join MODULE mod using(N_TYPE);
										join TEACHER tea using(N_TEACHER)
										join LESSON_TYPE les using(N_TYPE)
										join STUDENT stu using(N_STUDENT)';

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