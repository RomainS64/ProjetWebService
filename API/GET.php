<?php
  // Paramètres de connexion à la Base de donnée
  $PARAM_hote = "lakartxela.iutbayonne.univ-pau.fr";		// url du serveur
  $PARAM_bdd = "rsalha_bd";									// nom de la bdd
  $PARAM_user = "rsalha_bd";									// nom d'utilisateur
  $PARAM_pw = "rsalha_bd";

  // Connexion à la base de données
  try {$connexion = new PDO ('mysql:host='.$PARAM_hote.';dbname='.$PARAM_bdd, $PARAM_user, $PARAM_pw);}
  // Si la connexion a échoué, on affiche un message d'erreur
  catch (Exception $e) {echo 'Erreur : '.$e->getMessage().'<br />';}



  if(isset($_GET["ville"]))$ville = $_GET["ville"];
  if(isset($_GET["locomotion"]))$locomotion = $_GET["locomotion"];
  if(isset($_GET["horaire"]))$horaire = $_GET["horaire"];

    if(isset($_GET["ville"]) && isset($_GET["horaire"]) && isset($_GET["locomotion"])){
      // les 3
        $requeteSQL = "SELECT count(*)
  					FROM Webservice_api
  					WHERE ville = \"$ville\"
  					AND locomotion = \"$locomotion\"
  					AND horaire = \"$horaire\" ";
    }
    else if(isset($_GET["ville"]) && !isset($_GET["horaire"]) && isset($_GET["locomotion"])){
      // ville et locomotion
      $requeteSQL = "SELECT count(*)
          FROM Webservice_api
          WHERE ville = \"$ville\"
          AND locomotion = \"$locomotion\"" ;
    }
    else if(isset($_GET["ville"] )&& isset($_GET["horaire"]) && !isset($_GET["locomotion"])){
      // ville et horaire
      $requeteSQL = "SELECT count(*)
          FROM Webservice_api
          WHERE ville = \"$ville\"
          AND horaire = \"$horaire\" ";
    }
    else if(!isset($_GET["ville"]) && isset($_GET["horaire"]) && isset($_GET["locomotion"])){
      // horaire et locomotion
      $requeteSQL = "SELECT count(*)
          FROM Webservice_api
          WHERE locomotion = \"$locomotion\"
          AND horaire = \"$horaire\" ";
    }
    else if(!isset($_GET["ville"]) && isset($_GET["horaire"]) && !isset($_GET["locomotion"])){
      //horaire
      $requeteSQL = "SELECT count(*)
          FROM Webservice_api
          WHERE horaire = \"$horaire\" ";
    }
    else if(isset($_GET["ville"]) && !isset($_GET["horaire"]) && !isset($_GET["locomotion"])){
      //ville
      $requeteSQL = "SELECT count(*)
          FROM Webservice_api
          WHERE ville = \"$ville\" ";
    }
    else if(!isset($_GET["ville"]) && !isset($_GET["horaire"]) && isset($_GET["locomotion"])){
      //locomotion
      $requeteSQL = "SELECT count(*)
          FROM Webservice_api
          WHERE  locomotion = \"$locomotion\"  ";
    }
    else{
      $requeteSQL = "SELECT count(*) FROM Webservice_api";
    }

    $resultat = $connexion->query($requeteSQL);

    foreach ($resultat as $returnCount ) {
    $arr = array();
    $arr["result"]=$returnCount[0];
    echo json_encode($arr);
    }

  ?>
