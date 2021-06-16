<?php
    session_start();

    if(isset($_SESSION['online'])){
        unset($_SESSION['online']);
    }

    session_destroy();
    header("Location: /");
    exit();
