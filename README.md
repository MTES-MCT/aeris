Aeris
==============

Aeris a pour but de limiter les rejets polluants dans l'air en facilitant et en harmonisant la déclaration et le suivi des émissions des industriels.

Plus d'informations sur ce projet sur [beta.gouv.fr](https://beta.gouv.fr/startup/aeris.html)

La documentation se trouve dans le répertoire [documentation](./documentation). Elle contient:

 - des informations techniques: installation du projet, outils utilisés, modélisation du domaine métier...
 - des informations fonctionnelles, sur le problème que nous cherchons à résoudre à l'aide d'un outil informatique, un glossaire, etc.

## Installing Aeris

Before trying to run Aeris, make sure you have already installed:

 - [docker](https://docs.docker.com/install/)
 - [composer](https://getcomposer.org/)
 - [yarn](https://yarnpkg.com/en/)

There is a more detailled explanation regarding the installation in the [documentation](./doc/technical/install.md), but here are
Here are all the command you'll need to run Aeris right now:

```
# Download the code
git clone git@github.com:MTES-MCT/aeris.git
# Add a DNS entry
sudo echo "127.0.0.1 aeris.local" > /etc/hosts
# Fetch the PHP and JS dependencies
cd app
composer install
yarn install
# Build and deploy the CSS/JS files
yarn run encore dev
# Run the application inside containers
cd ..
docker-compose up
# Import the database schema (the PostgreSQL tables) and a few sample data
docker exec -it $(docker ps -aqf "name=aeris_php") /bin/sh
/var/www/symfony # bin/console doctrine:migrations:migrate --no-interaction
```

At the end, you should be able to access aeris at `http://aeris.local`. Two default users are created, you an use them to log inside the application:

 - inspecteur-demo / aeris
 - incinerateur-demo / aeris

For more details, you can have a look at the [documentation](./doc/).

## Licence

Ce projet est sous licence [MIT](./LICENSE.txt)