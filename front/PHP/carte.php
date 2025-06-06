<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carte - Solaire</title>
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
  />
  <link rel="stylesheet" href="/front/CSS/style_carte.css" />
  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
  ></script>
  <script src="/front/JS/utils.js" defer></script>
  <script src="/front/JS/env.js" defer></script>
  <script src="/front/JS/carte.js" defer></script>
</head>
<body class="page-carte">
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
          <span></span>
          <span></span>
          <span></span>
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
  <main class="main no-padding">
    <div class="search-bar-container">
      <form id="formSearch" class="search-bar">
        <input
          type="text"
          id="selAnnee"
          placeholder="Année d'installation (ex : 2023)"
        />
        <input
          type="text"
          id="selDepartement"
          placeholder="Département (ex : 14)"
        />
        <button type="submit" class="btn">Rechercher</button>
      </form>
    </div>
    <div id="map-container"></div>
  </main>
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>
</body>
</html>
