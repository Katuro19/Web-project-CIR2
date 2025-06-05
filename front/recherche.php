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
            <ul class="multi-select-options">
              <li><label><input type="checkbox" value="Onduleur A" /> Onduleur A</label></li>
              <li><label><input type="checkbox" value="Onduleur B" /> Onduleur B</label></li>
              <li><label><input type="checkbox" value="Onduleur C" /> Onduleur C</label></li>
              <li><label><input type="checkbox" value="Onduleur D" /> Onduleur D</label></li>
              <li><label><input type="checkbox" value="Onduleur E" /> Onduleur E</label></li>
              <li><label><input type="checkbox" value="Onduleur F" /> Onduleur F</label></li>
              <li><label><input type="checkbox" value="Onduleur G" /> Onduleur G</label></li>
              <li><label><input type="checkbox" value="Onduleur H" /> Onduleur H</label></li>
              <li><label><input type="checkbox" value="Onduleur I" /> Onduleur I</label></li>
              <li><label><input type="checkbox" value="Onduleur J" /> Onduleur J</label></li>
              <li><label><input type="checkbox" value="Onduleur K" /> Onduleur K</label></li>
              <li><label><input type="checkbox" value="Onduleur L" /> Onduleur L</label></li>
              <li><label><input type="checkbox" value="Onduleur M" /> Onduleur M</label></li>
              <li><label><input type="checkbox" value="Onduleur N" /> Onduleur N</label></li>
              <li><label><input type="checkbox" value="Onduleur O" /> Onduleur O</label></li>
              <li><label><input type="checkbox" value="Onduleur P" /> Onduleur P</label></li>
              <li><label><input type="checkbox" value="Onduleur Q" /> Onduleur Q</label></li>
              <li><label><input type="checkbox" value="Onduleur R" /> Onduleur R</label></li>
              <li><label><input type="checkbox" value="Onduleur S" /> Onduleur S</label></li>
              <li><label><input type="checkbox" value="Onduleur T" /> Onduleur T</label></li>
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
            <ul class="multi-select-options">
              <li><label><input type="checkbox" value="Panneau A" /> Panneau A</label></li>
              <li><label><input type="checkbox" value="Panneau B" /> Panneau B</label></li>
              <li><label><input type="checkbox" value="Panneau C" /> Panneau C</label></li>
              <li><label><input type="checkbox" value="Panneau D" /> Panneau D</label></li>
              <li><label><input type="checkbox" value="Panneau E" /> Panneau E</label></li>
              <li><label><input type="checkbox" value="Panneau F" /> Panneau F</label></li>
              <li><label><input type="checkbox" value="Panneau G" /> Panneau G</label></li>
              <li><label><input type="checkbox" value="Panneau H" /> Panneau H</label></li>
              <li><label><input type="checkbox" value="Panneau I" /> Panneau I</label></li>
              <li><label><input type="checkbox" value="Panneau J" /> Panneau J</label></li>
              <li><label><input type="checkbox" value="Panneau K" /> Panneau K</label></li>
              <li><label><input type="checkbox" value="Panneau L" /> Panneau L</label></li>
              <li><label><input type="checkbox" value="Panneau M" /> Panneau M</label></li>
              <li><label><input type="checkbox" value="Panneau N" /> Panneau N</label></li>
              <li><label><input type="checkbox" value="Panneau O" /> Panneau O</label></li>
              <li><label><input type="checkbox" value="Panneau P" /> Panneau P</label></li>
              <li><label><input type="checkbox" value="Panneau Q" /> Panneau Q</label></li>
              <li><label><input type="checkbox" value="Panneau R" /> Panneau R</label></li>
              <li><label><input type="checkbox" value="Panneau S" /> Panneau S</label></li>
              <li><label><input type="checkbox" value="Panneau T" /> Panneau T</label></li>
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
            <ul class="multi-select-options">
              <li><label><input type="checkbox" value="Ain (01)" /> Ain (01)</label></li>
              <li><label><input type="checkbox" value="Aisne (02)" /> Aisne (02)</label></li>
              <li><label><input type="checkbox" value="Allier (03)" /> Allier (03)</label></li>
              <li><label><input type="checkbox" value="Alpes-de-Haute-Provence (04)" /> Alpes-de-Haute-Provence (04)</label></li>
              <li><label><input type="checkbox" value="Hautes-Alpes (05)" /> Hautes-Alpes (05)</label></li>
              <li><label><input type="checkbox" value="Alpes-Maritimes (06)" /> Alpes-Maritimes (06)</label></li>
              <li><label><input type="checkbox" value="Ardèche (07)" /> Ardèche (07)</label></li>
              <li><label><input type="checkbox" value="Ardennes (08)" /> Ardennes (08)</label></li>
              <li><label><input type="checkbox" value="Ariège (09)" /> Ariège (09)</label></li>
              <li><label><input type="checkbox" value="Aube (10)" /> Aube (10)</label></li>
              <li><label><input type="checkbox" value="Aude (11)" /> Aude (11)</label></li>
              <li><label><input type="checkbox" value="Aveyron (12)" /> Aveyron (12)</label></li>
              <li><label><input type="checkbox" value="Bouches-du-Rhône (13)" /> Bouches-du-Rhône (13)</label></li>
              <li><label><input type="checkbox" value="Calvados (14)" /> Calvados (14)</label></li>
              <li><label><input type="checkbox" value="Cantal (15)" /> Cantal (15)</label></li>
              <li><label><input type="checkbox" value="Charente (16)" /> Charente (16)</label></li>
              <li><label><input type="checkbox" value="Charente-Maritime (17)" /> Charente-Maritime (17)</label></li>
              <li><label><input type="checkbox" value="Cher (18)" /> Cher (18)</label></li>
              <li><label><input type="checkbox" value="Corrèze (19)" /> Corrèze (19)</label></li>
              <li><label><input type="checkbox" value="Corse-du-Sud (2A)" /> Corse-du-Sud (2A)</label></li>
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

  <!-- ==============================================
       SCRIPT JAVASCRIPT
       ============================================== -->
  <script>
    // Gestion du menu mobile
    function toggleMenu() {
      document.getElementById("navMobile").classList.toggle("show");
    }

    // Initialisation du multi-select dropdown
    document.addEventListener('DOMContentLoaded', function() {
      document.querySelectorAll('.multi-select').forEach(function(container) {
        const toggleBtn = container.querySelector('.multi-select-toggle');
        const optionsList = container.querySelector('.multi-select-options');
        const checkboxes = optionsList.querySelectorAll('input[type="checkbox"]');
        const listItems = optionsList.querySelectorAll('li');
        const fieldName = container.getAttribute('data-name');

        // 1. Ouvrir / fermer la dropdown au clic sur le bouton
        toggleBtn.addEventListener('click', function(e) {
          e.stopPropagation();
          container.classList.toggle('open');
        });

        // 2. Fermer la dropdown si on clique en dehors
        document.addEventListener('click', function() {
          container.classList.remove('open');
        });

        // 3. Mettre à jour le résumé du bouton
        function updateSummary() {
          const sélectionnées = [];
          checkboxes.forEach(function(cb) {
            if (cb.checked) sélectionnées.push(cb.value);
          });
          if (sélectionnées.length === 0) {
            toggleBtn.innerHTML = 'Sélectionner… <span class="arrow">▾</span>';
          } else if (sélectionnées.length === 1) {
            toggleBtn.innerHTML =
              `<span class="multi-select-summary">${sélectionnées[0]}</span> <span class="arrow">▾</span>`;
          } else {
            toggleBtn.innerHTML =
              `<span class="multi-select-summary">${sélectionnées.length} éléments sélectionnés</span> <span class="arrow">▾</span>`;
          }
        }

        // 4. Synchroniser les <input type="hidden"> dans le formulaire
        function syncHiddenInputs() {
          // Supprimer d’anciens hidden
          container.querySelectorAll('input[type="hidden"]').forEach(function(h) {
            h.remove();
          });
          // Créer un hidden par case cochée
          checkboxes.forEach(function(cb) {
            if (cb.checked) {
              const hidden = document.createElement('input');
              hidden.type = 'hidden';
              hidden.name = fieldName;
              hidden.value = cb.value;
              // Insérer avant le bouton Filtrer
              container.closest('form')
                       .insertBefore(hidden, container.closest('form').querySelector('.button-group'));
            }
          });
        }

        // 5. À chaque changement de case à cocher, re-calculer
        checkboxes.forEach(function(cb) {
          cb.addEventListener('change', function(e) {
            e.stopPropagation();  // empêche la dropdown de se fermer
            updateSummary();
            syncHiddenInputs();
          });
          // Empêche la checkbox de fermer la dropdown
          cb.addEventListener('click', function(e) {
            e.stopPropagation();
          });
        });

        // 6. Empêcher le clic sur le <li> ou <label> de fermer la dropdown
        listItems.forEach(function(li) {
          li.addEventListener('click', function(e) {
            e.stopPropagation();
          });
          const lbl = li.querySelector('label');
          lbl.addEventListener('click', function(e) {
            e.stopPropagation();
          });
        });

        // 7. Initialiser le résumé au chargement
        updateSummary();
      });
    });
  </script>
</body>
</html>
