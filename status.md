# Etat du projet

*last update : 240926.2011*

1. [Fil conducteur](#1-fil-conducteur)
2. [A faire](#2-a-faire)
2. [Fait](#3-fait)
    1. [Modèle](#1-modèle)
    2. [Fixtures](#2-fixtures)
    2. [Controlleurs](#3-controlleurs)
    2. [Formulaires](#4-formulaires)
    2. [Repositories](#5-repositories)
    2. [Vues](#6-vues)
    2. [Autre](#7-autre)

## 1. Fil conducteur

- [X] Analyse
    - [ ] ... revoir analyse (encore et toujours)
- [X] Créer utilisateur
- [X] Créer système de connexion
- [X] Implémenter le modèle
- [ ] Programmer les fonctionnalités des annonces (adverts)
- [ ] Programmer les fonctionnalités des groupes
- [ ] Programmer les fonctionnalités des campagnes
- [ ] Programmer les fonctionnalités de gestion de compte utilisateur

## 2. A faire

- vues
    - advert
        - board
        - details
    - user
        - afficher
        - gestion
    - groupe
        - main
        - campaign

- controlleurs
    - advert
    - account
    - group

- formulaires
    - filtres affichage annonces

## 3. Fait

### 1. Modèle

**Etat implémentation :** fonctionnelle

**Tables :**

- advert
    - publish_date, is_open, modality, area, level, content
- campaign
    - playing_group, name, game
- comment
    - advert, author, answer_to, publish_date, content
- file
    - campaign, name, creation_date, last_modified, format, type, adress
- group
    - name
- group_admin *symf*
- group_member *symf*
- session
    - campaign, scheduled, run_time
- user
    - email, roles, password, username

**Liens OneToMany :**
- advert - comment.advert_id (orphanRemoval)
- campaign - session.campaign_id (orphanRemoval)
- campaign - file.campaign_id (orphanRemoval)
- comment - comment.answer_to_id (NULL)
- group - campaign
- user - advert (NULL)
- user - campaign
- user - comment (NULL)
- user - file (orphanRemoval)

### 2. Fixtures

- Advert
- Campaign
- Comment
- File
- Group
- Session
- User

### 3. Controlleurs

- Adverts
    - index
    - display
- Home
- Registration *symf*
- Security *symf*

### 4. Formulaires

- Advert
- Registration

### 5. Repositories

- Advert
    - `latest()`

### 6. Vues

- base
- adverts
    - index
    - detail
- home
    - index
- includes
    - nav
- registration
    - register
- security
    - login *symf*

### 7. Autre

- config/packages/security.yaml
    - redirection (dé)connexion
- config/services.yaml
    - ajout service extension Twig
- src/Twig/DateIntervalExtension.php
    - `timeAgo()`
- .env
    - configuration connexion db