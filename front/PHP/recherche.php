<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Installations - Gestion de panneau solaire</title>
  <link rel="stylesheet" href="/front/CSS/style_recherche.css" />
  <script src="/front/JS/env.js" defer></script>
  <script src="/front/JS/utils.js" defer></script>
  <script src="/front/JS/recherche.js" defer></script>
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
    <section class="filter-section">
      <h2>Installations</h2>
      <form class="filter-form">
        <div class="form-group">
          <label>Marque onduleur :</label>
          <div class="multi-select" data-name="selOnduleur[]">
            <button type="button" class="multi-select-toggle">
              Sélectionner… <span class="arrow">▾</span>
            </button>
            <ul class="multi-select-options" id="selOnduleur">
              <!-- Les options sont ajoutées dynamiquement par JavaScript -->
            </ul>
          </div>
        </div>
        <div class="form-group">
          <label>Marque panneaux :</label>
          <div class="multi-select" data-name="selPanneaux[]">
            <button type="button" class="multi-select-toggle">
              Sélectionner… <span class="arrow">▾</span>
            </button>
            <ul class="multi-select-options" id="selPanneau">
              <!-- Les options sont ajoutées dynamiquement par JavaScript -->
            </ul>
          </div>
        </div>
        <div class="form-group">
          <label>Département :</label>
          <div class="multi-select" data-name="selDepartement[]">
            <button type="button" class="multi-select-toggle">
              Sélectionner… <span class="arrow">▾</span>
            </button>
            <ul class="multi-select-options" id="selDepartement">
              <!-- Les options sont ajoutées dynamiquement par JavaScript -->
            </ul>
          </div>
        </div>
        <div class="form-group button-group">
          <button type="button" class="btn-filter" id="filter_rechercher">Filtrer</button>
        </div>
      </form>
    </section>
    <section class="results-section">
      <div class="header-bar">
        <h2 id="titre_recherche">Résultats de la recherche</h2>

        <div class="items-per-page-selector">
          <label for="elements_par_page">Éléments par page :</label>
          <select id="elements_par_page">
            <option value="5">5</option>
            <option value="10" selected>10</option>
            <option value="20">20</option>
            <option value="50">50</option>
          </select>
        </div>
      </div>
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
            <!-- Les lignes du tableau sont ajoutées dynamiquement par JavaScript -->
          </tbody>
        </table>
      </div>
    </section>
    <div class="pagination">
      <button id="prevBtn" aria-label="Page précédente">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="15 18 9 12 15 6"></polyline>
        </svg>
      </button>

      <button id="nextBtn" aria-label="Page suivante">
        <svg width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
          stroke-linecap="round" stroke-linejoin="round">
          <polyline points="9 18 15 12 9 6"></polyline>
        </svg>
      </button>
    </div>
  </main>
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>
</body>

</html>