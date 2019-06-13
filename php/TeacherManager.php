<?php
require_once("bdd.php");
require_once("Teacher.php");

class TeacherManager{

    private static $GET_ALL_TEACHER = 'SELECT * FROM teacher';
    private static $EXIST = 'SELECT * FROM TEACHER WHERE MAILTEACHER = ?';



    static function selectAll(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_TEACHER);
        $query->execute();
        $query = $query->fetchAll;

        if (!empty($query)){
            $result = array();
            foreach ($query as $value) {
                $result[] = TeacherManager::getTeacher($value);
            }
            return $result;
        }else{
            return NULL;
        }
    }
    
    static function getTeacher($ligne){
        return new Teacher($ligne['N_TEACHER'], $ligne['LASTNAMETEACHER'], $ligne['FIRSTNAMETEACHER'], $ligne['MAILTEACHER'], $ligne['PASSWORDTEACHER'], $ligne['IS_DIRECTOR_OF_STUDIES']);
    }

    static function exist($mail){

        $mail = htmlentities($mail);

        $query = Bdd::getInstance()->prepare(self::$EXIST);
        $query->bindParam(1, $mail, PDO::PARAM_STR, 40);
        $query->execute();
        $query = $query->fetch();

        if (!empty($query)){
            return TeacherManager::getTeacher($query);
        }else{
            return NULL;
        }
    }
}


?>