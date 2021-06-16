<?php
    class Database{
        private $host = "localhost";
        private $user = "root";
        private $pass = "";
        private $dbname = "shortly";

        private $dbh;
        private $error = false;

        public function __construct(){
            $this->error = "";
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

        public function getError(){
            return $this->error;
        }

        public function validateData($name, $email, $password, $errors) {
            $this->error = "";
            if (!preg_match('/^[a-zA-Z0-9]{4,32}$/', $name)) {
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

        public function mailExist($email){
            $this->error = "";
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
                $this->error = "Something went wrong.";
                return 0;
            }

            $number_of_rows = $stmt->rowCount();
            return $number_of_rows;
        }

        public function createAccount($name, $email, $password){
            $this->error = "";
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
                $this->error = "Something went wrong.";
                return false;
            }

            return true;
        }

        public function Login($login, $password){
            $this->error = "";
            $sql = "SELECT id, name, email, password FROM users WHERE name = :login OR email = :login";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":login", $login, PDO::PARAM_STR);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            $user = $stmt->fetch(PDO::FETCH_ASSOC);
            $number_of_rows = $stmt->rowCount();

            if($number_of_rows!=1 ||!password_verify($password, $user["password"])) {
                return false;
            }

            return $user;
        }

        public function getLink($id){
            $this->error = "";
            $sql = "SELECT original_url, short_url, long_url, creation_date, clicks FROM urls WHERE user_id = :id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":id", $id , PDO::PARAM_INT);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            $links = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $number_of_rows = $stmt->rowCount();

            if($number_of_rows==0) {
                return false;
            }

            return $links;
        }

        public function deleteLink($user_id, $original_url){
            $this->error = "";
            $sql = "DELETE FROM urls WHERE original_url = :original_url AND user_id = :user_id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":original_url", $original_url, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            $number_of_rows = $stmt->rowCount();

            if($number_of_rows==0) {
                return false;
            }

            return true;
        }

        public function deleteAllLinks($user_id){
            $this->error = "";
            $sql = "DELETE FROM urls WHERE user_id = :user_id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            return true;
        }

        public function validateLink($short_url) {
            $this->error = "";
            if ($short_url === "") {
                $this->error = "You can't leave this empty.";
                return false;
            }

            if (!preg_match('/^[a-zA-Z0-9]*$/', $short_url)) {
                $this->error = "Link contains illegal characters.";
                return false;
            }

            if (strlen($short_url)>2000) {
                $this->error = "Your link is too long.";
                return false;
            }

            return true;
        }

        public function ownLink($user_id, $original_url){
            $this->error = "";
            $sql = "SELECT * FROM urls WHERE user_id = :user_id AND original_url = :original_url";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":original_url", $original_url, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
            $this->error = "Something went wrong.";
                return false;
            }

            $number_of_rows = $stmt->rowCount();
            if($number_of_rows==0) {
                return false;
            }

            return true;
        }

        public function checkLink($short_url){
            $this->error = "";
            $sql = "SELECT * FROM urls WHERE original_url = :short_url OR short_url = :short_url";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":short_url", $short_url, PDO::PARAM_STR);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            $number_of_rows = $stmt->rowCount();
            if($number_of_rows>0) {
                return false;
            }

            return true;
        }

        public function editLink($user_id, $original_url, $short_url){
            $this->error = "";
            $sql = "UPDATE urls SET short_url = :short_url WHERE original_url = :original_url AND user_id = :user_id";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":short_url", $short_url, PDO::PARAM_STR);
            $stmt->bindParam(":original_url", $original_url, PDO::PARAM_STR);
            $stmt->bindParam(":user_id", $user_id, PDO::PARAM_INT);

            try {
            $stmt->execute();
            } catch(PDOException $e) {
            $this->error = "Error: ".$e->getCode();
            return false;
            }

            if(!$stmt) {
            $this->error = "Something went wrong.";
            return false;
            }

            return true;
        }

        public function validateLongLink($long_url){
            $this->error = "";
            if ($long_url === "") {
                $this->error = "You can't leave this empty.";
                return false;
            }

            if (filter_var($long_url, FILTER_VALIDATE_URL) === FALSE) {
                $this->error = "Not a valid URL.";
                return false;
            }

            if (strlen($long_url)>2000) {
                $this->error = "Your link is too long.";
                return false;
            }

            return true;
        }

        public function getCounter(){
            $this->error = "";
            $sql = "SELECT number FROM counters WHERE counter_name='short_url_number'";
            $stmt = $this->dbh->prepare($sql);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            $data = $stmt->fetch(PDO::FETCH_ASSOC);

            $sql = "UPDATE counters SET number = number + 1 WHERE counter_name='short_url_number'";
            $stmt = $this->dbh->prepare($sql);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }


            return $data["number"];
        }

        public function addLink($short_url, $long_url, $user_id, $date){
            $clicks = 0;
            $sql = "INSERT INTO urls (original_url, short_url, long_url, user_id, creation_date, clicks) VALUES (:original_url, :short_url, :long_url, :user_id, :creation_date, :clicks)";
            $stmt = $this->dbh->prepare($sql);
            $stmt->bindParam(":original_url" , $short_url, PDO::PARAM_STR);
            $stmt->bindParam(":short_url" , $short_url, PDO::PARAM_STR);
            $stmt->bindParam(":long_url" , $long_url, PDO::PARAM_STR);
            $stmt->bindParam(":user_id" , $user_id, PDO::PARAM_INT);
            $stmt->bindParam(":creation_date" , $date , PDO::PARAM_STR);
            $stmt->bindParam(":clicks" , $clicks, PDO::PARAM_INT);

            try {
                $stmt->execute();
            } catch(PDOException $e) {
                $this->error = "Error: ".$e->getCode();
                return false;
            }

            if(!$stmt) {
                $this->error = "Something went wrong.";
                return false;
            }

            return true;
        }

    }