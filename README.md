# 🌐 MonSite - Installation et Configuration

Bienvenue ! Ce guide vous expliquera comment configurer et lancer le site en local.

---

## 📦 Prérequis

- Node.js / npm
- MySQL **ou** PostgreSQL
- Un serveur HTTP (Apache, nginx, etc.)

---

## 🚀 Étapes d'installation

### 1. 📂 Configuration de la base de données

#### Créer un fichier `.env`

Dans le dossier `/back/databases/`, créez un fichier `.env` avec les informations de connexion à votre base de données :

`env`
DB_HOST=monHost
DB_NAME=maDatabase
DB_USER=monUser
DB_PASSWORD=monMdp
`/env`

> ℹ️ Un fichier `.env.exemple` est disponible pour vous guider.

---

### 2. 🏗️ Initialisation de la base de données

Dans le dossier `/back/databases/Schemas`, vous trouverez les fichiers SQL pour :

- Créer les tables
- Insérer les données

> Des scripts sont disponibles pour **MySQL** et **PostgreSQL**.

Importez-les dans votre base de données en respectant l'ordre :  
**1. Création des tables → 2. Insertion des données**

---

### 3. 🔐 Configuration des identifiants admin

Créez un fichier `.secret` dans le dossier `/back/`, avec les identifiants d'accès administrateur :

`env`
USER=myUser
PASSWORD=myPassword
`/env`

---

### 4. 🌍 Configuration du front-end

Créez un fichier `env.js` dans `/front/JS/`, avec l'adresse de votre API :

`js`
let api_link = "http://YOUR_IP_ADDRESS/YOUR_API_PATH";
`/js`

---

## ✅ Tout est prêt !

Une fois toutes ces étapes réalisées, vous pouvez lancer votre projet 🎉

---

## 🛠️ Conseils

- Assurez-vous que votre API est bien accessible depuis le front (problèmes CORS éventuels).
- Si vous utilisez un reverse proxy, pensez à bien rediriger les routes.
