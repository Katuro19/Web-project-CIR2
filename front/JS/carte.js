const map_container = document.getElementById("map-container");
var map = L.map('map-container').setView([46.603354, 1.888334], 6);

const annee = document.getElementById("selAnnee");
const departement = document.getElementById("selDepartement");

initialFill();

document.getElementById("carte_recherche").addEventListener("click", function () {
    filterResults_carte(annee, departement);
});


async function initialFill() {
    let anneData = await getData(api_link, "?table=doc&distinctColumn=an");

    anneData = getRandElements(anneData, 20);

    for (let i = 0; i < anneData.length; i++) {
        anneData[i] = anneData[i].an;
    }

    anneData.sort();

    let anneeOptions = [];
    for (let i = 0; i < anneData.length; i++) {
        let anne = "<option value=\"" + anneData[i] + "\">" + anneData[i] + "</option>";
        anneeOptions.push(anne);
    }

    annee.innerHTML = anneeOptions;

    let departementData = await getData(api_link, "?table=region&distinctColumn=admin2");

    departementData = getRandElements(departementData, 20);

    for (let i = 0; i < departementData.length; i++) {
        departementData[i] = departementData[i].admin2;
    }

    departementData.sort();

    let departementOptions = [];
    for (let i = 0; i < departementData.length; i++) {
        let departement = "<option value=\"" + departementData[i] + "\">" + departementData[i] + "</option>";
        departementOptions.push(departement);
    }

    departement.innerHTML = departementOptions;

}

function getRandElements(elements, count) {

    for (let i = elements.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [elements[i], elements[j]] = [elements[j], elements[i]]; // shuffle
    }
    return elements.slice(0, count);
}

async function filterResults_carte(annee, departement) {

    document.getElementById("searchResults").innerHTML = "";

    annee = annee.value;
    departement = departement.value;

    let code_insee = await getData(api_link, "?table=region&column=admin2&value=" + departement)
    code_insee = getValuesByKey(code_insee, "id");

    // console.log(code_insee);

    let localisation_data = await getData(api_link, "?table=localisation");
    localisation_data = filterResults(localisation_data, code_insee, "code_insee");

    // console.log(localisation_data);

    let localisation_id = getValuesByKey(localisation_data, "id");

    // console.log(localisation_id);

    let doc_data = await getData(api_link, "?table=doc&column=an&value=" + annee);

    doc_data = filterResults(doc_data, localisation_id, "localisation_id");

    console.log(doc_data);

    if (doc_data.length === 0) {
        document.getElementById("searchResults").innerHTML = "<p id=\"searchResultsText\">Aucun résultat trouvé pour " + departement + " " + annee + ".</p>";
        return;
    }

    for (let i = 0; i < doc_data.length; i++) {
        let doc = doc_data[i];
        let localisation_doc = await getData(api_link, "?table=localisation&id=" + doc.localisation_id);

        let lat = localisation_doc.lat;
        let long = localisation_doc.long;


        let marker = L.marker([lat, long]).addTo(map);

        marker.bindPopup("<b>Installation n°" + doc.id + "</b><br>Puissance max: " 
            + doc.puissance_crete+ "<br>Surface : "
            + doc.surface + " m²<br>Detail : <a href=\"details.php?table=doc&id=" 
            + doc.id + "\">Voir</a>");
    }

}

var marker = L.marker([46.603354, 1.888334]).addTo(map);

marker.bindPopup("<b>Hello world!</b><br>I am a popup.");


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);




