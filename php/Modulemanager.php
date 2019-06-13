<?php
require_once("bdd.php");
require_once("Module.php");

class ModuleManager{

    private static $GET_ALL_MODULE = 'SELECT mod.CODEMODULE, ue.CODEUE FROM MODULE mod
									join UE ue using(N_UE);';


    static function selectAll(){

        $query = Bdd::getInstance()->prepare(self::$GET_ALL_MODULE);
        $query->execute();
        $query = $query->fetchAll;
        print_r($query);

        if (!empty($query)){
            $result = array();
            foreach ($query as $value) {
                $result[] = new Module($value['$NumUE'],$value['$CodeMod'],$value['$DescMod']);
            }
            return $result;
        }else{
            return NULL;
        }
    }
}

print_r(ModuleManager::selectAll());

?>