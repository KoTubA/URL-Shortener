<?php

  header("Content-Type: application/json");
  session_start();

  if(isset($_SESSION['online'])) {
    header("panel");
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));
    $login = $data->name;
    $password = $data->password;
    $errors = [[]];

    require_once("../lib/Database.php");
    $db = new Database();
    $error = $db->getError();

    $result = $db->Login($login, $password);
    $error = $db->getError();
    require_once("../helpers/emptyArray.php");

    if($result==false && !empty($error)) {
      $errors["success"] = false;
      $errors["data"]["error"] = $error;
      echo json_encode($errors);
      exit();
    }
    else if($result==false) {
      $errors["success"] = false;
      $errors["data"]["data-error"] = "Invalid login or password.";
      echo json_encode($errors);
      exit();
    }
    else {
      $errors["success"] = true;
      $_SESSION['online'] = true;
      $_SESSION['id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['email'] = $result['email'];

      echo json_encode($errors);
      exit();
    }
  }

?>