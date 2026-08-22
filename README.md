# FANEVA_L1D_PROJETS_SUJET5_TODO-TASK

**RAKOTONDRAMANANA Andomanankasina Fanevanjanahary - L1D - 439/LA/25-26**

## Présentation

J'ai réalisé cette application web pour gérer des tâches simplement. Elle permet de créer une tâche, de la modifier, de la supprimer, de lui donner une priorité, de changer son statut et de l'affecter à un utilisateur précis.


## Fonctionnalités

- Ajouter une tâche avec un titre et une description
- Choisir une priorité : basse, normale, haute ou urgente
- Choisir un statut : à faire, en cours ou terminée
- Modifier une tâche existante
- Supprimer une tâche
- Marquer directement une tâche comme faite
- Rouvrir une tâche terminée
- Filtrer les tâches par statut et par priorité
- Créer, modifier et supprimer des utilisateurs
- Affecter une tâche à un utilisateur
- Retirer automatiquement l'affectation lorsqu'un utilisateur est supprimé
- Utiliser des formulaires protégés contre les requêtes CSRF

## Technologies utilisées

- PHP 8.2
- Symfony 7.4
- Doctrine ORM et Doctrine Migrations
- MySQL 8
- Twig
- Symfony Forms
- HTML et CSS
- AssetMapper

## Organisation du projet

Le projet Symfony se trouve dans le dossier `todo_app`.

- `src/Entity/Task.php` : entité des tâches
- `src/Entity/User.php` : entité des utilisateurs
- `src/Controller/TaskController.php` : actions des tâches
- `src/Controller/UserController.php` : actions des utilisateurs
- `src/Form/TaskType.php` : formulaire des tâches
- `src/Form/UserType.php` : formulaire des utilisateurs
- `src/Repository/TaskRepository.php` : recherche et filtres des tâches
- `templates/task/` : pages des tâches
- `templates/user/` : pages des utilisateurs
- `assets/styles/app.css` : styles de l'application
- `migrations/` : historique de la structure de la base de données

## Démarche de réalisation

### 1. Création du projet

J'ai commencé avec une base Symfony contenant Doctrine, Twig, les formulaires, la validation et les migrations.

### 2. Création des entités

J'ai créé deux entités :

- `Task` pour enregistrer les tâches
- `User` pour enregistrer les utilisateurs

Une tâche peut être affectée à un seul utilisateur. Un utilisateur peut avoir plusieurs tâches.

### 3. Création de la base de données

J'ai configuré Doctrine pour utiliser MySQL local avec la base `app`. J'ai ensuite créé et exécuté une migration pour créer les tables nécessaires.

### 4. Création des formulaires

J'ai créé un formulaire pour les tâches et un formulaire pour les utilisateurs. Les champs obligatoires et les choix de priorité et de statut sont contrôlés par Symfony Validator.

### 5. Création des contrôleurs

J'ai ajouté les contrôleurs permettant de gérer les opérations suivantes :

- afficher les listes ;
- ajouter ;
- modifier ;
- supprimer ;
- afficher le détail d'une tâche ;
- changer directement le statut d'une tâche.

### 6. Création de l'interface

J'ai créé les pages Twig pour les tâches et les utilisateurs. J'ai également ajouté une navigation entre les deux parties et une feuille de style responsive pour les écrans d'ordinateur et de téléphone.

### 7. Vérification

J'ai vérifié la syntaxe PHP, les templates Twig, le conteneur Symfony, les routes, le mapping Doctrine et l'état des migrations.

## Prérequis

Avant de lancer le projet, il faut installer :

- PHP 8.2 ou supérieur
- Composer
- MySQL 8 ou une version compatible
- Symfony CLI ou le serveur PHP intégré

MySQL doit être démarré et écouter sur le port `3306`.

## Configuration MySQL

La configuration actuelle utilise :

- serveur : `127.0.0.1`
- port : `3306`
- utilisateur : `root`
- base : `app`

Le mot de passe est défini dans le fichier `.env` local du projet. Pour un vrai déploiement, il faut utiliser un fichier `.env.local` et ne pas publier ce mot de passe.

## Installation

Depuis la racine du dépôt :

```bash
cd todo_app
composer install
```

Si la base `app` n'existe pas encore, je peux la créer avec :

```bash
php bin/console doctrine:database:create --if-not-exists
```

Ensuite, j'installe ou mets à jour les tables avec :

```bash
php bin/console doctrine:migrations:migrate --no-interaction
```

## Compilation des assets

Pour compiler les fichiers CSS et JavaScript :

```bash
php bin/console asset-map:compile
```

Cette commande génère les fichiers nécessaires dans `public/assets`.

## Lancement de l'application

Je démarre d'abord MySQL :

```bash
sudo systemctl start mysql
```

Puis je lance le serveur Symfony avec le serveur PHP intégré :

```bash
php -S 127.0.0.1:8000 -t public
```

J'ouvre ensuite l'application dans le navigateur :

- Tâches : http://127.0.0.1:8000/tasks
- Utilisateurs : http://127.0.0.1:8000/users

## Utilisation

1. J'ouvre la page `Utilisateurs`.
2. Je crée les utilisateurs qui pourront recevoir des tâches.
3. J'ouvre la page `Tâches`.
4. Je crée une tâche et je sélectionne sa priorité, son statut et son utilisateur.
5. Je peux modifier ou supprimer la tâche.
6. Je peux utiliser le bouton de statut pour la marquer comme faite ou la rouvrir.

## Vérifications et tests

Pour vérifier les templates et les services :

```bash
php bin/console lint:twig templates
php bin/console lint:container
```

Pour vérifier le mapping Doctrine :

```bash
php bin/console doctrine:schema:validate --skip-sync
```

Pour vérifier l'état des migrations :

```bash
php bin/console doctrine:migrations:status
```

Pour lancer les tests disponibles :

```bash
php bin/phpunit
```

