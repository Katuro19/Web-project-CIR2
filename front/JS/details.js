// Cette fonction permet de récupérer les données d'une installation à partir de son ID
async function getInstallationData(id) {

    let installation = await getData(api_link, "?table=doc&id=" + id);  // Récupère les données de l'installation à partir de son ID

    // console.log("Données de l'installation :", installation);

    let panneau = await getPanneauData(installation.panneau_id);    // Récupère les données du panneau à partir de l'ID du panneau
    let onduleur = await getOnduleurData(installation.onduleur_id); // Récupère les données de l'onduleur à partir de l'ID de l'onduleur
    let installateur = await getInstallateurData(installation.installateur_id);     // Récupère les données de l'installateur à partir de l'ID de l'installateur
    let localisation = await getloacalisationData(installation.localisation_id);    // Récupère les données de localisation à partir de l'ID de localisation

    // console.log("Installation :", installation);

    installation = {
        id: installation.id,
        mois: installation.mois,
        an: installation.an,
        nb_panneaux: installation.nb_panneaux,
        nb_onduleur: installation.nb_onduleur,
        puissance_crete: installation.puissance_crete == null ? "Non renseignée" : installation.puissance_crete + " w",
        surface: installation.surface + " m²",
        pente: installation.pente == null ? "Non renseignée" : installation.pente + "°",
        pente_opti: installation.pente_opti == null ? "Non renseignée" : installation.pente_opti + "°",
        orientation: installation.orientation == null ? "Non renseignée" : installation.orientation + "°",
        orientation_opti: installation.orientation_opti == null ? "Non renseignée" : installation.orientation_opti + "°",
        pvgis: installation.pvgis,
        marque_panneau: panneau.marque_panneau,
        modele_panneau: panneau.modele_panneau,
        marque_onduleur: onduleur.marque_onduleur,
        modele_onduleur: onduleur.modele_onduleur,
        installateur: installateur.nom,
        ville: localisation.ville,
        region: localisation.region,
        departement: localisation.departement,
        pays: localisation.pays,
        post_code: localisation.post_code,
        lat: localisation.lat,
        long: localisation.long
    };

    // console.log("Installation :", installation);

    return installation;
}

// Cette fonction permet de récupérer les données d'un panneau à partir de son ID
async function getPanneauData(id) {

    let panneau = await getData(api_link, "?table=panneau&id=" + id);   // Récupère les données du panneau à partir de son ID

    let marque_panneau = await getData(api_link, "?table=marque_panneau&id=" + panneau.marque_panneau); // Récupère la marque du panneau à partir de l'ID de la marque

    // console.log("Marque du panneau :", marque_panneau);

    let modele_panneau = await getData(api_link, "?table=modele_panneau&id=" + panneau.modele_panneau); // Récupère le modèle du panneau à partir de l'ID du modèle

    // console.log("Modèle du panneau :", modele_panneau);

    panneau = {
        marque_panneau: marque_panneau.nom
        , modele_panneau: modele_panneau.nom
    }

    // console.log("Panneau :", panneau);

    return panneau;
}

// Cette fonction permet de récupérer les données d'un onduleur à partir de son ID
async function getOnduleurData(id) {

    let onduleur = await getData(api_link, "?table=onduleur&id=" + id); // Récupère les données de l'onduleur à partir de son ID

    let marque_onduleur = await getData(api_link, "?table=marque_onduleur&id=" + onduleur.marque_onduleur); // Récupère la marque de l'onduleur à partir de l'ID de la marque

    // console.log("Marque de l'onduleur :", marque_onduleur);

    let modele_onduleur = await getData(api_link, "?table=modele_onduleur&id=" + onduleur.modele_onduleur); // Récupère le modèle de l'onduleur à partir de l'ID du modèle

    // console.log("Modèle de l'onduleur :", modele_onduleur);

    onduleur = {
        marque_onduleur: marque_onduleur.nom
        , modele_onduleur: modele_onduleur.nom
    }

    // console.log("Onduleur :", onduleur);

    return onduleur;
}

// Cette fonction permet de récupérer les données d'un installateur à partir de son ID
async function getInstallateurData(id) {

    let installateur = await getData(api_link, "?table=installateur&id=" + id); // Récupère les données de l'installateur à partir de son ID

    // console.log("Installateur :", installateur);

    return installateur;
}

// Cette fonction permet de récupérer les données de localisation à partir de l'ID
async function getloacalisationData(id) {

    let localisation = await getData(api_link, "?table=localisation&id=" + id); // Récupère les données de localisation à partir de l'ID

    // console.log("Localisation :", localisation);

    let region = await getData(api_link, "?table=region&id=" + localisation.code_insee);    // Récupère les données de la région à partir du code INSEE

    let localisation_data = {
        lat: localisation.lat,
        long: localisation.long,
        post_code: localisation.postcode,
        code_insee: localisation.code_insee,
        ville: region.ville,
        region: region.admin1,
        departement: region.admin2,
        pays: region.pays
    };

    // console.log("Localisation data :", localisation_data);

    return localisation_data;
}

// Cette fonction permet d'afficher les détails d'une installation à partir de l'ID passé dans l'URL
async function display_details() {

    const params = new URLSearchParams(window.location.search); // Récupère les paramètres de l'URL
    const id = params.get("id");    // Récupère l'ID de l'installation à partir des paramètres de l'URL

    if (id == null) {
        console.log("ID non présent dans l'URL");
    }


    let installation = await getInstallationData(id);   // Récupère les données de l'installation à partir de l'ID

    installation.mois = installation.mois < 10 ? "0" + installation.mois : installation.mois; // Formate le mois pour qu'il soit sur deux chiffres

    // console.log("Installation :", installation);


    let content = "<div class=\"box\" id=\"id\">ID : "
        + installation.id + "</div><div class=\"box\" id=\"date\">Date d’installation : "
        + installation.mois + "-" + installation.an + "</div><div class=\"box\" id=\"nb_panneau\">Nombre de panneaux : "
        + installation.nb_panneaux + "</div><div class=\"box\" id=\"marque_panneau \">Marque panneaux : "
        + installation.marque_panneau + "</div><div class=\"box\" id=\"modele_panneau\">Modèle panneaux : "
        + installation.modele_panneau + "</div><div class=\"box\" id=\"nb_onduleur\">Nombre d’onduleurs : "
        + installation.nb_onduleur + "</div><div class=\"box\" id=\"marque_onduleur\">Marques onduleur : "
        + installation.marque_onduleur + "</div><div class=\"box\" id=\"modele_onduleur\">Modèle onduleur : "
        + installation.modele_onduleur + "</div><div class=\"box\" id=\"pw_crete\">Puissance crête : "
        + installation.puissance_crete + "</div><div class=\"box\" id=\"surface\">Surface : "
        + installation.surface + "</div><div class=\"box\" id=\"pente\">Pente : "
        + installation.pente + "</div><div class=\"box\" id=\"pente_opti\">Pente optimum : "
        + installation.pente_opti + "</div><div class=\"box\" id=\"orientation\">Orientation : "
        + installation.orientation + "</div><div class=\"box\" id=\"orientation_opti\">Orientation optimum : "
        + installation.orientation_opti + "</div><div class=\"box\" id=\"installateur\">Installateur : "
        + installation.installateur + "</div><div class=\"box\" id=\"pos\">Latitude/Longitude : "
        + installation.lat + " - " + installation.long + "</div><div class=\"box\" id=\"pays\">Pays : "
        + installation.pays + "</div><div class=\"box\" id=\"code_postal\">Code postal : "
        + installation.post_code + "</div><div class=\"box\" id=\"ville\">Ville : "
        + installation.ville + "</div><div class=\"box\" id=\"region\">Région : "
        + installation.region + "</div><div class=\"box\" id=\"departement\">Département : "
        + installation.departement + "</div>";


    document.getElementById("details").innerHTML = content; // Affiche les détails de l'installation dans la div avec l'ID "details"
}

display_details()