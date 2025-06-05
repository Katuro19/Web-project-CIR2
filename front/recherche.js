function toggleMenu() {
    document.getElementById("navMobile").classList.toggle("show");
}

async function getData(api_link, args = "?table=doc") {
    let result = await fetch(api_link + args);
    if (!result.ok) {
        throw new Error("Network response was not ok " + result.statusText);
    }

    result = JSON.parse(await result.text());
    if (!result || !result.data) {
        throw new Error("Invalid data format received");
    }

    data = result['data'];

    //console.log(data);

    return data;
}

// Fonction pour initialiser un multi-select spécifique
function initializeMultiSelect(container) {
    const toggleBtn = container.querySelector('.multi-select-toggle');
    const optionsList = container.querySelector('.multi-select-options');
    const fieldName = container.getAttribute('data-name');

    // Supprimer les anciens event listeners pour éviter les doublons
    const newToggleBtn = toggleBtn.cloneNode(true);
    toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);

    // 1. Ouvrir / fermer la dropdown au clic sur le bouton
    newToggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        container.classList.toggle('open');
    });

    // 2. Fermer la dropdown si on clique en dehors
    function closeOnOutsideClick(e) {
        if (!container.contains(e.target)) {
            container.classList.remove('open');
        }
    }

    // Supprimer l'ancien listener s'il existe
    if (container._outsideClickListener) {
        document.removeEventListener('click', container._outsideClickListener);
    }
    container._outsideClickListener = closeOnOutsideClick;
    document.addEventListener('click', closeOnOutsideClick);

    // 3. Empêcher la fermeture quand on clique dans la dropdown
    optionsList.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // 4. Mettre à jour le résumé du bouton
    function updateSummary() {
        const checkboxes = optionsList.querySelectorAll('input[type="checkbox"]');
        const sélectionnées = [];

        checkboxes.forEach(function (cb) {
            if (cb.checked) {
                const label = cb.parentNode.textContent.trim();
                sélectionnées.push(label);
            }
        });

        if (sélectionnées.length === 0) {
            newToggleBtn.innerHTML = 'Sélectionner… <span class="arrow">▾</span>';
        } else if (sélectionnées.length === 1) {
            newToggleBtn.innerHTML =
                `<span class="multi-select-summary">${sélectionnées[0]}</span> <span class="arrow">▾</span>`;
        } else {
            newToggleBtn.innerHTML =
                `<span class="multi-select-summary">${sélectionnées.length} éléments sélectionnés</span> <span class="arrow">▾</span>`;
        }
    }


    // 6. Event delegation pour gérer les changements de checkbox
    optionsList.addEventListener('change', function (e) {
        if (e.target.type === 'checkbox') {
            e.stopPropagation();
            updateSummary();
            let selected_departement = getSelectedDepartements(); // Appel de la fonction pour récupérer les départements sélectionnés
            let selected_onduleur = getSelectedMarqueOnduleur(); // Appel de la fonction pour récupérer les onduleurs sélectionnés
            let selected_panneau = getSelectedMarquePanneau(); // Appel de la fonction pour récupérer les panneaux sélectionnés

            // console.log(selected_departement);
            // console.log(selected_onduleur);
            // console.log(selected_panneau);

            getMarquePanneau(selected_departement, selected_onduleur);
            // getMarqueOnduleur(selected_departement, selected_panneau);
            // getDepartement(selected_onduleur, selected_panneau);
        }
    });

    // 7. Initialiser le résumé au chargement
    updateSummary();
}

// Fonction pour initialiser tous les multi-selects
function initializeAllMultiSelects() {
    document.querySelectorAll('.multi-select').forEach(initializeMultiSelect);
}

const marque_onduleur = document.getElementById("selOnduleur");
const marque_panneau = document.getElementById("selPanneau");
const departement = document.getElementById("selDepartement");

// Initialisation au chargement de la page
document.addEventListener('DOMContentLoaded', function () {
    initialFill();
});

async function initialFill() {
    try {
        let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur&limit=20");
        let marque_panneau_data = await getData(api_link, "?table=marque_panneau&limit=20");
        let departement_data = await getData(api_link, "?table=region&limit=20");

        clearSelection(marque_onduleur);
        clearSelection(marque_panneau);
        clearSelection(departement);

        // Remplir marque_onduleur
        let marque_onduleur_options = "";
        for (let i = 0; i < Object.keys(marque_onduleur_data).length; i++) {
            marque_onduleur_options += `<li><label><input type="checkbox" value="${marque_onduleur_data[i].id}">${marque_onduleur_data[i].nom}</label></li>`;
        }
        marque_onduleur.innerHTML = marque_onduleur_options;

        // Remplir marque_panneau
        let marque_panneau_options = "";
        for (let i = 0; i < Object.keys(marque_panneau_data).length; i++) {
            marque_panneau_options += `<li><label><input type="checkbox" value="${marque_panneau_data[i].id}">${marque_panneau_data[i].nom}</label></li>`;
        }
        marque_panneau.innerHTML = marque_panneau_options;

        // Remplir departement
        let departement_options = "";
        for (let i = 0; i < Object.keys(departement_data).length; i++) {
            departement_options += `<li><label><input type="checkbox" value="${departement_data[i].code_insee}">${departement_data[i].admin2}</label></li>`;
        }
        departement.innerHTML = departement_options;

        // IMPORTANT : Initialiser les multi-selects APRÈS avoir ajouté les options
        initializeAllMultiSelects();

    } catch (error) {
        console.error('Erreur lors du chargement des données:', error);
    }
}

function clearSelection(field) {
    field.innerHTML = "";
}

function getSelectedDepartements() {
    const container = document.getElementById('selDepartement');
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');

    return Array.from(checkboxes).map(checkbox => ({
        value: checkbox.value, // code_insee
        text: checkbox.parentNode.textContent.trim() // admin2
    }));
}

// Fonctions utilitaires pour récupérer les sélections
function getSelectedMarqueOnduleur() {
    const container = document.getElementById('selOnduleur');
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');

    return Array.from(checkboxes).map(checkbox => ({
        value: checkbox.value,
        text: checkbox.parentNode.textContent.trim()
    }));
}

function getSelectedMarquePanneau() {
    const container = document.getElementById('selPanneau');
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');

    return Array.from(checkboxes).map(checkbox => ({
        value: checkbox.value,
        text: checkbox.parentNode.textContent.trim()
    }));
}



function filterResults(data, values, key) {

    //console.log(values);

    // console.log("filter values");
    // console.log(values);

    // Garde les éléments dont la propriété key est présente dans filterValues
    const filteredData = data.filter(item => values.includes(item[key]));

    //console.log("Filtered data:" + filteredData.length);

    return filteredData;
}

function getValuesByKey(data, key) {

    // console.log(data)

    let values = data.map(item => item[key]);

    // console.log("Values by key: " + values);

    return values;
}


async function getMarquePanneau(departement, marque_onduleur) {

    let doc_data = await getData(api_link, "?table=doc");

    console.log("dep : " + departement.length + " ond : " + marque_onduleur.length);

    if (departement.length > 0 && marque_onduleur.length > 0) {
        let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur");
        let departement_data = await getData(api_link, "?table=region");

        marque_onduleur_data = filterResults(marque_onduleur_data, getValuesByKey(marque_onduleur, "text"), "nom");
        departement_data = filterResults(departement_data, getValuesByKey(departement, "text"), "admin2");

        //console.log(departement_data);

        let code_insee = getValuesByKey(departement_data, "code_insee");

        //console.log("Code INSEE: " + code_insee.length);
        //console.log(code_insee);

        let localisation_data = await getData(api_link, "?table=localisation");

        //console.log(localisation_data);

        localisation_data = filterResults(localisation_data, code_insee, "code_insee");

        //console.log("Localisation data: " + localisation_data.length);
        //console.log(localisation_data);

        let localisation_id = getValuesByKey(localisation_data, "id");

        // console.log("IDs Localisation: " + localisation_id.length);
        // console.log("IDs Localisation: " + localisation_id);

        let id_marque_onduleur = getValuesByKey(marque_onduleur_data, "id");

        // console.log("IDs Onduleur: " + ids_onduleur.length);
        // console.log("IDs Onduleur: " + ids_onduleur);

        let onduleur_data = await getData(api_link, "?table=onduleur");

        // console.log("Onduleur data: " + onduleur_data.length);
        // console.log(onduleur_data);

        onduleur_data = filterResults(onduleur_data, id_marque_onduleur, "marque_onduleur");

        // console.log("Onduleur data: " + onduleur_data.length);
        // console.log(onduleur_data);

        onduleur_id = getValuesByKey(onduleur_data, "id");

        // console.log("IDs Onduleur: " + onduleur_id.length);
        // console.log("IDs Onduleur: " + onduleur_id);

        doc_data = await getData(api_link, "?table=doc");

        // console.log("Doc data: " + doc_data.length);
        // console.log(doc_data);

        doc_data = filterResults(doc_data, localisation_id, "localisation_id");

        // console.log("Doc data: " + doc_data.length);
        // console.log(doc_data);

        doc_data = filterResults(doc_data, onduleur_id, "onduleur_id");

        console.log("Doc data: " + doc_data.length);
        // console.log(doc_data);


        if (doc_data.length === 0) {
            console.log("No data found for the given filters.");
        }
    }
    else {
        if (marque_onduleur.length > 0) {


            let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur");
            marque_onduleur_data = filterResults(marque_onduleur_data, getValuesByKey(marque_onduleur, "text"), "nom");

            let id_marque_onduleur = getValuesByKey(marque_onduleur_data, "id");

            // console.log("IDs Onduleur: " + ids_onduleur.length);
            // console.log("IDs Onduleur: " + ids_onduleur);

            let onduleur_data = await getData(api_link, "?table=onduleur");

            // console.log("Onduleur data: " + onduleur_data.length);
            // console.log(onduleur_data);

            onduleur_data = filterResults(onduleur_data, id_marque_onduleur, "marque_onduleur");

            // console.log("Onduleur data: " + onduleur_data.length);
            // console.log(onduleur_data);

            onduleur_id = getValuesByKey(onduleur_data, "id");

            // console.log("IDs Onduleur: " + onduleur_id.length);
            // console.log("IDs Onduleur: " + onduleur_id);

            doc_data = await getData(api_link, "?table=doc");

            // console.log("Doc data: " + doc_data.length);
            // console.log(doc_data);

            doc_data = filterResults(doc_data, onduleur_id, "onduleur_id");

            console.log("Doc data: " + doc_data.length);
            // console.log(doc_data);

            if (doc_data.length === 0) {
                console.log("No data found for the given filter.");
            }

        }

        if (departement.length > 0) {
            let departement_data = await getData(api_link, "?table=region");
            departement_data = filterResults(departement_data, getValuesByKey(departement, "text"), "admin2");

            let code_insee = getValuesByKey(departement_data, "code_insee");

            //console.log("Code INSEE: " + code_insee.length);
            //console.log(code_insee);

            let localisation_data = await getData(api_link, "?table=localisation");

            // console.log("Localisation data: " + localisation_data.length);
            //console.log(localisation_data);

            let localisation_id = getValuesByKey(localisation_data, "id");

            // console.log("IDs Localisation: " + localisation_id.length);
            // console.log("IDs Localisation: " + localisation_id);

            localisation_data = filterResults(localisation_data, code_insee, "code_insee");

            //console.log("Localisation data: " + localisation_data.length);
            //console.log(localisation_data);

            doc_data = await getData(api_link, "?table=doc");

            // console.log("Doc data: " + doc_data.length);
            // console.log(doc_data);

            doc_data = filterResults(doc_data, localisation_id, "localisation_id");

            console.log("Doc data: " + doc_data.length);
            // console.log(doc_data);

            if (doc_data.length === 0) {
                console.log("No data found for the given filter.");
            }

        }
    }



}


async function getMarqueOnduleur(departement = null, marque_panneau = null) {
    console.log("dep : " + departement.length + " ond : " + marque_panneau.length);

    if (departement.length > 0 && marque_panneau.length > 0) {
        let marque_panneau_data = await getData(api_link, "?table=marque_panneau");
        let departement_data = await getData(api_link, "?table=region");

        marque_panneau_data = filterResults(marque_onduleur_data, marque_panneau);
        departement_data = filterResults(departement_data, departement, "code_insee");


    }
    else {
        if (marque_panneau.length > 0) {
            let marque_panneau_data = await getData(api_link, "?table=marque_panneau");
            marque_panneau_data = filterResults(marque_onduleur_data, marque_panneau, "nom");
        }

        if (departement.length > 0) {
            let departement_data = await getData(api_link, "?table=region");
            departement_data = filterResults(departement_data, departement, "admin2");
        }
    }
}

async function getDepartement(marque_onduleur = null, marque_panneau = null) {
    console.log("dep : " + marque_panneau.length + " ond : " + marque_onduleur.length);

    if (marque_panneau.length > 0 && marque_onduleur.length > 0) {
        let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur");
        let marque_panneau_data = await getData(api_link, "?table=marque_panneau");

        marque_onduleur_data = filterResults(marque_onduleur_data, marque_onduleur);
        marque_panneau_data = filterResults(departement_data, marque_panneau, "code_insee");


    }
    else {
        if (marque_onduleur.length > 0) {
            let marque_onduleur_data = await getData(api_link, "?table=marque_onduleur");
            marque_onduleur_data = filterResults(marque_onduleur_data, marque_onduleur, "nom");
        }

        if (marque_panneau.length > 0) {
            let marque_panneau_data = await getData(api_link, "?table=marque_panneau");
            marque_panneau_data = filterResults(departement_data, marque_panneau, "admin2");
        }
    }
}