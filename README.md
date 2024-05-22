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

### ------------------------
## Agenda

écrire ici 

### ------------------------
## Flux Instagram

écrire ici 

### ------------------------
## Utilisateur / profil 

écrire ici 
