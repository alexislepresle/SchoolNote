<?php
require_once("bdd.php");
require_once("Student.php");

class StudentManager{

    private static $GET_ALL_STUDENT = 'SELECT * FROM Student';


    static function selectAll(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_STUDENT);
        $query->execute();
        $query = $query->fetchAll;
        print_r($query);

        if (!empty($query)){
            $result = array();
            foreach ($query as $value) {
                $result[] = new Student($value['Fname'],$value['Lname'],$value['pwd'],$value['class'],$value['group'],$value['email']);
            }
            return $result;
        }else{
            return NULL;
        }
    }
}

print_r(StudentManager::selectAll());

?>