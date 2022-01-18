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

    $this->$connection->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    // set the PDO error mode to exception
    $this->$connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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

  // $data: array of tuples
  public function storeReferats($data) {
    try {
      $this->$connection->beginTransaction();

      // skipping the first (title) row
      for ($i = 1; $i < count($data); $i++) {
        $dataRow = $data[$i];

        $this->$connection->prepare("INSERT INTO REF_LIBRARY (Title, Ref, Max_Exports) VALUES (?, ?, ?)")
             ->execute(array($dataRow[0], $dataRow[1], 5));
      }

      $this->$connection->commit();
    } catch (PDOException $e) {
      $this->$connection->rollback();
      return $e->getMessage();
    }
  }
}

?>