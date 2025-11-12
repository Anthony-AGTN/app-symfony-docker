# Application Symfony Avec Environnement Docker

[![Docker](https://img.shields.io/badge/Docker-24-blue?logo=docker)](https://www.docker.com/)
[![Symfony](https://img.shields.io/badge/Symfony-7.3-000000?logo=symfony&logoColor=white)](https://symfony.com/)
[![PHP](https://img.shields.io/badge/PHP-8.2-777BB4?logo=php&logoColor=white)](https://www.php.net/)
[![Composer](https://img.shields.io/badge/Composer-2.x-885630?logo=composer&logoColor=white)](https://getcomposer.org/)
[![Xdebug](https://img.shields.io/badge/Xdebug-3.x-2E8B57?logo=php&logoColor=white)](https://xdebug.org/)
[![Nginx](https://img.shields.io/badge/Nginx-1.25+-009639?logo=nginx&logoColor=white)](https://nginx.org/en/docs/)
[![MariaDB](https://img.shields.io/badge/MariaDB-11.x-003545?logo=mariadb&logoColor=white)](https://mariadb.org/)
[![Adminer](https://img.shields.io/badge/Adminer-latest-34567C?logo=adminer&logoColor=white)](https://www.adminer.org/)
[![MailHog](https://img.shields.io/badge/MailHog-latest-D06C6C?logo=mailhog&logoColor=white)](https://github.com/mailhog/MailHog)

Ce projet fournit un environnement de développement complet pour **Symfony**, basé sur **Docker**.  
Il inclut PHP 8.2, Composer, Symfony CLI, Xdebug, Nginx, MariaDB, Adminer et Mailhog.

---

## 📂 Structure du projet

```text symfony-docker/ 
├─ app/ # Projet Symfony 
├─ docker/
│ ├─ php/
│ │ ├─ Dockerfile
│ │ └─ conf.d/
│ │     └─ xdebug.ini
│ └─ nginx/
│   └─ default.conf
└─ docker-compose.yml
```

---

## 🐳 Conteneurs inclus

| Service | Conteneur           | Ports                   | Description                                    |
|---------|---------------------|-------------------------|------------------------------------------------|
| PHP     | app-symfony-php     | -                       | PHP 8.2 FPM avec Composer, Symfony CLI, Xdebug |
| Nginx   | app-symfony-nginx   | 8080                    | Sert l’application Symfony                     |
| MariaDB | app-symfony-db      | 3306                    | Base de données                                |
| Adminer | app-symfony-adminer | 8081                    | Interface web pour gérer la BDD                |
| Mailhog | app-symfony-mailhog | 8025 (web), 1025 (SMTP) | Test des mails en local                        |

---

## ⚡ Prérequis

- Docker ≥ 24
- Docker Compose ≥ 2

---

## 🚀 Démarrage de l’environnement

Construire et démarrer les conteneurs :

```bash
# Création du fichier .env
cp app/.env.example app/.env.local

# Construction de l'image Docker
docker compose build

# Lancement des conteneurs
docker compose up -d

# Vérifier que les conteneurs tournent
docker compose ps

# Si la base de données est vide, on lance les migrations
docker compose exec php symfony console doctrine:migrations:migrate

# Compiler les assets
docker compose exec php symfony console asset-map:compile

# Si vous le souhaitez, vous pouvez remplir la base de donnée
# avec des données de test pour la table Item (Fixtures)
docker compose exec php symfony console doctrine:fixtures:load
```
Arrêter / redémarrer la stack

```bash
docker compose down
docker compose up -d
docker compose restart
```

### Application Symfony

Accéder à l’application Symfony : http://localhost:8080

### Adminer

Accéder à Adminer pour gérer la base de données : http://localhost:8081

Serveur de base de données : db

Utilisateur : appDBuser

Mot de passe : appDBpassword

Base de données: app-symfony-db

### Mailhog

Accéder à Mailhog: http://localhost:8025

## 🛠 Commandes utiles

Symfony CLI et Composer dans le conteneur PHP

```bash
# Ouvrir un terminal dans le conteneur PHP
docker compose exec php bash

# Lancer la commande Symfony pour afficher la version
docker compose exec php symfony -v

# Lancer la commande Symfony pour afficher la liste des commandes disponibles
docker compose exec php php bin/console

# Générer les scripts de migration avec Symfony CLI
docker compose exec php symfony make:migration

# Lancer les migrations avec Symfony CLI
docker compose exec php symfony doctrine:migrations:migrate
```

Xdebug Port : 9003

Configurable via docker/php/conf.d/xdebug.ini

Active le débogage à chaque requête.

## ✉ Mailer Symfony

Dans .env ou .env.local :

MAILER_DSN=smtp://mailhog:1025

Mailhog capture tous les mails envoyés en dev, accessibles via l’interface web sur http://localhost:8025.

## 🗂 Volumes

./app:/var/www/html → code Symfony

./docker/php/conf.d/xdebug.ini:/usr/local/etc/php/conf.d/xdebug.ini → configuration Xdebug

./docker/nginx/default.conf:/etc/nginx/conf.d/default.conf → configuration Nginx

## 🔧 Notes
Nginx pointe vers /var/www/html/public

MariaDB exposé sur le port 3306 pour usage local (Adminer ou IDE)

Symfony CLI et Composer installés dans le conteneur PHP

Xdebug configuré pour host.docker.internal (Linux : remplacer par l’IP de l’hôte)

## 🐞 Configuration et utilisation de Xdebug

Le projet inclut une configuration complète de Xdebug pour faciliter le débogage du code PHP, que ce soit depuis un IDE (PhpStorm, VSCode…) ou en ligne de commande.

⚙️ Configuration de base

Le fichier de configuration Xdebug se trouve ici :

/docker/php/conf.d/xdebug.ini

Par défaut, Xdebug est installé, mais désactivé, afin d’éviter les lenteurs ou les blocages lors de l’exécution de commandes Symfony (php bin/console, composer install, etc.).

Voici un aperçu du fichier :

```bash
zend_extension=xdebug
xdebug.mode=off
xdebug.start_with_request=no
xdebug.discover_client_host=true
xdebug.client_host=host.docker.internal
xdebug.client_port=9003
xdebug.log_level=0
xdebug.var_display_max_depth=5
xdebug.var_display_max_children=256
xdebug.var_display_max_data=1024
```

🚀 Activer Xdebug temporairement

Pour activer Xdebug uniquement le temps d’une commande, il suffit de définir la variable d’environnement XDEBUG_MODE=debug.

Exemples :

```bash
#Ouvrir un terminal dans le conteneur PHP
docker compose exec php bash

# Exécution d’une commande Symfony avec Xdebug
XDEBUG_MODE=debug php bin/console make:entity
```

💡 Activer Xdebug pour le débogage IDE

Si tu veux déboguer le projet depuis PhpStorm ou VSCode :

Active le mode debug :

```bash
XDEBUG_MODE=debug docker compose up -d
```

Assure-toi que ton IDE écoute sur le port 9003.

Configure le mapping :

Dossier du projet local → /var/www/html (dans le conteneur).

Lance une requête HTTP ou une commande CLI : le breakpoint s’activera automatiquement 🎯
