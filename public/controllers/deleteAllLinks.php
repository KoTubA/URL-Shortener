<?php

    header("Content-Type: application/json");
    session_start();

    if(!isset($_SESSION['online'])) {
        header('Location: /');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $r_errors = [[]];

        require_once("../lib/Database.php");
        $db = new Database();
        $error = $db->getError();

        if(!empty($error)) {
            $r_errors["success"] = false;
            $r_errors["error"] = $error;
            echo json_encode($r_errors);
            exit();
        }

        $result = $db->deleteAllLinks($_SESSION["id"]);
        $error = $db->getError();

        if($result==false && !empty($error)) {
            $r_errors["success"] = false;
            $r_errors["error"] = $error;
            echo json_encode($r_errors);
            exit();
        }
        else {
            $r_errors["success"] = true;
            echo json_encode($r_errors);
            exit();
        }
    }

?>