<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carte - Solaire</title>

  <!-- CSS Leaflet -->
  <link
    rel="stylesheet"
    href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
    integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
    crossorigin=""
  />

  <!-- Votre CSS existant pour “page-carte” -->
  <link rel="stylesheet" href="CSS/style_carte.css" />

  <!-- Leaflet JS + vos scripts JS -->
  <script
    src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
    integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
    crossorigin=""
  ></script>
  <!-- env.js contient : const api_link = "http://localhost/back/API/request.php"; -->
  <script src="env.js" defer></script>
  <!-- carte.js contiendra la logique pour récupérer l’API et afficher les marqueurs -->
  <script src="carte.js" defer></script>
</head>
<body class="page-carte">

  <!-- === HEADER FIXE === -->
  <header>
    <div class="header-content">
      <div class="logo-title">
        <img src="image/logo.png" alt="Logo" class="logo" />
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
          <a href="accueil.php">Accueil</a>
          <a href="recherche.php">Recherche</a>
          <a href="carte.php">Carte</a>
          <a href="login.php">Se Connecter</a>
        </nav>
      </div>
    </div>
    <nav class="nav-mobile" id="navMobile">
      <a href="accueil.php">Accueil</a>
      <a href="recherche.php">Recherche</a>
      <a href="carte.php">Carte</a>
      <a href="login.php">Se Connecter</a>
    </nav>
  </header>

  <!-- === CONTENU PRINCIPAL === -->
  <main class="main no-padding">
    <!-- Formulaire de recherche sous la navbar -->
    <div class="search-bar-container">
      <form id="formSearch" class="search-bar">
        <!-- Champ texte pour l’année (ex : 2023) -->
        <input
          type="text"
          id="selAnnee"
          placeholder="Année d'installation (ex : 2023)"
        />
        <!-- Champ texte pour le code INSEE du département (ex : 14) -->
        <input
          type="text"
          id="selDepartement"
          placeholder="Département (ex : 14)"
        />
        <button type="submit" class="btn">Rechercher</button>
      </form>
    </div>

    <!-- Conteneur de la carte Leaflet -->
    <div id="map-container"></div>
  </main>

  <!-- === FOOTER FIXE === -->
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>

  <!-- Script pour le menu mobile -->
  <script>
    function toggleMenu() {
      document.getElementById("navMobile").classList.toggle("show");
    }
  </script>
</body>
</html>
