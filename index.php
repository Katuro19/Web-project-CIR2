<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <title>Test API REST</title>
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
    input[type="text"], select {
      flex: 1;
    }
    button {
      padding: 5px 10px;
    }
    pre {
      background: #f3f3f3;
      padding: 10px;
      white-space: pre-wrap;
    }
  </style>
</head>
<body>

  <h2>Test API - Requête REST</h2>

  <label for="host">Adresse du serveur :</label>
  <input type="text" id="host" placeholder="Ex: localhost:4321" value="localhost:4321" />

  <br><br>

  <label for="method">Méthode :</label>
  <select id="method">
    <option value="GET">GET</option>
    <option value="POST">POST</option>
    <option value="PUT">PUT</option>
    <option value="DELETE">DELETE</option>
  </select>

  <br><br>

  <label for="table">Table :</label>
  <input type="text" id="table" placeholder="Nom de la table" />

  <div id="fields"></div>

  <button onclick="addField()">Ajouter un champ</button>
  <br><br>
  <button onclick="submitData()">Envoyer</button>

  <pre id="result"></pre>

  <script>
    const fieldsContainer = document.getElementById('fields');
    const resultContainer = document.getElementById('result');

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
      const host = document.getElementById('host').value.trim();
      let method = document.getElementById('method').value;
      const table = document.getElementById('table').value.trim();

      const cols = document.querySelectorAll('.col');
      const vals = document.querySelectorAll('.val');

      const data = { table };

      cols.forEach((colInput, i) => {
        const col = colInput.value.trim();
        const val = vals[i].value.trim();
        if (col) data[col] = val;
      });

      // Ciblage du bon fichier PHP
      const phpMap = {
        GET: 'request.php',
        POST: 'create.php',
        PUT: 'create.php',
        DELETE: 'delete.php'
      };

      const endpoint = phpMap[method];
      const url = `http://${host}/back/API/${endpoint}`;

      if (method === 'GET') {
        const query = new URLSearchParams(data).toString();
        fetch(`${url}?${query}`)
          .then(handleResponse)
          .catch(handleError);
      } else {
        // POST seulement (même pour PUT/DELETE)
        const options = {
          method: 'POST',
          headers: {
            'Content-Type': 'application/x-www-form-urlencoded'
          },
          body: new URLSearchParams(data)
        };

        fetch(url, options)
          .then(handleResponse)
          .catch(handleError);
      }
    }

    function handleResponse(res) {
      return res.text().then(text => {
        try {
          const json = JSON.parse(text);
          resultContainer.textContent = JSON.stringify(json, null, 2);
        } catch {
          resultContainer.textContent = 'Réponse brute:\n\n' + text;
        }
      });
    }

    function handleError(err) {
      resultContainer.textContent = 'Erreur: ' + err;
    }

    addField(); // Champ initial
  </script>

</body>
</html>
