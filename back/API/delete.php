<?php

/* Cette API répond au requete DELETE envoyée via un formulaire ($_POST):
    En fonction du type de parametre, on peut précisé si on veut un POST ou un PUT, directment via un seul $_POST pour plus de simplicitée !

    Réponses : 
        La réponse (réussite ou echec) se trouve dans "data", sous forme de BOOL
        Les autres données sont purement indicatives.

        ATTENTION : La requete peut afficher "success" mais si "data" est a false ou [], cela veut dire que la requete a réussi mais pas l'insertion dans la BDD.

        Les $_POST doivent a minima contenir la table sur laquelle operer et une ID.
*/


include_once "../databases/conn.php"; // Important pour le $databaseTables
header('Content-Type: application/json');

if (!isset($_POST['table']) || !isset($databaseTables[$_POST['table']])) { //si il n'y a aps la table, on ne peut rien faire !
    echo json_encode([
        'status' => 'error',
        'message' => 'Paramètre table manquant ou invalide (Est-ce que la table est définie dans la conn?)'
    ]);
    exit;
}

$DatabaseInstance = $databaseTables[$_POST['table']];

// Définition des méthodes disponibles
$allowedMethods = [
    //Methode DELETE
    'delete' => ['id'], //Delete n'accepte que les ID
    'delete_insee' => ['code_insee'], //Delete n'accepte que les ID

];

// Détection automatique de la méthode à appeler
$calledMethod = null;
$methodParams = [];


foreach ($allowedMethods as $method => $expectedParams) { //Boucle sur chaque clé du dico et prend en compte les valeures associées
    $getKeys = array_keys($_POST); //Crée un dico a partir des parametres du POST
    $filteredKeys = array_diff($getKeys, ['table', 'method']); // Retire les clé table et method du nouveau dictionnaire (on en a pas besoin !)

    $unsortedParams = $expectedParams;

    sort($expectedParams);
    sort($filteredKeys);


    if ($expectedParams === $filteredKeys) { //check si on a les memes clés que la fonction qu'on verifie
        if($method == "delete_insee") {$calledMethod = "delete";} else {$calledMethod = $method;}
        $methodParams = array_map(fn($param) => $_POST[$param], $unsortedParams); //Recupere les valeures de toute les clés de expectedParams dans le $_POST
        break;
    }
}


if ($calledMethod && method_exists($DatabaseInstance, $calledMethod)) { //si la methode est valide
    
    try {
        /*
            Cette fonction magique apelle la fonction calledMethod depuis l'instance DatabaseInstance
            en passant les params du dico methodeParams". 
            La fonction call_user_func_array place automatiquement les parametres et gere l'appel !

        */
        $result = call_user_func_array([$DatabaseInstance, $calledMethod], $methodParams); 

        echo json_encode([
            'status' => 'success',
            'called_method' => $calledMethod,
            'parameters' => $methodParams,
            'data' => $result
        ]);
    } catch (Exception $e) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Erreur interne',
            'error' => $e->getMessage()
        ]);
    }
} else {
    echo json_encode([
        'status' => 'error',
        'message' => 'Aucune méthode valide détectée ou paramètres manquants',
        'available_methods' => array_keys($allowedMethods),
        'received' => $_POST
    ]);
}
