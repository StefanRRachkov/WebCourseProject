<?php 

class DBConnection {
  private $connection;

  private $host = 'localhost';
  private $user = 'root';
  private $password = '';
  private $database = 'WEB_TAKE_A_REF';

  private static $instance = null;

  private function __construct() {
    $this->$connection = new PDO("mysql:host={$this->host};dbname={$this->database}", $this->user, $this->password);
  }

  public static function sharedInstance()
  {
    if(!self::$instance)
    {
      self::$instance = new DBConnection();
    }
   
    return self::$instance;
  }

  public function getAllFrom($table) {
    $query = $this->$connection->query("SELECT * FROM {$table}") or die('failed');

    return $query->fetchAll(PDO::FETCH_ASSOC);
  }
}

?>