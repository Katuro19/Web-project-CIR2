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
        // On fait le PDO pour postgres si jamais celui pour mysql a fail (au cas ou)
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
$Table = new db($conn,'tableName','primaryKey');
 And then you can do request :
$result = $Table->request($truc); (read the doc)
*/


$Doc = new db($conn, 'doc', 'id',['id','firstname','lastname','email','phone','password','postcode','expertise_id']);

?> 