<?php

  header("Content-Type: application/json");
  session_start();

  if(isset($_SESSION['online'])) {
    header('Location: panel');
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));
    $name = $data->name;
    $email = $data->email;
    $password = $data->password;
    $r_errors = [[]];

    require_once("../lib/Database.php");
    $db = new Database();
    $error = $db->getError();

    if(!empty($error)) {
      $r_errors["success"] = false;
      $r_errors["data"]["error"] = $error;
      echo json_encode($r_errors);
      exit();
    }

    $r_errors = $db->validateData($name, $email, $password, $r_errors);
    require_once("../helpers/emptyArray.php");

    if(!emptyArray($r_errors)) {
      $r_errors["success"] = false;
      echo json_encode($r_errors);
      exit();
    }

    $resultCheck = $db->mailExist($email);
    $error = $db->getError();

    if(!empty($error)) {
      $r_errors["success"] = false;
      $r_errors["data"]["error"] = $error;
      echo json_encode($r_errors);
      exit();
    }
    else if ($resultCheck>0) {
      $r_errors["success"] = false;
      $r_errors["data"]["email-error"] = "An account with that email already exists.";
      echo json_encode($r_errors);
      exit();
    }

    $resultCheck = $db->createAccount($name, $email, $password);
    $error = $db->getError();

    if(!$resultCheck) {
      $r_errors["success"] = false;
      $r_errors["data"]["error"] = $error;
      echo json_encode($r_errors);
      exit();
    }

    $r_errors["success"] = true;
    $r_errors["data"] = "An account has been created";
    echo json_encode($r_errors);

    exit();
  }

?>