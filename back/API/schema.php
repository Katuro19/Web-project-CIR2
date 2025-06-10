<?php


session_start();
if (!isset($_SESSION['user'])) {
  header('Location: /front/PHP/login.php');
  exit;
}




require_once('../databases/conn.php');
header('Content-Type: application/json');

$schema = [];                            // Tableau final pour stocker le schéma
$colonnes_a_ignorer = ['id'];           // Colonnes à ignorer par défaut
$su_tables = ['region'];                // Tables qui doivent garder 'id'

foreach ($databaseTables as $tableName => $instance) {
    if (!method_exists($instance, 'get_columns')) continue; // Sauter si méthode absente

    $toutes_les_colonnes = $instance->get_columns();        // On récupère les colonnes
    $colonnes_filtrees = [];                                // Colonnes qu'on va garder

    // Parcours eniter
    for ($i = 0; $i < count($toutes_les_colonnes); $i++) {
        $col = $toutes_les_colonnes[$i];

        // Vérifie si on doit ignorer cette colonne
        $ignorer = in_array($col, $colonnes_a_ignorer);

        // Si c'est une "super table" on ignore rien
        if (in_array($tableName, $su_tables)) {
            $ignorer = false;
        }

        // On ajoute la colonne uniquement si elle n'est pas ignorée
        if (!$ignorer) {
            $colonnes_filtrees[] = $col;
        }
    }

    // On ajoute au schéma final
    $schema[$tableName] = $colonnes_filtrees;
}



echo json_encode($schema);
