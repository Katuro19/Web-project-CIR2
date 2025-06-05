function toggleMenu() {
    document.getElementById("navMobile").classList.toggle("show");
}

const map_container = document.getElementById("map-container");
var map = L.map('map-container').setView([46.603354, 1.888334], 6);


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

const années = document.getElementById("selAnnee");
const departement = document.getElementById("selDepartement");

initialFill();

async function initialFill() {
    let anneData = await getData(api_link, "?table=doc&distinctColumn=an");
    let departementData = await getData(api_link, "?table=region&distinctColumn=admin2");

    anneData = getRandElements(anneData, 20);
    departementData = getRandElements(departementData, 20);

    clearSelection(années);
    clearSelection(departement);

    let anneeOptions = "";
    for (let i = 0; i < anneData.length; i++) {
        anneeOptions += `<option value="${anneData[i].an}">${anneData[i].an}</option>`;
    }
    années.innerHTML = anneeOptions;

    let departementOptions = "";
    for (let i = 0; i < departementData.length; i++) {
        departementOptions += `<option value="${departementData[i].code_insee}">${departementData[i].admin2}</option>`;
    }
    departement.innerHTML = departementOptions;
    
}

function getRandElements(elements, count) {

    const values = Object.values(elements);

    for (let i = values.length - 1; i > 0; i--) {
        const j = Math.floor(Math.random() * (i + 1));
        [values[i], values[j]] = [values[j], values[i]];
    }

    const selected = values.slice(0, count);

    const result = {};
    selected.forEach((item, index) => {
        result[index] = item;
    });

    console.log(result);

    return result;
}




function clearSelection(field) {
    field.innerHTML = "";
}





var marker = L.marker([46.603354, 1.888334]).addTo(map);

marker.bindPopup("<b>Hello world!</b><br>I am a popup.");


L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
    maxZoom: 19,
    attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
}).addTo(map);




