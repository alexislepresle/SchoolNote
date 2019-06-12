<?php
/**
* Redefinition des méthodes de PDO
*/
class Bdd extends PDO {

  private static $instance = null;

  public function __construct(){
    $host = 'localhost';
    $dbname = 'agile2_bd';
    $user = 'agile2';
    $password = 'iesh1Dah6Iet8rai';
    try{
      parent::__construct('mysql:host='.$host.';dbname='.$dbname.';port=3306;charset=utf8', $user, $password);
    }catch (PDOException $e){
      die('Error : ' . $e);
    }
  }
  
  /**
   *
   * @return Bdd L'instance de la base de données
   */
  public static function getInstance(){
    if(is_null(self::$instance)) {
      self::$instance = new BDD();
    }
    return self::$instance;

  }
}

?>
