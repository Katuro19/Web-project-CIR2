<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <title>Test API PHP</title>
    <style>
        body { font-family: sans-serif; padding: 20px; max-width: 600px; margin: auto; }
        label { display: block; margin-top: 10px; }
        input { padding: 5px; width: 100%; }
        button { margin-top: 15px; padding: 10px 20px; }
        pre { background-color: #f4f4f4; padding: 10px; border-radius: 5px; overflow-x: auto; }
    </style>
</head>
<body>

<h2>Appel API dynamique</h2>

<label for="table">Table :</label>
<input type="text" id="table" placeholder="Ex: coucou">

<label for="id">ID :</label>
<input type="text" id="id" placeholder="Ex: 1">

<button onclick="callAPI()">Envoyer</button>

<h3>URL appelée :</h3>
<pre id="url"></pre>

<h3>Réponse JSON :</h3>
<pre id="response"></pre>

<script>
function callAPI() {
    const table = document.getElementById("table").value;
    const id = document.getElementById("id").value;

    const apiUrl = `http://localhost:4321/back/API/request.php?table=${encodeURIComponent(table)}&id=${encodeURIComponent(id)}`;

    // Affiche l’URL
    document.getElementById("url").textContent = apiUrl;

    // Appel fetch
    fetch(apiUrl)
        .then(response => response.json())
        .then(data => {
            document.getElementById("response").textContent = JSON.stringify(data, null, 2);
        })
        .catch(error => {
            document.getElementById("response").textContent = "Erreur : " + error;
        });
}
</script>

</body>
</html>

