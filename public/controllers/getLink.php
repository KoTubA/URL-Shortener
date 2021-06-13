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
        $data = $data. <<<EOD
          <div class="panel-result-link-row">
              <div class="panel-result-link-data">{$row['short_url']}</div>
              <div class="panel-result-link-data">{$row['long_url']}</div>
              <div class="panel-result-link-data">{$row['creation_date']}</div>
              <div class="panel-result-link-data">{$row['clicks']}</div>
              <div class="panel-result-link-data">
                  <button class="panel-result-link-data-btn">
                      <img src="images/copy.svg" alt="Copy">
                  </button>
                  <button class="panel-result-link-data-btn">
                      <img src="images/edit.svg" alt="Edit">
                  </button>
                  <button class="panel-result-link-data-btn">
                      <img src="images/delete.svg" alt="Delete">
                  </button>
              </div>
          </div>
        EOD;
      }

      $r_errors["data"] = <<<EOD
        <div class="panel-result-counter">
            <span>Total Links: <span class="bold-text">{$number_of_links}</span> & total Clicks: <span
                    class="bold-text">{$number_of_total_clicks}</span></span>
            <a href="#" class="main-link">Clear All</a>
        </div>
        <div class="panel-result-links-wrapper">
            <div class="panel-result-links">
                <div class="panel-result-link-row panel-result-link-row-header">
                    <div class="panel-result-link-data">Shorten URL</div>
                    <div class="panel-result-link-data">Original URL</div>
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

?>