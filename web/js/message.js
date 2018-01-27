let serveurUrl = "http://nico2p.com";

// Crée et renvoie un élément DOM affichant les données d'un message
// Le paramètre message est un objet JS représentant un message
function creerElementMessage(message) {

    // Contenu du message
    let msgElt = document.createElement("p");
    msgElt.style.color = "white";
    msgElt.style.marginRight = "5px";


    msgElt.appendChild(document.createTextNode(message.content));


    // Cette ligne contient le titre du message
    let ligneMessageElt = document.createElement("h4");
    ligneMessageElt.style.margin = "0px";
    ligneMessageElt.appendChild(msgElt);

    // Cette ligne contient l'auteur
    let ligneAuteurElt = document.createElement("span");
    ligneAuteurElt.appendChild(document.createTextNode("Ajouté par " + message.author));

    // Ajout des lignes dans le block
    let divMessageElt = document.createElement("div");
    divMessageElt.style.borderRadius = "10px";
    divMessageElt.style.backgroundColor = "#17a2b8";
    divMessageElt.classList.add("message", "text-center");
    divMessageElt.appendChild(ligneMessageElt);
    divMessageElt.appendChild(ligneAuteurElt);

    return divMessageElt;
}

// Crée et renvoie un élément DOM de type input
function creerElementInput(placeholder, taille) {
    let inputElt = document.createElement("input");
    inputElt.type = "text";
    inputElt.setAttribute("placeholder", placeholder);
    inputElt.setAttribute("size", taille);
    inputElt.setAttribute("required", "true");
    inputElt.setAttribute("type", "text");
    inputElt.setAttribute("class", "form-control input_message");
    inputElt.setAttribute("oninvalid", "this.setCustomValidity('Champ obligatoire')");
    inputElt.setAttribute("oninput", "this.setCustomValidity('')");
    return inputElt;
}



let contenuElt = document.getElementById("contenu");

// Récupération de la liste des messages auprès du serveur
ajaxGet(serveurUrl + "/commentary", function (reponse) {
    // Liste des messages à afficher. Un message est défini par :
    // - son titre
    // - son auteur (la personne qui l'a publié)
    let listeMessages = JSON.parse(reponse);
    // Parcours de la liste des messages et ajout d'un élément au DOM pour chaque message
    listeMessages.forEach(function (message) {
        let messageElt = creerElementMessage(message);
        contenuElt.appendChild(messageElt);
    });
});



let ajouterMessageElt = document.getElementById("ajoutMsg");
// Gère l'ajout d'un nouveau message
ajouterMessageElt.addEventListener("click", function () {

    let formMessageElt = document.createElement('form');
    formMessageElt.setAttribute('name', 'ajaxForm');
    formMessageElt.setAttribute('id', 'ajaxForm');
    formMessageElt.setAttribute('method', 'POST');
    formMessageElt.setAttribute('enctype', 'multipart/form-datam');
    //formMessageElt.setAttribute('onsubmit' ,'return submitForm();');

    let auteurElt = creerElementInput("Entrez votre nom", 20);
    auteurElt.setAttribute('id', "author");
    auteurElt.setAttribute('name', "author");

    let messageElt = creerElementInput("Entrez votre message", 40);
    messageElt.setAttribute('id', "message");
    messageElt.setAttribute('name', "message");

    let ajoutElt = document.createElement("input");
    ajoutElt.setAttribute('id', "add-message");
    ajoutElt.setAttribute("class", "btn btn-info");
    ajoutElt.type = "submit";
    ajoutElt.value = "Ajoutez votre message";

    formMessageElt.appendChild(auteurElt);
    formMessageElt.appendChild(messageElt);
    formMessageElt.appendChild(ajoutElt);

    let ajouterMessageElt = document.getElementById("ajoutMsg");

    let p = document.querySelector("p");
    // Remplace le bouton d'ajout par le formulaire d'ajout
    p.replaceChild(formMessageElt, ajouterMessageElt);


    //function submitForm() {
    formMessageElt.addEventListener("submit", function () {


        // Création de l'objet contenant les données du nouveau message
        let message = {
            author : auteurElt.value,
            content: messageElt.value
        };
        let messageEltNew = creerElementMessage(message);
        contenuElt.insertBefore(messageEltNew, contenuElt.firstChild);

        // Création du message d'information
        let ajouterMessageElt = document.getElementById("ajoutMsg");
        let infoElt = document.createElement("div");
        let p = document.querySelector("p");
        infoElt.classList.add("info");
        infoElt.textContent = "Le message \"" + message.content + "\" a bien été ajouté.";
        p.insertBefore(infoElt, ajouterMessageElt);
        // Suppresion du message après 2 secondes
        setTimeout(function () {
            p.removeChild(infoElt);
        }, 2000);


        let form_data = new FormData(document.getElementById('ajaxForm'));
        form_data.append("label", "WEBUPLOAD");
    });



});

