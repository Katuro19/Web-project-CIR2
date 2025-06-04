<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Carte - Solaire</title>
  <link rel="stylesheet" href="CSS/style_carte.css" />
</head>
<body class="page-carte">

  <!-- HEADER FIXE -->
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

  <!-- CONTENU PRINCIPAL -->
  <main class="main no-padding">
    <!-- Formulaire de recherche positionné sous la navbar -->
    <div class="search-bar-container">
      <form class="search-bar">
        <input type="number" placeholder="Année d'installation" />
        <input type="text" placeholder="Département" />
        <button type="submit" class="btn">Rechercher</button>
      </form>
    </div>

    <!-- Conteneur de la carte -->
    <div id="map-container"></div>
  </main>

  <!-- FOOTER FIXE -->
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>

  <script>
    function toggleMenu() {
      document.getElementById("navMobile").classList.toggle("show");
    }
  </script>
</body>
</html>
