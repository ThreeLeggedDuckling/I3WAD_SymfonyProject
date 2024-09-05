**Version20240905153736**

Etat : fonctionnel

Tables :
- advert
- comment
- user

Liens :
- user (1) - advert.author_id (n) orphanRemoval
- user (1) - comment.author_id (n) NULL
- advert (1) - comment.advert_id (n) orphanRemoval