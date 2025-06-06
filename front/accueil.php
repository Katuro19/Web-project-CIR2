<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Accueil - Solaire</title>
  <link rel="stylesheet" href="/front/CSS/style_accueil.css" />
  <script src="/front/env.js" defer></script>
  <script src="utils.js" defer></script>
  <script src="/front/accueil.js" defer></script>
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
          <a href="/front/accueil.php">Accueil</a>
          <a href="/front/recherche.php">Recherche</a>
          <a href="/front/carte.php">Carte</a>
          <a href="/front/login.php">Se Connecter</a>
        </nav>
      </div>
    </div>
    <nav class="nav-mobile" id="navMobile">
      <a href="/front/accueil.php">Accueil</a>
      <a href="/front/recherche.php">Recherche</a>
      <a href="/front/carte.php">Carte</a>
      <a href="/front/login.php">Se Connecter</a>
    </nav>
  </header>
  <div class="layout">
    <aside class="sidebar">
      <img src="/front/image/pub1.png" alt="Publicité gauche" />
    </aside>
    <main class="main">
      <section class="section">
        <h2>Bienvenue</h2>
        <p>
          Ce site vous permet de consulter les installations solaires, leurs détails techniques,
          les localiser sur une carte et analyser des statistiques.
        </p>
      </section>

      <section class="section">
        <h2>Statistiques</h2>
        <div class="grid">
          <div class="box" id="enregistrement"></div>
          <div class="box" id="install_an"></div>
          <div class="box" id="install_region"></div>
          <div class="box" id="install_an_region"></div>
          <div class="box" id="installateur"></div>
          <div class="box" id="marque_onduleur"></div>
          <div class="box" id="marque_panneau"></div>
        </div>
      </section>

      <section class="section text-center">
        <h2>Accès rapide</h2>
        <a href="/front/recherche.php" class="btn">🔎 Recherche</a>
        <a href="/front/carte.php" class="btn">🗺️ Carte</a>
      </section>
    </main>
    <aside class="sidebar">
      <img src="/front/image/pub2.png" alt="Publicité droite" />
    </aside>
  </div>
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>
</body>
</html>