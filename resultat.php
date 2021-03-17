<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link href="style.css" rel="stylesheet">
  <script src="https://polyfill.io/v3/polyfill.min.js?features=default"></script>

  <title>SunnyPath</title>
  <script>
  window.onload = function load() {
    recupererInfoTrajets();
    meteo();
    trajet();

  }
  function $_GET(param) {
    var vars = {};
    window.location.href.replace( location.hash, '' ).replace(
      /[?&]+([^=&]+)=?([^&]*)?/gi, // regexp
      function( m, key, value ) { // callback
        vars[key] = value !== undefined ? value : '';
      }
    );

    if ( param ) {
      return vars[param] ? vars[param] : null;
    }
    return vars;
  }
  locomotion = $_GET("locomotion").toLowerCase();
  ville = $_GET("ville").split("%")[0].toLowerCase();
  horaire = $_GET("horaire").split("%")[0];

  function recupererInfoTrajets(){


    // ancien code de compatibilité, aujourd’hui inutile
    if (window.XMLHttpRequest) { // Mozilla, Safari, IE7+...
      httpRequest = new XMLHttpRequest();
    }
    else if (window.ActiveXObject) { // IE 6 et antérieurs
      httpRequest = new ActiveXObject("Microsoft.XMLHTTP");
    }

    fichier = "API/SET.php?locomotion="+locomotion+"&horaire="+horaire+"&ville="+ville;
    httpRequest.open("GET", fichier, false);
    httpRequest.send(null);
    if (httpRequest.readyState == 4) {
      set = httpRequest.responseText;
    }

    fichier = "API/GET.php?locomotion="+locomotion+"&horaire="+horaire+"&ville="+ville;
    httpRequest.open("GET", fichier, false);
    httpRequest.send(null);

    if (httpRequest.readyState == 4) {
      nbPersonnes = httpRequest.responseText;
    }
    var info = document.getElementById("infoPersonnes");
    if(nbPersonnes >1)
    info.innerHTML = "<center class=\"text-danger\"><H1>Attention</H1>,<H2>"+nbPersonnes+"  personnes prennent déjà le "+locomotion+" pour aller à "+ville+" à "+horaire+"h.</H2></center>";
    else if(nbPersonnes == 1)
    info.innerHTML = "<center class=\"text-warning\"><H1>Attention</H1>,<H2>"+nbPersonnes+"  personne prend déjà le "+locomotion+" pour aller à "+ville+" à "+horaire+"h.</H2></center>";
    else
    info.innerHTML = "<center class=\"text-success\"><H1>Attention</H1>,<H2>  personne ne prend le "+locomotion+" pour aller à "+ville+" à "+horaire+"h.</H2></center>";

  }
  function initMap() {
  const directionsService = new google.maps.DirectionsService();
  const directionsRenderer = new google.maps.DirectionsRenderer();
  const map = new google.maps.Map(document.getElementById("map"), {
    zoom: 12,
    center: { lat: 43.481402, lng: -1.514699 },
  });
  directionsRenderer.setMap(map);
  calculateAndDisplayRoute(directionsService, directionsRenderer);
 }

  function calculateAndDisplayRoute(directionsService, directionsRenderer) {
    if (locomotion == "bus") {
        directionsService.route(
          {
            origin: {
              query: "Anglet",
            },
            destination: {
              query: ville,
            },
            travelMode: google.maps.TravelMode.TRANSIT,
          },
          (response, status) => {
            if (status === "OK") {
              directionsRenderer.setDirections(response);
            } else {
              window.alert("Directions request failed due to " + status);
            }
          }
        );
      } else if (locomotion == "voiture") {
        directionsService.route(
          {
            origin: {
              query: "Anglet",
            },
            destination: {
              query: ville,
            },
            travelMode: google.maps.TravelMode.DRIVING,
          },
          (response, status) => {
            if (status === "OK") {
              directionsRenderer.setDirections(response);
            } else {
              window.alert("Directions request failed due to " + status);
            }
          }
        );
      } else if (locomotion == "velo") {
        directionsService.route(
          {
            origin: {
              query: "Anglet",
            },
            destination: {
              query: ville,
            },
            travelMode: google.maps.TravelMode.BICYCLING,
          },
          (response, status) => {
            if (status === "OK") {
              directionsRenderer.setDirections(response);
            } else {
              window.alert("Directions request failed due to " + status);
            }
          }
        );
      }}

  function meteo(){
    if (window.XMLHttpRequest) {
       request = new XMLHttpRequest();
    } else if (window.ActiveXObject) {
      request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    request.onreadystatechange = processRequest;
    request.open("GET","https://api.openweathermap.org/data/2.5/weather?q="+ville+"&appid=f046cd5c58a1628bc709bfbd7be520ba", true);
    request.send(null);
    function processRequest() {
      if (request.readyState == 4) {
        if (request.status == 200) {
          var reponse = request.responseText;
          reponseParse = JSON.parse(reponse);
          document.getElementById("meteo").innerHTML =

          "<div class=\"card\" style=\"width: 18rem;\">"+
          "<img src=\"http://openweathermap.org/img/w/"+reponseParse.weather[0].icon+".png\" class=\"card-img-top\">"+
          "<div class=\"card-body\">"+
          "<h5 class=\"card-title\">"+reponseParse.name+"</h5>"+
          "<p class=\"card-text\">"+reponseParse.weather[0].description+"</p>"+
          "</div>"+
          "<ul class=\"list-group list-group-flush\">"+
          "<li class=\"list-group-item\">Humidity - "+reponseParse.main.humidity+"%</li>"+
          "<li class=\"list-group-item\">Temperature - "+Math.round(eval(reponseParse.main.temp+"-273")) +"°C</li>"+
          "<li class=\"list-group-item\">Vent - "+ reponseParse.wind.speed+"km/h</li>"+
          "</ul>"+
           "</div>";


        }
      }
    }

  }

  </script>

  <body>
    <section class="bgpicture bg-dark " >
      <div class="container text-center">
        <br/><br/><br/>
        <div class="row">
          <br/>
          <center><h1 class="titre text-white" >Sunny Path</h1></center>
          <br/>
        </div>
      </div>
    </section>
    <span id="infoPersonnes" ></span>
    <br>
    <div class="container">
      <div class="row">
        <div class="col-sm">
          <hr>
          <p>Trajet pour aller à <?php echo($_GET['ville']);?> en <?php echo($_GET['locomotion']);?></p>
          <span id="resultats"></span><br>
          <div id="map"></div>
          <hr>
        </div>
        <div class="col-sm">
          <hr>
          <p>Météo à <?php echo($_GET['ville']);?></p>
          <span id="meteo"></span>
          <hr>
        </div>
      </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
    <script
      src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDzl_oUp19b_ro2ixp1t_5SMj6NNUppBoM&callback=initMap&libraries=&v=weekly"
      async
    ></script>
    <br/>
    <br/>
    <br/>
    <br/>
    <footer class="bg-light text-center text-lg-start">
      <!-- Copyright -->
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        <a class="text-dark" href="http://iparla.iutbayonne.univ-pau.fr/~rsalha/WebService/projet/API/">Documentation WebService SunnyPath</a>
      </div>
      <div class="text-center p-3" style="background-color: rgba(0, 0, 0, 0.2);">
        © 2021 (NO)Copyright:
        <a class="text-dark" href="https://sohny64.itch.io/">Miguel Viegas</a> et <a class="text-dark" href="https://romains.itch.io/">Romain Salha</a>
      </div>
  <!-- Copyright -->
</footer>
  </body>

  </html>

  <script>
