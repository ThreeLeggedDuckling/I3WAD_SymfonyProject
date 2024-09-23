# Etat du projet

*last update : 240919.1600*

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
- [ ] Implémenter le modèle

## 2. A faire

- lien réflexif Comment
- fixtures Comment
- fixtures autres

## 3. Fait

### 1. Modèle

**Etat implémentation :** fonctionnelle, incomplète

**Tables :**

- advert
    - publish_date, is_open, modality, area, level, content
- campaign
    - playing_group, name, game
- comment
    - advert, publish_date, content
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
- group - campaign
- user - advert (NULL)
- user - campaign
- user - comment (NULL)
- user - file (orphanRemoval)

### 2. Fixtures

- Advert
- Campaign
- File
- Group
- Session
- User

### 3. Controlleurs

- Home
- Registration *symf*
- Security *symf*

### 4. Formulaires

- Registration

### 5. Repositories

(*symf*)

### 6. Vues

- base
- home
    - index
- includes
    - nav
- registration
    - register
- security
    - login *symf*

### 7. Autre

- redirection (dé)connexion