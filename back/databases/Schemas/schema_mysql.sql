
-- MySQL Schema for Solar Panel Installation System (Final Cleaned Version)

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
    nom VARCHAR(255) NOT NULL,
    marque_panneau_id INT,
    FOREIGN KEY (marque_panneau_id) REFERENCES marque_panneau(id)
);

CREATE TABLE modele_onduleur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    marque_onduleur_id INT,
    FOREIGN KEY (marque_onduleur_id) REFERENCES marque_onduleur(id)
);

CREATE TABLE panneau (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele_id INT,
    FOREIGN KEY (modele_id) REFERENCES modele_panneau(id)
);

CREATE TABLE onduleur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele_id INT,
    FOREIGN KEY (modele_id) REFERENCES modele_onduleur(id)
);

CREATE TABLE region (
    code_insee VARCHAR(255) PRIMARY KEY,
    ville VARCHAR(255),
    admin1 VARCHAR(255),
    admin2 VARCHAR(255),
    political VARCHAR(255)
);

CREATE TABLE localisation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lat FLOAT,
    `long` FLOAT,
    pays VARCHAR(255),
    postcode VARCHAR(10),
    postcodeSuff VARCHAR(10),
    region_code_insee VARCHAR(255),
    FOREIGN KEY (region_code_insee) REFERENCES region(code_insee)
);

CREATE TABLE installateur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255)
);

CREATE TABLE doc (
    id INT AUTO_INCREMENT PRIMARY KEY,
    mois INT,
    an INT,
    nbPanneaux INT,
    nbOnduleur INT,
    puissanceCrete FLOAT,
    surface FLOAT,
    pente FLOAT,
    penteOpti FLOAT,
    orientation VARCHAR(50),
    pvgis TINYINT(1),
    panneau_id INT,
    onduleur_id INT,
    localisation_id INT,
    installateur_id INT,
    FOREIGN KEY (panneau_id) REFERENCES panneau(id),
    FOREIGN KEY (onduleur_id) REFERENCES onduleur(id),
    FOREIGN KEY (localisation_id) REFERENCES localisation(id),
    FOREIGN KEY (installateur_id) REFERENCES installateur(id)
);
