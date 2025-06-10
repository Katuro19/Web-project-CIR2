<?php
session_start();

// Lire le fichier .secret
$secrets = parse_ini_file("../../back/.secret");
$expected_user = $secrets['USER'] ?? '';
$expected_pass = $secrets['PASSWORD'] ?? '';

// Traitement du formulaire
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
  $username = $_POST['username'] ?? '';
  $password = $_POST['password'] ?? '';

  if ($username === $expected_user && $password === $expected_pass) {
    $_SESSION['user'] = $username;
    header("Location: admin.php");
    exit;
  } else {
    $error = "Nom d'utilisateur ou mot de passe incorrect.";
  }
}
?>

<!DOCTYPE html>
<html lang="fr">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1" />
  <title>Connexion</title>
  <link rel="stylesheet" href="/front/CSS/style_accueil.css" />
  <link rel="stylesheet" href="/front/CSS/style_login.css" />
  <script src="/front/JS/env.js" defer></script>
  <script src="/front/JS/utils.js" defer></script>
  <script src="/front/JS/accueil.js" defer></script>
</head>
<body class="page-login">
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
      <a href="/front/PHP/recherche.php">Recherche</a>
      <a href="/front/PHP/carte.php">Carte</a>
      <a href="/front/PHP/login.php">Se Connecter</a>
    </nav>
  </header>

  <main class="main-login">
    <div class="form-container">
      <h2>Connexion</h2>
      <?php if (!empty($error)) : ?>
        <div class="error"><?php echo htmlspecialchars($error); ?></div>
      <?php endif; ?>
      <form method="post">
        <div class="form-group">
          <label for="username">Nom d'utilisateur</label>
          <input type="text" name="username" id="username" required />
        </div>
        <div class="form-group">
          <label for="password">Mot de passe</label>
          <input type="password" name="password" id="password" required />
        </div>
        <button type="submit" class="btn">Se connecter</button>
      </form>
    </div>
  </main>

  <footer class="footer">
    <p>Kévin Pierre-Luc Eliott – Groupe 3 – 2025</p>
  </footer>
</body>
</html>
