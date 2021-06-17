<?php

    session_start();

    if(isset($_SESSION['online'])) {
        header('Location: panel');
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
  <meta name="description" content="Shortly is a URL shortener tool that shortens long links to more manageable and useable URLs.">
  <link rel="preconnect" href="https://fonts.gstatic.com">
  <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/main.css">
  <title>Shortly | URL Shortner & Link Managment</title>
</head>

<body>

  <div class="overlay"></div>
  <header class="header">
    <div class="header-cnt">
      <a href="/" class="company-logo-link">
        <img src="images/logo.svg" alt="company logo" class="company-logo">
      </a>
      <nav class="nav">
        <ul class="container-nav-items">
          <li class="nav-item"><a href="features">Features</a></li>
          <li class="nav-item"><a href="pricing">Pricing</a></li>
          <li class="nav-item"><a href="resources">Resources</a></li>
        </ul>
        <div class="side-nav-items">
          <a href="sign_in" class="main-btn-opposed side-nav-btn">Login</a>
          <a href="sign_up" class="main-btn side-nav-btn">Sign Up</a>
        </div>
      </nav>
      <button class="mobile-nav-toogle">
        <img src="images/icon-burger.svg" alt="=">
      </button>
    </div>
  </header>
  <main class="main">
    <section class="form">
      <div class="form-cnt">
        <h2 class="form-title">Log in and start sharing</h2>
        <p class="form-description">Don't have an account? <a href="sign_up" class="main-link">Sign Up</a></p>
        <form id="form-login" class="form-system" method="POST">
          <div class="form-feedback"></div>
          <label class="form-label" for="username">Email address or Username</label>
          <input class="form-control" type="text" name="username" autocomplete="username email" autocorrect="off"
            autocapitalize="none">
          <label class="form-label" for="password">Password</label>
          <input class="form-control" type="password" name="password" autocomplete="current-password" autocorrect="off"
            autocapitalize="none">
          <span class="error-message data-error"></span>
          <a class="main-link form-link" href="" target="_blank">Forgot password?</a>
          <button class="main-btn form-btn">Log in</button>
        </form>
      </div>
    </section>
  </main>
  <script src="scripts/main.js"></script>
  <script src="scripts/login.js"></script>
</body>

</html>