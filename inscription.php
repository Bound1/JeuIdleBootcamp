<?php
function inscription_base_de_donnees($nom_utilisateur,$mot_de_passe){
    $nom_de_serveur_mysql="localhost";
    $base_de_donnees="base_de_donnees_jeu_idle";
    $utilisateur_base_de_donnees="root";
    $mot_de_passe_base_de_donnees="";
    session_start();
    $_SESSION["nom_utilisateur"]=$nom_utilisateur;
    $_SESSION["mot_de_passe"]=$mot_de_passe;
    $connexion_au_serveur_mysql=new mysqli($nom_de_serveur_mysql,$utilisateur_base_de_donnees,$mot_de_passe_base_de_donnees,$base_de_donnees);
    if($connexion_au_serveur_mysql->connect_error){
        return NULL;
    } 
    $requete_sql_a_executer =$connexion_au_serveur_mysql->prepare("INSERT INTO utilisateurs (nom_utilisateur,mot_de_passe) VALUES (?,?)");
    if($requete_sql_a_executer->connect_error){
        return NULL;
    }
    $_preparation_de_la_requete=$requete_sql_a_executer->bind_param("ss",$nom_utilisateur,$mot_de_passe);
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