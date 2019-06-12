<?php

require_once("StudentManager.php");

if (!empty($_POST)){
    
    if (!isset($_SESSION['id'])){

        if (isset($_POST['password']) && isset($_POST['email'])){
            
            $student = StudentManager::exist($_POST['email']);
            echo $student->toString();
            
            if (isset($student)){
                
                if ($student->getPwd() == $_POST['password']){
                    
                    session_start();
                    echo "Sa marche !";
                    $_SESSION['id'] = $value['num'];
                    header('Location: ../interface.php');
                    exit();
                    
                }else{
                    echo "1 : Mauvais mot de passe !";
                }
            }else{
                echo "2: Utilisateur inconnu !";
            }
            
        }else{
            echo "3: probleme de valeur de Post ";
        }
    }else{
        echo "4: déjà connecté !";
    }
}else{
    echo "5: pas de requête POST !";
}

?>
