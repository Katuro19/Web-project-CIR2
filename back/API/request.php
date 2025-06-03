<?php

/* Cette API répond au requete de la forme :

    ./back/API/request.php?table=matable&id=0

    Arguments :
        table : Doit contenir le nom de la table correspondant dans la BDD 
        id : Un int representant la clé primaire definie dans "db"
        column : Le nom de la colonne (sans guillement)
        sortColumn : Le nom de la colonne dans l'ordre a trier
        asc : 1 ou 0 (ascendant ou descendant)



    Réponses : 
        La réponse se trouve dans "data". La réponse peut etre sous forme de tableau ou non (a verifier apres l'appel)
        Les autres données sont purement indicatives.

        Type JSON avec la forme suivante :

            {
            "status": "success",
            "called_method": "request_if",
            "parameters": [
                "nom",
                "oui"
            ],
            "data": [
                {
                "id": 1,
                "nom": "oui"
                },
                {
                "id": 2,
                "nom": "oui"
                }
            ]
            }
                    
    Exemples d'appels :

    Récuperer seulement la personne avec l'id 1 :
        http://localhost:4321/back/API/request.php?table=marque_panneau&id=1

    Récuperer toute la BDD :
        http://localhost:4321/back/API/request.php?table=marque_panneau

    Récuperer la BDD triée :
        http://localhost/back/API/request.php?table=marque_panneau&sortColumn=id&asc=0

    Récuperer seulement le nom "oui" :
        http://localhost:4321/back/API/request.php?table=marque_panneau&column=nom&value=oui

*/


include_once "../databases/conn.php"; // Important pour le $databaseTables
header('Content-Type: application/json');

if (!isset($_GET['table']) || !isset($databaseTables[$_GET['table']])) { //If the table is missing/invalid, we can't do anything
    echo json_encode([
        'status' => 'error',
        'message' => 'Paramètre table manquant ou invalide (Est-ce que la table est définie dans la conn?)'
    ]);
    exit;
}

$DatabaseInstance = $databaseTables[$_GET['table']];

// Définition des méthodes disponibles
$allowedMethods = [
    'request' => ['id'], //Request prend seulment l'id et renvoie l'entiertée de la ligne 
    'request_if' => ['column', 'value'], //request if renvoie toute les lignes qui verifie la condition "value dans column"
    'request_if_null' => ['column'], //Renvoie toute les lignes pour lequelles la column donnée est nulle
    'request_in_order' => ['sortColumn', 'asc'], //Renvoie la BDD entiere triée en fonction des param
    'request_if_in_order' => ['column', 'value', 'sortColumn', 'asc'], //Renvoie la DB entiere triée en fonction des parametres donnés. ATTENTION, asc doit etre 1 ou 0
    'request_all' => [] //Renvoie toute la DB (ne prend aucun parametre sauf table !)
    //'delete' => ['id'],
    //'change_if' => ['id', 'column', 'value'],
];

// Détection automatique de la méthode à appeler
$calledMethod = null;
$methodParams = [];


foreach ($allowedMethods as $method => $expectedParams) { //Boucle sur chaque clé du dico et prend en compte les valeures associées
    $getKeys = array_keys($_GET); //Crée un dico a partir des parametres de l'url (que pour GET !)
    $filteredKeys = array_diff($getKeys, ['table', 'method']); // Retire les clé table et method du nouveau dictionnaire (on en a pas besoin !)

    $unsortedParams = $expectedParams;

    sort($expectedParams);
    sort($filteredKeys);

    if ($expectedParams === $filteredKeys) { //check si on a les memes clés que la fonction qu'on verifie
        $calledMethod = $method; //On choisi donc celle ci a appelé
        $methodParams = array_map(fn($param) => $_GET[$param], $unsortedParams); //Recupere les valeures de toute les clés de expectedParams dans le $_GET
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
        'received' => $_GET
    ]);
}
