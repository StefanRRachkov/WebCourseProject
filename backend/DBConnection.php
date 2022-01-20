<?php 

class DBConnection {
  private $connection;

  private $host = 'localhost';
  private $user = 'root';
  private $password = '';
  private $database = 'WEB_TAKE_A_REF';

  private static $instance = null;

  private function __construct()  {
    global $connection;

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
    global $connection;

    $query = $this->$connection->query("SELECT * FROM {$table}") or die('failed');

    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  public function getReferatsWithConditions($str_condition){
    global $connection;

    $query = $this->$connection->query("SELECT * FROM REF_LIBRARY WHERE Title LIKE '%{$str_condition}%'");

    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  // $data: array of tuples
  public function storeReferats($data) {
    global $connection;

    try {
      $this->$connection->beginTransaction();

      // skipping the first (title) row
      for ($i = 1; $i < count($data); $i++) {
        $dataRow = $data[$i];

        if (count($dataRow) == 3) {
          $this->$connection->prepare("INSERT INTO REF_LIBRARY (Title, Ref, Keywords, Max_Exports) VALUES (?, ?, ?, ?)")
             ->execute(array($dataRow[0], $dataRow[1], $dataRow[2], 5));;
        }
      }

      $this->$connection->commit();
    } catch (PDOException $e) {
      $this->$connection->rollback();
      return $e->getMessage();
    }
  }

  public function login($email, $password){
    global $connection;

    $hashed_password = sha1($password);
  
    try {
      $sql = 'SELECT * FROM USERS WHERE email=? and password = ?';
      $stmt = $this->$connection->prepare($sql);
      $result = $stmt->execute(array($email, $hashed_password));
  
      if ($result && $stmt->rowCount() == 1) {
        $_SESSION['user'] = $email;
        $_SESSION['userID'] = $result['User_ID'];
      }
      else{
        $_SESSION['loginError'] = "Wrong email or password";
      }
    }
    catch(Exception $e) {
      $_SESSION['loginError'] = "No connection with DB";
    }
  }

  public function register($email, $password, $pass2) {
    global $connection;
    
    if(strlen($password) < 6){
      $_SESSION['regError'] = "Password is too short";
      $this->finishRegister();
    }
    
    if(!filter_var($email, FILTER_VALIDATE_EMAIL)){
      $_SESSION['regError'] = "Incorrect Email Syntax";
      $this->finishRegister();
    }
    
    if($password != $pass2){
      $_SESSION['regError'] = "Passwords are different";
      $this->finishRegister();
    }
    
    $hashed_password = sha1($password);
    
    try {
      $sql = 'INSERT INTO USERS (email, password) VALUES (?, ?)';
      $stmt = $this->$connection->prepare($sql);
      $result = $stmt->execute(array($email, $hashed_password));
    
      if ($result && $stmt->rowCount() == 1) {
        $_SESSION['user'] = $email;
      }
      $this->finishRegister();
    }
    catch(Exception $e) {
      $error = $stmt->errorInfo();

      if ($error[1] == 1062) {
        $_SESSION['regError'] = 'Email is already registered';
      } else {
        $_SESSION['regError'] = "No connection with DB<br>".$e->getMessage();
      }
      
      $this->finishRegister();
    }
  }

  private function finishRegister(){
    header('Location: ../index.php#login');
    exit();
  }
}
?>
