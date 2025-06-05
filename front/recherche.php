<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Installations - Gestion Panneaux Photovoltaïques</title>
  <link rel="stylesheet" href="CSS/style_recherche.css" />
  <script src="env.js" defer></script>
  <script src="recherche.js" defer></script>
</head>
<body class="page-carte">

  <!-- ==============================================
       HEADER FIXE EN HAUT
       ============================================== -->
  <header>
    <div class="header-content">
      <!-- Logo à gauche -->
      <div class="logo-title">
        <img src="image/logo.png" alt="Logo" class="logo" />
      </div>

      <!-- Titre centré -->
      <div class="title-container">
        <span class="title">Gestion Panneau Photovoltaïque</span>
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

  <!-- ==============================================
       MAIN (CONTENU ENTRE HEADER ET FOOTER)
       ============================================== -->
  <main class="content">
    <!-- SECTION FILTRAGE (BARRE DE RECHERCHE) -->
    <section class="filter-section">
      <h2>Installations</h2>
      <form class="filter-form">
        <!-- MULTI-SELECT « Marque onduleur » -->
        <div class="form-group">
          <label>Marque onduleur :</label>
          <div class="multi-select" data-name="selOnduleur[]">
            <button type="button" class="multi-select-toggle">
              Sélectionner… <span class="arrow">▾</span>
            </button>
            <ul class="multi-select-options" id="selOnduleur">
              <!-- Les options seront ajoutées dynamiquement par JavaScript -->
            </ul>
          </div>
        </div>

        <!-- MULTI-SELECT « Marque panneaux » -->
        <div class="form-group">
          <label>Marque panneaux :</label>
          <div class="multi-select" data-name="selPanneaux[]">
            <button type="button" class="multi-select-toggle">
              Sélectionner… <span class="arrow">▾</span>
            </button>
            <ul class="multi-select-options" id="selPanneau">
              <!-- Les options seront ajoutées dynamiquement par JavaScript -->
            </ul>
          </div>
        </div>

        <!-- MULTI-SELECT « Département » -->
        <div class="form-group">
          <label>Département :</label>
          <div class="multi-select" data-name="selDepartement[]">
            <button type="button" class="multi-select-toggle">
              Sélectionner… <span class="arrow">▾</span>
            </button>
            <ul class="multi-select-options" id="selDepartement">
              <!-- Les options seront ajoutées dynamiquement par JavaScript -->
            </ul>
          </div>
        </div>

        <!-- BOUTON FILTRER -->
        <div class="form-group button-group">
          <button type="button" class="btn-filter" id="filter_rechercher">Filtrer</button>
        </div>
      </form>
    </section>

    <!-- ==============================================
         SECTION RÉSULTATS (TABLEAU)
         ============================================== -->
    <section class="results-section">
      <h2>Résultats</h2>
      <div class="table-container">
        <table class="results-table">
          <thead>
            <tr>
              <th>Date d’installation</th>
              <th>Nombre de panneaux</th>
              <th>Surface (m²)</th>
              <th>Puissance crête (kW)</th>
              <th>Localisation</th>
              <th>Détail</th>
            </tr>
          </thead>
          <tbody id="resultat_recherche">
            <!-- Les lignes du tableau seront ajoutées dynamiquement par JavaScript -->
          </tbody>
        </table>
      </div>
    </section>
  </main>

  <!-- ==============================================
       FOOTER FIXE EN BAS
       ============================================== -->
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>

</body>
</html>
