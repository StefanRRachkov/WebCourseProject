<?php
  session_start();
  unset($_SESSION['csvFileUploadError']);

  $csvMimes = array('text/x-comma-separated-values', 'text/comma-separated-values', 'application/octet-stream', 'application/vnd.ms-excel', 'application/x-csv', 'text/x-csv', 'text/csv', 'application/csv', 'application/excel', 'application/vnd.msexcel', 'text/plain');

  if (!in_array($_FILES['uploaded-file']['type'], $csvMimes)) {
    $_SESSION['csvFileUploadError'] = "Only CSV files are supported";
    finish();
  }

  if (($handle = fopen($_FILES['uploaded-file']['tmp_name'], 'r')) !== FALSE) {
    while (($data = fgetcsv($handle, 1000, ";")) !== FALSE) {
        $num = count($data);
        echo "<p> $num fields in line $row: <br /></p>\n";
        $row++;
        for ($c=0; $c < $num; $c++) {
            echo $data[$c] . "<br />\n";
        }
    }
    fclose($handle);
  }

  function finish(){
    header('Location: ../Index_FrontEnd/import');
    exit();
  }
?>