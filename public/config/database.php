<?php

  $host = "localhost";
  $user = "root";
  $pass = "";
  $dbname = "shortly";

  $dsn = "mysql:host={$host};dbname={$dbname}";
  $options = array(
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
  );

  try {
    $db = new PDO($dsn, $user , $pass, $options);
  }
  catch(PDOException $e) {
    $error = $e->getMessage();
  }