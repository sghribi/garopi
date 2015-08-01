Installation en local
=====================


Prérequis
---------

 * `git `
 * `apache2` >= *2.4*
 * `php` >= *5.5*, avec les modules PHP suivants : `cli`, `pdo`, `curl`, `intl`, `xml`, `ldap`, `pgsql`, `ldap` et  `gd`
 * un serveur `PostgreSQL` >= 9.0.
 * `phpunit`, pour lancer les tests unitaires/fonctionnels
 * `bundler`, pour gérer les dépendances Ruby
 * `capifony`, pour déployer

On Ubuntu/Debian, run :

``` bash
sudo aptitude install git apache2 php5 curl php5-ldap php5-gd php5-curl php5-cli php5-intl postgresql php5-pgsql bundler phpunit
bundle install --path=vendor
```

Configuration
-------------

### PHP

Il faut définir la timezone PHP et vérifier que les short tag sont désactivés. Dans *les* fichiers `php.ini` à la fois dans les dossiers `/etc/php5/apache2/` (et `/etc/php5/fpm/` si vous utilisez `php5-fpm`) et `/etc/php5/cli/` :

``` php.ini
date.timezone = Europe/Paris
short_open_tag = Off
```

Ne pas oublier de reloader Apache2 (et php-fpm si vous l'utilisez).

### Apache

 * Pour configurer Apache2, créer d'abord notre dossier de travail et le rendre accessible.

``` bash
# En www-data ou avec votre user (chown si nécessaire)
mkdir /var/www/garopi
```

Pour un **environnement de développement uniquement**, vous pouvez éviter de pénibles problèmes de droits en modifiant la conf d'Apache2 pour que l'environnement d'exécution soit lancé par un autre utilisateur que `www-data:www-data`.
Il suffit de modifier les variables d'environnement `APACHE_RUN_USER` et `APACHE_RUN_GROUP`, qui se situent sur Linux dans le fichier `/etc/apache2/envvars`.
Mettez-y l'utilisateur et le groupe du dossier `/var/www/garopi`. Ensuite, restarter le démon Apache2 ; si un message d'erreur apparaît, il faut `chown votre_user:root /var/lock/apache2`, puis réessayer.

Il s'agit en fait de la plus mauvaise solution recommandée par Symfony2, mais la plus rapide et efficace. Pour voir les autres manières de gérer correctement les droits : http://symfony.com/doc/master/book/installation.html#book-installation-permissions

 * Ensuite, créer un VirtualHost.

Par exemple sous Linux, créer dans `/etc/apache2/sites-available/` un fichier intitulé `garopi.conf` (/!\ sur certaines versions d'Apache2, l'extension `.conf` est nécessaire), qui contient :

``` apache
<VirtualHost *:80>
        DocumentRoot /var/www/garopi/web
        ServerName garopi.dev

       <Directory /var/www/garopi/web>
                AllowOverride None
                Options -Indexes +FollowSymLinks
                Require all granted

                <IfModule mod_rewrite.c>
                        RewriteEngine On
                        RewriteCond %{REQUEST_FILENAME} !-f
                        RewriteRule ^(.*)$ app_dev.php [QSA,L]
                </IfModule>
        </Directory>
</VirtualHost>
```

Ensuite, créer un lien symbolique pour activer ce VirtualHost, à l'aide de la commande :

``` bash
# En root
a2ensite garopi.conf
```

 * Pour que ce vhost particulier fonctionne, il faut que le nom de domaine, garopi.dev, soit associé à la machine de dev, localhost. Il suffit pour cela de rajouter dans `/etc/hosts`

``` host
127.0.1.2 garopi.dev
```

 * Activer enfin le mode `rewrite` d'Apache (cela permet de ne pas avoir à écrire `app_dev.php` à la fin des URLs).

Par exemple sous Linux :

``` bash
# En root
a2enmod rewrite
service apache2 reload
```

### PostGreSQL

Accéder à une interface pour rentrer des commandes SQL (cli, phppgadmin, ou autres).
Par exemple sous Linux :

``` bash
# En root
su postgres
psql
```

Créer la base de données et l'utilisateur en lançant les commandes :

``` sql
CREATE DATABASE garopi ENCODING 'UTF-8';
CREATE USER garopi ENCRYPTED PASSWORD 'garopi';
GRANT ALL ON DATABASE garopi TO garopi;
```

Installation du projet
----------------------

``` bash
cd /var/www/
git clone git@github.com:sghribi/garopi.git
```

### Vérification du système

Vérifier que notre système a tout ce dont il a besoin en lançant :

``` bash
php app/check.php
```

Corriger toutes les erreurs `Mandatory`, et en best-effort les recommendations `Optional`.


### Installation des dépendances

Télécharger toutes les dépendances en lançant la commande :

``` bash
curl -sS https://getcomposer.org/installer | php
sudo mv composer.phar /usr/local/bin/composer
composer install
```

Laisser les paramètres par défaut, ou adaptez-les si vous n'avez pas choisi la même configuration.


### Initialisation des dépendances CSS/JS

Désormais, il reste quelques commandes Symfony pour préparer le site.

``` bash
# Préparation des données du site
php app/console assets:install --symlink web
php app/console assetic:dump
```

### Initialisation de la BDD

``` bash
php app/console dox:fix:load --env=dev
```
