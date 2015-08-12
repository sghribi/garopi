Environnements et déploiement
=============================

Environnements
--------------

Les environnements suivants son disponibles :

 * **Production** : http://garopi.via.ecp.fr/
    - IP : `138.195.130.35`
    - Branche git associée : `master`

 * **Dev** : http://garopi.ghribi.net/
    - IP : `92.222.47.24`
    - Branche git associée : `master`

Déploiement
-----------

Le déploiement se fait grâce au Gem `capifony`.
Pour déployer sur un environnement, il faut ajouter sa clé publique à l'utilisateur `www-data` de l'environnement où l'on souhaite déployer.

``` bash
bundle exec cap <env> deploy
```

Où `<env>` est : `dev` ou `production`
