# Gallab Gestion - Application Démo Symfony 4 (saisie / suivi factures)

    Fonctionnalités : 
	Sauvegarde les factures, montants, et dates sur une BDD MySQL

## Installer et lancer le projet

```
git clone the project
php bin/console composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:run
```

## Lancer le tooling front-end  
```
encore dev --watch
```