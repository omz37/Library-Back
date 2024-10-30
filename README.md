# BaseJump - Symfony

<!-- START doctoc generated TOC please keep comment here to allow auto update -->
<!-- DON'T EDIT THIS SECTION, INSTEAD RE-RUN doctoc TO UPDATE -->
**Table of Contents**  *generated with [DocToc](https://github.com/thlorenz/doctoc)*

- [Git](#git)
  - [Numéro de version](#num%C3%A9ro-de-version)
- [Installation du projet](#installation-du-projet)
  - [Prérequis](#pr%C3%A9requis)
  - [Mémo des commandes](#m%C3%A9mo-des-commandes)
  - [Configuration PhpStorm OU IDEA via le plugin PHP](#configuration-phpstorm-ou-idea-via-le-plugin-php)
    - [Plugins à installer](#plugins-%C3%A0-installer)
    - [Debug](#debug)
    - [CLI Interpreter pour le debug (optionnel, permet de lancer les commandes composer / php depuis l'IDE)](#cli-interpreter-pour-le-debug-optionnel-permet-de-lancer-les-commandes-composer--php-depuis-lide)
  - [Configuration de l'IDE vscode](#configuration-de-lide-vscode)
    - [Debug sur VScode](#debug-sur-vscode)
- [Liens](#liens)
- [Tests](#tests)
  - [Lancer les tests unitaires](#lancer-les-tests-unitaires)
  - [Coverage](#coverage)
- [Qualité du code](#qualit%C3%A9-du-code)
  - [PHP-CS-FIXER](#php-cs-fixer)
  - [PHPStan](#phpstan)
  - [PHPMetrics](#phpmetrics)

<!-- END doctoc generated TOC please keep comment here to allow auto update -->

# Git

On utilise le [gitflow](https://datasift.github.io/gitflow/IntroducingGitFlow.html)

La branche de dev est **master**. 

Pour chaque évolution, on crée une nouvelle branche puis on réintègre les changements sur la branche master via des merges requests.

Pour livrer en recette, on livre sur la branche **release**, si tout est validé, on livre sur **prod** et on tag la version.

## Numéro de version

Le dernier numéro de version est visible dans le [CHANGELOG](CHANGELOG.md).
Il est aussi visible dans le [composer.json](composer.json).

Pour le numéro de version on utilise la norme [https://semver.org](https://semver.org) :
- MAJOR version when you make incompatible API changes,
- MINOR version when you add functionality in a backwards compatible manner, and
- PATCH version when you make backwards compatible bug fixes.

 
Lors de la livraison en recette, il faut modifier le numéro de version dans le [CHANGELOG](CHANGELOG.md) ainsi que dans le [package](package.json).
Le **[project_version.txt](public/project_version.txt)** sera ensuite créé lors du déploiement via Jenkins avec des infos de version, du commit, et de la date.

# Installation du projet

## Prérequis

* [installer docker](https://docs.docker.com/install/) (bien suivre la partie "If you would like to use Docker as a non-root user" sous linux)
* [installer docker-compose](https://docs.docker.com/compose/install/)


Lors de l'installation de nouvelles extensions PHP, il est nécessaire de rebuild l'image :
**/!\\** Pour Windows et Mac un simple docker-compose up est suffisant.

```shell
DUID=$(id -u) DGID=$(id -g) docker-compose up -d
```

## Mémo des commandes

Installer les dépendances du projet à l'aide de composer :

```shell
./runc composer install
```

Après modification d'une entité, il faut générer le fichier de migration **/!\ A ne faire seulement que lors d'une modification d'entité, et pas lors d'une installation du projet/!\\** :

```shell
./runc php bin/console make:migration
```

Pour exécuter les migrations sur la base de données : 

```shell
./runc php bin/console doctrine:migrations:migrate
```

Clear le cache symfony

```shell
./runc php bin/console cache:clear
```

## Configuration PhpStorm OU IDEA via le [plugin PHP](https://plugins.jetbrains.com/plugin/6610-php)

### Plugins à installer

Voici une liste de plugin à installer afin d'avoir un environnement correctement configuré :
* PhpStorm Workshop
* PHP Annotations
* .env files support
* Symfony Support
* Docker
* Docker PHP

### Debug

Puis cliquer sur le bouton "Start Listening for PHP Debug Connections" (le petit téléphone) à côté du bouton de "Run" (grisé).

### CLI Interpreter pour le debug (optionnel, permet de lancer les commandes composer / php depuis l'IDE)

Dans "Settings" > "Languages & Frameworks" > "PHP" > "CLI Interpreter" > "..." > "+" > "From Docker..."
                                             
Sélectionner "Docker Compose"
Server : créer un nouveau et sélectionner "Unix socket"
Configuration files : "./docker-compose.yml"
Service : "php-fpm"
 
Puis valider. Dans la configuration "CLI Interpreter" choisir "Connect to existing container" et valider.

## Configuration de l'IDE vscode

### Debug sur VScode

Installer le plugin PHP Debug, et vous pouvez commencer à débuguer.

# Liens

* [pgAdmin](http://localhost:7181) - Administration BDD. login : basejump / mdp : basejump. Ajouter une connexion host : db / user : basejump / password : basejump.
* [maildev](http://localhost:7182) - Interface web pour accéder au mails envoyé depuis l'application
* [swaggerUI](http://localhost:7180/api/swagger) - Le swaggerUI des Apis du projet
* [swagger](http://localhost:7180/api/swagger.json) - Le descriptif swagger des Apis du projet

# Tests

Des tests sont mis en place dans le dossier [test](./tests)
- https://symfony.com/doc/current/testing.html#the-phpunit-testing-framework

## Lancer les tests unitaires


```shell
./runc ./bin/phpunit --coverage-html phpunit --coverage-clover phpunit/coverage.xml
```

## Coverage

Une fois les tests lancés, un coverage est disponible à cette url : [index.html](./phpunit/index.html)


# Qualité du code

## PHP-CS-FIXER

Pour lancer PHP-CS-FIXER afin de corriger les erreurs de code style

```shell
./runc php vendor/bin/php-cs-fixer fix
```

## PHPStan

Pour lancer PHPStan afin de vérifier la qualité du code

```shell
./runc php vendor/bin/phpstan analyse src tests
```

## PHPMetrics

Pour lancer PHPMetrics afin d'avoir des infos sur le projet

```shell
./runc php vendor/bin/phpmetrics --report-html=phpmetrics src --junit=phpunit/report.xml
```

Une fois terminé, le rapport est disponible à cette url : [index.html](./phpmetrics/index.html)
