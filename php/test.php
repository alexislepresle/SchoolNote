<?php
require_once("StudentManager.php");

$liste = StudentManager::selectAll();

print_r($liste);

?>