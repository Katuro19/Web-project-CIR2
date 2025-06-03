<?php

function loadEnv($path) {
    $lines = file($path, FILE_IGNORE_NEW_LINES | FILE_SKIP_EMPTY_LINES);
    $env = [];

    foreach ($lines as $line) {
        // Ignore les commentaires
        if (strpos(trim($line), '#') === 0) {
            continue;
        }
        // Sépare la clé et la valeur
        list($key, $value) = explode('=', $line, 2);
        $env[trim($key)] = trim($value);
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


$Doctors = new db($conn, 'doctors', 'id',['id','firstname','lastname','email','phone','password','postcode','expertise_id']);
$Patients = new db($conn, 'patients', 'id', ['id','firstname','lastname','email','phone','password']);
$Rendezvous = new db($conn, 'rendezvous', 'id', ['id','date','start','end','patient_id','doctor_id','location_id']);
$Expertise = new db($conn, 'expertise', 'id',['id','name']);
$Locations = new db($conn, 'locations', 'id',['id','name','postcode']);


?> 