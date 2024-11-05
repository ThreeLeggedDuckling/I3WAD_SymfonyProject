# Etat du projet

## 1. Fil conducteur

- [X] Analyse
    - [ ] ... revoir analyse (encore et toujours)
- [X] Créer utilisateur
- [X] Créer système de connexion
- [X] Implémenter le modèle
- [ ] Programmer les fonctionnalités de gestion de compte utilisateur
- [ ] Programmer les fonctionnalités des annonces (adverts)
- [ ] Programmer les fonctionnalités des groupes
- [ ] Programmer les fonctionnalités des campagnes

## 2. A faire

- vues
    - advert
        - details
            - comments
            - new comment
    - account
        - details
            - ajouter dans groupe
        - manage
        - confirm delete
    - groupe
        - display
        - main
        - campaign

- controlleurs
    - advert
        - nouveau commentaire
    - account
        - ajout groupe (?)
        - modification mail
        - modification mdp
        - supression compte
    - group
        - nouveau groupe
        - gestion
            - ajout membre
    - campaign

- formulaires
    - ...

## 3. Fait

### 1. Modèle

**Etat implémentation :** fonctionnel

**Tables :**

- advert
    - publish_date, is_open, area, content
- advert_tag *symf*
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
- tag
    - name, type
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
- Tag
- User

### 3. Controlleurs

- Account *symf*
- Adverts
    - index
    - new
    - edit *symf*
- Home
- Registration *symf*
- Security *symf*

### 4. Formulaires

- Advert *symf*
- FilterAdverts
- NewMail
- NewPassword
- Registration
- User

### 5. Repositories

- Advert
    - `latest()`
    - `filterSearch()`

### 6. Vues

- base
- account
    - _delete_form *symf*
    - _form
    - edit
    - show
- adverts
    - _delete_form *symf*
    - _form *symf*
    - edit *symf*
    - index
    - new *symf*
    - show *symf*
- home
    - index
- includes
    - latest_ad
    - nav
- registration
    - register
- security
    - login *symf*

### 7. Assets

- app.js : import Bootstrap
- dNav.js : onglets nav dynamiques (marche pas mais bon)

### 8. Autre

- config/packages/**security.yaml**
    - redirection (dé)connexion
- config/**services.yaml**
    - ajout service extension Twig
- src/Twig/**Extension.php**
    - filtre `wrap()`
    - fonction `common()`
    - fonction `timeAgo()`
- **.env**
    - configuration connexion db
- **webpack.config.js**