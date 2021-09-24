<?php
function arrondir_dollars($value){
	return floor($value*100)/100;
}
function nombre_en_couleur($nombre){
	$couleur_RGB["bleu"]=$nombre % 256;
	$couleur_RGB["vert"]= floor($nombre / 256) % 256;
	$couleur_RGB["rouge"]=((floor($nombre / 256) % 256) / 256) % 256;
	return $couleur_RGB;
}
function achat($nombre_magasins_tableau,$prix_tableau,$argent_restant){
	for($index=0;$index<count($nombre_magasins_tableau);$index++){
		$argent = $argent - $nombre_magasins_tableau[$index]*$prix_tableau[$index];
		$_SESSION["magasins_possedes"][$index]+=$nombre_magasins_tableau[$index];
		if($argent<=0){
			$argent=$argent_restant;	
		}
	}
	$argent=arrondir_dollars($argent);
	$_SESSION["argent"]=$argent;
}
function secondes_passes(){
	$temps_initial=$_SESSION["temps_actualisation"];
	$_SESSION["temps_actualisation"]=getdate()[0];		
	$temps_fin=getdate()[0];
	$valeur_retourne=$temps_fin - $temps_initial;
	return $valeur_retourne;
}
?>