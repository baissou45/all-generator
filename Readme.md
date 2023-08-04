# All Generator

<!-- [![Version](https://img.shields.io/badge/version-1.0.0-blue.svg)](https://semver.org)
[![License](https://img.shields.io/badge/license-MIT-blue.svg)](https://opensource.org/licenses/MIT) -->

Le package **baiss/all-generate** est conçu pour simplifier la génération complète de CRUD (Create, Read, Update, Delete) dans une application Laravel. Il automatise la création de contrôleurs, de modèles et de ressources d'interface utilisateur pour la gestion de modules en utilisant les modèles liés aux migrations. Cela vous permet de gagner du temps lors du développement en automatisant les tâches répétitives.

## Table des matières

- [Installation](#installation)
- [Utilisation](#utilisation)
- [Personnalisation](#personnalisation)
- [Ressources complementaire](#ressources-complementaire)
- [Contribuer](#contribuer)
- [Licence](#licence)

## Installation

1. Installé un nouveau projet laravel.
2. Exécutez la commande suivante pour installer le package :

```bash
composer require baiss/all-generator
```

3. Ajoutez le fournisseur de services dans config/app.php

```bash
'providers' => [
    // ...
    Baiss\ViewGenerator\ServiceProvider::class,
],
```

4. Publiez les ressources de configuration et personnalisez-les:


```bash
php artisan vendor:publish --tag=all-generator-config
```


## Utilisation

1. Ajouter la migration de votre module.

2. Exécuter votre migration.

3. Lancer la commande ci-après, puis suiver les instructions :


```bash
php artisan all:generate Model
```

Vous pouvez ajouter l'option -a pour tout accepter

```bash
php artisan all:generate Model -a
```

Remplacerez l'expression "Model" par le model de la migration que vous avez précédement créée. Si la table de la migration, c'est "users", vous remplacerer "Model" par "User". Ce qui nous donnera la commande ci après :

```bash
php artisan all:generate User -a
```

## Personnalisation

En lancant la commande de génération pour le model User par exemple, il vous sera généré les fichiers suivants

```bash
|app
|   |-- Http/
|   |   |-- Controllers/
|   |   |   |-- UserController
|   |-- Models/
|   |   |-- User
...
|config/
|   |-- allGeneratorConfig.php
...
|resources/
|    views/
|    |-- users/
|    |   |-- partials/
|    |   |   |--- form.blade.php
|    |   |-- index.blade.php
|    |   |-- create.blade.php
|    |   |-- edit.blade.php
...
|routes
|   |-- all_generate_routes.php

```

1. Le controller UserController ainsi générer est déjà prêt à l'emploi sans avoir a ajouter les methodes de CRUD. Cependant, vous pourrez toujours surcharger les methodes pour les rendres plus adapté à votre besoin. Une méthode à éditer y sera aussi générer afin de permettre la mise en place des validations rules.

2. Le model User est généré avec un fillable et les relations belongsTo si vous respectez les conventions de nommage en surfixant les clés étrangères de '_id'.

3. Le fichier de configuration allGeneratorConfig permet de définir certins parametres pour la génération des fichiers de vues pour la pluspart.

4. Les fichiers de vues générés sont directements placés dans les ressources, vous permettant ainsi de les customiser à votre guise.

5. Le fichier de route all_generate_routes renfermera les routes des modules qui seront générés par ce package.

## Ressources complementaire

Des ressources supplémentaires peuvent aussi etres trouvée en suivant les liens ci-après:

<!-- - [Powerful dependency injection container](https://laravel.com/docs/container).
- [Powerful dependency injection container](https://laravel.com/docs/container). -->

## Contribuer

Les contributions sont les bienvenues ! Consultez le guide de contribution dans le fichier CONTRIBUTING.md pour plus de détails.

## Licence

Ce projet est sous licence MIT. Voir le fichier LICENSE pour plus d'informations.