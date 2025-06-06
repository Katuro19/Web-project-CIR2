<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Détails d’une installation</title>
  <link rel="stylesheet" href="/front/CSS/style_details.css" />
  <script src="/front/JS/env.js" defer></script>
  <script src="/front/JS/utils.js" defer></script>
  <script src="/front/JS/details.js" defer></script>
</head>
<body class="page-accueil">
  <header>
    <div class="header-content">
      <div class="logo-title">
        <img src="/front/image/logo.png" alt="Logo" class="logo" />
      </div>
      <div class="title-container">
        <span class="title">Gestion de panneau solaire</span>
      </div>
      <div class="right-menu">
        <div class="burger" id="burger" onclick="toggleMenu()">
          <span></span><span></span><span></span>
        </div>
        <nav class="nav-desktop">
          <a href="/front/PHP/accueil.php">Accueil</a>
          <a href="/front/PHP/recherche.php">Recherche</a>
          <a href="/front/PHP/carte.php">Carte</a>
          <a href="/front/PHP/login.php">Se Connecter</a>
        </nav>
      </div>
    </div>
    <nav class="nav-mobile" id="navMobile">
      <a href="/front/PHP/accueil.php">Accueil</a>
      <a href="/front/PHP/recherche.php">Recherche</a>
      <a href="/front/PHP/carte.php">Carte</a>
      <a href="/front/PHP/login.php">Se Connecter</a>
    </nav>
  </header>
  <main class="content">
    <section class="section">
      <h2>Détails de l’installation</h2>
      <div class="grid" id="details">
        
      </div>
    </section>
  </main>
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>
</body>
</html>
