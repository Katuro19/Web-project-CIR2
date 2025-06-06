<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Détails d’une installation</title>
  <link rel="stylesheet" href="CSS/style_details.css" />
  <script src="env.js" defer></script>
  <script src="utils.js" defer></script>
  <script src="details.js" defer></script>
</head>
<body class="page-accueil">
  <!-- HEADER FIXE -->
  <header>
    <div class="header-content">
      <!-- Logo à gauche -->
      <div class="logo-title">
        <img src="image/logo.png" alt="Logo" class="logo" />
      </div>

      <!-- Titre centré -->
      <div class="title-container">
        <span class="title">Gestion de panneau solaire</span>
      </div>

      <!-- Burger et menu desktop à droite -->
      <div class="right-menu">
        <div class="burger" id="burger" onclick="toggleMenu()">
          <span></span><span></span><span></span>
        </div>
        <nav class="nav-desktop">
          <a href="accueil.php">Accueil</a>
          <a href="recherche.php">Recherche</a>
          <a href="carte.php">Carte</a>
          <a href="login.php">Se Connecter</a>
        </nav>
      </div>
    </div>

    <!-- Menu mobile (initialement caché) -->
    <nav class="nav-mobile" id="navMobile">
      <a href="accueil.php">Accueil</a>
      <a href="recherche.php">Recherche</a>
      <a href="carte.php">Carte</a>
      <a href="login.php">Se Connecter</a>
    </nav>
  </header>

  <!-- CONTENU PRINCIPAL -->
  <main class="content">
    <section class="section">
      <h2>Détails de l’installation</h2>
      <div class="grid" id="details">
        
      </div>
    </section>
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
