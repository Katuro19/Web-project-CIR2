const map_container = document.getElementById("map-container");     // Récupère le conteneur de la carte
var map = L.map('map-container').setView([46.603354, 1.888334], 6); // Initialise la carte centrée sur la France avec un niveau de zoom de 6

const annee = document.getElementById("selAnnee");                  // Récupère l'élément de sélection pour l'année
const departement = document.getElementById("selDepartement");      // Récupère l'élément de sélection pour le département

L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);

initialFill();  // Remplis les options aavec des choix aléatoires

document.getElementById("carte_recherche").addEventListener("click", function () { // On regarde si le bouton de recherche est cliqué
    filterResults_carte(annee, departement);
});

// Cette fonction remplit les sélecteurs d'année et de département avec des options aléatoires.
async function initialFill() {

    let anneData = await getData(api_link, "?table=doc&distinctColumn=an"); // Récupère les années distinctes des installations

    anneData = getRandElements(anneData, 20);   // Prend 20 années aléatoires

    for (let i = 0; i < anneData.length; i++) {
        anneData[i] = anneData[i].an;
    }

    anneData.sort();        // Trie les années par ordre croissant

    let anneeOptions = [];
    for (let i = 0; i < anneData.length; i++) {
        let anne = "<option value=\"" + anneData[i] + "\">" + anneData[i] + "</option>";
        anneeOptions.push(anne);
    }

    annee.innerHTML = anneeOptions;         //On met les options dans le select

    let departementData = await getData(api_link, "?table=region&distinctColumn=admin2"); // Récupère les départements distincts

    departementData = getRandElements(departementData, 20);     // Prend 20 départements aléatoires

    for (let i = 0; i < departementData.length; i++) {
        departementData[i] = departementData[i].admin2;
    }

    departementData.sort();     // Trie les départements par ordre alphabétique

    let departementOptions = [];
    for (let i = 0; i < departementData.length; i++) {
        let departement = "<option value=\"" + departementData[i] + "\">" + departementData[i] + "</option>";
        departementOptions.push(departement);
    }

    departement.innerHTML = departementOptions;     // On met les options dans le select

}
// Cette fonction filtre les résultats de la carte en fonction de l'année et du département sélectionnés.
async function filterResults_carte(annee, departement) {

    document.getElementById("searchResults").innerHTML = ""; // Réinitialise les résultats de la recherche

    annee = annee.value;
    departement = departement.value;

    let code_insee = await getData(api_link, "?table=region&column=admin2&value=" + departement); // Récupère les données de la région correspondant au département sélectionné

    // console.log(code_insee);

    code_insee = getValuesByKey(code_insee, "id"); // Extrait les codes INSEE des régions 

    // console.log(code_insee);

    let localisation_data = await getData(api_link, "?table=localisation");         // Récupère la table localisation
    localisation_data = filterResults(localisation_data, code_insee, "code_insee");     // Filtre les localisations en fonction des codes INSEE des régions

    // console.log(localisation_data);

    let localisation_id = getValuesByKey(localisation_data, "id");      // Extrait les IDs des localisations filtrées

    // console.log(localisation_id);

    let doc_data = await getData(api_link, "?table=doc&column=an&value=" + annee);      // Récupère les données des installations pour l'année sélectionnée

    doc_data = filterResults(doc_data, localisation_id, "localisation_id");     // Filtre les installations en fonction des IDs des localisations filtrées

    // console.log(doc_data);

    if (doc_data.length === 0) {
        document.getElementById("searchResults").innerHTML = "<p id=\"searchResultsText\">Aucun résultat trouvé pour " + departement + " " + annee + ".</p>";
        return;
    }   

    let markers = [];       // Tableau pour stocker les marqueurs de la carte

    for (let i = 0; i < doc_data.length; i++) {
        let doc = doc_data[i];
        
        let localisation_doc = await getData(api_link, "?table=localisation&id=" + doc.localisation_id);

        let lat = localisation_doc.lat;
        let long = localisation_doc.long;

        markers.push(L.marker([lat, long]).bindPopup("<b>Installation n° <a href=\"details.php?table=doc&id="
            + doc.id + "\">" + doc.id + "</a></b><br>Puissance max: "
            + doc.puissance_crete + " w<br>Surface : "
            + doc.surface + " m²"));        // Crée un marqueur pour chaque installation avec un popup contenant les détails de l'installation
    }

    markers.forEach(marker => marker.addTo(map));   // Ajoute les marqueurs à la carte

    const bounds = L.latLngBounds(markers.map(marker => marker.getLatLng()));   // Calcule les limites de la carte en fonction des marqueurs

    map.fitBounds(bounds);  // Ajuste la vue de la carte pour afficher tous les marqueurs

}

