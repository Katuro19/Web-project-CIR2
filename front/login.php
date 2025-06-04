<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Connexion</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <style>
    body {
      background-color: #f0f2f5;
    }

    #login {
      box-shadow: 8px 8px 16px rgba(0, 0, 0, 0.2);
      border-radius: 10px;
      transition: transform 0.3s ease-in-out, box-shadow 0.3s ease-in-out;
    }

    #login:hover {
      transform: translateY(-5px);
      box-shadow: 12px 12px 24px rgba(0, 0, 0, 0.3);
    }

    .form-label {
      font-weight: 500;
    }

    .text-muted {
      font-size: 0.9rem;
    }

    .card {
      background-color: white;
    }
  </style>
</head>
<body class="d-flex justify-content-center align-items-center vh-100">

  <div id="login" class="card p-4" style="width: 350px;">
    <h2 class="text-center mb-4">Connexion</h2>

    <form>
      <div class="mb-3">
        <label class="form-label">Utilisateur</label>
        <input type="Utilisateur" class="form-control" placeholder="Nom Utilisateur" required>
      </div>

      <div class="mb-3">
        <label class="form-label">Mot de passe</label>
        <input type="password" class="form-control" placeholder="Votre mot de passe" required>
      </div>

      <button type="submit" class="btn btn-primary w-100">Se connecter</button>

      <!-- Message d’erreur fictif -->
      <div class="mt-3 text-danger text-center">
        <!-- Exemple de message, tu peux le supprimer -->
        Nom Utilisateur ou mot de passe incorrect.
      </div>
    </form>

    <hr>
  </div>

</body>
</html>
