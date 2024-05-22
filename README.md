<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://github.com/laravel/framework/actions"><img src="https://github.com/laravel/framework/workflows/tests/badge.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## About Laravel

Laravel is a web application framework with expressive, elegant syntax. We believe development must be an enjoyable and creative experience to be truly fulfilling. Laravel takes the pain out of development by easing common tasks used in many web projects, such as:

- [Simple, fast routing engine](https://laravel.com/docs/routing).
- [Powerful dependency injection container](https://laravel.com/docs/container).
- Multiple back-ends for [session](https://laravel.com/docs/session) and [cache](https://laravel.com/docs/cache) storage.
- Expressive, intuitive [database ORM](https://laravel.com/docs/eloquent).
- Database agnostic [schema migrations](https://laravel.com/docs/migrations).
- [Robust background job processing](https://laravel.com/docs/queues).
- [Real-time event broadcasting](https://laravel.com/docs/broadcasting).

Laravel is accessible, powerful, and provides tools required for large, robust applications.

## Learning Laravel

Laravel has the most extensive and thorough [documentation](https://laravel.com/docs) and video tutorial library of all modern web application frameworks, making it a breeze to get started with the framework.

You may also try the [Laravel Bootcamp](https://bootcamp.laravel.com), where you will be guided through building a modern Laravel application from scratch.

If you don't feel like reading, [Laracasts](https://laracasts.com) can help. Laracasts contains over 2000 video tutorials on a range of topics including Laravel, modern PHP, unit testing, and JavaScript. Boost your skills by digging into our comprehensive video library.

## Laravel Sponsors

We would like to extend our thanks to the following sponsors for funding Laravel development. If you are interested in becoming a sponsor, please visit the [Laravel Partners program](https://partners.laravel.com).

### Premium Partners

- **[Vehikl](https://vehikl.com/)**
- **[Tighten Co.](https://tighten.co)**
- **[WebReinvent](https://webreinvent.com/)**
- **[Kirschbaum Development Group](https://kirschbaumdevelopment.com)**
- **[64 Robots](https://64robots.com)**
- **[Curotec](https://www.curotec.com/services/technologies/laravel/)**
- **[Cyber-Duck](https://cyber-duck.co.uk)**
- **[DevSquad](https://devsquad.com/hire-laravel-developers)**
- **[Jump24](https://jump24.co.uk)**
- **[Redberry](https://redberry.international/laravel/)**
- **[Active Logic](https://activelogic.com)**
- **[byte5](https://byte5.de)**
- **[OP.GG](https://op.gg)**

## Contributing

Thank you for considering contributing to the Laravel framework! The contribution guide can be found in the [Laravel documentation](https://laravel.com/docs/contributions).

## Code of Conduct

In order to ensure that the Laravel community is welcoming to all, please review and abide by the [Code of Conduct](https://laravel.com/docs/contributions#code-of-conduct).

## Security Vulnerabilities

If you discover a security vulnerability within Laravel, please send an e-mail to Taylor Otwell via [taylor@laravel.com](mailto:taylor@laravel.com). All security vulnerabilities will be promptly addressed.

## License

The Laravel framework is open-sourced software licensed under the [MIT license](https://opensource.org/licenses/MIT).

# APPLICATION 


#### Prérequis

Avant de commencer, assurez-vous que les éléments suivants sont installés et configurés sur votre machine :

- [PHP](https://www.php.net/downloads) (version 7.4 ou supérieure)
- [Composer](https://getcomposer.org/download/)
- [Laravel](https://laravel.com/docs/8.x/installation) (version 8.x ou supérieure)
- Clé d'API Google et identifiants OAuth pour Google Calendar API

#### Installation

1. Clonez le dépôt :

    ```sh
    git clone https://github.com/votre-utilisateur/votre-repo.git
    cd votre-repo
    ```

2. Installez les dépendances PHP avec Composer :

    ```sh
    composer install
    ```

3. Configurez votre fichier `.env` :

    ```sh
    cp .env.example .env
    php artisan key:generate
    ```

4. Configurez la base de données dans le fichier `.env` et migrez les tables :

    ```sh
    php artisan migrate
    ```

5. Configurez Google API :

    - Placez votre fichier de clés OAuth JSON dans `config/google/credentials.json`.
    - Ajoutez votre clé d'API Google dans le fichier `.env` :

    ```sh
    GOOGLE_API_KEY=Votre_Clé_API
    ```



### ------------------------
## Agenda


Cette section du projet gère la fonctionnalité d'agenda, incluant la création, l'affichage, la mise à jour et la suppression d'événements. Les événements peuvent être filtrés par équipe et sont synchronisés avec Google Calendar.

#### Utilisation

##### Modèle : `Event`

Le modèle `Event` représente un événement dans le système. Voici les attributs principaux :

- `id` : Identifiant unique de l'événement (utilisé pour la synchronisation avec Google Calendar).
- `title` : Titre de l'événement.
- `description` : Description de l'événement (peut inclure les catégories d'équipe).
- `location` : Lieu de l'événement.
- `place` : Indication du lieu (par exemple, "domicile" ou "extérieur").
- `start` : Date et heure de début de l'événement.
- `end` : Date et heure de fin de l'événement.
- `isRecurring` : Booléen indiquant si l'événement est récurrent.

##### Vues

###### `calendar.blade.php`

Cette vue affiche le calendrier et les événements. Elle permet également de filtrer les événements par équipe.

###### `events/show.blade.php`

Cette vue affiche les détails d'un événement spécifique.

##### Contrôleurs

###### `CalendarController`

- `getUserTeam` : Récupère l'équipe de l'utilisateur authentifié.
- `getTeamName` : Récupère le nom de l'équipe par son ID.
- `show` : Affiche tous les événements et catégories d'équipes.
- `index` : Filtre et affiche les événements par équipe sélectionnée.

###### `EventsController`

- `getEvents` : Synchronise les événements depuis Google Calendar et les enregistre dans la base de données.
- `getCategories` : Récupère les catégories d'équipes pour chaque événement depuis Google Calendar.
- `getCategoriesById` : Récupère les catégories pour un événement spécifique.
- `getEventsByCategory` : Filtre les événements par catégorie d'équipe.

#### Synchronisation avec Google Calendar

1. Configurez votre projet Google API et obtenez les identifiants OAuth et la clé d'API.
2. Placez le fichier des clés OAuth dans `config/google/credentials.json`.
3. Ajoutez la clé d'API dans le fichier `.env` :

    ```sh
    GOOGLE_API_KEY=Votre_Clé_API
    ```

4. Utilisez les méthodes du `EventsController` pour synchroniser les événements.

#### Relier le Google Agenda de votre choix à l'application

1. Rendez-vous sur le site : [Google Calendar](https://calendar.google.com/calendar/) et connectez-vous au compte souhaité.
2. Ouvrez le menu déroulant en haut à gauche.
3. Dans "Mes agendas", allez dans "Paramètre et partage" de l'agenda souhaité.
4. Sélectionnez "Rendre disponible publiquement" dans "Autorisations d'accès aux événements".
5. Puis récupérez dans "Intégrer l'agenda" votre "ID de l'agenda".

Implémentez ensuite dans le code votre ID d'agenda dans `EventsController.php` :
Dans les fonctions `getEvents`, `getCategories`, `getEventsByCategory`, indiquez l'id d'agenda voulu à la ligne :

    ```php
    $calendarId = 'votre id d'agenda';
    ```

#### Styles et Scripts

##### CSS

Le style est principalement géré par Tailwind CSS et les classes Bootstrap pour le style des composants.

##### JavaScript

Le calendrier est géré par FullCalendar et des scripts personnalisés pour la manipulation des événements et des filtres.

#### Développement futur

##### Fonctionnalités à ajouter

1. **Notifications** : Implémenter des notifications pour les nouveaux événements ou les changements.
2. **Support multilingue** : Ajouter des traductions pour supporter plusieurs langues.
3. **Tests** : Ajouter des tests unitaires et fonctionnels pour améliorer la robustesse du système.

##### Améliorations possibles

1. **Interface utilisateur** : Améliorer l'interface utilisateur avec des animations et une meilleure UX.
2. **Sécurité** : Ajouter des mesures de sécurité supplémentaires pour protéger les données des événements.
3. **Performances** : Optimiser les requêtes et la gestion des événements pour de meilleures performances.
### ------------------------


## Messagerie

Cette partie est consacrée à la messagerie en temps réel permettant aux utilisateurs de communiquer via des groupes et des conversations privées. Vous trouverez ci-dessous une explication détaillée des fonctionnalités de messagerie, ainsi que la logique et les fonctions utilisées pour les mettre en œuvre.

### Fonctionnalités de la Messagerie

#### Gestion des Conversations et des Groupes

- **toggleGroupCreationMode()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Active ou désactive le mode de création de groupe, affichant ou masquant les éléments de l'interface utilisateur liés à la création de groupe.

- **createGroup()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Crée un nouveau groupe avec les utilisateurs sélectionnés et recharge la liste des groupes.

- **loadUsers()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Charge la liste des utilisateurs à partir de l'API et les affiche dans le modal de sélection d'utilisateurs.

- **loadUserGroups()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Charge la liste des groupes de l'utilisateur, en séparant les groupes favoris des autres groupes, et les affiche.

- **joinGroupChat(groupId, groupName)**
    - **Entrée** : `groupId` (ID du groupe), `groupName` (Nom du groupe)
    - **Sortie** : Aucune
    - **Description** : Rejoint un chat de groupe, met à jour l'en-tête et charge les messages précédents du groupe sélectionné.

- **subscribeToGroupChannel(groupId)**
    - **Entrée** : `groupId` (ID du groupe)
    - **Sortie** : Aucune
    - **Description** : Abonne l'utilisateur au canal de groupe pour recevoir les messages en temps réel.

- **subscribeToAllGroupChannels(groups)**
    - **Entrée** : `groups` (Liste des groupes)
    - **Sortie** : Aucune
    - **Description** : Abonne l'utilisateur à tous les canaux de groupe pour recevoir les messages en temps réel.

#### Envoi et Réception de Messages

- **sendMessage()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Envoie un message texte et/ou des fichiers au groupe ou à la conversation privée actuellement sélectionné(e).

- **loadPreviousMessages(groupId)**
    - **Entrée** : `groupId` (ID du groupe)
    - **Sortie** : Aucune
    - **Description** : Charge les messages précédents du groupe spécifié et les affiche dans le chat.

- **appendMessageToChat(messageContent, authorID, authorFirstname, authorLastname, fileData)**
    - **Entrée** : `messageContent` (Contenu du message), `authorID` (ID de l'auteur), `authorFirstname` (Prénom de l'auteur), `authorLastname` (Nom de l'auteur), `fileData` (Données des fichiers)
    - **Sortie** : Aucune
    - **Description** : Ajoute un message au chat, en formatant le message en fonction de l'auteur et des fichiers attachés.

#### Favoris

- **loadUserFavorites()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Charge les favoris de l'utilisateur et les affiche.

- **addFavorite(groupId)**
    - **Entrée** : `groupId` (ID du groupe)
    - **Sortie** : Aucune
    - **Description** : Ajoute le groupe spécifié aux favoris de l'utilisateur.

- **removeFavorite(groupId)**
    - **Entrée** : `groupId` (ID du groupe)
    - **Sortie** : Aucune
    - **Description** : Supprime le groupe spécifié des favoris de l'utilisateur.

#### Gestion des Utilisateurs

- **getUserInfo()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Récupère les informations de l'utilisateur et les stocke dans des variables globales.

- **getUserInfoAsync()**
    - **Entrée** : Aucune
    - **Sortie** : Promise
    - **Description** : Wrapper de `getUserInfo` pour fonctionner de manière asynchrone avec des promesses.

#### Autres Fonctions Utilitaires

- **showConversationList()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Affiche la liste des conversations et masque la conversation active.

- **showConversation()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Affiche la conversation active et masque la liste des conversations.

- **updateGroupPreview(groupId, messageContent)**
    - **Entrée** : `groupId` (ID du groupe), `messageContent` (Contenu du message)
    - **Sortie** : Aucune
    - **Description** : Met à jour l'aperçu du dernier message et l'heure du dernier message pour un groupe.

- **startConversation(userId)**
    - **Entrée** : `userId` (ID de l'utilisateur)
    - **Sortie** : Aucune
    - **Description** : Démarre une nouvelle conversation avec l'utilisateur spécifié ou rejoint une conversation existante.

- **createPrivateGroup(userOneId, userTwoId)**
    - **Entrée** : `userOneId` (ID du premier utilisateur), `userTwoId` (ID du second utilisateur)
    - **Sortie** : Aucune
    - **Description** : Crée un groupe privé entre deux utilisateurs et rejoint la conversation.

- **loadUserConversation()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Charge les conversations privées de l'utilisateur et les affiche.

- **triggerPushNotification(groupId, messageContent, globaluserId)**
    - **Entrée** : `groupId` (ID du groupe), `messageContent` (Contenu du message), `globaluserId` (ID de l'utilisateur)
    - **Sortie** : Aucune
    - **Description** : Déclenche une notification push pour un nouveau message.

- **startRefreshingConversations()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Démarre l'actualisation périodique des conversations et des groupes.

- **updateLastVisitedAt(groupId)**
    - **Entrée** : `groupId` (ID du groupe)
    - **Sortie** : Aucune
    - **Description** : Met à jour la dernière visite d'un utilisateur pour un groupe spécifié.

- **loadUnreadMessagesCount()**
    - **Entrée** : Aucune
    - **Sortie** : Promise
    - **Description** : Charge le nombre de messages non lus pour chaque groupe et conversation.

- **openModal()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Ouvre la modale pour la sélection des utilisateurs.

- **closeModal()**
    - **Entrée** : Aucune
    - **Sortie** : Aucune
    - **Description** : Ferme la modale pour la sélection des utilisateurs.

## Utilisation de la Messagerie

### Affichage des Groupes et Conversations Privées :
- Utilisez les onglets "Groupes" et "Conversations" pour basculer entre les vues.

### Création de Groupes :
- Cliquez sur le bouton "+" en bas à droite pour entrer en mode création de groupe.
- Entrez un nom de groupe, sélectionnez des utilisateurs, puis cliquez sur "Suivant" pour créer le groupe.

### Envoi de Messages :
- Sélectionnez un groupe ou une conversation privée.
- Tapez votre message dans le champ de saisie et cliquez sur le bouton d'envoi ou appuyez sur "Entrée".
- Pour envoyer des fichiers, cliquez sur l'icône de fichier et sélectionnez les fichiers à envoyer.

### Gestion des Favoris :
- Ajoutez ou supprimez des groupes et des conversations privées de vos favoris en cliquant sur l'étoile à côté de chaque élément.


## Flux Instagram

écrire ici 

### ------------------------
## Utilisateur / profil 

Cette section est dédiée à la gestion des utilisateurs et des profils dans l'application. Voici les détails sur les fonctionnalités, la logique et les fonctions utilisées pour gérer les utilisateurs et leurs profils.

Fonctionnalités Utilisateur et Profil

Contrôleurs
- ##### UserController
### index()
    Description : Affiche la liste de tous les utilisateurs.
    Route : GET /users
    Sortie : Vue affichant tous les utilisateurs.
    
### show($id)
    Description : Affiche les détails d'un utilisateur spécifique.
    Route : GET /users/{id}
    Sortie : Vue affichant les détails de l'utilisateur.
    
### create()
    Description : Affiche le formulaire pour créer un nouvel utilisateur.
    Route : GET /users/create
    Sortie : Vue affichant le formulaire de création.
    
### store(Request $request)
    Description : Enregistre un nouvel utilisateur dans la base de données.
    Route : POST /users
    Sortie : Redirection vers la liste des utilisateurs.
    
### edit($id)
    Description : Affiche le formulaire pour éditer un utilisateur existant.
    Route : GET /users/{id}/edit
    Sortie : Vue affichant le formulaire d'édition.
    
### update(Request $request, $id)
    Description : Met à jour les informations d'un utilisateur existant dans la base de données.
    Route : PUT /users/{id}
    Sortie : Redirection vers la liste des utilisateurs.
    
### destroy($id)
    Description : Supprime un utilisateur de la base de données.
    Route : DELETE /users/{id}
    Sortie : Redirection vers la liste des utilisateurs.
    
 - ##### ProfileController
### show($id)
    Description : Affiche les détails du profil d'un utilisateur spécifique.
    Route : GET /profile/{id}
    Sortie : Vue affichant les détails du profil.

### update(Request $request, $id)
    Description : Met à jour les informations du profil d'un utilisateur spécifique.
    Route : PUT /profile/{id}
    Sortie : Redirection vers les détails du profil.

### Utilisateur / Profil

Cette section détaille les fonctionnalités disponibles pour la gestion des utilisateurs et des profils, ainsi que les étapes pour effectuer chaque action.

#### Fonctionnalités Utilisateur et Profil

##### 1. Afficher la liste des utilisateurs

- **Étapes** :
  1. Accédez à l'URL `/users` dans votre navigateur.
  2. La page affiche une table listant tous les utilisateurs avec leurs noms, emails et actions disponibles.
  3. Vous pouvez voir les options pour afficher, éditer ou supprimer chaque utilisateur.

##### 2. Afficher les détails d'un utilisateur

- **Étapes** :
  1. Dans la liste des utilisateurs, cliquez sur le lien "View" à côté de l'utilisateur que vous souhaitez voir.
  2. Vous serez redirigé vers la page `/users/{id}`, où `{id}` est l'identifiant de l'utilisateur.
  3. La page affiche les détails de l'utilisateur, y compris son nom et son email.
  4. Vous pouvez également voir les options pour éditer ou supprimer cet utilisateur.

##### 3. Créer un nouvel utilisateur

- **Étapes** :
  1. Accédez à l'URL `/users/create` dans votre navigateur.
  2. Remplissez le formulaire de création d'utilisateur avec les informations suivantes :
     - **Nom** : Saisissez le nom de l'utilisateur.
     - **Email** : Saisissez l'email de l'utilisateur.
     - **Mot de passe** : Saisissez un mot de passe pour l'utilisateur.
  3. Cliquez sur le bouton "Create User" pour soumettre le formulaire.
  4. L'utilisateur sera créé et vous serez redirigé vers la liste des utilisateurs.

##### 4. Éditer un utilisateur existant

- **Étapes** :
  1. Dans la liste des utilisateurs, cliquez sur le lien "Edit" à côté de l'utilisateur que vous souhaitez modifier.
  2. Vous serez redirigé vers la page `/users/{id}/edit`, où `{id}` est l'identifiant de l'utilisateur.
  3. Modifiez les informations de l'utilisateur dans le formulaire :
     - **Nom** : Modifiez le nom de l'utilisateur.
     - **Email** : Modifiez l'email de l'utilisateur.
  4. Cliquez sur le bouton "Update User" pour soumettre le formulaire.
  5. Les informations de l'utilisateur seront mises à jour et vous serez redirigé vers la liste des utilisateurs.

##### 5. Supprimer un utilisateur

- **Étapes** :
  1. Dans la liste des utilisateurs, cliquez sur le lien "Delete" à côté de l'utilisateur que vous souhaitez supprimer.
  2. Un formulaire de confirmation de suppression s'affiche.
  3. Cliquez sur le bouton "Delete User" pour confirmer la suppression.
  4. L'utilisateur sera supprimé de la base de données et vous serez redirigé vers la liste des utilisateurs.

##### 6. Mettre à jour le mot de passe d'un utilisateur

- **Étapes** :
  1. Accédez à l'URL `/profile/updatePassword/{id}`, où `{id}` est l'identifiant de l'utilisateur.
  2. Remplissez le formulaire de mise à jour du mot de passe avec le nouveau mot de passe.
  3. Cliquez sur le bouton "Update Password" pour soumettre le formulaire.
  4. Le mot de passe de l'utilisateur sera mis à jour.

##### 7. Ajouter des photos dans le profil

- **Étapes** :
  1. Accédez à l'URL `/profile/addPictures/{id}`, où `{id}` est l'identifiant de l'utilisateur.
  2. Cliquez sur le champ input de type fichier pour sélectionner les photos que vous souhaitez ajouter.
  3. Sélectionnez les fichiers de photos depuis votre ordinateur.
  4. Cliquez sur le bouton "Add Pictures" pour téléverser les photos.
  5. Les photos seront ajoutées au profil de l'utilisateur.

##### 8. Mettre à jour les informations de profil

- **Étapes** :
  1. Accédez à l'URL `/profile/update/{id}`, où `{id}` est l'identifiant de l'utilisateur.
  2. Modifiez les informations de profil dans le formulaire :
     - **Nom** : Modifiez le nom de l'utilisateur.
     - **Email** : Modifiez l'email de l'utilisateur.
  3. Cliquez sur le bouton "Update Profile" pour soumettre le formulaire.
  4. Les informations de profil de l'utilisateur seront mises à jour.
