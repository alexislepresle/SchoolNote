<?php
session_start();
if(!isset($_SESSION['id'] && !isset($_SESSION['code']))){
    header("../Location: index.php");
}
?>