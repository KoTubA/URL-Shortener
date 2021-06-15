<?php

    header("Content-Type: application/json");
    session_start();

    if(!isset($_SESSION['online'])) {
        header('Location: /');
        exit();
    }

    if($_SERVER['REQUEST_METHOD'] === 'POST') {
        $data = json_decode(file_get_contents("php://input"));
        $original_url = $data->original_url;
        $short_url = $data->short_url;
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

        $result = $db->validateLink($short_url);
        $error = $db->getError();
        if (!$result) {
            $r_errors["success"] = false;
            $r_errors["data"]["data-error"] = $error;
            echo json_encode($r_errors);
            exit();
        }

        $result = $db->ownLink($_SESSION["id"], $original_url);
        $error = $db->getError();

        if($result==false && !empty($error)) {
            $r_errors["success"] = false;
            $r_errors["data"]["error"] = $error;
            echo json_encode($r_errors);
            exit();
        }
        else if($result==false) {
            $r_errors["success"] = false;
            $r_errors["data"]["data-error"] = "You are not the owner of the link.";
            echo json_encode($r_errors);
            exit();
        }

        $result = $db->checkLink($short_url);
        $error = $db->getError();

        if($result==false && !empty($error)) {
            $r_errors["success"] = false;
            $r_errors["data"]["error"] = $error;
            echo json_encode($r_errors);
            exit();
        }
        else if($result==false) {
            $r_errors["success"] = false;
            $r_errors["data"]["data-error"] = "This custom link is taken.";
            echo json_encode($r_errors);
            exit();
        }

        $result = $db->editLink($_SESSION["id"], $original_url, $short_url);
        $error = $db->getError();

        if($result==false && !empty($error)) {
            $r_errors["success"] = false;
            $r_errors["data"]["error"] = $error;
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