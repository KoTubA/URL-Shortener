<?php
class Database{
  private $host = "localhost";
  private $user = "root";
  private $pass = "";
  private $dbname = "shortly";

  private $dbh;
  private $error;

  public function __construct()
  {
    $dsn = "mysql:host={$this->host};dbname={$this->dbname}";

    $options = array(
      PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    );

    try {
      $this->dbh = new PDO($dsn, $this->user , $this->pass, $options);
    } catch(PDOException $e) {
      $this->error = "Error: ".$e->getCode();
    }
  }

  public function getError() {
    return $this->error;
  }

  public function validateData($name, $email, $password, $errors) {

    if (!preg_match('/[A-Za-z0-9]{4,32}/', $name)) {
        $errors["data"]["name-error"] = "Letter & numbers only. 4–32 characters.";
    }
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors["data"]["email-error"] = "Please include a valid email address.";
    }
    if (!preg_match('/^(?=.*\d)(?=.*[a-zA-Z])(?=.*[\W_]).{6,}$/', $password)) {
        $errors["data"]["password-error"] = "Please include a valid password.";
    }

    return $errors;
  }

  public function mailExist($email) {
    $sql = "SELECT * FROM users WHERE email = :email";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch(PDOException $e) {
      $this->error = "Error: ".$e->getCode();
      return 0;
    }

    if(!$stmt) {
      $this->error = "Something go wrong.";
      return 0;
    }

    $number_of_rows = $stmt->rowCount();
    return $number_of_rows;
  }

  public function createAccount($name, $email, $password) {
    $options = ['cost' => 12];
    $hash_password = password_hash($password, PASSWORD_BCRYPT, $options);

    $sql = "INSERT INTO users (name, email, password) VALUES (:name , :email, :password)";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(":name" , $name, PDO::PARAM_STR);
    $stmt->bindParam(":email", $email, PDO::PARAM_STR);
    $stmt->bindParam(":password" , $hash_password, PDO::PARAM_STR);

    try {
      $stmt->execute();
    } catch(PDOException $e) {
      $this->error = "Error: ".$e->getCode();
      return false;
    }

    if(!$stmt) {
      $this->error = "Something go wrong.";
      return false;
    }

    return true;
  }

  public function Login($login, $password)
  {
    $sql = "SELECT id, name, email, password FROM users WHERE name = :login OR email = :login";
    $stmt = $this->dbh->prepare($sql);
    $stmt->bindParam(":login", $login);

    try {
      $stmt->execute();
    } catch(PDOException $e) {
      $this->error = "Error: ".$e->getCode();
      return false;
    }

    if(!$stmt) {
      $this->error = "Something go wrong.";
      return false;
    }

    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    $number_of_rows = $stmt->rowCount();

    if($number_of_rows!=1 ||!password_verify($password, $user["password"])) {
      return false;
    }

    return $user;
  }

}