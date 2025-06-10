<?php

include_once "requests.php";

ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);


function loadEnv(string $filepath): array {
    $env = [];

    // Vérifie si le fichier existe et est lisible
    if (!is_readable($filepath)) {
        throw new Exception("Fichier non lisible ou inexistant : $filepath");
    }

    // Ouvre et lit le fichier ligne par ligne
    $lines = file($filepath, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);

    foreach ($lines as $line) {
        // Sépare à la première occurrence de '='
        $parts = explode('=', $line, 2);

        if (count($parts) === 2) {
            $key = trim($parts[0]);
            $value = trim($parts[1]);
            $env[$key] = $value;
        }
    }

    return $env;
}





$env = loadEnv(__DIR__ . '/.env');

$host = $env['DB_HOST'];
$dbname = $env['DB_NAME'];
$username = $env['DB_USER'];
$password = $env['DB_PASSWORD'];




$databaseConnected = false;

try {
    // On fait un PDO pour mysql
    $conn = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $databaseConnected = true;
} 
catch (PDOException $e1) {
    try {
        // On fait le PDO pour postgres si jamais celui pour mysql a fail (au cas ou on serais sur la bdd dev)
        $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
        $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        $databaseConnected = true;
    }
    catch (PDOException $e2){
        echo "Erreur (connection mysql) : " . $e1->getMessage() . "<br>";
        echo "Erreur (connection postgres) : " . $e2->getMessage() . "<br>";
    }

}


/*

Création des instances de tables

*/


$MarquePanneau = new db($conn, 'marque_panneau', 'id', ['id','nom']);
$MarqueOnduleur = new db($conn, 'marque_onduleur', 'id', ['id','nom']);
$ModelePanneau = new db($conn, 'modele_panneau', 'id', ['id','nom']);
$ModeleOnduleur = new db($conn, 'modele_onduleur', 'id', ['id','nom']);

$Panneau = new db($conn, 'panneau', 'id', ['id','marque_panneau','modele_panneau']);
$Onduleur = new db($conn, 'onduleur', 'id', ['id','modele_onduleur', 'marque_onduleur']);

$Region = new db($conn, 'region', 'id', ['id','ville','admin1','admin2','pays']);
$Localisation = new db($conn, 'localisation', 'id', ['id','lat','long','postcode','postcodesuff','code_insee']);

$Installateur = new db($conn, 'installateur', 'id', ['id','nom']);

$Doc = new db($conn, 'doc', 'id',['id','mois','an','nbpanneaux','nbonduleur','puissancecrete','surface','pente','penteopti','orientation', 'orientation_opti','pvgis','panneau_id','onduleur_id','localisation_id','installateur_id']);


/* 
    La variable $databaseTables est utilisée pour faire correspondre une instance de classe a un parametre passé dans les requetes GET !
    La clé doit etre le nom du parametre qui devrai correspondre dans un $_GET
*/

$databaseTables = [
    'marque_panneau' => $MarquePanneau,
    'marque_onduleur' => $MarqueOnduleur,
    'modele_panneau' => $ModelePanneau,
    'modele_onduleur' => $ModeleOnduleur,

    'panneau' => $Panneau,
    'onduleur' => $Onduleur,

    'region' => $Region,
    'localisation' => $Localisation,

    'installateur' => $Installateur,

    'doc' => $Doc,

]

?> 