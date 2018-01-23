//var serveurUrl = "http://localhost/javascript-web-srv/web";
var serveurUrl = "http://localhost:8001";

// Crée et renvoie un élément DOM affichant les données d'un message
// Le paramètre message est un objet JS représentant un message
function creerElementMessage(message) {
    var titreElt = document.createElement("p");
    titreElt.style.color = "#428bca";
    titreElt.style.textDecoration = "none";
    titreElt.style.marginRight = "5px";
    titreElt.appendChild(document.createTextNode(message.content));


    // Cette ligne contient le titre du message
    var ligneMessageElt = document.createElement("h4");
    ligneMessageElt.style.margin = "0px";
    ligneMessageElt.appendChild(titreElt);

    // Cette ligne contient l'auteur
    var ligneAuteurElt = document.createElement("span");
    ligneAuteurElt.appendChild(document.createTextNode("Ajouté par " + message.author));

    var divMessageElt = document.createElement("div");
    divMessageElt.classList.add("message");
    divMessageElt.appendChild(ligneMessageElt);
    divMessageElt.appendChild(ligneAuteurElt);

    return divMessageElt;
}



var contenuElt = document.getElementById("contenu");
// Récupération de la liste des messages auprès du serveur
ajaxGet(serveurUrl + "/commentary", function (reponse) {
    // Liste des messages à afficher. Un message est défini par :
    // - son titre
    // - son auteur (la personne qui l'a publié)
    var listeMessages = JSON.parse(reponse);
    // Parcours de la liste des messages et ajout d'un élément au DOM pour chaque message
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

var ajouterMessageElt = document.getElementById("ajoutMsg");
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

    var ajoutElt = document.createElement("input");
    ajoutElt.type = "submit";
    ajoutElt.value = "Ajouter";

    formMessageElt.appendChild(auteurElt);
    formMessageElt.appendChild(messageElt);
    formMessageElt.appendChild(ajoutElt);

    var ajouterMessageElt = document.getElementById("ajoutMsg");

    var p = document.querySelector("p");
    // Remplace le bouton d'ajout par le formulaire d'ajout
    p.replaceChild(formMessageElt, ajouterMessageElt);

    var message = {
        author : auteurElt.value,
        content: messageElt.value
    }

    //function submitForm() {
    formMessageElt.addEventListener("submit", function () {


        // Création de l'objet contenant les données du nouveau message
        var message = {
            author : auteurElt.value,
            content: messageElt.value
        }
        var messageEltNew = creerElementMessage(message);
        contenuElt.insertBefore(messageEltNew, contenuElt.firstChild);

        // Création du message d'information
        var ajouterMessageElt = document.getElementById("ajoutMsg");
        var infoElt = document.createElement("div");
        var p = document.querySelector("p");
        infoElt.classList.add("info");
        infoElt.textContent = "Le message \"" + message.content + "\" a bien été ajouté.";
        p.insertBefore(infoElt, ajouterMessageElt);
        // Suppresion du message après 2 secondes
        setTimeout(function () {
            p.removeChild(infoElt);
        }, 5000);
        alert("Votre magnifique message va etre enregistré et vous allez être rediriger sur la page d'accueil !");


        // Remplace le formulaire d'ajout par le bouton d'ajout
        p.replaceChild(ajouterMessageElt, formMessageElt );



        var form_data = new FormData(document.getElementById('ajaxForm'));

        console.log(form_data + "formdata");


        form_data.append("label", "WEBUPLOAD");
        $.ajax({
            url: "localhost:8001/message",
            type: "POST",
            data: form_data,
            processData: false,
            contentType: false
        }).done(function (data) {
            console.log(data);

        });




        return false;
    });



});

