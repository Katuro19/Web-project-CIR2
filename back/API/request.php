<?php

/* Cette API répond au requete de la forme :

    ./back/API/request.php?table=matable&id=0

    Arguments :
        table : Doit contenir le nom de la table comme définie avec la classe "db"
        id : Un int representant la clé primaire definie dans "db"

*/

include_once "../databases/conn.php";

if (isset($_GET['table']) && isset($_GET['id'])) {
    $nom = $_GET['nom'];
    $age = $_GET['age'];
    echo "Nom : $nom, Age : $age";
} else {
    echo "Les paramètres nom et age ne sont pas définis.";
}
