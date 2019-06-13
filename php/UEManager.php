<?php
require_once("bdd.php");
require_once("UE.php");

class UEManager{

    private static $GET_ALL_UE = 'SELECT * FROM UE';


    static function selectAll(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_UE);
        $query->execute();
        $query = $query->fetchAll;
        print_r($query);

        if (!empty($query)){
            $result = array();
            foreach ($query as $value) {
                $result[] = new UE($value['$CodeUE'],$value['$DescUE']);
            }
            return $result;
        }else{
            return NULL;
        }
    }
}

print_r(UEManager::selectAll());

?>