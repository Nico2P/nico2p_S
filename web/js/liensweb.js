/* 
Activité 3
*/

//var serveurUrl = "http://localhost/javascript-web-srv/web";
var serveurUrl = "http://localhost:8000";

// Crée et renvoie un élément DOM affichant les données d'un lien
// Le paramètre lien est un objet JS représentant un lien
function creerElementMessage(message) {
    var titreElt = document.createElement("p");
    titreElt.style.color = "#428bca";
    titreElt.style.textDecoration = "none";
    titreElt.style.marginRight = "5px";
    titreElt.appendChild(document.createTextNode(message.content));


    // Cette ligne contient le titre et l'URL du lien
    var ligneMessageElt = document.createElement("h4");
    ligneMessageElt.style.margin = "0px";
    ligneMessageElt.appendChild(titreElt);

    // Cette ligne contient l'auteur et le nombre de commentaires
    var ligneAuteurElt = document.createElement("span");
    ligneAuteurElt.appendChild(document.createTextNode("Ajouté par " + message.author));

    var divMessageElt = document.createElement("div");
    divMessageElt.classList.add("message");
    divMessageElt.appendChild(ligneMessageElt);
    divMessageElt.appendChild(ligneAuteurElt);

    return divMessageElt;
}



//function CreateMessageFormElt()



var contenuElt = document.getElementById("contenu");
// Récupération de la liste des liens auprès du serveur
ajaxGet(serveurUrl + "/commentary", function (reponse) {
    // Liste des liens Web à afficher. Un lien est défini par :
    // - son titre
    // - son URL
    // - son auteur (la personne qui l'a publié)
    var listeMessages = JSON.parse(reponse);
    // Parcours de la liste des liens et ajout d'un élément au DOM pour chaque lien
    listeMessages.forEach(function (message) {
        var messageElt = creerElementMessage(message);
        contenuElt.appendChild(messageElt);
    });
});

// Crée et renvoie un élément DOM de type input
function creerElementInput(placeholder, taille) {
    var inputElt = document.createElement("input");
    inputElt.type = "text";
    inputElt.setAttribute("placeholder", placeholder);
    inputElt.setAttribute("size", taille);
    inputElt.setAttribute("required", "true");
    inputElt.setAttribute("type", "text");
    inputElt.setAttribute("class", "form-control");
    return inputElt;
}

var ajouterLienElt = document.getElementById("ajoutMsg");
// Gère l'ajout d'un nouveau lien
ajouterLienElt.addEventListener("click", function () {

    let formMessageElt = document.createElement('form');
    formMessageElt.setAttribute('name', 'ajaxForm');
    formMessageElt.setAttribute('id', 'ajaxForm');
    formMessageElt.setAttribute('action', '#');
    formMessageElt.setAttribute('method', 'POST');
    formMessageElt.setAttribute('enctype', 'multipart/form-datam');

    let auteurElt = creerElementInput("Entrez votre nom", 20);
    auteurElt.setAttribute('id', "author");
    auteurElt.setAttribute('name', "author");

    let messageElt = creerElementInput("Entrez votre message", 40);
    messageElt.setAttribute('id', "message");
    messageElt.setAttribute('name', "message");

    var ajoutElt = document.createElement("input");
    ajoutElt.type = "submit";
    ajoutElt.value = "Ajouter";

    formMessageElt.appendChild(auteurElt);
    formMessageElt.appendChild(messageElt);
    formMessageElt.appendChild(ajoutElt);

    var ajouterLienElt = document.getElementById("ajoutMsg");

    var p = document.querySelector("p");
    // Remplace le bouton d'ajout par le formulaire d'ajout
    p.replaceChild(formMessageElt, ajouterLienElt);

    // Ajoute le nouveau lien
    formMessageElt.addEventListener("submit", function () {


        // Création de l'objet contenant les données du nouveau lien
        var message = {
            titre: messageElt.value,
            auteur: auteurElt.value
        };

        // Envoi du nouveau lien au serveur
        ajaxPost(serveurUrl + "/commentary", lien,
            function (reponse) {
                var messageElt = creerElementMessage(message);
                // Ajoute le nouveau lien en haut de la liste
                contenuElt.insertBefore(messageElt, contenuElt.firstChild);

                // Création du message d'information
                var infoElt = document.createElement("div");
                infoElt.classList.add("info");
                infoElt.textContent = "Le lien \"" + lien.titre + "\" a bien été ajouté.";
                p.insertBefore(infoElt, ajouterLienElt);
                // Suppresion du message après 2 secondes
                setTimeout(function () {
                    p.removeChild(infoElt);
                }, 2000);
            },
            true
        );

        // Remplace le formulaire d'ajout par le bouton d'ajout
        p.replaceChild(ajouterLienElt, formAjoutElt);
    });
});