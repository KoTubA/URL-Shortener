<?php

  header("Content-Type: application/json");
  session_start();

  if(isset($_SESSION['online'])) {
    header('Location: panel');
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));
    $login = $data->name;
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

    $result = $db->Login($login, $password);
    $error = $db->getError();

    if($result==false && !empty($error)) {
      $r_errors["success"] = false;
      $r_errors["data"]["error"] = $error;
      echo json_encode($r_errors);
      exit();
    }
    else if($result==false) {
      $r_errors["success"] = false;
      $r_errors["data"]["data-error"] = "Invalid login or password.";
      echo json_encode($r_errors);
      exit();
    }
    else {
      $r_errors["success"] = true;
      $_SESSION['online'] = true;
      $_SESSION['id'] = $result['id'];
      $_SESSION['name'] = $result['name'];
      $_SESSION['email'] = $result['email'];

      echo json_encode($r_errors);
      exit();
    }
  }

?>