<?php

    header("Content-Type: application/json");
    session_start();

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        $long_url = $data->long_url;
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

        $result = $db->validateLongLink($long_url);
        $error = $db->getError();
        if (!$result) {
            $r_errors["success"] = false;
            $r_errors["data"]["data-error-add"] = $error;
            echo json_encode($r_errors);
            exit();
        }

        $f_link = false;
        $short_url;
        require_once("../helpers/base62.php");

        while(!$f_link) {
            $result = $db->getCounter();
            $error = $db->getError();

            if($result==false && !empty($error)) {
                $r_errors["success"] = false;
                $r_errors["data"]["error"] = $error;
                echo json_encode($r_errors);
                exit();
            }
            else {
                $short_url = $result;
                $short_url = toBase($short_url);
            }

            $result = $db->checkLink($short_url);
            $error = $db->getError();

            if($result==false && !empty($error)) {
                $r_errors["success"] = false;
                $r_errors["data"]["error"] = $error;
                echo json_encode($r_errors);
                exit();
            }
            else if($result==true) {
                $f_link = true;
            }
        }

        $id = null;
        if(isset($_SESSION['online'])) {
            $id = $_SESSION["id"];
        }
        $date = date('Y-m-d');
        $result = $db->addLink($short_url, $long_url, $id, $date);
        $error = $db->getError();

        if(!$result) {
            $r_errors["success"] = false;
            $r_errors["data"]["error"] = $error;
            echo json_encode($r_errors);
            exit();
        }

        if(!isset($_SESSION['online'])) {
            $short_url = $_SERVER['HTTP_HOST']."/?u=".$short_url;
        }

        $r_errors["success"] = true;
        $r_errors["data"]["date"] = $date;
        $r_errors["data"]["original-url"] = $short_url;
        $r_errors["data"]["short-url"] = $short_url;
        $r_errors["data"]["long-url"] = $long_url;
        echo json_encode($r_errors);
        exit();
    }

    exit();

?>
