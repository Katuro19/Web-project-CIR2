function toggleMenu() {
    document.getElementById("navMobile").classList.toggle("show");
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

    const filteredData = data.filter(item => values.includes(item[key]));

    return filteredData;
}

function getValuesByKey(data, key) {

    let values = data.map(item => item[key]);

    return values;
}


async function getDocDataParSelection(departement, marque_onduleur, marque_panneau, verbose = false) {

    let doc_data = [];

    if (departement.length > 0 || marque_onduleur.length > 0 || marque_panneau.length > 0) {
        doc_data = await getData(api_link, "?table=doc");
    }

    if (verbose) {
        console.log("dep : " + departement.length + " ond : " + marque_onduleur.length + " pan : " + marque_panneau.length);
    }

    if (departement.length > 0 && marque_onduleur.length > 0 && marque_panneau.length > 0) {

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

        if (doc_data.length === 0) {
            console.log("No data found after filter departement.");
        }

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
            console.log("IDs Onduleur: " + ids_onduleur.length);
            console.log("IDs Onduleur: " + ids_onduleur);
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

        if (doc_data.length === 0) {
            console.log("No data found after filter onduleur.");
        }


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

        if (doc_data.length === 0) {
            console.log("No data found after filter panneau.");
        }

    }

    else if ((marque_panneau.length > 0 && departement.length > 0) || (marque_onduleur.length > 0 && departement.length > 0) || (marque_onduleur.length > 0 && marque_panneau.length > 0)) {

        if (marque_panneau.length > 0 && departement.length > 0) {
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

            if (doc_data.length === 0) {
                console.log("No data found after filter departement.");
            }

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

            if (doc_data.length === 0) {
                console.log("No data found after filter panneau.");
            }
        }

        if (marque_panneau.length > 0 && marque_onduleur.length > 0) {
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
                console.log("IDs Onduleur: " + ids_onduleur.length);
                console.log("IDs Onduleur: " + ids_onduleur);
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

            if (doc_data.length === 0) {
                console.log("No data found after filter onduleur.");
            }

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

            if (doc_data.length === 0) {
                console.log("No data found after filter panneau.");
            }
        }

        if (marque_onduleur.length > 0 && departement.length > 0) {
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

            if (doc_data.length === 0) {
                console.log("No data found after filter departement.");
            }

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
                console.log("IDs Onduleur: " + ids_onduleur.length);
                console.log("IDs Onduleur: " + ids_onduleur);
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

            if (doc_data.length === 0) {
                console.log("No data found after filter onduleur.");
            }
        }
    }

    else if (departement.length > 0 || marque_onduleur.length > 0 || marque_panneau.length > 0) {

        if (marque_onduleur.length > 0) {
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
                console.log("IDs Onduleur: " + ids_onduleur.length);
                console.log("IDs Onduleur: " + ids_onduleur);
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

            if (doc_data.length === 0) {
                console.log("No data found after filter onduleur.");
            }
        }

        if (departement.length > 0) {

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

            if (doc_data.length === 0) {
                console.log("No data found after filter departement.");
            }
        }

        if (marque_panneau.length > 0) {
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

            if (doc_data.length === 0) {
                console.log("No data found after filter panneau.");
            }
        }

    }

    if (verbose) {
        console.log("Final Doc Data: " + doc_data.length);
        console.log(doc_data);
    }

    return doc_data;
}


document.getElementById("filter_rechercher").addEventListener("click", async function () {

    let selected_departement = getSelectedDepartements(); // Appel de la fonction pour récupérer les départements sélectionnés
    let selected_onduleur = getSelectedMarqueOnduleur(); // Appel de la fonction pour récupérer les onduleurs sélectionnés
    let selected_panneau = getSelectedMarquePanneau(); // Appel de la fonction pour récupérer les panneaux sélectionnés

    let data = await getDocDataParSelection(selected_departement, selected_onduleur, selected_panneau);

    console.log("Data length: " + data.length);

    if (data.length === 0) {
        document.getElementById("resultat_recherche").innerHTML = "<tr><td colspan=\"6\">Aucun résultat trouvé.</td></tr>";
        return;
    }

    let result = [];

    for (let i = 0; i < data.length; i++) {

        let doc = data[i];
        let localisation = await getData(api_link, "?table=localisation&id=" + doc.localisation_id);
        ville = await getData(api_link, "?table=region&id=" + localisation.code_insee);
        ville = ville.ville;

        let mois = doc.mois < 10 ? "0" + doc.mois : doc.mois;

        element = "<tr id=" + doc.id + "><td value=\"date\">"
            + mois + "-" + doc.an + "</td><td value=\"nb_panneau\">"
            + doc.nbpanneaux + "</td><td value=\"surface\">"
            + doc.surface + "</td><td value=\"puissance_crete\">"
            + doc.puissancecrete + "</td><td value=\"ville\">"
            + ville + "</td><td value=\"detail\"><a href=\"details.php?table=doc&id="
            + doc.id + "\">Voir détails</a></td></tr>";

        result.push(element);
    }

    document.getElementById("resultat_recherche").innerHTML = result.join("");

    //console.log(result[0])
});