//Cette fonction récupère les données statistiques de l'API et les ajoute dans le DOM.
async function statistics() {

  // console.log("Fetching statistics...");

  let installations = await getData(api_link, "?table=doc&countColumn=id");
  let années = await getData(api_link, "?table=doc&countColumn=an");
  let regions = await getData(api_link, "?table=region&countColumn=admin1");
  let oduleurs = await getData(api_link, "?table=marque_onduleur&countColumn=id");
  let panneaux = await getData(api_link, "?table=marque_panneau&countColumn=id");
  let installateurs = await getData(api_link, "?table=installateur&countColumn=id");

  // console.log("Installations:", installations[0]);
  // console.log("Années: ", années[0].count ?? "Aucune donnée");
  // console.log("Régions: ", regions[0].count ?? "Aucune donnée");
  // console.log("Onduleurs: ", oduleurs[0].count ?? "Aucune donnée");
  // console.log("Panneaux: ", panneaux[0].count ?? "Aucune donnée");
  // console.log("Installateurs: ", installateurs[0].count ?? "Aucune donnée");

  let statistics = {
    "installations": installations[0].count,
    "années": années[0].count,
    "régions": regions[0].count,
    "onduleurs": oduleurs[0].count,
    "panneaux": panneaux[0].count,
    "installateurs": installateurs[0].count
  };

  // console.log(statistics);

  document.getElementById("enregistrement").innerText = statistics.installations + " installations";
  document.getElementById("install_an").innerText = statistics.années + " ans";
  document.getElementById("install_region").innerText = statistics.régions + " régions";
  document.getElementById("install_an_region").innerText = Math.round((statistics.installations / (statistics.années + statistics.régions))) + " installations/region/an  ";
  document.getElementById("marque_panneau").innerText = statistics.panneaux + " marques de panneaux solaires";
  document.getElementById("marque_onduleur").innerText = statistics.onduleurs + " marques d'onduleurs";
  document.getElementById("installateur").innerText = statistics.installateurs + " installateurs";

  //console.log("Statistics inserted into the DOM");

}

statistics();