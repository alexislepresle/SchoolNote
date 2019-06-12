<?php

require_once("StudentManager.php");
require_once("TeacherManager.php");
require_once("HoSManager.php");


    
if (!empty($_POST)){
    
    if (!isset($_SESSION['id'])){
        
        if ($_POST['password'] && $_POST['username']){
            
            $listeStudent = StudentManager::selectAll();
            $listeTeacher = TeacherManager::selectAll();
            $Hos = HoSManager::SelectCurrent();
            
            $liste = $listeStudent + $misteTeacher + $Hos;
            
            foreach($liste as $value){
                if ($value['Email'] == $_POST['username']){
                    
                    if ($value['Password'] == $_POST['password']){
                        
                        session_start();
                        $_SESSION['id'] = $value['num'];
                        header("Location: interface.php")
                        exit();
                    }else{
                        echo "Mauvais mot de passe !";
                    }
                    echo "Utilisateur inconnu !";
                }
            }
        }
    }
}