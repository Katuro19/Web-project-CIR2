async function onduleur_data(doc_data, api_link, marque_onduleur, verbose = false) {

    /////////////////////////////////////////
    // Traintement des données de onduleur //
    /////////////////////////////////////////

    let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur");

    if (verbose) {
        console.log("Marque Onduleur data: " + marque_onduleur_data.length);
        console.log(marque_onduleur_data);
    }

    marque_onduleur_data = filterResults(marque_onduleur_data, getValuesByKey(marque_onduleur, "text"), "nom");

    if (verbose) {
        console.log("Marque Onduleur data: " + marque_onduleur_data.length);
        console.log(marque_onduleur_data);
    }

    let id_marque_onduleur = getValuesByKey(marque_onduleur_data, "id");

    if (verbose) {
        console.log("IDs Onduleur: " + id_marque_onduleur.length);
        console.log("IDs Onduleur: " + id_marque_onduleur);
    }

    let onduleur_data = await getData(api_link, "?table=onduleur");

    if (verbose) {
        console.log("Onduleur data: " + onduleur_data.length);
        console.log(onduleur_data);
    }

    onduleur_data = filterResults(onduleur_data, id_marque_onduleur, "marque_onduleur");

    if (verbose) {
        console.log("Onduleur data: " + onduleur_data.length);
        console.log(onduleur_data);
    }

    onduleur_id = getValuesByKey(onduleur_data, "id");

    if (verbose) {
        console.log("IDs Onduleur: " + onduleur_id.length);
        console.log("IDs Onduleur: " + onduleur_id);
    }

    doc_data = filterResults(doc_data, onduleur_id, "onduleur_id");

    if (verbose) {
        console.log("Doc data: " + doc_data.length);
        console.log(doc_data);
    }

    if (doc_data.length === 0  && verbose) {
        console.log("No data found after filter onduleur.");
    }

    return doc_data;

}


async function panneau_data(doc_data, api_link, marque_panneau, verbose = false) {

    ////////////////////////////////////////
    // Traintement des données de panneau //
    ////////////////////////////////////////

    let marque_panneau_data = await getData(api_link, "?table=marque_panneau");

    if (verbose) {
        console.log("Marque Panneau data: " + marque_panneau_data.length);
        console.log(marque_panneau_data);
    }

    marque_panneau_data = filterResults(marque_panneau_data, getValuesByKey(marque_panneau, "text"), "nom");

    if (verbose) {
        console.log("Marque Panneau data: " + marque_panneau_data.length);
        console.log(marque_panneau_data);
    }

    let id_marque_panneau = getValuesByKey(marque_panneau_data, "id");

    if (verbose) {
        console.log("IDs Panneau: " + id_marque_panneau.length);
        console.log("IDs Panneau: " + id_marque_panneau);
    }

    let panneau_data = await getData(api_link, "?table=panneau");

    if (verbose) {
        console.log("Panneau data: " + panneau_data.length);
        console.log(panneau_data);
    }

    panneau_data = filterResults(panneau_data, id_marque_panneau, "marque_panneau");

    if (verbose) {
        console.log("Panneau data: " + panneau_data.length);
        console.log(panneau_data);
    }

    panneau_id = getValuesByKey(panneau_data, "id");

    if (verbose) {
        console.log("IDs Panneau: " + panneau_id.length);
        console.log("IDs Panneau: " + panneau_id);
    }

    doc_data = filterResults(doc_data, panneau_id, "panneau_id");

    if (verbose) {
        console.log("Doc data: " + doc_data.length);
        console.log(doc_data);
    }

    if (doc_data.length === 0 && verbose) {
        console.log("No data found after filter panneau.");
    }

    return doc_data;

}

async function departement_data(doc_data, api_link, departement, verbose = false) {

    ///////////////////////////////////////////
    // Traintement des données de departement//
    ///////////////////////////////////////////

    let departement_data = await getData(api_link, "?table=region");

    if (verbose) {
        console.log("Departement data: " + departement_data.length);
        console.log(departement_data);
    }

    departement_data = filterResults(departement_data, getValuesByKey(departement, "text"), "admin2");

    if (verbose) {
        console.log("Departement data: " + departement_data.length);
        console.log(departement_data);
    }

    let code_insee = getValuesByKey(departement_data, "id");

    if (verbose) {
        console.log("Code INSEE: " + code_insee.length);
        console.log(code_insee);
    }

    let localisation_data = await getData(api_link, "?table=localisation");

    if (verbose) {
        console.log("Localisation data " + localisation_data.length);
        console.log(localisation_data);
    }


    localisation_data = filterResults(localisation_data, code_insee, "code_insee");

    if (verbose) {
        console.log("Localisation data: " + localisation_data.length);
        console.log(localisation_data);
    }

    let localisation_id = getValuesByKey(localisation_data, "id");

    if (verbose) {
        console.log("IDs Localisation: " + localisation_id.length);
        console.log("IDs Localisation: " + localisation_id);
    }

    doc_data = filterResults(doc_data, localisation_id, "localisation_id");

    if (verbose) {
        console.log("Doc data: " + doc_data.length);
        console.log(doc_data);
    }

    if (doc_data.length === 0 && verbose) {
        console.log("No data found after filter departement.");
    }

    return doc_data;
}

function filterResults(data, values, key) {
    const filteredData = data.filter(item => values.includes(item[key]));
    return filteredData;
}

function getValuesByKey(data, key) {
    let values = data.map(item => item[key]);
    return values;
}

async function getData(api_link, args = "?table=doc") {
    let result = await fetch(api_link + args);
    if (!result.ok) {
        throw new Error("Network response was not ok " + result.statusText);
    }

    result = JSON.parse(await result.text());
    //console.log(result);
    if (!result || !result.data) {
        throw new Error("Invalid data format received");
    }

    data = result['data'];

    //console.log(data);

    return data;
}

function toggleMenu() {
  document.getElementById("navMobile").classList.toggle("show");
}