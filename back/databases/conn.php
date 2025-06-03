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
        // Ignore les commentaires
        if (str_starts_with($line, '#')) {
            continue;
        }

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
    // Create a new PDO instance for PostgreSQL
    $conn = new PDO("pgsql:host=$host;dbname=$dbname", $username, $password);
    $conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $databaseConnected = true;

} 
catch (PDOException $e) {
    echo "Erreur : " . $e->getMessage();

}

/* 
$Table = new db($conn,'tableName','primaryKey');
 And then you can do request :
$result = $Table->request($truc); (read the doc)
*/


$Doc = new db($conn, 'doc', 'id',['id','firstname','lastname','email','phone','password','postcode','expertise_id']);

?> 