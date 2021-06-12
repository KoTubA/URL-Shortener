<?php

  header("Content-Type: application/json");
  session_start();

  if(isset($_SESSION['online'])) {
    header("panel");
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));
    $name = $data->name;
    $email = $data->email;
    $password = $data->password;
    $errors = [[]];

    require_once("../lib/Database.php");
    $db = new Database();
    $error = $db->getError();

    if(!empty($error)) {
      $errors["success"] = false;
      $errors["data"]["error"] = $error;
      echo json_encode($errors);
      exit();
    }

    $errors = $db->validateData($name, $email, $password, $errors);
    require_once("../helpers/emptyArray.php");

    if(!emptyArray($errors)) {
      $errors["success"] = true;
      echo json_encode($errors);
      exit();
    }

    $resultCheck = $db->mailExist($email);
    $error = $db->getError();

    if(!empty($error)) {
      $errors["success"] = false;
      $errors["data"]["error"] = $error;
      echo json_encode($errors);
      exit();
    }
    else if ($resultCheck>0) {
      $errors["success"] = true;
      $errors["data"]["email-error"] = "An account with that email already exists.";
      echo json_encode($errors);
      exit();
    }

    $resultCheck = $db->createAccount($name, $email, $password);
    $error = $db->getError();

    if(!$resultCheck) {
      $errors["success"] = false;
      $errors["data"]["error"] = $error;
      echo json_encode($errors);
      exit();
    }

    $errors["success"] = true;
    $errors["data"]["success"] = "An account has been created";
    echo json_encode($errors);

    exit();
  }

?>