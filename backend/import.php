<?php
include 'DBConnection.php';

session_start();
unset($_SESSION['csvFileUploadError']);

$edition = $_POST['edition'];

$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

if (!in_array($_FILES['uploaded-file']['type'], $csvMimes)) {
  $_SESSION['csvFileUploadError'] = "Only CSV files are supported";
  finish(true);
}

if (($handle = fopen($_FILES['uploaded-file']['tmp_name'], 'r')) !== FALSE) {
  $valuesOfInterest = array();

  while (($data = fgetcsv($handle, 10000)) !== FALSE) {
      if (count($data) < 10) {
          $_SESSION['csvFileUploadError'] = 'The file has an unsupported structure';
          break;
      }

      // take the first keyword as the category
      $category = explode(',', $data[10])[0];

      // id, title, references, keywords, category
      array_push($valuesOfInterest, array($data[3] == '' ? NULL : $data[3], $data[4], $data[5], $data[10], $category));
  }

  // the file has only one row (the title row)
  if (count($valuesOfInterest) < 2) {
    $_SESSION['csvFileUploadError'] = 'The file has an unsupported structure';
  }

  if (!isset($_SESSION['csvFileUploadError'])) {
      $result = DBConnection::sharedInstance()->storeReferats($valuesOfInterest, $edition);

      if ($result != null) {
        $_SESSION['csvFileUploadError'] = $result;
      }
  }

  fclose($handle);

  finish(isset($_SESSION['csvFileUploadError']));
}

function finish($hasError){
  header('Location: ../'.($hasError ? 'import' : 'search'));
  exit();
}
?>