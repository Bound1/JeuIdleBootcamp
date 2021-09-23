<?php 
function connexion_base_de_donnees($nom_utilisateur,$mot_de_passe,$option){
    $nom_de_serveur_mysql="localhost";
    $base_de_donnees="base_de_donnees_jeu_idle";
    $utilisateur_base_de_donnees="root";
    $mot_de_passe_base_de_donnees="";
    $connexion_au_serveur_mysql=new mysqli($nom_de_serveur_mysql,$utilisateur_base_de_donnees,$mot_de_passe_base_de_donnees,$base_de_donnees);
    if($connexion_au_serveur_mysql->connect_error){
        return NULL;
    }
    $requete_sql_a_executer =$connexion_au_serveur_mysql->prepare("SELECT * FROM utilisateurs WHERE nom_utilisateur=? AND mot_de_passe=?");
    if($requete_sql_a_executer->connect_error){
        return NULL;
    }
    $requete_sql_a_executer->bind_param("ss",$nom_utilisateur,$mot_de_passe);
    $requete_sql_a_executer->execute();
    $resultat_de_la_requete=$requete_sql_a_executer->get_result();
    if($resultat_de_la_requete->num_rows==0){
        return NULL;
    }
    if($option=="sauvegarde"){
        session_start();
        $ligne_de_la_requete = mysqli_fetch_assoc($resultat_de_la_requete);
        $session_a_enregistrer=$ligne_de_la_requete["sauvegarde"];
        if($session_a_enregistrer!=NULL){
            $_SESSION=$session_a_enregistrer;            
        }
        return "session validé";
    }
    $requete_sql_a_executer->close();
    $connexion_au_serveur_mysql->close();
}
?>