function toggleMenu() {
    document.getElementById("navMobile").classList.toggle("show");
}

async function getData(api_link, args = "?table=doc") {
    let result = await fetch(api_link + args);
    if (!result.ok) {
        throw new Error("Network response was not ok " + result.statusText);
    }
    //console.log(result);

    result = JSON.parse(await result.text());
    if (!result || !result.data) {
        throw new Error("Invalid data format received");
    }

    temp = result['data'];

    let data = {}

    for (let i = 0; i < temp.length; i++) {
        data[i] = temp[i];
    }

    console.log(data);

    return data;

}


async function getMarquePanneau(departement = null, marque_onduleur = null) {

    if (departement !== null) {

    }
    if (marque_onduleur !== null) {

    }
}


async function getMarqueOnduleur(departement = null, marque_panneau = null) {

    let marque_onduleur = await getData(api_link, "?table=marque_onduleur&limit=20");


}


async function getDepartement(marque_onduleur = null, marque_panneau = null) {

    let region = await getData(api_link, "?table=region&limit=20");

}



const marque_onduleur = document.getElementById("selOnduleur");
const marque_panneau = document.getElementById("selPanneaux");
const departement = document.getElementById("selDepartement");

initialFill();

async function initialFill() {

    let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur&limit=20");
    let marque_panneau_data = await getData(api_link, "?table=marque_panneau&limit=20");
    let departement_data = await getData(api_link, "?table=region&limit=20");
    console.log(departement_data);

    clearSelection(marque_onduleur);
    clearSelection(marque_panneau);
    clearSelection(departement);

    let marque_onduleur_options = "";
    for (let i = 0; i < Object.keys(marque_onduleur_data).length; i++) {
        marque_onduleur_options += `<option value="${marque_onduleur_data[i].id}">${marque_onduleur_data[i].nom}</option>`;
    }
    marque_onduleur.innerHTML = marque_onduleur_options;

    let marque_panneau_options = "";
    for (let i = 0; i < Object.keys(marque_panneau_data).length; i++) {
        marque_panneau_options += `<option value="${marque_panneau_data[i].id}">${marque_panneau_data[i].nom}</option>`;
    }
    marque_panneau.innerHTML = marque_panneau_options;

    let departement_options = "";
    for (let i = 0; i < Object.keys(departement_data).length; i++) {
        departement_options += `<option value="${departement_data[i].code_insee}">${departement_data[i].admin2}</option>`;
    }
    departement.innerHTML = departement_options;
}


function clearSelection(field) {
    field.innerHTML = "";
}


marque_panneau.addEventListener("change", function () {
    selected_marque_panneau = Array.from(marque_panneau.selectedOptions).map(option => option.value);
    console.log("Marque Panneau changed to: " + selected_marque_panneau.join(", "));
});

marque_onduleur.addEventListener("change", function () {
    selected_marque_onduleur = Array.from(marque_onduleur.selectedOptions).map(option => option.value);
    console.log("Marque Onduleur changed to: " + selected_marque_onduleur.join(", "));
});

departement.addEventListener("change", function () {
    selected_departement = Array.from(departement.selectedOptions).map(option => option.value);
    console.log("Departement changed to: " + selected_departement.join(", "));
});