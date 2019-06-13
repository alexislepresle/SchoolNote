<?php
require_once("bdd.php");
require_once("Student.php");

class StudentManager{

    private static $GET_ALL_STUDENT = 'SELECT * FROM STUDENT';
    private static $EXIST = 'SELECT * FROM STUDENT WHERE MAILSTUDENT = ?';

    static function selectAll(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_STUDENT);
        $query->execute();
        $query = $query->fetchAll();

        if (!empty($query)){
            $result = array();
            foreach ($query as $value) {
                $result[] = StudentManager::getStudent($value);
            }
            return $result;
        }else{
            return NULL;
        }
    }

    static function exist($mail){

        $mail = htmlentities($mail);

        $query = Bdd::getInstance()->prepare(self::$EXIST);
        $query->bindParam(1, $mail, PDO::PARAM_STR, 40);
        $query->execute();
        $query = $query->fetch();

        if (!empty($query)){
            return StudentManager::getStudent($query);
        }else{
            return NULL;
        }
    }

    static function getStudent($ligne){
        return new Student($ligne['N_STUDENT'], $ligne['LASTNAMESTUDENT'],$ligne['FIRSTNAMESTUDENT'],$ligne['MAILSTUDENT'],$ligne['PASSWORDSTUDENT'],$ligne['TPSTUDENT'],$ligne['TDSTUDENT']); 
    }
}

?>