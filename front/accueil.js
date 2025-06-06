

async function statistics() {


  console.log("Fetching statistics...");

  let installations = await getData(api_link, "?table=doc&countColumn=id");
  let années = await getData(api_link, "?table=doc&countColumn=an");
  let regions = await getData(api_link, "?table=region&countColumn=admin1");
  let oduleurs = await getData(api_link, "?table=marque_onduleur&countColumn=id");
  let panneaux = await getData(api_link, "?table=marque_panneau&countColumn=id");
  let installateurs = await getData(api_link, "?table=installateur&countColumn=id");

  console.log("Installations:", installations[0]);
  console.log("Années: ", années[0].count ?? "Aucune donnée");
  console.log("Régions: ", regions[0].count ?? "Aucune donnée");
  console.log("Onduleurs: ", oduleurs[0].count ?? "Aucune donnée");
  console.log("Panneaux: ", panneaux[0].count ?? "Aucune donnée");
  console.log("Installateurs: ", installateurs[0].count ?? "Aucune donnée");

  let statistics = {
    "installations": installations[0].count,
    "années": années[0].count,
    "régions": regions[0].count,
    "onduleurs": oduleurs[0].count,
    "panneaux": panneaux[0].count,
    "installateurs": installateurs[0].count
  };

  console.log(statistics);



  insertStatistics(statistics);
}

function insertStatistics(statistics) {

  document.getElementById("enregistrement").innerText = statistics.installations + " installations";
  document.getElementById("install_an").innerText = statistics.années + " ans";
  document.getElementById("install_region").innerText = statistics.régions + " régions";
  document.getElementById("install_an_region").innerText = Math.round((statistics.installations / (statistics.années + statistics.régions))) + " installations/region/an  ";
  document.getElementById("marque_panneau").innerText = statistics.panneaux + " marques de panneaux solaires";
  document.getElementById("marque_onduleur").innerText = statistics.onduleurs + " marques d'onduleurs";
  document.getElementById("installateur").innerText = statistics.installateurs + " installateurs";

  //console.log("Statistics inserted into the DOM");

}

//data = getData(api_link, "?table=doc&limit=10");
statistics();



function getYearMonth() {
  let date = new Date();
  let year = date.getFullYear();
  let month = date.getMonth() + 1; // Months are zero-based in JavaScript

  let result = {
    year: year,
    month: month
  };

  return result;

}

getYearMonth();