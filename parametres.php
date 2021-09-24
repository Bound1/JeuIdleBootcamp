<?php
function sauvegarder(){
    $nom_de_serveur_mysql="localhost";
    $base_de_donnees="base_de_donnees_jeu_idle";
    $utilisateur_base_de_donnees="root";
    $mot_de_passe_base_de_donnees="";
    $nom_utilisateur=$_SESSION["nom_utilisateur"];
    $mot_de_passe=$_SESSION["mot_de_passe"];
    $connexion_au_serveur_mysql=new mysqli($nom_de_serveur_mysql,$utilisateur_base_de_donnees,$mot_de_passe_base_de_donnees,$base_de_donnees);
    if($connexion_au_serveur_mysql->connect_error){
        return NULL;
    }
    $requete_sql_a_executer =$connexion_au_serveur_mysql->prepare("UPDATE utilisateurs SET sauvegarde=? WHERE nom_utilisateur=? AND mot_de_passe=?");
    if($requete_sql_a_executer->connect_error){
        return NULL;
    }
    $preparation_de_la_requete=$requete_sql_a_executer->bind_param("sss",serialize($_SESSION),$nom_utilisateur,$mot_de_passe);
    if(!$preparation_de_la_requete){
        return NULL;
    }
    $execution_de_la_requete=$requete_sql_a_executer->execute();
    if(!$preparation_de_la_requete){
        return NULL;
    }
    return true;
}
function supprimer_le_compte(){
    $nom_de_serveur_mysql="localhost";
    $base_de_donnees="base_de_donnees_jeu_idle";
    $utilisateur_base_de_donnees="root";
    $mot_de_passe_base_de_donnees="";    
    $nom_utilisateur=$_SESSION["nom_utilisateur"];
    $mot_de_passe=$_SESSION["mot_de_passe"];
    $connexion_au_serveur_mysql=new mysqli($nom_de_serveur_mysql,$utilisateur_base_de_donnees,$mot_de_passe_base_de_donnees,$base_de_donnees);
    if($connexion_au_serveur_mysql->connect_error){
        return NULL;
    }
    $requete_sql_a_executer =$connexion_au_serveur_mysql->prepare("DELETE FROM utilisateurs WHERE nom_utilisateur=? AND mot_de_passe=?");
    if($requete_sql_a_executer->connect_error){
        return NULL;
    }
    $preparation_de_la_requete=$requete_sql_a_executer->bind_param("ss",$nom_utilisateur,$mot_de_passe);
    if(!$preparation_de_la_requete){
        return NULL;
    }
    $execution_de_la_requete=$requete_sql_a_executer->execute();
    if(!$execution_de_la_requete){
        return NULL;
    }
    return true;
}
?>