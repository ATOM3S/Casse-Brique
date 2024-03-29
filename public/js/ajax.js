// Exécute un appel AJAX GET
// Prend en paramètres l'URL cible et la fonction callback appelée en cas de succès
function ajaxGet(url, callback) {
	// Création d'une requête HTTP
	var req = new XMLHttpRequest();

	// La requête est asynchrone lorsque le 3ème paramètre vaut true ou est absent
	req.open("GET", url);
    req.setRequestHeader("X-Requested-With",'xmlhttprequest');
	// Gestion de l'évènement indiquant la fin de la requête 
	req.addEventListener("load", function () {
		if (req.status >= 200 && req.status < 400) { //Le serveur a réussi à traiter la requête
			// Affiche la réponse reçue pour la requête 
			callback(req.responseText);
		} else { 
			// Affiche des informations sur l'échec du traitement de la requête 
			console.error(req.status + " " + req.statusText + " " + url);
		}
	});
	req.addEventListener("error", function () {
		// La requête n'a pas réussi à atteindre le serveur
		console.error("Erreur réseau avec l'URL " + url);
	});
	req.send(null); 
}

// Exécute un appel AJAX POST
// Prend en paramètres l'URL cible, la donnée à envoyer et la fonction callback appelée en cas de succès
// Le paramètre isJson permet d'indiquer si l'envoi concerne des données JSON
function ajaxPost(url, data, callback, isJson) {
    var req = new XMLHttpRequest();
    req.open("POST", url);
    req.addEventListener("load", function () {
        if (req.status >= 200 && req.status < 400) {
            // Appelle la fonction callback en lui passant la réponse de la requête
            callback(req.responseText);
        } else {
            console.error(req.status + " " + req.statusText + " " + url);
        }
    });
    req.addEventListener("error", function () {
        console.error("Erreur réseau avec l'URL " + url);
    });
    if (isJson) {
        // Définit le contenu de la requête comme étant du JSON
        req.setRequestHeader("Content-Type", "application/json");
        // Transforme la donnée du format JSON vers le format texte avant l'envoi
        data = JSON.stringify(data);
    }
    req.send(data);
}