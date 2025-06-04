<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Installations - Gestion Panneaux Photovoltaïques</title>
  <link rel="stylesheet" href="CSS/style_recherche.css" />
</head>
<body class="page-carte">

  <!-- HEADER FIXE -->
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

  <!-- CONTENU PRINCIPAL -->
  <main class="content">
    <!-- SECTION FILTRAGE -->
    <section class="filter-section">
      <h2>Installations</h2>
      <form class="filter-form">
        <div class="form-group">
          <label for="selOnduleur">Marque onduleur :</label>
          <select id="selOnduleur">
            <option value="" disabled selected>Selection...</option>
            <option>Onduleur A</option><option>Onduleur B</option><option>Onduleur C</option>
            <option>Onduleur D</option><option>Onduleur E</option><option>Onduleur F</option>
            <option>Onduleur G</option><option>Onduleur H</option><option>Onduleur I</option>
            <option>Onduleur J</option><option>Onduleur K</option><option>Onduleur L</option>
            <option>Onduleur M</option><option>Onduleur N</option><option>Onduleur O</option>
            <option>Onduleur P</option><option>Onduleur Q</option><option>Onduleur R</option>
            <option>Onduleur S</option><option>Onduleur T</option>
          </select>
        </div>
        <div class="form-group">
          <label for="selPanneaux">Marque panneaux :</label>
          <select id="selPanneaux">
            <option value="" disabled selected>Selection...</option>
            <option>Panneau A</option><option>Panneau B</option><option>Panneau C</option>
            <option>Panneau D</option><option>Panneau E</option><option>Panneau F</option>
            <option>Panneau G</option><option>Panneau H</option><option>Panneau I</option>
            <option>Panneau J</option><option>Panneau K</option><option>Panneau L</option>
            <option>Panneau M</option><option>Panneau N</option><option>Panneau O</option>
            <option>Panneau P</option><option>Panneau Q</option><option>Panneau R</option>
            <option>Panneau S</option><option>Panneau T</option>
          </select>
        </div>
        <div class="form-group">
          <label for="selDepartement">Département :</label>
          <select id="selDepartement">
            <option value="" disabled selected>Selection...</option>
            <option>Ain (01)</option><option>Aisne (02)</option><option>Allier (03)</option>
            <option>Alpes-de-Haute-Provence (04)</option><option>Hautes-Alpes (05)</option>
            <option>Alpes-Maritimes (06)</option><option>Ardèche (07)</option><option>Ardennes (08)</option>
            <option>Ariège (09)</option><option>Aube (10)</option><option>Aude (11)</option>
            <option>Aveyron (12)</option><option>Bouches-du-Rhône (13)</option><option>Calvados (14)</option>
            <option>Cantal (15)</option><option>Charente (16)</option><option>Charente-Maritime (17)</option>
            <option>Cher (18)</option><option>Corrèze (19)</option><option>Corse-du-Sud (2A)</option>
          </select>
        </div>
        <div class="form-group button-group">
          <button type="submit" class="btn-filter">Filtrer</button>
        </div>
      </form>
    </section>

    <!-- SECTION RÉSULTATS -->
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
            <tr>
              <td data-label="Date d’installation">06-2024</td>
              <td data-label="Nombre de panneaux">10</td>
              <td data-label="Surface (m²)">20.0</td>
              <td data-label="Puissance crête (kW)">4.0</td>
              <td data-label="Localisation">Caen</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">04-2024</td>
              <td data-label="Nombre de panneaux">14</td>
              <td data-label="Surface (m²)">28.0</td>
              <td data-label="Puissance crête (kW)">5.6</td>
              <td data-label="Localisation">Paris</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">01-2024</td>
              <td data-label="Nombre de panneaux">6</td>
              <td data-label="Surface (m²)">12.0</td>
              <td data-label="Puissance crête (kW)">2.4</td>
              <td data-label="Localisation">Lyon</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">11-2023</td>
              <td data-label="Nombre de panneaux">11</td>
              <td data-label="Surface (m²)">22.0</td>
              <td data-label="Puissance crête (kW)">4.4</td>
              <td data-label="Localisation">Marseille</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">09-2023</td>
              <td data-label="Nombre de panneaux">9</td>
              <td data-label="Surface (m²)">18.0</td>
              <td data-label="Puissance crête (kW)">3.6</td>
              <td data-label="Localisation">Toulouse</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">07-2023</td>
              <td data-label="Nombre de panneaux">13</td>
              <td data-label="Surface (m²)">26.0</td>
              <td data-label="Puissance crête (kW)">5.2</td>
              <td data-label="Localisation">Bordeaux</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">05-2023</td>
              <td data-label="Nombre de panneaux">7</td>
              <td data-label="Surface (m²)">14.0</td>
              <td data-label="Puissance crête (kW)">2.8</td>
              <td data-label="Localisation">Nantes</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">02-2023</td>
              <td data-label="Nombre de panneaux">10</td>
              <td data-label="Surface (m²)">20.0</td>
              <td data-label="Puissance crête (kW)">4.0</td>
              <td data-label="Localisation">Strasbourg</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">10-2022</td>
              <td data-label="Nombre de panneaux">12</td>
              <td data-label="Surface (m²)">24.0</td>
              <td data-label="Puissance crête (kW)">4.8</td>
              <td data-label="Localisation">Lille</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">08-2022</td>
              <td data-label="Nombre de panneaux">8</td>
              <td data-label="Surface (m²)">16.0</td>
              <td data-label="Puissance crête (kW)">3.2</td>
              <td data-label="Localisation">Nice</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">06-2022</td>
              <td data-label="Nombre de panneaux">9</td>
              <td data-label="Surface (m²)">18.0</td>
              <td data-label="Puissance crête (kW)">3.6</td>
              <td data-label="Localisation">Montpellier</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">04-2022</td>
              <td data-label="Nombre de panneaux">13</td>
              <td data-label="Surface (m²)">26.0</td>
              <td data-label="Puissance crête (kW)">5.2</td>
              <td data-label="Localisation">Rennes</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">02-2022</td>
              <td data-label="Nombre de panneaux">7</td>
              <td data-label="Surface (m²)">14.0</td>
              <td data-label="Puissance crête (kW)">2.8</td>
              <td data-label="Localisation">Caen</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">12-2021</td>
              <td data-label="Nombre de panneaux">11</td>
              <td data-label="Surface (m²)">22.0</td>
              <td data-label="Puissance crête (kW)">4.4</td>
              <td data-label="Localisation">Toulouse</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">10-2021</td>
              <td data-label="Nombre de panneaux">9</td>
              <td data-label="Surface (m²)">18.0</td>
              <td data-label="Puissance crête (kW)">3.6</td>
              <td data-label="Localisation">Lyon</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
            <tr>
              <td data-label="Date d’installation">08-2021</td>
              <td data-label="Nombre de panneaux">14</td>
              <td data-label="Surface (m²)">28.0</td>
              <td data-label="Puissance crête (kW)">5.6</td>
              <td data-label="Localisation">Bordeaux</td>
              <td data-label="Détail"><a href="details.php">Voir détails</a></td>
            </tr>
          </tbody>
        </table>
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
