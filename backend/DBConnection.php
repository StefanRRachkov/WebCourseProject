<?php 

include 'utils/constants.php';

class DBConnection {
  private $connection;

  private static $instance = null;

  private function __construct()  {
    global $connection;

    $this->$connection = new PDO("mysql:host=".Constants::$host.";dbname=".Constants::$db, Constants::$user, Constants::$password);

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

  public function getReferatsWithConditions($userId, $str_condition, $course_edition){
    global $connection;

    $query = $this->$connection->query("SELECT * FROM REF_LIBRARY  WHERE BOOK_ID NOT IN (SELECT BOOK_ID FROM EXPORTED_REFS WHERE EXPORTS >= MAX_EXPORTS) AND (MATCH(TITLE, KEYWORDS) AGAINST('%{$str_condition}%') OR '{$str_condition}' LIKE '' OR TITLE LIKE '%{$str_condition}%' OR KEYWORDS LIKE '%{$str_condition}%') AND BOOK_ID NOT IN (SELECT BOOK_ID FROM OWNED_REFS WHERE USER_ID = {$userId}) AND ({$course_edition} IS NULL OR COURSEEDITION = {$course_edition})");
    $_SESSION['user_courseedition'] = $course_edition;

    return $query->fetchAll(PDO::FETCH_ASSOC);
  }

  // $data: array of tuples
  public function storeReferats($data, $edition) {
    global $connection;

    try {
      $this->$connection->beginTransaction();

      // skipping the first (title) row
      for ($i = 1; $i < count($data); $i++) {
        $dataRow = $data[$i];

        if (count($dataRow) == 6) {
          $this->$connection->prepare("INSERT INTO REF_LIBRARY (RefID, Title, Ref, Keywords, Category, Link, Max_Exports, CourseEdition) VALUES (?, ?, ?, ?, ?, ?, ?, ?)")
             ->execute(array($dataRow[0], $dataRow[1], $dataRow[2], $dataRow[3], $dataRow[4], $dataRow[5], Constants::$maxExportsPerReferat, $edition));
        }
      }

      $this->$connection->commit();
    } catch (PDOException $e) {
      $this->$connection->rollback();
      return $e->getMessage();
    }
  }

  public function login($email, $password) {
    global $connection;

    $hashed_password = sha1($password);
  
    try {
      $sql = 'SELECT * FROM USERS WHERE email=? and password = ?';
      $stmt = $this->$connection->prepare($sql);
      $stmt->execute(array($email, $hashed_password));
      $stmt->setFetchMode(PDO::FETCH_ASSOC);
      $result = $stmt->fetchAll();
  
      if ($result && $stmt->rowCount() == 1) {
        $_SESSION['user'] = $result[0]['User_ID'];
        $_SESSION['user_courseedition'] = $result[0]['CourseEdition'];
        $_SESSION['user_grade'] = $result[0]['UserGrade'];
      } else {
        $_SESSION['loginError'] = "Wrong email or password";
      }
    } catch(Exception $e) {
      $_SESSION['loginError'] = "No connection with DB";
    }
  }

  public function register($email, $password, $pass2, $first_name, $last_name, $course_edition, $faculty_number) {
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
      $sql = 'INSERT INTO USERS (email, password, firstname, lastname, courseedition, fn) VALUES (?, ?, ?, ?, ?, ?)';
      $stmt = $this->$connection->prepare($sql);
      $result = $stmt->execute(array($email, $hashed_password, $first_name, $last_name, $course_edition, $faculty_number));
    
      if ($result && $stmt->rowCount() == 1) {
        $_SESSION['user'] = $this->$connection->lastInsertId();
        $_SESSION['user_courseedition'] = $course_edition;
        $_SESSION['user_grade'] = $result[0]['UserGrade'];
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

  public function fetchUserData($userId) {
    global $connection;

    try {
      $userStatement = $this->$connection->query("SELECT * FROM USERS WHERE USER_ID = $userId");
      $userData = $userStatement->fetchAll(PDO::FETCH_ASSOC)[0];

      $referatsStatemet = $this->$connection->query("SELECT * FROM REF_LIBRARY AS LIB JOIN OWNED_REFS AS OWN ON LIB.Book_ID = OWN.Book_ID WHERE OWN.User_ID = $userId");
      $referats = $referatsStatemet->fetchAll(PDO::FETCH_ASSOC);

      if ($userData) {
        return array('userData' => $userData, 'referats' => $referats);
      } else {
        return null;
      }
    } catch(Exception $e) {
      $_SESSION['profileError'] = "No connection with DB";
    }
  }

  public function returnReferat($userId, $referatId) {
    global $connection;

    try {
      $sql = "DELETE FROM OWNED_REFS WHERE USER_ID = {$userId} AND BOOK_ID = {$referatId}";
      $this->$connection->exec($sql);

      $return_sql = "UPDATE EXPORTED_REFS SET `Exports` = `Exports` - 1";
      $this->$connection->exec($return_sql);
    } catch (Exception $e) {
      $_SESSION['profileError'] = $e->getMessage();
    }
  }

  public function takeReferat($userId, $referatId){
    global $connection;

    $date = mktime(0, 0, 0, date('m'), date('d') + Constants::$referatTakenDaysCount, date('Y'));

    try {
      $sql = "INSERT INTO OWNED_REFS(USER_ID, BOOK_ID, DEADLINE) VALUES(?, ?, ?)";
      $this->$connection->prepare($sql)->execute(array($userId, $referatId, date('Y-m-d H:i:s', $date)));

      $export_sql = "INSERT INTO EXPORTED_REFS VALUES(?, ?, ?) ON DUPLICATE KEY UPDATE `Exports` = `Exports` + 1";
      $this->$connection->prepare($export_sql)->execute(array($referatId, 1, Constants::$maxExportsPerReferat));

    } catch (Exception $e) {
      $_SESSION['profileError'] = $e->getMessage();
    }
  }

    public function getCourseEditions() {
    global $connection;

    try {
      $query = $this->$connection->query('SELECT CourseEditionID FROM COURSE_EDITION ORDER BY CourseEditionID DESC');
      return $query->fetchAll(PDO::FETCH_ASSOC);
    } catch (Exception $e) {
      $_SESSION['importError'] = 'No connection with DB';
      return array();
    }
  }

  private function finishRegister(){
    header('Location: ../index.php#login');
    exit();
  }
}
?>
