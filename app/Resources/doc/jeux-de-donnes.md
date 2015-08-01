Jeux de données
===============
**Si vous utilisez un jeu de données issu de la prod, cette section ne vous concerne pas.**


Ce projet utilise le bundle `DoctrineMigrationsBundle` qui assure une mise à jour simple et sécurisée de la base de données.
Assurez-vous donc de disposer du dernier schéma en lançant :

``` bash
php app/console doctrine:migration:migrate
```

La version de dispose dispose d'un jeu de données de base générées à partir de fichiers de fixtures gérées par le bundle `AliceBundle`.
Pour réinitialiser ces données (**ATTENTION**  le contenu de la base de données sera vidée) :

``` bash
php app/console doctrine:fixture:load
```

Ce jeu de données permet notamment de créer des comptes pour se connecter à votre version de devf.
Voici quelques un des comptes créés :


| ***Rôle***         | ***Login***           | ***Password*** |
|:------------------:|:---------------------:|:--------------:|
| **Administrateur** | admin                 | 123123         |
| **Utilisateur**    | user1, user2 … user10 | 123123         |
