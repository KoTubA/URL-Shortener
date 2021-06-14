<?php

  session_start();

  if(!isset($_SESSION['online'])) {
    header('Location: /');
    exit();
  }

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="robots" content="index,follow" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="css/main.css">
    <title>Shortly | URL Shortner & Link Managment</title>
</head>

<body class="panel-wrapper">

    <header class="header header-panel">
        <div class="header-cnt header-panel-cnt">
            <div class="header-panel-home">
                <a href="/" class="company-logo-link">
                    <img src="images/logo-icon.svg" alt="company logo" class="company-logo">
                </a>
            </div>
            <button class="account-settings-toogle">
                <img src="images/profile-user.svg" alt="User">
                <img src="images/close.svg" alt="X">
            </button>
        </div>
    </header>
    <main class="main main-panel">
        <section class="panel">
            <div class="panel-cnt">
                <div class="panel-nav">
                    <div class="panel-nav-info">
                        <h1 class="panel-title">Links</h1>
                        <h2 class="panel-description"></h2>
                    </div>
                    <button type="button" class="main-btn main-btn-add">
                        <div class="add-btn">
                            <svg width="11" height="11" xmlns="http://www.w3.org/2000/svg">
                                <path d="M6.313 10.023v-3.71h3.71v-2.58h-3.71V.023h-2.58v3.71H.023v2.58h3.71v3.71z"
                                    fill="#2acfcf"></path>
                            </svg>
                        </div>
                        <div class="add-info">
                            <span>New </span><span class="add-info-plus">Link</span>
                        </div>
                    </button>
                </div>
                <div class="panel-result">
                    <div class="panel-result-feedback panel-result-cnt"></div>
                    <div class="panel-result-feedback panel-result-empty">
                        <img src="./images/undraw_empty_xct9.svg" alt="">
                        <h2 class="panel-title">There is nothing here.</h2>
                        <p class="panel-description">Create an link by clicking the <span>New</span> button and get
                            started.</p>
                    </div>
                    <div class="panel-result-feedback panel-result-error">
                        <img src="./images/undraw_server_down_s4lk.svg" alt="">
                        <h2 class="panel-title">Something went wrong.</h2>
                        <p class="panel-description">It's not you. It's us. If you see this message please contact us.</p>
                        <p class="panel-error"></p>
                    </div>
                    <div class="panel-result-loader">
                        <div class="loader"></div>
                    </div>
                </div>
            </div>
        </section>
        <section class="add-link">
            <form class="form-system form-panel" action="#" method="POST">
                <h2 class="add-link-title">Create Link</h2>
                <div class="form-fileds">
                    <label class="form-label" for="username">Long URL</label>
                    <input class="form-control" type="text" name="username"
                        autocorrect="off">
                    <span class="error-message"></span>
                </div>
                <div class="form-action-buttons">
                    <button type="button"
                        class="main-btn form-btn panel-btn no-fill-btn add-link-disable">Discard</button>
                    <button class="main-btn form-btn panel-btn">Create</button>
                </div>
            </form>
        </section>
        <section class="edit-link"></section>
        <section class="account-settings">
            <nav class="account-settings-nav">
                <ul class="account-settings-nav-items">
                    <li class="account-settings-nav-item"><a href="#">Profile Settings</a></li>
                    <li class="account-settings-nav-item"><a href="#">Help Center</a></li>
                    <li class="account-settings-nav-item"><a href="#">Change Plan</a></li>
                    <li class="account-settings-nav-item"><a href="#">Account Settings</a></li>
                </ul>
            </nav>
            <div class="form-action-buttons">
                <a href="sign_out" class="main-btn account-link-btn">Log Out</a>
            </div>
        </section>
        <div class="overlay overlay-panel"></div>
    </main>
    <div class="delete-feedback-error"></div>
    <div class="overlay-notification"></div>
    <script src="scripts/panel.js"></script>
    <script src="scripts/link.js"></script>
</body>

</html>