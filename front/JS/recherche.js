const elements_par_page = document.getElementById("elements_par_page"); // Récupère l'élément select pour le nombre d'éléments par page

let selectedValue = elements_par_page.value;    // Initialise la valeur sélectionnée avec la valeur par défaut du select

let page = 1;   // Initialise la page actuelle à 1

elements_par_page.addEventListener("change", function () {  // Écoute l'événement de changement sur le select des éléments par page

    selectedValue = elements_par_page.value;    // Met à jour la valeur sélectionnée avec la nouvelle valeur du select

    // console.log("Nombre d'éléments par page sélectionné : " + selectedValue);

     display_elements(1, selectedValue);    // Affiche les éléments de la première page avec le nombre d'éléments sélectionné
});


document.getElementById("prevBtn").addEventListener("click", function () {  // Écoute l'événement de clic sur le bouton "Précédent"

    if (page > 1) { // Vérifie si la page actuelle est supérieure à 1
        page--; // Décrémente la page actuelle
        display_elements(page, selectedValue);  // Affiche les éléments de la page précédente avec le nombre d'éléments sélectionné
    }
});

document.getElementById("nextBtn").addEventListener("click", function () {  // Écoute l'événement de clic sur le bouton "Suivant"
    if (document.querySelectorAll("tr[recherche-id]").length > page * selectedValue) {  // Vérifie s'il y a plus d'éléments à afficher
        page++; // Incrémente la page actuelle
        display_elements(page, selectedValue);  // Affiche les éléments de la page suivante avec le nombre d'éléments sélectionné
    }
});

// Cette fonction affiche les éléments de la page, rentrée en paramètre, en fonction du nombre d'éléments par page sélectionné
function display_elements(page,elements_per_page){

    let start_elem_id = (page - 1) * elements_per_page; // Calcule l'ID de l'élément de départ en fonction de la page et du nombre d'éléments par page
    let final_elem_id = start_elem_id + parseInt(elements_per_page, 10);    // Calcule l'ID de l'élément final en ajoutant le nombre d'éléments par page à l'ID de départ

    // console.log(start_elem_id + " - " + final_elem_id);

    // console.log("Affichage des éléments de la page " + page + " (éléments par page : " + elements_per_page + ")");
    // console.log("Démarrage à l'élément ID : " + start_elem_id);

    let elements = document.querySelectorAll("tr[recherche-id]");   // Sélectionne tous les éléments de la table qui ont l'attribut "recherche-id"
    let total_elements = elements.length;   // Récupère le nombre total d'éléments

    // Afficher uniquement les éléments de la page actuelle

    for (let i = 0; i < total_elements; i++) {  // Parcourt tous les éléments sélectionnés
        if (i >= start_elem_id && i < final_elem_id) {  // Vérifie si l'ID de l'élément est compris entre l'ID de départ et l'ID final

            elements[i].style.display = ""; // Afficher l'élément

            // console.log("Affichage de l'élément ID : " + elements[i].getAttribute("recherche-id"));

        } else {

            elements[i].style.display = "none"; // Masquer l'élément

        }
    }
}



// Fonction pour initialiser un multi-select
function initializeMultiSelect(container) {
    const toggleBtn = container.querySelector('.multi-select-toggle');
    const optionsList = container.querySelector('.multi-select-options');
    const fieldName = container.getAttribute('data-name');

    // Supprimer les anciens event listeners pour éviter les doublons
    const newToggleBtn = toggleBtn.cloneNode(true);
    toggleBtn.parentNode.replaceChild(newToggleBtn, toggleBtn);

    // Ouvrir / fermer la dropdown au clic sur le bouton
    newToggleBtn.addEventListener('click', function (e) {
        e.preventDefault();
        e.stopPropagation();
        container.classList.toggle('open');
    });

    // Fermer la dropdown si on clique en dehors
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

    // Empêcher la fermeture quand on clique dans la dropdown
    optionsList.addEventListener('click', function (e) {
        e.stopPropagation();
    });

    // Mettre à jour le résumé du bouton
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


    // Event delegation pour gérer les changements de checkbox
    optionsList.addEventListener('change', function (e) {
        if (e.target.type === 'checkbox') {
            e.stopPropagation();
            updateSummary();

        }
    });

    // Initialiser le résumé au chargement
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


// Cette fonction remplit les sélecteurs avec des données aléatoires au chargement de la page
async function initialFill() {
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

        initializeAllMultiSelects();    // Initialiser tous les multi-selects après avoir rempli les options
}

// Cette fonction vide le contenu d'un champ de sélection
function clearSelection(field) {
    field.innerHTML = "";
}

// Cette fonction récupère les départements sélectionnés dans le multi-select
function getSelectedDepartements() {

    const container = document.getElementById('selDepartement');    // Récupère le conteneur du multi-select pour les départements
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');    // Sélectionne tous les checkboxes cochés dans le conteneur

    return Array.from(checkboxes).map(checkbox => ({
        value: checkbox.value, // code_insee
        text: checkbox.parentNode.textContent.trim() // admin2
    }));
}

// Cette fonction récupère les marques d'onduleurs sélectionnées dans le multi-select
function getSelectedMarqueOnduleur() {

    const container = document.getElementById('selOnduleur');   // Récupère le conteneur du multi-select pour les onduleurs
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');    // Sélectionne tous les checkboxes cochés dans le conteneur

    return Array.from(checkboxes).map(checkbox => ({
        value: checkbox.value,
        text: checkbox.parentNode.textContent.trim()
    }));
}

// Cette fonction récupère les marques de panneaux sélectionnées dans le multi-select
function getSelectedMarquePanneau() {

    const container = document.getElementById('selPanneau');    // Récupère le conteneur du multi-select pour les panneaux
    const checkboxes = container.querySelectorAll('input[type="checkbox"]:checked');    // Sélectionne tous les checkboxes cochés dans le conteneur

    return Array.from(checkboxes).map(checkbox => ({
        value: checkbox.value,
        text: checkbox.parentNode.textContent.trim()
    }));
}


// Ctte fonction fitre les données de la table doc en fonction des départements, marques d'onduleurs et marques de panneaux sélectionnés
async function getDocDataParSelection(departement, marque_onduleur, marque_panneau, verbose = false) {

    let doc_data = [];

    if (departement.length > 0 || marque_onduleur.length > 0 || marque_panneau.length > 0) {    // Si au moins un des filtres est sélectionné
        doc_data = await getData(api_link, "?table=doc");
    }

    if (verbose) {
        console.log("dep : " + departement.length + " ond : " + marque_onduleur.length + " pan : " + marque_panneau.length);
    }

    if (departement.length > 0 && marque_onduleur.length > 0 && marque_panneau.length > 0) {    // Si tous les filtres sont sélectionnés
        doc_data = await departement_data(doc_data, api_link, departement, verbose);    // Filtre les données en fonction des départements
        doc_data = await onduleur_data(doc_data, api_link, marque_onduleur, verbose);   // Filtre les données en fonction des marques d'onduleurs
        doc_data = await panneau_data(doc_data, api_link, marque_panneau, verbose);     // Filtre les données en fonction des marques de panneaux

    }

    else if ((marque_panneau.length > 0 && departement.length > 0) || (marque_onduleur.length > 0 && departement.length > 0) || (marque_onduleur.length > 0 && marque_panneau.length > 0)) {    // Si deux filtres sont sélectionnés
        if (marque_panneau.length > 0 && departement.length > 0) {  // Si les marques de panneaux et les départements sont sélectionnés
            doc_data = await departement_data(doc_data, api_link, departement, verbose);    // Filtre les données en fonction des départements
            doc_data = await panneau_data(doc_data, api_link, marque_panneau, verbose);     // Filtre les données en fonction des marques de panneaux
        }
        if (marque_panneau.length > 0 && marque_onduleur.length > 0) {  // Si les marques de panneaux et les marques d'onduleurs sont sélectionnées
            doc_data = await onduleur_data(doc_data, api_link, marque_onduleur, verbose);   // Filtre les données en fonction des marques d'onduleurs
            doc_data = await panneau_data(doc_data, api_link, marque_panneau, verbose);     // Filtre les données en fonction des marques de panneaux
        }
        if (marque_onduleur.length > 0 && departement.length > 0) {     // Si les marques d'onduleurs et les départements sont sélectionnés
            doc_data = await departement_data(doc_data, api_link, departement, verbose);    // Filtre les données en fonction des départements
            doc_data = await onduleur_data(doc_data, api_link, marque_onduleur, verbose);   // Filtre les données en fonction des marques d'onduleurs
        }
    }

    else if (departement.length > 0 || marque_onduleur.length > 0 || marque_panneau.length > 0) {   // Si un seul filtre est sélectionné
        if (marque_onduleur.length > 0) {   // Si les marques d'onduleurs sont sélectionnées
            doc_data = await onduleur_data(doc_data, api_link, marque_onduleur, verbose);   // Filtre les données en fonction des marques d'onduleurs
        }
        if (departement.length > 0) {   // Si les départements sont sélectionnés
            doc_data = await departement_data(doc_data, api_link, departement, verbose);    // Filtre les données en fonction des départements
        }
        if (marque_panneau.length > 0) {    // Si les marques de panneaux sont sélectionnées
            doc_data = await panneau_data(doc_data, api_link, marque_panneau, verbose);     // Filtre les données en fonction des marques de panneaux
        }
    }

    if (verbose) {
        console.log("Final Doc Data: " + doc_data.length);
        console.log(doc_data);
    }

    return doc_data;
}


document.getElementById("filter_rechercher").addEventListener("click", async function () {  // Écoute l'événement de clic sur le bouton de recherche

    document.getElementById("titre_recherche").innerHTML = "<h2 style=\"display:inline\">Résultats : </h2>" // Réinitialise le titre de la recherche
    document.getElementById("resultat_recherche").innerHTML = "";   // Réinitialise le contenu des résultats de la recherche
    document.getElementById("resultat_recherche").innerHTML = "<tr><td colspan=\"6\">Recherche en cours...</td></tr>";  // Affiche un message de recherche en cours

    await recherche();

});

// Cette fonction effectue la recherche en fonction des sélections faites dans les multi-selects et affiche les résultats dans le tableau de résultats de recherche
async function recherche() {
    let selected_departement = getSelectedDepartements(); // Appel de la fonction pour récupérer les départements sélectionnés
    let selected_onduleur = getSelectedMarqueOnduleur(); // Appel de la fonction pour récupérer les onduleurs sélectionnés
    let selected_panneau = getSelectedMarquePanneau(); // Appel de la fonction pour récupérer les panneaux sélectionnés

    let data = await getDocDataParSelection(selected_departement, selected_onduleur, selected_panneau); // Récupère les données des installations en fonction des sélections

    //console.log("Data length: " + data.length);

    if (data.length === 0) {
        document.getElementById("resultat_recherche").innerHTML = "";
        document.getElementById("resultat_recherche").innerHTML = "<tr><td colspan=\"6\">Aucun résultat trouvé pour les elements sélectionnés.</td></tr>";
        document.getElementById("titre_recherche").innerHTML = "<h2 style=\"display:inline\">Résultats : </h2>&nbsp;" + data.length + " résultats trouvés";
        return;
    } else {

        //console.log(data[0]);

        let result = [];

        for (let i = 0; i < data.length; i++) { // Parcourt les données récupérées
            let doc = data[i];
            let localisation = await getData(api_link, "?table=localisation&id=" + doc.localisation_id);    // Récupère les données de localisation pour chaque installation
            ville = await getData(api_link, "?table=region&id=" + localisation.code_insee); // Récupère la ville associée à la localisation
            ville = ville.ville;

            let mois = doc.mois < 10 ? "0" + doc.mois : doc.mois;

            element = "<tr recherche-id=\"" + i + "\"display=\"\"id=\"" + doc.id + "\"><td value=\"date\">"
                + mois + "-" + doc.an + "</td><td value=\"nb_panneau\">"
                + doc.nb_panneaux + "</td><td value=\"surface\">"
                + doc.surface + "</td><td value=\"puissance_crete\">"
                + doc.puissance_crete + "</td><td value=\"ville\">"
                + ville + "</td><td value=\"detail\"><a href=\"details.php?table=doc&id="
                + doc.id + "\">Voir détails</a></td></tr>";

            result.push(element);
        }

        document.getElementById("resultat_recherche").innerHTML = result.join("");  // Insère les résultats dans le tableau de résultats de recherche
        document.getElementById("titre_recherche").innerHTML = "<h2 style=\"display:inline\">Résultats : </h2>&nbsp;&nbsp;&nbsp;" + data.length + " résultats trouvés"; // Met à jour le titre de la recherche avec le nombre de résultats trouvés

        display_elements(1, selectedValue); // Afficher la première page avec le nombre d'éléments sélectionné

        //console.log(result[0])
    }



}