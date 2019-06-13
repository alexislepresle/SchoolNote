<?php

require_once("StudentManager.php");

if (!empty($_POST)){
    
    if (!isset($_SESSION['id'])){

        if (isset($_POST['password']) && isset($_POST['email'])){
            
            $student = StudentManager::exist($_POST['email']);
            //$teacher = TeacherManager::exist($_POST['email']);

            //if (!empty($student)){
            //    $user = $student; 
            //}

            //if (!empty($teacher)){
            //    $user = $teacher;
            //}
            if (!empty($student)){
                
                if ($student->getPwd() == $_POST['password']){
                    
                    session_start()
                    echo "Sa marche !";
                    $_SESSION['id'] = $value['num'];
                    header('Location: ../interface.php');
                    exit();
                    
                }else{
                    echo "<script> window.alert(\"Mauvais Mot de Passe !\"); </script>";
                }
            }else{
                echo "<script> window.alert(\"Utilisateur Inconnu !\"); </script>";
            }
        }else{
            echo "<script> window.alert(\"Mauvais champs !\"); </script>";
        }
    }else{
        echo "<script> window.alert(\"Vous etes déjà connecté!\"); </script>";
    }
}else{
    echo "<script> window.alert(\"d Mauvais paramêtres !\"); </script>";

}

?>
