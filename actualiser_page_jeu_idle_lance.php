<?php
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
			$magasins_possedes[$index]=0;
			$magasin_a_acheter[$index]=0;
			$prix_du_magasin[$index]=pow(5,$index); 
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
?>
<div class="en_tete">
	<span class="etiquette"> Argent : </span><?php echo $argent ?> $ <br>
	<form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" >
		<input type="submit" style="font-size:x-large" name="cliquer_pour_gain"  value=" Cliquer (+ <?php echo $gain_par_clic;?>)/Mettre à jour" >	
	</form>
</div>
<div class="container">
	<form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" > <br>
<?php
	for($index=0;$index<$nombre_total_de_magasins;$index++){
		$magasin_a_acheter[$index]=0;
		$prix_du_magasin[$index]=pow(5,$index);
		$prix_du_magasin[$index]=arrondir_dollars($prix_du_magasin[$index]);
		$gains_par_seconde[$index]=$prix_du_magasin[$index]/2;
		$gains_par_seconde[$index]=arrondir_dollars($gains_par_seconde[$index]); 
		$nombre_correspondant_a_la_couleur=floor( ((256  * 256 * 256 - 1) / 1.2 / $nombre_total_de_magasins) * $index);
		$nombre_converti_en_couleur=nombre_en_couleur($nombre_correspondant_a_la_couleur);
		$transparence=0.4;
		$au_debut_de_la_ligne=( ($index % $nombre_colonnes_formulaire_jeu) == 0);
		if($au_debut_de_la_ligne){
?>
	<div class="row">
<?php
		}
?>
		<div class="col" style="background-color:rgba(<?php echo $nombre_converti_en_couleur["rouge"]; ?>,<?php echo $nombre_converti_en_couleur["vert"]; ?>,<?php echo $nombre_converti_en_couleur["bleu"]?>,<?php echo $transparence;?>);">
			<label for="champ_nombre"><?php echo $magasins[$index];?> : </label>		
		<input type="number" name="magasin_a_acheter[<?php echo $index?>]" class= "form-control" value="0" min="0" id="champ_nombre"> <br>
		<span class="etiquette"> Prix : </span> <?php echo $prix_du_magasin[$index]; ?> <br>
		<span class="etiquette"> Nombre possédés : </span> <?php echo $magasins_possedes[$index]; ?> <br>
		<span class="etiquette">Rendement par seconde : </span> <?php echo $gains_par_seconde[$index];?> <br>
		<span class="etiquette">Gain total par seconde : </span> <?php echo $gains_par_seconde[$index]*$magasins_possedes[$index];?> <br>
<?php
		$a_la_fin_de_la_ligne=( ($index % $nombre_colonnes_formulaire_jeu) == $nombre_total_de_magasins - 1);
		if($a_la_fin_de_la_ligne){
?>
	</div>
<?php
		}
?>
</div>
<?php
}
?>
</div>
<form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
	<input type=submit value="Acheter des magasins."><br>
</form>
<br>
<br>
<form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post" >
	<input type="submit" name="restart" value="Recommencer le jeu.">
</form>
<p style="color:red">Cette action est irréversible.</p>
<?php
}
?>