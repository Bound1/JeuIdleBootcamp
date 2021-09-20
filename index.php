<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8" />
<title>Mon jeu IDLE.</title>
</head>
<body>
<?php
if(!isset($_POST["magasin_a_acheter"])){
	$nombre_total_de_magasins=5;
	$magasins=array("Stand de limonade","Médias", "Nettoyage de voiture", "Pizza", "Magasin de donut");	
	echo "<form action=\"index.php\" method=\"post\"> "; //On commence à mettre notre formulaire.
	echo "<br>";
	for($index=0;$index<$nombre_total_de_magasins;$index++){
		$magasins_possedes[$index]=0; //Initialisation de la valeur des magasins.
		$magasin_a_acheter[$index]=0;//Initialisation du nombre de magasin de ce type qu'on achète.
		$prix_du_magasin[$index]=pow(10,$index); // Initialisation des prix.
		echo $magasins[$index]." : "; // On affiche le texte lié au magasin.			
		echo "<input type=\"text\" name=\"["."\$magasin_a_acheter[\$index]"."]" . " \" />";
		echo "<br>";
	}
	echo "<input type=submit value=\"Acheter des magasins.\">";
}
?>
</body>
</html>