
//do with this or get biker city to display weather ?
function geoloc(){ // ou tout autre nom de fonction
    var geoSuccess = function(position) { // Ceci s'exécutera si l'utilisateur accepte la géolocalisation
        startPos = position;
        userlat = startPos.coords.latitude;
        userlon = startPos.coords.longitude;
        console.log("lat: "+userlat+" - lon: "+userlon);
    };
    var geoFail = function(){ // Ceci s'exécutera si l'utilisateur refuse la géolocalisation
        console.log("refus");
    };
    // La ligne ci-dessous cherche la position de l'utilisateur et déclenchera la demande d'accord
    navigator.geolocation.getCurrentPosition(geoSuccess,geoFail);
}

geoloc()

function chercher(){
    var ville = $("#ville").val();
    if(ville != ""){
        $.ajax({
            url: "https://nominatim.openstreetmap.org/search", // URL de Nominatim
            type: 'get', // Requête de type GET
            data: "q="+ville+"&format=json&addressdetails=1&limit=1&polygon_svg=1" // Données envoyées (q -> adresse complète, format -> format attendu pour la réponse, limit -> nombre de réponses attendu, polygon_svg -> fournit les données de polygone de la réponse en svg)
        }).done(function (response) {
            if(response !== ""){
                userlat = response[0]['lat'];
                userlon = response[0]['lon'];
            }
        }).fail(function (error) {
            alert(error);
        });
    }
}

function cercle(){ // Ou tout autre nom de fonction
    var distance = $("#distance").val(); // Nous récupérons la distance
    $.ajax({
        url:'http://localhost/carte/cherchevilles.php',
        type: 'POST',
        data: 'lat='+userlat+'&lon='+userlon+'&distance='+distance
    }).done(function(reponse){
        var points = JSON.parse(reponse);
        // Ici nous traitons les différents points
    }).fail (function(error){
        console.log(error);
    });
}
