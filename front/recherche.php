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
          <button type="submit" class="btn-filter">Filtrer</button>
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
          <tbody>
            <!-- 20 lignes d’exemple -->
            <tr>
              <td data-label="Date d’installation">03-2025</td>
              <td data-label="Nombre de panneaux">12</td>
              <td data-label="Surface (m²)">24.5</td>
              <td data-label="Puissance crête (kW)">5.0</td>
              <td data-label="Localisation">Caen</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">12-2024</td>
              <td data-label="Nombre de panneaux">8</td>
              <td data-label="Surface (m²)">16.0</td>
              <td data-label="Puissance crête (kW)">3.2</td>
              <td data-label="Localisation">Rennes</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <!-- … autres lignes … -->
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
