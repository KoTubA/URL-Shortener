<?php

    if(isset($_GET["u"])) {
        $short_url = $_GET["u"];

        require_once("lib/Database.php");
        $db = new Database();
        $error = $db->getError();

        if(!empty($error)) {
            http_response_code(500);
            include('error/500.html');
            exit();
        }

        $result = $db->checkLinkRedirect($short_url);
        $error = $db->getError();

        if($result==false && !empty($error)) {
            http_response_code(500);
            include('error/500.html');
            exit();
        }
        else if($result==false) {
            http_response_code(404);
            include('error/404.html');
            exit();
        }

        $long_url = $result["long_url"];
        $result = $db->incrementLinkRedirect($short_url);
        $error = $db->getError();

        if($result==false) {
            http_response_code(500);
            include('error/500.html');
            exit();
        }
        else {
            header("Location: ".$long_url);
            exit();
        }
    }
?>