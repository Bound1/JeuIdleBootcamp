<!DOCTYPE html>
<html>
<head>
<title>Mon jeu IDLE.</title>
<meta charset="utf8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille_de_style.css">

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
<style>
</style>
</head>
<body>
<?php include_once "actualiser_page.php";?>
<?php include_once "fonctions_diverses.php";?>
<?php
session_start();
if(!isset($_POST["restart"]) && !isset($_POST["magasin_a_acheter"]) && !isset($_POST["cliquer_pour_gain"])){
	if(!isset($_SESSION["deja_initialise"])){	
		actualiser_page($initialisation=true);
	}	
	else{
		actualiser_page();
	}
}
if(isset($_POST["restart"])){
	session_unset();
	session_destroy();
	session_start();
	actualiser_page($initialisation=true);
}
if(isset($_POST["magasin_a_acheter"])){
	$argent=$_SESSION["argent"];
	$magasins_possedes=$_SESSION["magasins_possedes"];
	$magasins=$_SESSION["magasins"];
	$prix_du_magasin=$_SESSION["prix_du_magasin"];
	$nombre_total_de_magasins=$_SESSION["nombre_total_de_magasins"];
	achat($_POST["magasin_a_acheter"],$prix_du_magasin,$argent);
    actualiser_page();
}
if(isset($_POST["cliquer_pour_gain"])){
	$_SESSION["argent"]+=$_SESSION["gain_par_clic"];
    actualiser_page();
}
$nombre_secondes_passes=secondes_passes();
for($index=0;$index<$_SESSION["nombre_total_de_magasins"];$index++){
	$_SESSION["argent"]+=$_SESSION["magasins_possedes"][$index]*$_SESSION["gains_par_seconde"][$index]*$nombre_secondes_passes;
}
?>
</body>
</html>