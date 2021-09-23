<!DOCTYPE html>
<html>
<head>
<title>Mon jeu IDLE</title>
<meta charset="utf8">
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/css/bootstrap.min.css">
<link rel="stylesheet" href="feuille_de_style.css">
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.1/dist/js/bootstrap.min.js"></script>
</head>
<body>
<?php include "connexion.php" ?>
<?php
debut:
if(!isset($_POST["nom_utilisateur"]) && !isset($_POST["mot_de_passe"])){
?>
<div class="centrage_affichage_compte">
    <form action="<?php echo $_SERVER["REQUEST_URI"];?>" method="post">
        <span class="centrage_mot_connexion_affichage_compte etiquette" >Connexion : </span> <br>
        Nom d'utilisateur : <br>
        <input type="text" size="10" name="nom_utilisateur" maxlength="99" required> <br>
        Mot de passe : <br>
        <input type="password" name="mot_de_passe" size="10" maxlength="99" required> <br>
        <input type="submit" value="Se connecter">
    </form>
</div>
<?php
}
else{
    $_POST["nom_utilisateur"]=htmlspecialchars($_POST["nom_utilisateur"]);
    $_POST["mot_de_passe"]=htmlspecialchars($_POST["mot_de_passe"]);
    $connexion=connexion_base_de_donnees($_POST["nom_utilisateur"],$_POST["mot_de_passe"],"sauvegarde");
    if($connexion!=NULL){
        $_SESSION=$connexion;
        header("Location: jeu_idle_lance.php");
        die();
    }
    else{        
        unset($_POST["nom_utilisateur"]);
        unset($_POST["mot_de_passe"]);
?>
<p style="color:red">Connexion échoué.</p>
<?php        
        goto debut;
    }
}
?>

</body>
</html>