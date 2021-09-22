<!DOCTYPE html>
<html>
<head>
<title>Mon jeu IDLE.</title>
<meta charset="utf8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
<style>
	.etiquette{
		font-weight: bold;	
	}
	.en_tete{
		display:block;
		text-align:center;
	}
</style>
</head>
<body>
<?php
session_start();
function arrondir_dollars($value){
	return floor($value*100)/100;
}
function nombre_en_couleur($nombre){
	$couleur_RGB=array("red" => 0,"green" => 0,"blue" => 0);
	$couleur_RGB["bleu"]=$nombre % 256;
	$couleur_RGB["vert"]= floor($nombre / 256) % 256;
	$couleur_RGB["rouge"]=((floor($nombre / 256) % 256) / 256) % 256;
	return $couleur_RGB;
}
function achat($nombre_magasins_tableau,$prix_tableau,$argent_restant){
	$argent=$argent_restant;
	for($index=0;$index<count($nombre_magasins_tableau);$index++){
		$argent = $argent - $nombre_magasins_tableau[$index]*$prix_tableau[$index];
		$_SESSION["magasins_possedes"][$index]+=$nombre_magasins_tableau[$index];
		if($argent<0){
			$argent=$argent_restant;	
		}
	}
	$argent=arrondir_dollars($argent);
	$_SESSION["argent"]=$argent;
	return true;
}
function secondes_passes(){
	$temps_initial=$_SESSION["temps_actualisation"];
	$_SESSION["temps_actualisation"]=getdate()[0];		
	$temps_fin=getdate()[0];
	$valeur_retourne=$temps_fin - $temps_initial;
	return $valeur_retourne;
}
function actualiser_page($initialisation=false){
	if($initialisation==false){	
		$argent=$_SESSION["argent"];
		$magasins_possedes=$_SESSION["magasins_possedes"];
		$magasins=$_SESSION["magasins"];
		$prix_du_magasin=$_SESSION["prix_du_magasin"];
		$nombre_total_de_magasins=$_SESSION["nombre_total_de_magasins"];
		$gains_par_seconde=$_SESSION["gains_par_seconde"];
		$temps_actualisation=$_SESSION["temps_actualisation"];
		$gain_par_clic=$_SESSION["gain_par_clic"];
		$nombre_colonnes_formulaire_jeu=$_SESSION["nombre_colonnes_formulaire_jeu"];
	}
	else{
		$nombre_total_de_magasins=6;
		$magasins=array("Stand de limonade","Médias", "Nettoyage de voiture", "Pizza", "Magasin de donut", "Bateaux de pêche");	
		$gains_par_seconde=array();
		$argent=0.0;
		$temps_actualisation=getdate()[0];
		$magasins_possedes=array();
		$magasin_a_acheter=array();
		$prix_du_magasin=array();
		$gain_par_clic=1;
		$nombre_colonnes_formulaire_jeu=4;
		for($index=0;$index<$nombre_total_de_magasins;$index++){
			$magasins_possedes[$index]=0; //Initialisation de la valeur des magasins.
			$magasin_a_acheter[$index]=0;//Initialisation du nombre de magasin de ce type qu'on achète.
			$prix_du_magasin[$index]=pow(5,$index); // Initialisation des prix.
			$prix_du_magasin[$index]=arrondir_dollars($prix_du_magasin[$index]);
			$gains_par_seconde[$index]=$prix_du_magasin[$index]/2;
			$gains_par_seconde[$index]=arrondir_dollars($gains_par_seconde[$index]);
		}		
		$_SESSION["deja_initialise"]=true;
		$_SESSION["argent"]=$argent;
		$_SESSION["magasins_possedes"]=$magasins_possedes;
		$_SESSION["magasins"]=$magasins;
		$_SESSION["prix_du_magasin"]=$prix_du_magasin;
		$_SESSION["nombre_total_de_magasins"]=$nombre_total_de_magasins;
		$_SESSION["gains_par_seconde"]=$gains_par_seconde;
		$_SESSION["temps_actualisation"]=$temps_actualisation;
		$_SESSION["gain_par_clic"]=$gain_par_clic;
		$_SESSION["nombre_colonnes_formulaire_jeu"]=$nombre_colonnes_formulaire_jeu;
	}
	echo "<div class=\"en_tete\">";
	echo 	"<span class=\"etiquette\"> Argent : </span>" . $argent . " \$";
	echo 		"<br>";
	echo 	"<form action=\"index.php\" method=\"post\" >"; //On commence à mettre notre formulaire.
	echo		"<input type=\"submit\" style=\"font-size:x-large\" name=\"cliquer_pour_gain\"  value=\" Cliquer (+".$gain_par_clic.")";
	echo 			"/Mettre à jour\">";	
	echo 	"</form>";
	echo "<div class=\"container\">";//On met le formulaire dans un container grâce à Bootstrap.
	echo 		"<form action=\"index.php\" method=\"post\" >"; //On commence à mettre notre formulaire.
	echo "<br>";
	for($index=0;$index<$nombre_total_de_magasins;$index++){
		$nombre_correspondant_a_la_couleur=floor( ((256  * 256 * 256 - 1) / 1.2 / $nombre_total_de_magasins) * $index);
		$nombre_converti_en_couleur=nombre_en_couleur($nombre_correspondant_a_la_couleur);
		$transparence=0.4;
		$au_debut_de_la_ligne=( ($index % $nombre_colonnes_formulaire_jeu) == 0);
		if($au_debut_de_la_ligne){
			echo "<div class=\"row\">"; 
		}
		echo "<div class=\"col\"";
		echo " style=\"background-color: rgba(" . $nombre_converti_en_couleur["rouge"] . ", " . $nombre_converti_en_couleur["vert"] . ", " . $nombre_converti_en_couleur["bleu"] . ", " . $transparence . ");\" >";
		echo $magasins[$index]." : ". "<br>"; // On affiche le texte lié au magasin.			
		echo "<input type=\"number\" name="."\"magasin_a_acheter[$index]\" class= \"form-control"; //On nomme le formulaire pour acheter des magasins.
			
		echo "\" value=\"0\">"; //On assigne la valeur 0 à chacun des champs.
		echo "<br>";
		echo "<span class=\"etiquette\"> Prix : </span>".$prix_du_magasin[$index]; // On affiche les prix du magasin.
		echo "<br>";
		echo "<span class=\"etiquette\"> Nombre possédés : </span>" . $magasins_possedes[$index];
		echo "<br>";
		echo "<span class=\"etiquette\">Rendement par seconde : </span>" . $gains_par_seconde[$index];
		echo "<br>\n";
		$a_la_fin_de_la_ligne=( ($index % $nombre_colonnes_formulaire_jeu) == $nombre_total_de_magasins - 1);
		if($a_la_fin_de_la_ligne){
			echo "</div>";		
		}
		echo "</div>";
	}	
	echo "</div>";
	echo "<form action=\"index.php\" method=\"post\" >";
	echo "<input type=submit value=\"Acheter des magasins.\">"; //On affiche le bouton "Acheter des magasins".
	echo "<br><br>";
	echo "</form>";
	echo "</div>";
	echo "<form action=\"index.php\" method=\"post\" >";
	echo "<input type=\"submit\" name=\"restart\" value=\"Recommencer le jeu.\">";
	echo "</form>";
	echo "<p style=\"color:red\">Cette action est irréversible.</p>";
}
if(!isset($_POST["restart"]) && !isset($_POST["magasin_a_acheter"])){ // Si l'initialiser se fait la première fois..
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
}
$nombre_secondes_passes=secondes_passes();
for($index=0;$index<$_SESSION["nombre_total_de_magasins"];$index++){
	$_SESSION["argent"]+=$_SESSION["magasins_possedes"][$index]*$_SESSION["gains_par_seconde"][$index]*$nombre_secondes_passes;
	
}
?>
</body>
</html>