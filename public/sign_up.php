<?php

  session_start();

  if(isset($_SESSION['online'])) {
    header('Location: panel.php');
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
        <h2 class="form-title">Sign up and start shortening</h2>
        <p class="form-description">Already have an account? <a href="sign_in.html" class="main-link">Login in</a></p>
        <form id="form-login" class="form-system" method="POST">
          <label class="form-label" for="username">Username</label>
          <input class="form-control" type="text" name="username" autocomplete="username" autocorrect="off"
            autocapitalize="none">
          <span class="error-message name-error"></span>
          <label class="form-label" for="username">Email address</label>
          <input class="form-control" type="text" name="email" autocomplete="email" autocorrect="off"
            autocapitalize="none">
          <span class="error-message email-error"></span>
          <label class="form-label" for="password">Password</label>
          <input class="form-control" type="password" name="password" autocomplete="current-password" autocorrect="off"
            autocapitalize="none">
          <span class="error-message password-error"></span>
          <ul class="password-tip-items">
            <li class="password-tip-item">6 or more characters</li>
            <li class="password-tip-item">One number</li>
            <li class="password-tip-item">One letter</li>
            <li class="password-tip-item">One special character</li>
          </ul>
          <button class="main-btn form-btn">Sign up with Email</button>
        </form>
        <div class="terms-and-conditions">
          <span>By creating an account, you agree to</span>
          <span>Shortly's <a href="#" class="main-link">Terms of Service</a> and <a href="#" class="main-link">Privacy
              Policy.</a></span>
        </div>
      </div>
    </section>
  </main>
  <script src="scripts/main.js"></script>
  <script src="scripts/login.js"></script>
</body>

</html>