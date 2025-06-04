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
  </style>
</head>
<body>

  <h2>Test API - Requête REST</h2>

  <label for="host">Adresse du serveur :</label>
  <input type="text" id="host" placeholder="Ex: 192.168.1.50 ou localhost:4321" value="localhost:4321" />

  <br><br>

  <label for="method">Méthode REST :</label>
  <select id="method">
    <option value="POST">POST</option>
    <option value="GET">GET</option>
    <option value="PUT">PUT</option>
    <option value="DELETE">DELETE</option>
  </select>

  <br><br>

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
      const host = document.getElementById('host').value.trim();
      const method = document.getElementById('method').value;
      const table = document.getElementById('table').value.trim();
      const cols = document.querySelectorAll('.col');
      const vals = document.querySelectorAll('.val');
      const data = { table };

      cols.forEach((colInput, i) => {
        const col = colInput.value.trim();
        const val = vals[i].value.trim();
        if (col) {
          data[col] = val;
        }
      });

      // URL dynamique selon méthode
      const urlMap = {
        GET: `http://${host}/back/API/request.php`,
        POST: `http://${host}/back/API/create.php`,
        PUT: `http://${host}/back/API/update.php`,
        DELETE: `http://${host}/back/API/request_delete.php`
      };
      const url = urlMap[method];

      const options = {
        method: method,
        headers: {
          'Content-Type': method === 'PUT' ? 'application/json' : 'application/x-www-form-urlencoded'
        }
      };

      if (method === 'GET') {
        const queryString = new URLSearchParams(data).toString();
        fetch(`${url}?${queryString}`, options)
          .then(handleResponse)
          .catch(handleError);
      } else if (method === 'PUT') {
        options.body = JSON.stringify(data);
        fetch(url, options)
          .then(handleResponse)
          .catch(handleError);
      } else {
        options.body = new URLSearchParams(data);
        fetch(url, options)
          .then(handleResponse)
          .catch(handleError);
      }
    }

    function handleResponse(res) {
      return res.text().then(text => {
        try {
          const json = JSON.parse(text);
          document.getElementById('result').textContent = JSON.stringify(json, null, 2);
        } catch {
          document.getElementById('result').textContent = 'Réponse brute:\n\n' + text;
        }
      });
    }

    function handleError(err) {
      document.getElementById('result').textContent = 'Erreur: ' + err;
    }

    addField(); // Champ de base
  </script>

</body>
</html>
