<?php
session_start();
if (!isset($_SESSION['user'])) {
  header('Location: login.php');
  exit;
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Admin - Gestion panneau solaire</title>
  <link rel="stylesheet" href="CSS/style_admin.css" />
  <style>
    /* Juste pour rendre visible l'overlay quand visible */
    .overlay {
      display: none;
      position: fixed;
      inset: 0;
      background: rgba(0,0,0,0.5);
      justify-content: center;
      align-items: center;
      z-index: 9999;
    }
    .overlay.visible {
      display: flex;
    }
    .form-container {
      background: white;
      padding: 20px;
      border-radius: 8px;
      max-width: 400px;
      width: 90%;
      box-shadow: 0 0 10px rgba(0,0,0,0.3);
    }
    .form-field {
      margin-bottom: 15px;
    }
    label {
      display: block;
      margin-bottom: 6px;
      font-weight: bold;
    }
    input[type="text"], select {
      width: 100%;
      padding: 8px;
      box-sizing: border-box;
    }
    .form-buttons {
      display: flex;
      justify-content: space-between;
    }
    button.btn {
      padding: 10px 15px;
      cursor: pointer;
      border: none;
      border-radius: 4px;
      background-color: #007BFF;
      color: white;
      font-weight: bold;
    }
    button.btn.cancel-btn {
      background-color: #6c757d;
    }
  </style>
</head>
<body>

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
  <nav class="nav-mobile" id="navMobile">
    <a href="accueil.php">Accueil</a>
    <a href="recherche.php">Recherche</a>
    <a href="carte.php">Carte</a>
    <a href="login.php">Se Connecter</a>
  </nav>
</header>

<div class="container">
  <h2>Choisissez une action</h2>
  <div class="action-buttons">
    <button class="btn" data-action="creer">Créer</button>
    <button class="btn" data-action="modifier">Modifier</button>
    <button class="btn" data-action="supprimer">Supprimer</button>
    <button class="btn" data-action="request">Request</button>
  </div>
</div>

<!-- Formulaire unique et dynamique dans un overlay -->
<div class="overlay" id="formOverlay">
  <div class="form-container">
    <h3 id="formTitle">Formulaire</h3>

    <form id="actionForm">
      <!-- Choix de la table, visible pour créer et modifier -->
      <div class="form-field" id="tableSelectorContainer" style="display: none;">
        <label for="tableSelector">Table :</label>
        <select id="tableSelector" required>
          <option value="">-- Choisir une table --</option>
        </select>
      </div>

      <!-- Ici seront injectés les champs selon l'action -->
      <div id="dynamicFields"></div>

      <div class="form-buttons">
        <button type="submit" class="btn submit-btn">Valider</button>
        <button type="button" class="btn cancel-btn" id="cancelForm">Annuler</button>
      </div>
    </form>
  </div>
</div>

<footer class="footer">
  <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
</footer>

<a href="logout.php" class="logout-btn" title="Se déconnecter">Déconnexion 🚪</a>

<script>
  // Toggle menu mobile
  function toggleMenu() {
    document.getElementById("navMobile").classList.toggle("show");
  }

  const actionButtons = document.querySelectorAll(".btn[data-action]");
  const overlay = document.getElementById("formOverlay");
  const formTitle = document.getElementById("formTitle");
  const cancelBtn = document.getElementById("cancelForm");
  const actionForm = document.getElementById("actionForm");
  const tableSelector = document.getElementById("tableSelector");
  const tableSelectorContainer = document.getElementById("tableSelectorContainer");
  const dynamicFields = document.getElementById("dynamicFields");

  let schema = {};

  actionButtons.forEach(btn => {
    btn.addEventListener("click", async () => {
      const action = btn.getAttribute("data-action");
      formTitle.textContent = "Formulaire";
      dynamicFields.innerHTML = "";

      if (["creer", "modifier", "supprimer", "request"].includes(action)) {
        tableSelectorContainer.style.display = "block";

        try {
          const res = await fetch("/back/API/schema.php");
          schema = await res.json();

          tableSelector.innerHTML = '<option value="">-- Choisir une table --</option>';
          Object.keys(schema).forEach(table => {
            const opt = document.createElement("option");
            opt.value = table;
            opt.textContent = table;
            tableSelector.appendChild(opt);
          });
        } catch (e) {
          alert("Erreur de chargement du schéma : " + e);
          return;
        }
      }

      if (action === "creer") {
        formTitle.textContent = "Formulaire de création";
        tableSelector.onchange = () => {
          const selectedTable = tableSelector.value;
          dynamicFields.innerHTML = "";
          if (selectedTable && schema[selectedTable]) {
            schema[selectedTable].forEach(column => {
              const label = column === "id" ? "Code INSEE" : column;
              const fieldDiv = document.createElement("div");
              fieldDiv.className = "form-field";
              fieldDiv.innerHTML = `
                <label>${label}</label>
                <input type="text" name="${column}" placeholder="${label}" />
              `;
              dynamicFields.appendChild(fieldDiv);
            });
          }
        };
      }

      else if (action === "modifier") {
        formTitle.textContent = "Formulaire de modification";
        tableSelector.onchange = () => {
          const selectedTable = tableSelector.value;
          if (!selectedTable) {
            dynamicFields.innerHTML = "";
            return;
          }
          const colonnes = schema[selectedTable].filter(c => c.toLowerCase() !== "id");
          dynamicFields.innerHTML = `
            <div class="form-field">
              <label for="idModifier">ID à modifier</label>
              <input type="text" id="idModifier" name="idModifier" required placeholder="Ex: 42" />
            </div>
            <div class="form-field">
              <label for="colonneModifier">Colonne à modifier</label>
              <select id="colonneModifier" name="colonneModifier" required>
                ${colonnes.map(c => `<option value="${c}">${c}</option>`).join("")}
              </select>
            </div>
            <div class="form-field">
              <label for="valeurModifier">Nouvelle valeur</label>
              <input type="text" id="valeurModifier" name="valeurModifier" required />
            </div>
          `;
        };
      }

      else if (action === "supprimer") {
        formTitle.textContent = "Formulaire de suppression";
        tableSelector.onchange = () => {
          dynamicFields.innerHTML = `
            <div class="form-field">
              <label for="idDelete">ID à supprimer</label>
              <input type="text" id="idDelete" name="idDelete" required placeholder="Ex: 123" />
            </div>
          `;
        };
      }

      else if (action === "request") {
        formTitle.textContent = "Formulaire de recherche";
        tableSelector.onchange = () => {
          const selectedTable = tableSelector.value;
          if (!selectedTable || !schema[selectedTable]) {
            dynamicFields.innerHTML = "";
            return;
          }
          const colonnes = ['id', ...schema[selectedTable]];
          dynamicFields.innerHTML = `
            <div class="form-field">
              <label for="colonneRequest">Colonne à chercher</label>
              <select id="colonneRequest" name="colonneRequest" required>
                ${colonnes.map(c => `<option value="${c}">${c}</option>`).join("")}
              </select>
            </div>
            <div class="form-field">
              <label for="valeurRequest">Valeur recherchée</label>
              <input type="text" id="valeurRequest" name="valeurRequest" required />
            </div>
          `;
        };
      }

      overlay.classList.add("visible");
    });
  });

  cancelBtn.addEventListener("click", () => {
    overlay.classList.remove("visible");
    actionForm.reset();
    dynamicFields.innerHTML = "";
  });

  actionForm.addEventListener("submit", async function(e) {
    e.preventDefault();
    const action = formTitle.textContent;

    if (action.includes("création")) {
      const table = tableSelector.value;
      if (!table) return alert("Veuillez choisir une table.");

      const inputs = dynamicFields.querySelectorAll("input");
      const payload = { table };
      inputs.forEach(input => {
        payload[input.name] = input.value;
      });

      try {
        const res = await fetch("/back/API/create.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: new URLSearchParams(payload)
        });
        const json = await res.json();
        alert("Réponse API :\n" + JSON.stringify(json, null, 2));
        overlay.classList.remove("visible");
        actionForm.reset();
        dynamicFields.innerHTML = "";
      } catch (err) {
        alert("Erreur lors de l'envoi : " + err);
      }

    } else if (action.includes("modification")) {
      const table = tableSelector.value;
      const id = document.getElementById("idModifier")?.value;
      const colonne = document.getElementById("colonneModifier")?.value;
      const valeur = document.getElementById("valeurModifier")?.value;

      if (!table || !id || !colonne || !valeur) {
        alert("Tous les champs sont obligatoires.");
        return;
      }

      const data = new URLSearchParams({ table, id, column: colonne, value: valeur });

      try {
        const res = await fetch("/back/API/create.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: data
        });
        const json = await res.json();
        alert("Réponse API :\n" + JSON.stringify(json, null, 2));
        overlay.classList.remove("visible");
        actionForm.reset();
        dynamicFields.innerHTML = "";
      } catch (err) {
        alert("Erreur lors de la modification : " + err);
      }

    } else if (action.includes("suppression")) {
      const table = tableSelector.value;
      const id = document.getElementById("idDelete")?.value;

      if (!table || !id) {
        alert("Veuillez remplir tous les champs.");
        return;
      }

      if (!confirm(`Supprimer l'entrée ${id} dans ${table} ?`)) return;

      const data = new URLSearchParams({ table, id });

      try {
        const res = await fetch("/back/API/delete.php", {
          method: "POST",
          headers: { "Content-Type": "application/x-www-form-urlencoded" },
          body: data
        });
        const json = await res.json();
        alert("Réponse API :\n" + JSON.stringify(json, null, 2));
        overlay.classList.remove("visible");
        actionForm.reset();
        dynamicFields.innerHTML = "";
      } catch (err) {
        alert("Erreur lors de la suppression : " + err);
      }

    } else if (action.includes("recherche")) {
      const table = tableSelector.value;
      const colonne = document.getElementById("colonneRequest")?.value;
      const valeur = document.getElementById("valeurRequest")?.value;

      if (!table || !colonne || !valeur) {
        alert("Tous les champs sont obligatoires.");
        return;
      }

      const params = new URLSearchParams({ table, column: colonne, value: valeur });

      try {
        const res = await fetch(`/back/API/request.php?${params.toString()}`);
        const json = await res.json();
        const newWindow = window.open();
        newWindow.document.write(`<pre>${JSON.stringify(json, null, 2)}</pre>`);
      } catch (err) {
        alert("Erreur lors de la recherche : " + err);
      }

      overlay.classList.remove("visible");
      actionForm.reset();
      dynamicFields.innerHTML = "";
    }
  });
</script>



</body>
</html>
