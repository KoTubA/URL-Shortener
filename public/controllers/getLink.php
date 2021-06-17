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

        $result = $db->getLink($_SESSION["id"]);
        $error = $db->getError();

        if($result==false && !empty($error)) {
            $r_errors["success"] = false;
            $r_errors["error"] = $error;
            echo json_encode($r_errors);
            exit();
        }
        else if($result==false) {
            $r_errors["success"] = false;
            echo json_encode($r_errors);
            exit();
        }
        else {
            $r_errors["success"] = true;
            $number_of_links = 0;
            $number_of_total_clicks = 0;
            $data = "";

            foreach($result as $row) {
                $number_of_links++;
                $number_of_total_clicks += $row["clicks"];
                $hostname = $_SERVER['HTTP_HOST'];
                $data = $data. <<<EOD
                    <div class="panel-result-link-row">
                        <div class="panel-result-link-data"><span>{$hostname}/?u={$row['short_url']}</span></div>
                        <div class="panel-result-link-data"><span>{$row['long_url']}</span></div>
                        <div class="panel-result-link-data panel-result-link-date">{$row['creation_date']}</div>
                        <div class="panel-result-link-data panel-result-link-data-clicks">{$row['clicks']}</div>
                        <div class="panel-result-link-data">
                            <button class="panel-result-link-data-btn panel-result-link-data-btn-cpy" data-clipboard-text="{$hostname}/?u={$row['short_url']}">
                                <img src="images/copy.svg" alt="Copy">
                            </button>
                            <button class="panel-result-link-data-btn panel-result-link-data-btn-edit" data-original-url="{$row['original_url']}">
                                <img src="images/edit.svg" alt="Edit">
                            </button>
                            <button class="panel-result-link-data-btn panel-result-link-data-btn-delete" data-original-url="{$row['original_url']}">
                                <img src="images/delete.svg" alt="Delete">
                            </button>
                        </div>
                    </div>
                EOD;
            }

            $r_errors["data"] = <<<EOD
            <div class="panel-result-counter">
                <span class="panel-result-counter-data"><span class="panel-result-counter-data-total">Total Links: <span class="bold-text">{$number_of_links}</span></span><span class="panel-result-counter-data-and">&</span><span class="panel-result-counter-data-total">Total Clicks: <span
                        class="bold-text">{$number_of_total_clicks}</span></span></span>
                <button class="main-link main-link-clear-all">Clear All</button>
            </div>
            <div class="panel-result-links-wrapper">
                <div class="panel-result-links">
                    <div class="panel-result-link-row panel-result-link-row-header">
                        <div class="panel-result-link-data">Shorten URL</div>
                        <div class="panel-result-link-data">Long URL</div>
                        <div class="panel-result-link-data">Created</div>
                        <div class="panel-result-link-data">Clicks</div>
                        <div class="panel-result-link-data">Action</div>
                    </div>
                    {$data}
                </div>
            </div>
            EOD;

            echo json_encode($r_errors);
            exit();
        }
    }

    exit();

?>