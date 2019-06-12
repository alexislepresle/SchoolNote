<?php
require_once("bdd.php");
require_once("Teacher.php");

class TeacherManager{

    private static $GET_ALL_TEACHER = 'SELECT * FROM teacher';


    static function selectAll(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_TEACHER);
        $query->execute();
        $query = $query->fetchAll;

        if (!empty($query)){
            $result = array();
            foreach ($query as $value) {
                $result[] = new Teacher($value[''],$value[''],$value[''],$value[''],$value[''],$value[''])
            }
            return $result;
        }else{
            return NULL;
        }
    }
}



?>