<?php

    require_once("StudentManager.php");

    $liste = StudentManager::selectAll();

    if (empty($liste)){
        echo "Null";
    }else{
        print_r($liste);
    }

    echo "<p> sa marche ? </p>";
?>

