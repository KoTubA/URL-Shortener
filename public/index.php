<?php

    require_once("controllers/redirect.php");
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
    <section class="intro">
      <div class="intro-cnt">
        <div class="illustration-intro">
          <img src="images/illustration-working.svg" alt="">
        </div>
        <div class="info-description-cnt">
          <h1 class="info-title">More than just shorter links</h1>
          <p class="info-description">Build your brand’s recognition and get detailed insights on how your
            links are
            performing.</p>
          <a href="pricing" class="main-btn get-started-btn">Get Started</a>
        </div>
      </div>
    </section>
    <section class="shorten-link">
      <div class="shorten-link-cnt">
        <form id="short-link" class="form-system" action="#" method="POST">
          <h2 class="shorten-link-title">Shorten function section</h2>
          <div class="shorten-link-input-group">
            <label class="shorten-link-label" for="long-url">Input link downbelow</label>
            <input id="shorten-link-input-field" name="long-url" placeholder="Shorten a link here...">
            <span class="error-message error-message-absolute"></span>
          </div>
          <button class="main-btn shorten-link-btn">Shorten It!</button>
        </form>
        </div>
    </section>
    <section class="shorten-link-result">
      <div class="shorten-link-result-cnt">
        <h2 class="shorten-link-title shorten-link-title-result">Shorten result section</h2>
      </div>
    </section>
    <section class="advanced-statistics">
      <div class="advanced-statistics-cnt">
        <h2 class="advanced-statistics-title">Advanced Statistics</h2>
        <p class="advanced-statistics-description">Track how your links are performing across the web with our
          advanced statistics dashboard.</p>
        <div class="statistics-cards">
          <div class="statistics-card">
            <div class="statistics-card-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40">
                <path fill="#2BD0D0"
                  d="M36.406 11.719c.648 0 1.172.524 1.172 1.172v24.765h1.25a1.172 1.172 0 110 2.344H1.172a1.172 1.172 0 110-2.344h1.25V24.61c0-.647.524-1.172 1.172-1.172H8.28c.648 0 1.172.525 1.172 1.172v13.047h2.344v-8.36c0-.646.524-1.171 1.172-1.171h4.687c.648 0 1.172.525 1.172 1.172v8.36h2.344V19.921c0-.647.524-1.172 1.172-1.172h4.687c.648 0 1.172.525 1.172 1.172v17.734h2.344V12.891c0-.648.524-1.172 1.172-1.172zm-1.172 2.344h-2.343v23.593h2.343V14.063zm-9.375 7.03h-2.343v16.563h2.343V21.094zm-9.375 9.376h-2.343v7.187h2.343V30.47zM7.11 25.78H4.766v11.875h2.343V25.781zM34.062 0a3.52 3.52 0 013.516 3.516 3.52 3.52 0 01-3.516 3.515c-.72 0-1.389-.217-1.947-.59l-4.073 3.055a3.52 3.52 0 01-3.355 4.567 3.496 3.496 0 01-1.514-.344l-4.689 4.688c.22.459.344.973.344 1.515a3.52 3.52 0 01-3.515 3.515 3.52 3.52 0 01-3.488-3.949l-3.45-1.724a3.503 3.503 0 01-2.438.986 3.52 3.52 0 01-3.515-3.516 3.52 3.52 0 013.515-3.515 3.52 3.52 0 013.488 3.949l3.45 1.725a3.503 3.503 0 013.952-.643l4.689-4.688a3.496 3.496 0 01-.344-1.515 3.52 3.52 0 013.515-3.516c.72 0 1.39.218 1.948.59l4.073-3.054A3.52 3.52 0 0134.063 0zm-18.75 18.75c-.646 0-1.171.526-1.171 1.172 0 .646.525 1.172 1.171 1.172.647 0 1.172-.526 1.172-1.172 0-.646-.525-1.172-1.172-1.172zm-9.374-4.688c-.647 0-1.172.526-1.172 1.172 0 .646.525 1.172 1.171 1.172.647 0 1.172-.526 1.172-1.172 0-.646-.525-1.171-1.171-1.171zm18.75-4.687c-.647 0-1.172.526-1.172 1.172 0 .646.525 1.172 1.172 1.172.646 0 1.171-.526 1.171-1.172 0-.646-.525-1.172-1.172-1.172zm9.375-7.031c-.647 0-1.172.526-1.172 1.172 0 .646.525 1.171 1.172 1.171.646 0 1.171-.525 1.171-1.171s-.525-1.172-1.172-1.172z" />
              </svg>
            </div>
            <h3 class="statistics-card-title">Brand Recognition</h3>
            <p class="statistics-card-description">Boost your brand recognition with each click. Generic
              links don’t mean a thing. Branded links help instil confidence in your content.</p>
          </div>
          <div class="statistics-card">
            <div class="statistics-card-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40">
                <path fill="#2BD0D0"
                  d="M19.968 0c11.01 0 19.969 8.958 19.969 19.968s-8.958 19.969-19.969 19.969C8.958 39.937 0 30.979 0 19.968 0 8.958 8.958 0 19.968 0zm7.805 35.579c-4.863-2.402-10.746-2.402-15.609 0a17.339 17.339 0 007.804 1.862 17.34 17.34 0 007.805-1.862zm-6.556-33.02V6.24H18.72V2.56a17.362 17.362 0 00-9.492 3.656l2.798 2.797-1.765 1.765L7.373 7.89a17.41 17.41 0 00-4.678 9.582h4.793v2.497H2.496c0 5.805 2.857 10.943 7.227 14.122 6.217-3.714 14.274-3.714 20.49 0 4.37-3.179 7.228-8.317 7.228-14.123h-4.992v-2.496h4.793a17.41 17.41 0 00-4.678-9.582l-2.888 2.888-1.765-1.765 2.798-2.797a17.362 17.362 0 00-9.492-3.657zm-2.437 8.292c.332-1.034 2.045-1.034 2.377 0 .635 1.978 3.804 11.955 3.804 14.11a4.997 4.997 0 01-4.993 4.992 4.997 4.997 0 01-4.992-4.992c0-2.155 3.17-12.132 3.804-14.11zm1.188 4.567c-1.233 4.047-2.496 8.522-2.496 9.543a2.5 2.5 0 002.496 2.496 2.5 2.5 0 002.497-2.496c0-1.02-1.263-5.496-2.497-9.543z" />
              </svg>
            </div>
            <h3 class="statistics-card-title">Detailed Records</h3>
            <p class="statistics-card-description">Gain insights into who is clicking your links. Knowing
              when and where people engage with your content helps inform better decisions.</p>
          </div>
          <div class="statistics-card">
            <div class="statistics-card-icon">
              <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48">
                <path fill="#2BD0D0"
                  d="M46.608 6.02a.975.975 0 00-.927-.047l-7.624 3.591a8.283 8.283 0 00-4.728 6.837l-.196 2.436-3.95 6.561v-2.801c0-.01-.006-.017-.006-.027a.974.974 0 00-.046-.284l-1.838-5.514 3.753-7.504a.984.984 0 00-.099-1.03l-5.9-7.867a1.019 1.019 0 00-1.573 0L17.573 8.24a.984.984 0 00-.093 1.03l3.753 7.503-1.838 5.514a.974.974 0 00-.047.284v3.951l-6.127-9.299c-.007-.01-.02-.017-.026-.026a.995.995 0 00-.211-.215c-.02-.013-.036-.03-.056-.042-.02-.013-.022-.02-.035-.027l-3.605-2.085-1.497-2.271L5.628 9.27a.983.983 0 00-1.147-.386L.654 10.227a.983.983 0 00-.491 1.468l2.705 4.107 1.492 2.27.492 4.137a.36.36 0 00.01.04c.004.02.009.041.015.061a.973.973 0 00.116.295c.007.01.007.023.014.033.007.01 14.624 22.165 14.695 22.225A4.87 4.87 0 0024.255 48c.4 0 .8-.05 1.19-.145a4.886 4.886 0 003.028-2.235l13.08-21.698 2.065-1.307a8.343 8.343 0 002.66-2.721 8.259 8.259 0 001.18-4.651l-.383-8.42a.984.984 0 00-.467-.803zm-7.122 17.524l-1.522 2.527-5.054-3.048 1.524-2.527 5.052 3.048zM21.315 38.446V23.58h5.9v5.08l-5.9 9.786zm1.693-20.766h2.515l1.31 3.933h-5.136l1.31-3.933zm1.257-6.885a.983.983 0 110-1.966.983.983 0 010 1.966zm0-8.194l4.75 6.331-3.39 6.78h-.377v-3.13a2.95 2.95 0 10-1.966 0v3.13h-.376l-3.39-6.78 4.75-6.331zM10.53 17.818l-.29.19-3.621 2.387-.333-2.787a.982.982 0 00-.156-.424l-1.081-1.642L6.69 14.46l1.081 1.642a.988.988 0 00.329.31l2.429 1.406zm-6.122-6.826l1.2 1.822-1.642 1.082-1.475-2.232 1.917-.672zm5.249 9.755l2.458-1.624 7.233 10.972v10.726L7.193 22.371l2.464-1.624zm17.135 23.851a2.95 2.95 0 11-5.052-3.048l7.425-12.315h.017v-.027l2.712-4.499 2.527 1.526 2.53 1.52-10.16 16.843zm17.807-25.724a6.353 6.353 0 01-2.028 2.073l-1.747 1.107-2.852-1.717-2.852-1.717.162-2.065a6.318 6.318 0 013.604-5.213L45.18 8.38l.125 2.74a.973.973 0 00-.295.014l-2.382.59a5.986 5.986 0 00-4.425 4.524.983.983 0 001.919.43 4.032 4.032 0 012.977-3.043l2.297-.57.103 2.262a6.304 6.304 0 01-.9 3.548z" />
              </svg>
            </div>
            <h3 class="statistics-card-title">Fully Customizable</h3>
            <p class="statistics-card-description">Improve brand awareness and content discoverability
              through customizable links, supercharging audience engagement.</p>
          </div>
        </div>
      </div>
    </section>
    <section class="summary">
      <div class="summary-cnt">
        <h2 class="summary-title">Boost your links today</h2>
        <a href="pricing" class="main-btn get-started-btn">Get Started</a>
      </div>
    </section>
  </main>
  <footer class="footer">
    <div class="footer-cnt">
      <a href="/" class="company-logo-link-footer">
        <img src="images/logo-white.svg" alt="company logo" class="company-logo">
      </a>
      <div class="footer-nav">
        <div class="footer-nav-items-wrapper">
          <h4 class="footer-nav-title">Features</h4>
          <ul class="footer-nav-items">
            <li class="footer-nav-item"><a href="#">Link Shortening</a></li>
            <li class="footer-nav-item"><a href="#">Branded Links</a></li>
            <li class="footer-nav-item"><a href="#">Analytics</a></li>
          </ul>
        </div>
        <div class="footer-nav-items-wrapper">
          <h4 class="footer-nav-title">Resources</h4>
          <ul class="footer-nav-items">
            <li class="footer-nav-item"><a href="#">Blog</a></li>
            <li class="footer-nav-item"><a href="#">Developers</a></li>
            <li class="footer-nav-item"><a href="#">Support</a></li>
          </ul>
        </div>
        <div class="footer-nav-items-wrapper">
          <h4 class="footer-nav-title">Company</h4>
          <ul class="footer-nav-items">
            <li class="footer-nav-item"><a href="#">About</a></li>
            <li class="footer-nav-item"><a href="#">Our Team</a></li>
            <li class="footer-nav-item"><a href="#">Careers</a></li>
            <li class="footer-nav-item"><a href="#">Contact</a></li>
          </ul>
        </div>
      </div>
      <div class="footer-social-media">
        <ul class="footer-social-media-items">
          <li class="footer-social-media-item">
            <a href="#" aria-label="facebook">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="#FFF"
                  d="M22.675 0H1.325C.593 0 0 .593 0 1.325v21.351C0 23.407.593 24 1.325 24H12.82v-9.294H9.692v-3.622h3.128V8.413c0-3.1 1.893-4.788 4.659-4.788 1.325 0 2.463.099 2.795.143v3.24l-1.918.001c-1.504 0-1.795.715-1.795 1.763v2.313h3.587l-.467 3.622h-3.12V24h6.116c.73 0 1.323-.593 1.323-1.325V1.325C24 .593 23.407 0 22.675 0z" />
              </svg>
            </a>
          </li>
          <li class="footer-social-media-item">
            <a href="#" aria-label="twitter"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="20">
                <path fill="#FFF"
                  d="M24 2.557a9.83 9.83 0 01-2.828.775A4.932 4.932 0 0023.337.608a9.864 9.864 0 01-3.127 1.195A4.916 4.916 0 0016.616.248c-3.179 0-5.515 2.966-4.797 6.045A13.978 13.978 0 011.671 1.149a4.93 4.93 0 001.523 6.574 4.903 4.903 0 01-2.229-.616c-.054 2.281 1.581 4.415 3.949 4.89a4.935 4.935 0 01-2.224.084 4.928 4.928 0 004.6 3.419A9.9 9.9 0 010 17.54a13.94 13.94 0 007.548 2.212c9.142 0 14.307-7.721 13.995-14.646A10.025 10.025 0 0024 2.557z" />
              </svg>
            </a>
          </li>
          <li class="footer-social-media-item">
            <a href="#" aria-label="pinterest">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="#FFF"
                  d="M12 0C5.373 0 0 5.372 0 12c0 5.084 3.163 9.426 7.627 11.174-.105-.949-.2-2.405.042-3.441.218-.937 1.407-5.965 1.407-5.965s-.359-.719-.359-1.782c0-1.668.967-2.914 2.171-2.914 1.023 0 1.518.769 1.518 1.69 0 1.029-.655 2.568-.994 3.995-.283 1.194.599 2.169 1.777 2.169 2.133 0 3.772-2.249 3.772-5.495 0-2.873-2.064-4.882-5.012-4.882-3.414 0-5.418 2.561-5.418 5.207 0 1.031.397 2.138.893 2.738a.36.36 0 01.083.345l-.333 1.36c-.053.22-.174.267-.402.161-1.499-.698-2.436-2.889-2.436-4.649 0-3.785 2.75-7.262 7.929-7.262 4.163 0 7.398 2.967 7.398 6.931 0 4.136-2.607 7.464-6.227 7.464-1.216 0-2.359-.631-2.75-1.378l-.748 2.853c-.271 1.043-1.002 2.35-1.492 3.146C9.57 23.812 10.763 24 12 24c6.627 0 12-5.373 12-12 0-6.628-5.373-12-12-12z" />
              </svg>
            </a>
          </li>
          <li class="footer-social-media-item">
            <a href="#" aria-label="instagram">
              <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24">
                <path fill="#FFF"
                  d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zM12 0C8.741 0 8.333.014 7.053.072 2.695.272.273 2.69.073 7.052.014 8.333 0 8.741 0 12c0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98C8.333 23.986 8.741 24 12 24c3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98C15.668.014 15.259 0 12 0zm0 5.838a6.162 6.162 0 100 12.324 6.162 6.162 0 000-12.324zM12 16a4 4 0 110-8 4 4 0 010 8zm6.406-11.845a1.44 1.44 0 100 2.881 1.44 1.44 0 000-2.881z" />
              </svg>
            </a>
          </li>
        </ul>
      </div>
    </div>
  </footer>
  <script src="scripts/main.js"></script>
  <script src="scripts/addLink.js"></script>
</body>

</html>