# billtracking.io - A bill tracker based on Symfony RAD tools

    Log bills, amounts and date
    List bills
    Have a few graphs (this year / last year)
    Store them somewhere

## install & run project

```
git clone the project
php bin/console composer install
php bin/console doctrine:database:create
php bin/console doctrine:schema:update --force
php bin/console doctrine:fixtures:load
php bin/console server:run
```

## run front-end tooling 
```
encore dev --watch
```