**Version20240905175632**

Etat : fonctionnel

Tables :
- advert
- campain
- comment
- file
- group
- group_member
- session
- user

Liens :
- advert (1) - comment.advert_id (n) orphanRemoval
- group (1) - group_member.in_group_id [^1] (n) orphanRemoval
- user (1) - advert.author_id (n) orphanRemoval
- user (1) - comment.author_id (n) NULL
- user (1) - group_member.user_id (n) orphanRemoval

---

**Version20240905211820**

Etat : fonctionnel

Tables :
- advert
- campain
- comment
- file
- group
- group_member
- session
- user

Liens :
- advert (1) - comment.advert_id (n) orphanRemoval
- campain (1) - session.campain_id (n) orphanRemoval
- campain (1) - file.campain_id (n) orphanRemoval
- group (1) - group_member.in_group_id (n) orphanRemoval
- group_member (1) - campain.game_master_id (n) NULL
- group_member (1) - file.author_id (n)
- user (1) - advert.author_id (n) orphanRemoval
- user (1) - comment.author_id (n) NULL
- user (1) - group_member.user_id (n) orphanRemoval

[^1]: Même si rajoute automatiquement "-id" à la fin, impossible d'utiliser "group" car appellation réservée