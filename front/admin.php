<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin</title>
  <!-- Lien vers la feuille de style CSS -->
  <link rel="stylesheet" href="CSS/style_admin.css" />
</head>
<body>
  <!-- ============================
       HEADER FIXE
       ============================ -->
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

  <!-- ============================
       CONTENU PRINCIPAL (CENTRÉ)
       ============================ -->
  <div class="container">
    <h2>Choisissez une action</h2>
    <div class="action-buttons">
      <button class="btn" data-action="supprimer">Supprimer</button>
      <button class="btn" data-action="modifier">Modifier</button>
      <button class="btn" data-action="request">Request</button>
    </div>
  </div>

  <!-- ============================
       OVERLAY DU FORMULAIRE
       ============================ -->
  <div class="overlay" id="formOverlay">
    <div class="form-container">
      <h3 id="formTitle">Formulaire</h3>
      <form id="actionForm">
        <div class="form-field">
          <label for="field1">Champ 1</label>
          <input type="text" id="field1" name="field1" placeholder="Entrez une valeur" required />
        </div>
        <div class="form-field">
          <label for="field2">Champ 2</label>
          <input type="text" id="field2" name="field2" placeholder="Entrez une valeur" required />
        </div>
        <div class="form-buttons">
          <button type="submit" class="btn submit-btn">Valider</button>
          <button type="button" class="btn cancel-btn" id="cancelForm">Annuler</button>
        </div>
      </form>
    </div>
  </div>

  <!-- ============================
       FOOTER FIXE
       ============================ -->
  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>

  <!-- ============================
       SCRIPT JAVASCRIPT
       ============================ -->
  <script>
    // Gestion du menu mobile
    function toggleMenu() {
      document.getElementById("navMobile").classList.toggle("show");
    }

    // Sélectionne tous les boutons d’action (supprimer / modifier / request)
    const actionButtons = document.querySelectorAll(".btn[data-action]");
    const overlay = document.getElementById("formOverlay");
    const formTitle = document.getElementById("formTitle");
    const cancelBtn = document.getElementById("cancelForm");
    const actionForm = document.getElementById("actionForm");

    actionButtons.forEach(btn => {
      btn.addEventListener("click", () => {
        const action = btn.getAttribute("data-action");
        if (action === "supprimer") {
          formTitle.textContent = "Formulaire de suppression";
        } else if (action === "modifier") {
          formTitle.textContent = "Formulaire de modification";
        } else if (action === "request") {
          formTitle.textContent = "Formulaire de request";
        } else {
          formTitle.textContent = "Formulaire";
        }
        overlay.classList.add("visible");
      });
    });

    cancelBtn.addEventListener("click", () => {
      overlay.classList.remove("visible");
      actionForm.reset();
    });

    actionForm.addEventListener("submit", function(e) {
      e.preventDefault();
      const val1 = document.getElementById("field1").value;
      const val2 = document.getElementById("field2").value;
      alert(`Champ 1 : ${val1}\nChamp 2 : ${val2}`);
      actionForm.reset();
      overlay.classList.remove("visible");
    });
  </script>
</body>
</html>
