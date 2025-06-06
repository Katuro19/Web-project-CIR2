async function getInstallationData(id) {

    let installation = await getData(api_link, "?table=doc&id=" + id);

    // console.log("Données de l'installation :", installation);

    let panneau = await getPanneauData(installation.panneau_id)
    let onduleur = await getOnduleurData(installation.onduleur_id)
    let installateur = await getInstallateurData(installation.installateur_id);
    let localisation = await getloacalisationData(installation.localisation_id);

    console.log("Installation :", installation);

    installation = {
        id: installation.id,
        mois: installation.mois,
        an: installation.an,
        nb_panneaux: installation.nb_panneaux,
        nb_onduleur: installation.nb_onduleur,
        puissance_crete: installation.puissance_crete,
        surface: installation.surface,
        pente: installation.pente,
        pente_opti: installation.pente_opti,
        orientation: installation.orientation,
        orientation_opti: installation.orientation_opti,
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

    console.log("Installation :", installation);

    return installation;
}

async function getPanneauData(id) {

    let panneau = await getData(api_link, "?table=panneau&id=" + id);

    let marque_panneau = await getData(api_link, "?table=marque_panneau&id=" + panneau.marque_panneau);

    // console.log("Marque du panneau :", marque_panneau);

    let modele_panneau = await getData(api_link, "?table=modele_panneau&id=" + panneau.modele_panneau);

    // console.log("Modèle du panneau :", modele_panneau);

    panneau = {
        marque_panneau: marque_panneau.nom
        , modele_panneau: modele_panneau.nom
    }

    // console.log("Panneau :", panneau);

    return panneau;
}

async function getOnduleurData(id) {
    let onduleur = await getData(api_link, "?table=onduleur&id=" + id);

    let marque_onduleur = await getData(api_link, "?table=marque_onduleur&id=" + onduleur.marque_onduleur);

    // console.log("Marque de l'onduleur :", marque_onduleur);

    let modele_onduleur = await getData(api_link, "?table=modele_onduleur&id=" + onduleur.modele_onduleur);

    // console.log("Modèle de l'onduleur :", modele_onduleur);

    onduleur = {
        marque_onduleur: marque_onduleur.nom
        , modele_onduleur: modele_onduleur.nom
    }

    // console.log("Onduleur :", onduleur);

    return onduleur;
}

async function getInstallateurData(id) {
    let installateur = await getData(api_link, "?table=installateur&id=" + id);

    // console.log("Installateur :", installateur);

    return installateur;
}


async function getloacalisationData(id) {
    let localisation = await getData(api_link, "?table=localisation&id=" + id);

    // console.log("Localisation :", localisation);

    let region = await getData(api_link, "?table=region&id=" + localisation.code_insee);

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

async function display_details() {

    const params = new URLSearchParams(window.location.search);
    const id = params.get("id");

    if (id == null) {
        console.log("ID non présent dans l'URL");
    }


    let installation = await getInstallationData(id);

    console.log("Installation :", installation);

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


    document.getElementById("details").innerHTML = content;
}

display_details()