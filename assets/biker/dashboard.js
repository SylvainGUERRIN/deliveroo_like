//no css import

//do with this or get biker city to display weather ?
function geoLocalization(){
    var geoSuccess = function(position) {
        // on acceptation
        startPos = position;
        userLat = startPos.coords.latitude;
        userLon = startPos.coords.longitude;
        console.log("lat: "+ userLat +" - lon: "+ userLon );
    };
    var geoFail = function(){
        //on reject
        console.log("reject");
    };
    // search position if acceptation
    navigator.geolocation.getCurrentPosition(geoSuccess,geoFail);
}

geoLocalization()

function search(){
    var city = $("#city").val();
    if(city !== ""){
        $.ajax({
            url: "https://nominatim.openstreetmap.org/search", // Nominatim url to search with Open Street Map data
            type: 'get',
            data: "q="+ city +"&format=json&addressdetails=1&limit=1&polygon_svg=1" // Données envoyées (q -> adresse complète, format -> format attendu pour la réponse, limit -> nombre de réponses attendu, polygon_svg -> fournit les données de polygone de la réponse en svg)
        }).done(function (response) {
            if (response !== "") {
                userLat = response[0]['lat'];
                userLon = response[0]['lon'];
            }
        }).fail(function (error) {
            alert(error);
        });
    }
}

function around(){
    var distance = $("#distance").val();
    $.ajax({
        url:'http://localhost/search-city', //change road
        type: 'POST',
        data: 'lat='+ userLat + '&lon=' + userLon + '&distance='+distance
    }).done(function(response){
        var points = JSON.parse(response);
    }).fail (function(error){
        console.log(error);
    });
}
