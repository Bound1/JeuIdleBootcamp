<!DOCTYPE html>
<html>
<head>
<meta charset="utf8" http-equiv='refresh' content='1'>
<title>Mon jeu IDLE.</title>
<style type="text/css">
.formulaire{
}
</style>
</head>
<body>
<?php
if(!isset($_POST["magasin_a_acheter"])){ // Si le paramètre magasin_a_acheter n'existe pas.
	$nombre_total_de_magasins=5;
	$magasins=array("Stand de limonade","Médias", "Nettoyage de voiture", "Pizza", "Magasin de donut");	
	$argent_de_depart=5;
	$argent=$argent_de_depart;
	echo "<strong> Argent :  </strong>";
	echo($argent. " \$");
	echo "<div class=\"formulaire\" >";//On met en forme le formulaire.
	echo "<form action=\"index.php\" method=\"post\""; //On commence à mettre notre formulaire.
	echo "<br>";
	for($index=0;$index<$nombre_total_de_magasins;$index++){
		$magasins_possedes[$index]=0; //Initialisation de la valeur des magasins.
		$magasin_a_acheter[$index]=0;//Initialisation du nombre de magasin de ce type qu'on achète.
		$prix_du_magasin[$index]=pow(10,$index); // Initialisation des prix.
		echo $magasins[$index]." : ". "<br>"; // On affiche le texte lié au magasin.			
		echo "<input type=\"text\" name=\"["."\$magasin_a_acheter[$index]"."]"; //On nomme le formulaire pour acheter des magasins.
		echo " \" value=\"0\"/>"; //On assigne la valeur 0 à chacun des champs.
		echo "<br>";
		echo "Prix : ".$prix_du_magasin[$index]; // On affiche les prix du magasin.
		echo "<br>";
	}
	echo "<input type=submit value=\"Acheter des magasins.\">";
	echo "</div>";
}
?>

</body>
</html>