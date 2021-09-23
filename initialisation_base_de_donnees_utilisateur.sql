DROP TABLE IF EXISTS utilisateurs;
CREATE TABLE utilisateurs
(
	id SMALLINT UNSIGNED NOT NULL AUTO_INCREMENT,
    nom_utilisateur VARCHAR(100),
    mot_de_passe VARCHAR(100),
    sauvegarde TEXT,
    PRIMARY KEY (id),
    UNIQUE (nom_utilisateur)
)
ENGINE=INNODB CHARSET=utf8;
