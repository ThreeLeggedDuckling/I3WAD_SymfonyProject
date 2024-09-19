# Etat du projet (240919.1246)

## 1. Fil conducteur

- [X] Analyse
    - [ ] Revoir analyse
    - [ ] ... attendre validation
- [X] Créer utilisateur
- [X] Créer système de connexion
- [ ] Implémenter le modèle

## 2. Fait

### 1. Modèle

Etat implémentation : incomplète

Tables :
- advert
    - publish_date
    - is_open
    - modality
    - area
    - level
    - content
- campain
    - playing_group
    - name
    - game
- comment
    - advert
    - publish_date
    - content
- file
    - campain
    - name
    - creation_date
    - last_modified
    - format
    - type
    - adress
- group
    - name
- session
    - campain
    - scheduled
    - run_time
- user
    - email
    - roles
    - password
    - username

Liens 1-M :
- advert (1) - comment.advert_id (n) / orphanRemoval
- campain (1) - session.campain_id (n) / orphanRemoval
- campain (1) - file.campain_id (n) / orphanRemoval
<!-- - group (1) - group_member.in_group_id (n) / orphanRemoval -->
<!-- - group_member (1) - campain.game_master_id (n) / NULL -->
<!-- - group_member (1) - file.author_id (n) -->
<!-- - user (1) - advert.author_id (n) / orphanRemoval -->
<!-- - user (1) - comment.author_id (n) / NULL -->
<!-- - user (1) - group_member.user_id (n) / orphanRemoval -->

Fixtures :
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

## 3. A faire

- liens User
    - (voir modèle)
- fixtures autres