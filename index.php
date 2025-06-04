<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Test POST API</title>
  <style>
    body {
      font-family: sans-serif;
      max-width: 600px;
      margin: auto;
      padding: 20px;
    }
    .field-group {
      display: flex;
      gap: 10px;
      margin-bottom: 10px;
    }
    input[type="text"] {
      flex: 1;
    }
    button {
      padding: 5px 10px;
    }
  </style>
</head>
<body>

  <h2>Test API - Ajouter une ligne</h2>

  <label for="table">Nom de la table :</label>
  <input type="text" id="table" placeholder="Ex: utilisateurs" />

  <div id="fields"></div>

  <button onclick="addField()">Ajouter un champ</button>
  <br><br>
  <button onclick="submitData()">Envoyer</button>

  <pre id="result"></pre>

  <script>
    const fieldsContainer = document.getElementById('fields');

    function addField() {
      const div = document.createElement('div');
      div.className = 'field-group';
      div.innerHTML = `
        <input type="text" placeholder="Colonne" class="col" />
        <input type="text" placeholder="Valeur" class="val" />
        <button onclick="this.parentNode.remove()">❌</button>
      `;
      fieldsContainer.appendChild(div);
    }

    function submitData() {
      const table = document.getElementById('table').value.trim();
      const cols = document.querySelectorAll('.col');
      const vals = document.querySelectorAll('.val');
      const data = { method: 'add_with', table };

      cols.forEach((colInput, i) => {
        const col = colInput.value.trim();
        const val = vals[i].value.trim();
        if (col) {
          data[col] = val;
        }
      });

        fetch('http://localhost:4321/back/API/insert.php', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
        },
        body: new URLSearchParams(data)
        })
        .then(async res => {
        const text = await res.text();
        try {
            const json = JSON.parse(text);
            document.getElementById('result').textContent = JSON.stringify(json, null, 2);
        } catch (e) {
            // Si ce n’est pas du JSON, on affiche le texte brut
            document.getElementById('result').textContent = 'Réponse brute:\n\n' + text;
        }
        })
        .catch(err => {
        document.getElementById('result').textContent = 'Erreur: ' + err;
        });

    }

    // Ajoute un champ de base au démarrage
    addField();
  </script>

</body>
</html>
