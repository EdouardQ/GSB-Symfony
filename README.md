# GSB-Symfony

Ce projet réunie le dévellopement d'une application de gestion de comptes-rendus et de fiche de frais de visites (PPE2 + PPE3).

## Pré-requis

Nous vous invitons à exécuter les commandes suivantes :

- ``composer req profiler --dev``
- ``composer req asset debug annot twig make form validator orm ormfixtures security mime``

## Organisation
- Git Hub (une branche pour la prod, une autre pour le dev afin de gérer les conflits)
- Discord (pour le dialogue / réunions)

## Auteurs

* **Edouard** **Quilliou** _alias_ [@EdouardQ](https://github.com/EdouardQ)
* **Jonas** **Groetschel** _alias_ [@Jogroe](https://github.com/Jogroe)
* **Marc** **Baribaud** _alias_ [@devFendrix](https://github.com/devFendrix)

## Note

Pour update la version prod, rentrer la commande suivante:
APP_ENV=prod APP_DEBUG=0 php bin/console cache:clear
