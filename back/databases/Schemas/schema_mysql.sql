-- MySQL Schema for Solar Panel Installation System

BEGIN;

DROP TABLE IF EXISTS doc;
DROP TABLE IF EXISTS installateur;
DROP TABLE IF EXISTS localisation;
DROP TABLE IF EXISTS region;
DROP TABLE IF EXISTS onduleur;
DROP TABLE IF EXISTS panneau;
DROP TABLE IF EXISTS modele_onduleur;
DROP TABLE IF EXISTS modele_panneau;
DROP TABLE IF EXISTS marque_onduleur;
DROP TABLE IF EXISTS marque_panneau;

CREATE TABLE marque_panneau (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE marque_onduleur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE modele_panneau (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE modele_onduleur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL
);

CREATE TABLE panneau (
    id INT AUTO_INCREMENT PRIMARY KEY,
    marque_panneau INT,
    modele_panneau INT,
    FOREIGN KEY (marque_panneau) REFERENCES marque_panneau(id),
    FOREIGN KEY (modele_panneau) REFERENCES modele_panneau(id)
);

CREATE TABLE onduleur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele_onduleur INT,
    marque_onduleur INT,
    FOREIGN KEY (modele_onduleur) REFERENCES modele_onduleur(id),
    FOREIGN KEY (marque_onduleur) REFERENCES marque_onduleur(id)
);

CREATE TABLE region (
    id VARCHAR(255) PRIMARY KEY,
    ville VARCHAR(255),
    admin1 VARCHAR(255),
    admin2 VARCHAR(255),
    pays VARCHAR(255)

);

CREATE TABLE localisation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lat FLOAT,
    `long` FLOAT, -- mot-clé réservé, on l'entoure avec des backticks
    postcode VARCHAR(10),
    postcode_suff VARCHAR(10),
    code_insee VARCHAR(255),
    FOREIGN KEY (code_insee) REFERENCES region(id)
);

CREATE TABLE installateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);

CREATE TABLE doc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mois INT,
    an INT,
    nb_panneaux INT,
    nb_onduleur INT,
    puissance_crete FLOAT,
    surface FLOAT,
    pente FLOAT,
    pente_opti FLOAT,
    orientation VARCHAR(50),
    orientation_opti VARCHAR(50),
    pvgis FLOAT,
    panneau_id INT,
    onduleur_id INT,
    localisation_id INT,
    installateur_id INT,
    FOREIGN KEY (panneau_id) REFERENCES panneau(id),
    FOREIGN KEY (onduleur_id) REFERENCES onduleur(id),
    FOREIGN KEY (localisation_id) REFERENCES localisation(id),
    FOREIGN KEY (installateur_id) REFERENCES installateur(id)
);


COMMIT;