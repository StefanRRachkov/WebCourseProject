<?php
include 'DBConnection.php';

session_start();
unset($_SESSION['csvFileUploadError']);

$csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

if (!in_array($_FILES['uploaded-file']['type'], $csvMimes)) {
  $_SESSION['csvFileUploadError'] = "Only CSV files are supported";
  finish(true);
}

if (($handle = fopen($_FILES['uploaded-file']['tmp_name'], 'r')) !== FALSE) {
  $valuesOfInterest = array();

  while (($data = fgetcsv($handle, 10000)) !== FALSE) {
      array_push($valuesOfInterest, array($data[4], $data[5], $data[10]));
  }

  $result = DBConnection::sharedInstance()->storeReferats($valuesOfInterest);

  if ($result != null) {
    $_SESSION['csvFileUploadError'] = $result;
  }

  fclose($handle);

  finish($result != null);
}

function finish($hasError){
  header('Location: ../'.($hasError ? 'import' : 'search'));
  exit();
}
?>