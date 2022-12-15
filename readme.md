# Prérequis

## outils
Wampser
php 8.1.1
phpMyAdmin 5.1.2
Symfony CLI 5.4.19
composer
nodejs

## Configuration de php, Mysql, git
**Lancer php8**
>>>Php/php.ini

memory_limit = 500M

extension=curl

extension=mysqli

extension=openssl

extension=gd

extension=pdo_mysql


**Lancer wampserver**

>>> Mysql/my.ini
innodb-default-row-format=dynamic

**Lancer git**

>>>webgroup/.env

Cloner l'application

git clone https://github.com/DavidBoubou/Sonata.git

Configurer la variable d'environnement DATABASE_URL pour votre base de données Mysql.

# Demarer le Projet webgroup
## 1- Démarer wampserver

## 2- Mettre ajour l'application et ses dépendence.
$ cd webgroup
$ composer update

## 3- Créer la base de données de l'application
$php bin/console doctrine:database:create

## 4- Génerer des fixures
$php bin/console doctrine:fixtures:load

## 6- lancer le serveur local symfony
$ symfony serve

## 7 - Routes:
S'authentifié après s'être enregistrer.

    localhost/Admin/register : gestion des contenus sur l'interface administrateur avec le role ROLE_ADMIN.

    localhost/registrer: laisser un commentaire avec un role ROLE_USER

    localhost/login: Authentification