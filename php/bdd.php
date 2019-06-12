<?php
/**
* Redefinition des méthodes de PDO
*/
class Bdd extends PDO {

  private static $instance = null;

  public function __construct(){
    $host = 'agile2.users.info.unicaen.fr';
    $dbname = 'agile2_bd';
    $user = 'agile2';
    $password = 'iesh1Dah6Iet8rai';
    parent::__construct('mysql:host='.$host.';dbname='.$dbname.';charset=utf8', $user, $password);
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
