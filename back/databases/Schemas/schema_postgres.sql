
    -- PostgreSQL Schema for Solar Panel Installation System (Final Cleaned Version)
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
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL
    );

    CREATE TABLE marque_onduleur (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL
    );

    CREATE TABLE modele_panneau (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL
    );

    CREATE TABLE modele_onduleur (
        id SERIAL PRIMARY KEY,
        nom VARCHAR(255) NOT NULL
    );

    CREATE TABLE panneau (
        id SERIAL PRIMARY KEY,
        marque_panneau INTEGER REFERENCES modele_panneau(id),
        modele_panneau INTEGER REFERENCES modele_panneau(id)
    );

    CREATE TABLE onduleur (
        id SERIAL PRIMARY KEY,
        modele_onduleur INTEGER REFERENCES modele_onduleur(id),
        marque_onduleur INTEGER REFERENCES marque_onduleur(id)
    );

    CREATE TABLE region (
        code_insee VARCHAR(255) PRIMARY KEY,
        ville VARCHAR(255),
        admin1 VARCHAR(255),
        admin2 VARCHAR(255),
        pays VARCHAR(255)
    );

    CREATE TABLE localisation (
        id SERIAL PRIMARY KEY,
        lat FLOAT,
        long FLOAT,
        postcode VARCHAR(10),
        postcodeSuff VARCHAR(10),
        code_insee VARCHAR(255) REFERENCES region(code_insee)
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
        orientation_opti VARCHAR(50),
        pvgis FLOAT,
        panneau_id INTEGER REFERENCES panneau(id),
        onduleur_id INTEGER REFERENCES onduleur(id),
        localisation_id INTEGER REFERENCES localisation(id),
        installateur_id INTEGER REFERENCES installateur(id)
    );


COMMIT;