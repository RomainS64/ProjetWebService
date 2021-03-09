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

  $requeteSQL = "SELECT count(*) FROM Webservice_api";
  $resultat = $connexion->query($requeteSQL);
  foreach ($resultat as $returnCount ) {$id = "$returnCount[0]";}
  $id = $id+1;
  $ins = "INSERT INTO Webservice_api(id,locomotion,ville,horaire) VALUES (?,?,?,?)";

  $connexion->prepare($ins)->execute([$id,$locomotion,$ville,$horaire]);
  echo "ok";
  ?>
