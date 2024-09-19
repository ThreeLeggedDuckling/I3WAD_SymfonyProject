# Etat du projet (240919.1246)

1. [Fil conducteur](#1-fil-conducteur)
2. [A faire](#2-a-faire)
2. [Fait](#3-fait)
    1. [Modèle](#1-modèle)
    2. [Controlleurs](#2-controlleurs)
    2. [Formulaires](#3-formulaires)
    2. [Repositories](#4-repositories)
    2. [Vues](#5-vues)
    2. [Autre](#6-autre)

## 1. Fil conducteur

- [X] Analyse
    - [ ] Revoir analyse
    - [ ] ... attendre validation
- [X] Créer utilisateur
- [X] Créer système de connexion
- [ ] Implémenter le modèle

## 2. A faire

- liens User
- fixtures autres

## 3. Fait

### 1. Modèle

**Etat implémentation :** fonctionnelle, incomplète

**Tables :**

- advert
    - publish_date, is_open, modality, area, level, content
- campain
    - playing_group, name, game
- comment
    - advert, publish_date, content
- file
    - campain, name, creation_date, last_modified, format, type, adress
- group
    - name
- session
    - campain, scheduled, run_time
- user
    - email, roles, password, username

**Liens OneToMany :**
- advert - comment.advert_id (orphanRemoval)
- campain - session.campain_id (orphanRemoval)
- campain - file.campain_id (orphanRemoval)
<!-- - group (1) - group_member.in_group_id (n) / orphanRemoval -->
<!-- - group_member (1) - campain.game_master_id (n) / NULL -->
<!-- - group_member (1) - file.author_id (n) -->
<!-- - user (1) - advert.author_id (n) / orphanRemoval -->
<!-- - user (1) - comment.author_id (n) / NULL -->
<!-- - user (1) - group_member.user_id (n) / orphanRemoval -->

**Fixtures :**
- User


### 2. Controlleurs

- Home
- Registration *symf*
- Security *symf*

### 3. Formulaires

- Regitration

### 4. Repositories

(*symf*)

### 5. Vues

- base
- home
    - index
- includes
    - nav
- registration
    - register
- security
    - login *symf*

### 6. Autre

- redirections (dé)connexion