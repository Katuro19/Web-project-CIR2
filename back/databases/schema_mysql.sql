
-- MySQL Schema for Solar Panel Installation System

CREATE TABLE marque (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    estPanneau TINYINT(1)
);

CREATE TABLE modele (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    marque_id INT,
    FOREIGN KEY (marque_id) REFERENCES marque(id)
);

CREATE TABLE panneau (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele_id INT,
    marque_id INT,
    FOREIGN KEY (modele_id) REFERENCES modele(id),
    FOREIGN KEY (marque_id) REFERENCES marque(id)
);

CREATE TABLE onduleur (
    id INT AUTO_INCREMENT PRIMARY KEY,
    modele_id INT,
    marque_id INT,
    FOREIGN KEY (modele_id) REFERENCES modele(id),
    FOREIGN KEY (marque_id) REFERENCES marque(id)
);

CREATE TABLE localisation (
    id INT AUTO_INCREMENT PRIMARY KEY,
    lat FLOAT,
    `long` FLOAT,
    pays VARCHAR(255),
    postcode VARCHAR(10),
    postcodeSuff VARCHAR(10)
);

CREATE TABLE region (
    id INT AUTO_INCREMENT PRIMARY KEY,
    ville VARCHAR(255),
    admin1 VARCHAR(255),
    admin2 VARCHAR(255),
    political VARCHAR(255)
);

CREATE TABLE appartient (
    localisation_id INT,
    region_id INT,
    PRIMARY KEY (localisation_id, region_id),
    FOREIGN KEY (localisation_id) REFERENCES localisation(id),
    FOREIGN KEY (region_id) REFERENCES region(id)
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
