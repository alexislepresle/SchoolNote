<!DOCTYPE html>
<html>
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>SchoolNote</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bulma/0.7.5/css/bulma.min.css">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link rel="stylesheet" href="./css/index.css">
  </head>
  <body class="account-sign-in">
	  <section class="section form_sign-in has-text-centered">
	    <div class="container is-fullhd"style="">
	      <h1 class="title"> SchoolNote </h1>
			<form action="index.php" method="post"> 
			<div class="field">
			  <p class="control has-icons-left has-icons-right">
			    <input class="input" type="email" placeholder="Email" name="email">
			    <span class="icon is-small is-left">
			      <i class="fas fa-envelope"></i>
			    </span>
			    <span class="icon is-small is-right">
			      <i class="fas fa-check"></i>
			    </span>
			  </p>
			</div>

			<div class="field">
			  <p class="control has-icons-left">
			    <input class="input" type="password" placeholder="Password" name="password">
			    <span class="icon is-small is-left">
			      <i class="fas fa-lock"></i>
			    </span>
			  </p>
			</div>

			<div class="field">
			  <p class="control">
			    <input value="Login" type="submit" class="button is-dark is-fullwidth">

			  </p>
			</div>
			</form> 
		</div>
	  </section>
  </body>
</html>

<?php
require_once("php/StudentManager.php");
require_once("php/TeacherManager.php");

if (!empty($_POST)){
    if (!isset($_SESSION['id'])){
        if (isset($_POST['password']) && isset($_POST['email'])){
            
			$student = StudentManager::exist($_POST['email']);
			$teacher = TeacherManager::exist($_POST['email']);

            if (!empty($student)){
                
                if ($student->getPwd() == $_POST['password']){
                    
                    session_start();
					$_SESSION['id'] = $student->getNum();
					$_SESSION['code'] = 1; 
                    header('Location: ../interface.php');
                    exit();
                    
                }else{
                    echo "<script> window.alert(\"Wrong Password !\"); </script>";
				}
			}else if (!empty($teacher)){
				if ($teacher->getPwd() == $_POST['password']){	
                    
                    session_start();
					$_SESSION['id'] = $teacher->getNum();
					if ($teacher->isHoS()){
						$_SESSION['code'] = 3;
					}else{
						$_SESSION['code'] = 2;
					}
                    header('Location: ../interface.php');
                    exit();
                    
                }else{
                    echo "<script> window.alert(\"Wrong Password !\"); </script>";
				}
            }else{
                echo "<script> window.alert(\"Unknown user !\"); </script>";
			}
        }else{
            echo "<script> window.alert(\"Wrong field !\"); </script>";
        }
    }else{
        echo "<script> window.alert(\"You're already connect !\"); </script>";
    }
}

?>
