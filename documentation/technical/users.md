
## Bonus : Creating users and incinerateurs

This is an optionnal step, if you need more users than what running the migrations did.

### Creating an inspecteur

In order to create an inspecteur, you need to do 2 things:

 - create an user with the appropriate username and password. This is done with `bin/console fos:user:create`
 - add the appropriate role (`ROLE_INSPECTEUR`) to this user, with `bin/console fos:user:promote`

Here is an example below:

    /var/www/symfony # bin/console fos:user:create
    Please choose a username:inspecteur-demo
    Please choose an email:inspecteur-demo@aeris.fr
    Please choose a password:
    Created user inspecteur-demo
    /var/www/symfony # bin/console fos:user:promote
    Please choose a username:inspecteur-demo
    Please choose a role:ROLE_INSPECTEUR
    Role "ROLE_INSPECTEUR" has been added to user "inspecteur-demo". This change will not apply until the user logs out and back in again.

You should be now be able to login with this user and password.

### Creating an incinerateur

It starts in the same way as before: first We create a user, and we add him the role ROLE_PROPRIETAIRE.

    /var/www/symfony # bin/console fos:user:create
    Please choose a username:incinerateur-demo
    Please choose an email:incinerateur-demo@aeris.fr
    Please choose a password:
    Created user incinerateur-demo
    /var/www/symfony # bin/console fos:user:promote
    Please choose a username:incinerateur-demo
    Please choose a role:ROLE_PROPRIETAIRE
    Role "ROLE_PROPRIETAIRE" has been added to user "incinerateur-demo". This change will not apply until the user logs out and back in again.

Then, we need to create and incinerateur, and attach it to the corresponding user and inspecteur. If you don't have created an inspecteur already, create one now. Then, you can use the following command:

    bin/console aeris:create-incinerateur "Incinérateur de 
démonstration" 2 2 "incinerateur-demo" "inspecteur-demo"

This command will create an incinérateur with 2 lignes, each containing 2 ovens, where the owner is the user "incinerateur-demo" and the matching inspecteur is "inspecteur-demo". More infos with:

    bin/console aeris:create-incinerateur --help
