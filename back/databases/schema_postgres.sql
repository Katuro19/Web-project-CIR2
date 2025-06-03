
-- PostgreSQL Schema for Solar Panel Installation System

CREATE TABLE marque (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    estPanneau BOOLEAN
);

CREATE TABLE modele (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255) NOT NULL,
    marque_id INTEGER REFERENCES marque(id)
);

CREATE TABLE panneau (
    id SERIAL PRIMARY KEY,
    modele_id INTEGER REFERENCES modele(id),
    marque_id INTEGER REFERENCES marque(id)
);

CREATE TABLE onduleur (
    id SERIAL PRIMARY KEY,
    modele_id INTEGER REFERENCES modele(id),
    marque_id INTEGER REFERENCES marque(id)
);

CREATE TABLE localisation (
    id SERIAL PRIMARY KEY,
    lat FLOAT,
    long FLOAT,
    pays VARCHAR(255),
    postcode VARCHAR(10),
    postcodeSuff VARCHAR(10)
);

CREATE TABLE region (
    id SERIAL PRIMARY KEY,
    ville VARCHAR(255),
    admin1 VARCHAR(255),
    admin2 VARCHAR(255),
    political VARCHAR(255)
);

CREATE TABLE appartient (
    localisation_id INTEGER REFERENCES localisation(id),
    region_id INTEGER REFERENCES region(id),
    PRIMARY KEY (localisation_id, region_id)
);

CREATE TABLE installateur (
    id SERIAL PRIMARY KEY,
    nom VARCHAR(255)
);

CREATE TABLE doc (
    id SERIAL PRIMARY KEY,
    mois INTEGER,
    an INTEGER,
    nbPanneaux INTEGER,
    nbOnduleur INTEGER,
    puissanceCrete FLOAT,
    surface FLOAT,
    pente FLOAT,
    penteOpti FLOAT,
    orientation VARCHAR(50),
    pvgis BOOLEAN,
    panneau_id INTEGER REFERENCES panneau(id),
    onduleur_id INTEGER REFERENCES onduleur(id),
    localisation_id INTEGER REFERENCES localisation(id),
    installateur_id INTEGER REFERENCES installateur(id)
);
