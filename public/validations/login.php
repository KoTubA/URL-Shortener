<?php

  header("Content-Type: application/json");
  session_start();

  if(isset($_SESSION['online'])) {
    header("panel.php");
    exit();
  }

  if($_SERVER['REQUEST_METHOD'] === 'POST') {

    $data = json_decode(file_get_contents("php://input"));
    $name = $data->name;
    $email = $data->email;
    $password = $data->password;
    $error_flag = false;
    $errors = [[]];

    if (!preg_match('/^[\w].{4,32}$/', $name)) {
        $errors["data"]["name-error"] = "Letter & numbers only. 4–32 characters.";
        $error_flag = true;
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["data"]["email-error"] = "Please include a valid email address.";
        $error_flag = true;
    }
    if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[\W_]).{6,}$/', $password)) {
        $errors["data"]["password-error"] = "You can't leave this empty";
        $error_flag = true;
    }

    if($error_flag) {
      $errors["success"] = true;
      echo json_encode($errors);
      exit();
    }

    require_once("../config/database.php");
    if(isset($error)) {
      $errors["success"] = false;
      $errors["data"]["error"] = $error;
      echo json_encode($errors);
      exit();
    }

    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->execute();
    $number_of_rows = $stmt->fetchColumn();

    if($number_of_rows>0) {
      $errors["success"] = false;
      $errors["data"]["error"] = "Email already exists";
      echo json_encode($errors);
      exit();
    }

    $options = ['cost' => 12];
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);

    $sql = "INSERT INTO users (name, email, password) VALUES (:name , :email, :password)";
    $stmt = $db->prepare($sql);
    $stmt->bindParam(":name" , $name, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":password" , $hash_password, PDO::PARAM_STR);
    $stmt->execute();

    $errors["success"] = true;
    $errors["data"]["success"] = "An account has been created";
    echo json_encode($errors);

    exit();

  }

?>