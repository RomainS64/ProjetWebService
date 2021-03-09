<html>
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-BmbxuPwQa2lc/FVzBcNJ7UAyJxM6wuqIj61tLrc4wSX0szH/Ev+nYRRuWlolflfl" crossorigin="anonymous">
  <link href="style.css" rel="stylesheet">
  
  <title>SunnyPath</title>

  <script>

  window.onload = function load() {
    recupererInfoTrajets();
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


  function recupererInfoTrajets(){


    locomotion = $_GET("locomotion").toLowerCase();
    ville = $_GET("ville").split("%")[0].toLowerCase();
    horaire = $_GET("horaire").split("%")[0];
	



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
  <div class="container">
  <div class="row">
    <div class="col-sm">
      <p>Trajet pour aller à <?php echo($_POST['ville']);?> en <?php echo($_POST['locomotion']);?></p>
    </div>
    <div class="col-sm">
      <p>Météo à <?php echo($_POST['ville']);?></p>
    </div>
  </div>
</div>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta2/dist/js/bootstrap.bundle.min.js" integrity="sha384-b5kHyXgcpbZJO/tY9Ul7kGkf1S0CWuKcCD38l8YkeH8z8QjE0GmW1gYU5S9FOnJ0" crossorigin="anonymous"></script>
</body>

</html>

<script>
