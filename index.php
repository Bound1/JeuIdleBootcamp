<!DOCTYPE html>
<html>
<head>
<title>Mon jeu IDLE.</title>
<style type="text/css">
.formulaire{
}
</style>
</head>
<body>
<?php
session_start();
function achat($nombre_magasins_tableau,$prix_tableau,$argent_restant){
	$argent=$argent_restant;
	for($index=0;$index<count($nombre_magasins_tableau);$index++){
		$argent = $argent-$nombre_magasins_tableau[$index]*$prix_tableau[$index];
		if($argent<0){
			$argent=$argent_restant;
			return false;		
		}
	}
	$_SESSION["argent"]=$argent;
	return true;
}
function actualiser_page($initialisation=false){
	if($initialisation==false){
		$argent=$_SESSION["argent"];
		$magasins_possedes=$_SESSION["magasins_possedes"];
		$magasins=$_SESSION["magasins"];
		$prix_du_magasin=$_SESSION["prix_du_magasin"];
		$nombre_total_de_magasins=$_SESSION["nombre_total_de_magasins"];	
	}
	else{
		$nombre_total_de_magasins=5;
		$magasins=array("Stand de limonade","Médias", "Nettoyage de voiture", "Pizza", "Magasin de donut");	
		$argent=100;
		$magasins_possedes=array();
		$magasin_a_acheter=array();
		$prix_du_magasin=array();
		for($index=0;$index<$nombre_total_de_magasins;$index++){
			$magasins_possedes[$index]=0; //Initialisation de la valeur des magasins.
			$magasin_a_acheter[$index]=0;//Initialisation du nombre de magasin de ce type qu'on achète.
			$prix_du_magasin[$index]=pow(10,$index); // Initialisation des prix.
		}
	}
	echo "<strong> Argent :  </strong>";
	echo $argent. " \$";
	echo "<div class=\"formulaire\" >";//On met en forme le formulaire.
	echo "<form action=\"index.php\" method=\"post\" >"; //On commence à mettre notre formulaire.
	echo "<br>";
	for($index=0;$index<$nombre_total_de_magasins;$index++){
		echo $magasins[$index]." : ". "<br>"; // On affiche le texte lié au magasin.			
		echo "<input type=\"number\" name=\""."magasin_a_acheter[$index]"; //On nomme le formulaire pour acheter des magasins.
		echo "\" value=\"0\"/>"; //On assigne la valeur 0 à chacun des champs.
		echo "<br>";
		echo "Prix : ".$prix_du_magasin[$index]; // On affiche les prix du magasin.
		echo "<br>";
		echo "Nombre possédés : " . $magasins_possedes[$index];
		echo "<br>\n";
	}	
	echo "<input type=submit value=\"Acheter des magasins.\">"; //On affiche le bouton "Acheter des magasins".
	echo "</form>";
	echo "</div>";
	echo "<form action=\"index.php\" method=\"post\" >";
	echo "<input type=\"submit\" name=\"restart\" value=\"Recommencer le jeu.\">";
	echo "</form>";
	$_SESSION["deja_initialise"]=true;
	$_SESSION["argent"]=$argent;
	$_SESSION["magasins_possedes"]=$magasins_possedes;
	$_SESSION["magasins"]=$magasins;
	$_SESSION["prix_du_magasin"]=$prix_du_magasin;
	$_SESSION["nombre_total_de_magasins"]=$nombre_total_de_magasins;
}
if(!isset($_POST["restart"]) && !isset($_POST["magasin_a_acheter"])){ // Si l'initialiser se fait la première fois..
	actualiser_page($initialisation=true);	
}
if(isset($_POST["restart"])){
	actualiser_page($initialisation=true);
}
if(isset($_POST["magasin_a_acheter"])){
	var_dump($_SESSION);
	$argent=$_SESSION["argent"];
	$magasins_possedes=$_SESSION["magasins_possedes"];
	$magasins=$_SESSION["magasins"];
	$prix_du_magasin=$_SESSION["prix_du_magasin"];
	$nombre_total_de_magasins=$_SESSION["nombre_total_de_magasins"];
	if(achat($_POST["magasin_a_acheter"],$prix_du_magasin,$argent)){
		actualiser_page();
	}
}
?>
</body>
</html>